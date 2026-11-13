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
            $user = Auth::user();

            // Cegah relawan atau mitra masuk ke admin panel CMS (/q/login)
            if ($user->role_type === 'volunteer' || $user->role_type === 'affiliate') {
                Auth::logout();
                $req->session()->invalidate();
                $req->session()->regenerateToken();

                return back()->withErrors([
                    'error' => 'Akun Relawan & Mitra tidak memiliki izin akses ke Admin Panel. Silakan login melalui /z/login',
                ]);
            }

            $req->session()->regenerate();

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
