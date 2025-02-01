<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AccessTokensController extends Controller
{
    public function store(Request $request){

      $credetenals =   $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:6',
            'device_name'=>'string|max:255',
            'abiliiets'=>'nullable|array'
        ]);

        if (Auth::attempt( $credetenals)) {
             $user = Auth::user();

             $device_name = $request->post('device_name',$request->userAgent());
            $token = $user->createToken($device_name,$request->abilities);

            return response()->json([
                'code'=> 1,
                'token'=>$token->plainTextToken,
                'user'=>$user
            ],201);
        }
        return response()->json([
            'code'=> 0,
            'message'=>'invalid credentials',

        ],401);


    }

    public function destroy($token=null)
    {
        
            $user =Auth::guard('sanctum')->user();
            if ($user) {
            if ($token == null) {
             $user->currentAccessToken()->delete();
             return response()->json('success',201);
        }
        
          $personal_token = PersonalAccessToken::findToken($token);
            if ($user->id == $personal_token->tokenable_id && get_class($user) == $personal_token->tokenable_type) {
                $personal_token->delete();
                return response()->json('success',201);
            }
        }

        return redirect()->json('faild',401);
    }

}
