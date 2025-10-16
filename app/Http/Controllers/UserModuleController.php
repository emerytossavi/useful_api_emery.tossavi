<?php

namespace App\Http\Controllers;

use App\Models\UserModule;
use Illuminate\Http\Request;

class UserModuleController extends Controller
{

    public function activateModule(Request $request, $id)
    {
        try {

            /* $request->validate(
                ['id' => "required|exists:modules,id"],
                [
                    "id.required" => "Module required",
                    "id.exists" => "This Module does'n exists",
                ]
            ); */

            if (Auth('sanctum')->user() == null) {
                return response()->json(
                    [
                        "error" => "Login first !!!"
                    ],
                    403
                );
            }

            if (Auth('sanctum')->user() == null) {
                return response()->json(
                    [
                        "error" => "Login first !!!"
                    ],
                    403
                );
            }

            $module = UserModule::where('module_id', $id)
                    ->where("user_id", Auth('sanctum')->user()->id)
                    ->first();

            $isModuleActive = $module->active ?? false;


            if($isModuleActive == false){

                $userModule = UserModule::updateOrCreate([
                    "user_id" => Auth('sanctum')->user()->id,
                    "module_id" => $id,
                ]);

                $userModule->setAttribute("active", true);
                $userModule->save();

                return response()->json(
                    [
                        "message" => "Module activated",
                    ],
                    200
                );
            }else{
                return response()->json(
                    ["message" => "Already activated"],
                    401
                );
            }


        } catch (\Throwable $th) {
            return response()->json(
                [
                    "error" => $message ?? $th->getMessage(),
                ],
                403,
            );
        }
    }


    public function deActivateModule(Request $request, $id)
    {
        try {

            /* $request->validate(
                ['id' => "required|exists:modules,id"],
                [
                    "id.required" => "Module required",
                    "id.exists" => "This Module does'n exists",
                ]
            ); */

            if (Auth('sanctum')->user() == null) {
                return response()->json(
                    [
                        "error" => "Login first !!!"
                    ],
                    403
                );
            }

            $module = UserModule::where('module_id', $id)
                    ->where("user_id", Auth('sanctum')->user()->id)
                    ->first();

            $isModuleActive = $module->active ?? true;


            if($isModuleActive == true){
                /* $module->setAttribute('active', true);
                $module->save(); */
                $userModule = UserModule::updateOrCreate([
                    "user_id" => Auth('sanctum')->user()->id,
                    "module_id" => $id,
                ]);

                $userModule->setAttribute("active", false);
                $userModule->save();

                return response()->json(
                    [
                        "message" => "Module deactivated",
                    ],
                    200
                );
            }else{
                return response()->json(
                    ["message" => "Already deactivated"],
                    401
                );
            }


        } catch (\Throwable $th) {
            return response()->json(
                [
                    "error" => $message ?? $th->getMessage(),
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
    public function show(UserModule $userModule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserModule $userModule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserModule $userModule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserModule $userModule)
    {
        //
    }
}
