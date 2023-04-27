<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;





class TokenController extends Controller
{
    public function user(Request $request)
    {
        $user = User::where('email', $request->user()->email)->first();
       
        return response()->json([
            "success" => true,
            "user"    => $request->user(),
            //"roles"   => $user->getRoleNames(),
        ]);
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            // Get user
            $user = User::where([
                ["email", "=", $credentials["email"]]
            ])->firstOrFail();
            // Revoke all old tokens
            $user->tokens()->delete();
            // Generate new token
            $token = $user->createToken("authToken")->plainTextToken;
            // Token response
            return response()->json([
                "success"   => true,
                "authToken" => $token,
                "tokenType" => "Bearer"
            ], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Invalid login credentials"
            ], 401);
        }
    }
    
    protected function register(Request $request)
    {
        $validacion = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
        ]);

        $user = User::create([
            'name' => $validacion['name'],
            'email' => $validacion['email'],
            'password' => Hash::make($validacion['password']),
        ]);

        //$user->assignRole('author');

        $token = $user->createToken("authToken")->plainTextToken;


        return response()->json([
            "success"   => true,
            "authToken" => $token,
            "tokenType" => "Bearer"
        ], 200);
        
    }
    protected function logout(Request $request){
        $user = User::where('email', $request->user()->email)->first();

        $ok=$user->tokens()->delete();
        return response()->json([
            "success"   => true,
            "message" => "Logout succesfully"
        ], 200);



    }


}
