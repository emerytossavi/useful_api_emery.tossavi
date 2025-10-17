<?php

namespace App\Http\Middleware;

use App\Models\Module;
use App\Models\UserModule;
use Closure;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $activeModuleId): Response
    {

        // dd("yp");
        try {

            // $request->activeModuleId = $request->activeModuleId ?? $id;
            if (!$request->activeModuleId){
                $activeModuleId = ["activeModuleId" => $activeModuleId];
                $request->merge($activeModuleId);
            }


            if ((Auth('sanctum')->user() != null)) {

                $currentModule = $request->activeModuleId;

                if ($currentModule == null) {
                    return response()->json(
                        [
                            "error" => "Module not defined !"
                        ],
                        403
                    );
                }


                $isModuleActive = UserModule::where('module_id', $currentModule)
                ->where("user_id", Auth('sanctum')->user()->id)
                ->first();

                $isModuleActive = $isModuleActive->active ?? false;


                if ($isModuleActive) {
                    return $next($request);
                } else {
                    return response()->json(
                        [
                            "error" => "Module inactive. Please activate this module to use it."
                        ],
                        403
                    );
                }
            } else {
                return response()->json(
                    [
                        "error" => "Login first !!!"
                    ],
                    403
                );
                // return abort()
            }
        }
        //code...
        catch (\Throwable $th) {
            return response()->json(
                [
                    "error" => "Wrong params !!!"
                    ]
            );
        }
    }
}
