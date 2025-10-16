<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class ShortLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        //
        try {

            $request->validate(
                [
                    "original_url" => "required|url",
                    "custom_code" => "max:10|string|unique:short_links,code"
                ],
                [
                    "original_url.required" => "Link's missing",
                    "original_url.url" => "Link format is invalid",

                    "custom_code.max" => "The code is too long; Max 10 chars",
                    "custom_code.unique" => "This code already exists",
                    "custom_code.string" => "Invalid code format",
                ]
            );

            $code = $request->custom_code ?? substr((uniqid("")), 0, 10);

            $data = ShortLink::create([
                "user_id" => Auth('sanctum')->user()->id,
                "original_url" => $request->original_url,
                "code" => $code,
            ]);

            return response()->json(
                [
                    "id" => $data->id,
                    "original_url" => $data->original_url,
                    "code" => $data->code,
                    "clicks" => $data->clicks,
                    "created_at" => $data->created_at,
                ],
                201
            );
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(
                [
                    "error" => $th->getMessage(),
                ],
                403,
            );
        }
    }

    public function redirectTo($id, $code)
    {
        try {

            $request = new Request;

            // request only takes arrays
            $code = ["code" => $code];

            $request->merge($code);
            $request->validate(
                [
                    "code" => "required|exists:short_links,code"
                ],
                [
                    "code.required" => "Missing code",
                    "code.exists" => "This code does'n exists",
                ]
            );

            $data = ShortLink::where("code", $code)
                ->where('user_id', Auth("sanctum")->user()->id)
                ->first();

            // dd($data);

            if($data){
                $data->setAttribute('clicks', $data->clicks += 1);
                $data->save();

                return redirect()->away($data->original_url);
            }else{
                return response()->json(
                    ["message" => "Not found" ],
                    401,
                );
            }

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(
                [
                    "error" => $th->getMessage(),
                ],
                403,
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ShortLink $shortLink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShortLink $shortLink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShortLink $shortLink)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShortLink $shortLink)
    {
        //
    }
}
