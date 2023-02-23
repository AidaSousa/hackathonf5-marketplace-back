<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{

    protected function validator(array $data) {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_type' => ['required', 'string', Rule::in(['usuario', 'cliente'])], 
        ]);
    }

    public function create() {
        return view('auth.register');
    }

    public function store(Request $request) {

        $this->validator($request->all())->validate();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'user_type' => $request->user_type,
        ]);

        auth()->login($user);

        if ($user->user_type == 'cliente') {
            return redirect()->route('cliente.create');
        } else {
            return redirect()->to('/');
        }
    }
    // public function create() {
    //     return view('auth.register');
    // }

    // public function store() {

    //     $this->validate(request(), [
    //         'name' => 'required',
    //         'email' => 'required|email',
    //         'username' => 'required',
    //         'password' => 'required|confirmed'
    //     ]);

    //     $user = User::create(request(['name', 'email', 'username', 'password']));

    //     auth()->login($user);
    //     return redirect()->to('/');
    // }

    // protected function validator(array $data) {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'username' => ['required', 'string', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //         'user_type' => ['required', 'string', Rule::in(['usuario', 'cliente'])],
    //     ]);
    // }
}
