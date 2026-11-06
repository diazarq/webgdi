<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(Request $req){
        $creds = $req->validate([
            'username' => ['required', 'string'],
            'password'=> ['required']
        ]);
        
        
        if(Auth::attempt($creds)){
            $req->session()->regenerate();

            $user = Auth::user();
            $upd = User::find($user->id);
            $upd->last_login = date('Y-m-d H:i:s');
            $upd->save();
            return redirect()->intended('admin/dashboard'); //temp
        }

        return back()->withErrors([
            'error' => 'Login Anda salah.',
        ]);
    }

    public function logout(Request $request){
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('q/login');
    }
}
