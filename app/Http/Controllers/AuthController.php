<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function index(){
        return view('login');
    }

    public function login(Request $request){
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cari user berdasarkan username
        $user = User::where('username', $request->username)
                   ->orWhere('email', $request->username)
                   ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Session::put('user', [
                'username' => $user->username ?? $user->email,
                'nama' => $user->name,
                'id' => $user->id
            ]);

            return redirect()->route('home');
        }

        return back()->withErrors(['error'=> 'username/password anda salah']);
    }

    public function dashboard(){
        if (!Session::has('user')) {
            return redirect()->route('login');
        }
        $user = Session::get('user');
        return view('welcome',compact('user'));
    }

    public function login2(){
        return view('login2');
    }
}


