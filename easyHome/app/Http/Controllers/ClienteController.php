<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function create() {
        return view('auth.client-register');
    }

    public function store(Request $request) {

        $user = auth()->user();

        $client = new Client([
            'phone' => $request->input('phone'),
            'address' => $request->input('address')
        ]);

        $client->user()->associate($user);

        $client->save();

        return redirect()->to('/');
    
    }

    protected function validator(array $data) {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string'],
            'address' => ['required', 'string'],
        ]);
    }
        

}
