<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;


class AuthUser extends Controller
{
        /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
    
        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            // Determine the role and create a token
            if ($user->role == 0) {
                // Create token for user with 'role' scope
                $token = $user->createToken('User Token', ['role:user'])->plainTextToken;
            } elseif ($user->role == 1) {
                // Create token for admin with 'role' scope
                $token = $user->createToken('Admin Token', ['role:admin'])->plainTextToken;
            }
    
            // Return the token as a JSON response
            return response()->json(['token' => $token]);
        }
    
        // If authentication fails, return an error
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function registration(Request $request) {

        // Validate field
        $fields = $request->validate([
            'username' => ['required','string'],
            'email' => ['required','string'],
            'home_number' => ['required','string'],
        ]);

        $password = Str::password(8, true, true, false, false);
        $fields['password'] = $password;

        // Create user
        if(User::create($fields)){
            return response([
                'message' => 'Register Sucess!',
                'password' => $password
            ], 201);
        }
    }
}
