<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\VerfieTokens;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GuestUserController;

class AuthTokens extends Controller
{
    public function Create(Request $request)
    {
        try
        {
            $credentials = $request->validate([
                'vehicle_log_id' => ['required', 'string']
            ]);

            //if ()
    
            $token = Str::random(32);
            $credentials['token'] = $token;
    
            if(VerfieTokens::create($credentials))
            {
                return response([
                    'message' => 'created sucessed'
                ], 201);
            }

            return response([
                'message' => 'created failed'
            ], 200);
        }
        catch (Exception $e)
        {
            return response([
                'message' => 'Server Error'
            ], 500);
        }
    }

    public function Verifie(Request $request)
    {
        
        try{
            $credentials = $request->validate([
                //'vehicle_log_id' => ['required', 'string'],
                'token' => ['required', 'string'],
            ]);
    
            $user = Auth::guard('sanctum')->user();
            
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
    
            if ($user->role == 0) {
                return response()->json(['message' => 'User role', 'user' => $user], 200);
            } elseif ($user->role == 1) {

                $verifiedToken = VerfieTokens::where('token', $credentials['token'])->first();
                $credentials['user_id'] = $user->id;
                if ($verifiedToken) {

                    $verifiedToken->verified = true;
                    $verifiedToken->user_id = $credentials['user_id'];
                    $verifiedToken->save();

                    GuestUserController::CheckOut($verifiedToken->vehicle_log_id);
    
                    return response()->json(['message' => 'Verified Successfully'], 200);
                }
                return response()->json(['message' => 'No Token'], 404);
            } else {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }
        catch (Exception $e){
            return response()->json(['message' => 'Server Error'], 500);
        }
    }
}
