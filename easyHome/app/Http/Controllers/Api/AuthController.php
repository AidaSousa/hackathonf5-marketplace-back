<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request) {
        //Validacion de los datos
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'username'=>'required|unique:users',
            'password'=>'required|confirmed',
            'user_type'=>['required', Rule::in(['usuario', 'cliente'])]
        ]);
        //Alta del usuario
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = $request->password;
        $user->user_type = $request->user_type;
        $user->save();

        //respuesta
        // return response ()->json([
        //     "message"=>"Alta exitosa"
        // ]);
        return response($user, Response::HTTP_CREATED);

    }

    public function login(Request $request) {
      $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required']
      ]);

      if (Auth::attempt($credentials)) {
        $user = Auth::user();
        return response(["message"=>"Bienvenido"], Response::HTTP_OK);
      } else {
        return response(["message" =>"Credenciales inválidas"],Response::HTTP_UNAUTHORIZED);
      }

    }

    public function userProfile(Request $request) {
        
    }

    public function logout() {
        
    }

    public function allUsers(Request $request) {
        
    }
}
