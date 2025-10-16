<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {

            $request->validate(
                [
                    "name" => "required|string",
                    "email" => "required|email|unique:users,email",
                    "password" => "required|min:8"

                ],
                [
                    "name.required" => "Missing the name",
                    "name.string" => "Enter a valid name to continue",
                    "email.required" => "Missing the email",
                    "email.email" => "Enter a valid email address to continue",
                    "email.unique" => "The selected email already exit the system, you can't login with it !!",

                    "password.required" => "Missing the password",
                    "password.min" => "Weak password"

                ]
            );

            $data = User::create($request->toArray());
            $responseData = [
                "id" => $data->id,
                "name" => $data->name,
                "email" => $data->email,
                "created_at" => $data->created_at,
            ];
            return response()->json(
                $responseData
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "error" => $message ?? $th->getMessage(),
                ],
                403,
            );
        }
    }

    public function login(Request $request)
    {
        try {

            $request->validate(
                [
                    'email' => 'required|email',
                    'password' => 'required',
                ],
                [
                    "email.required" => "Missing the email",
                    "email.email" => "Enter a valid email address to continue",

                    "password.required" => "Missing the password",
                ]
            );

            $user = User::where("email", $request->email)->first();

            if(!$user || !Hash::check($request->password, $user->password))
            {
                $message = "Incorrect values";

                return response()->json(
                    $message,
                    401
                );

            }


            $data = [
                /* "token" => $user->createToken($request->device_name)->plainTextToken, */
                "token" => $user->createToken('apiToken')->plainTextToken,
                "user_id" => $user->id,
            ];

            return response()->json(
                $data,
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "error" => $th->getMessage(),
                ],
                403,
            );
        }
    }

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
