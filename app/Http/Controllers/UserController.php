<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\UserController;

class UserController extends Controller
{
    //fungsi untuk register
    public function register_action(Request $request)
    {
        $request->validate([
            'nisn' => 'nullable|unique:users', 
            'nip' => 'nullable|unique:users',
            'id_role' => 'required',
            'user' => 'required',
            'password_confirm' => 'required|same:password',
        ]);

        $user = new User([
            'nisn' => $request->nisn,
            'nip' => $request->nip,
            'id_role'=> $request->id_role,
            'user' => $request->user,
            'password' => Hash::make($request->password),  
        ]);

        $user->save();

        return redirect()->route('TampilUserAdm')->with('success', 'Data User berhasil ditambah!');
    }


    //fungsi untuk login
    public function login_action(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt(['user' => $request->user, 'password' => $request->password])) {
            $request->session()->regenerate();
            $user = Auth::user();

            switch ($user->id_role) {
                case 1:
                    return redirect()->route('TampilanAwal');
                case 2:
                    return redirect()->route('TampilanAwalGuru');
                case 3:
                    return redirect()->route('TampilanAwalOrtu');
                default:
                    return redirect('/home');
            }
        } else {


        }

        return back()->withErrors([
            'password' => 'username atau password salah',
        ]);
    }

    public function password()
    {
        
        return view('user/password');
    }
   //fungsi untuk mengganti password
    public function password_action(Request $request)
    {
        $request->validate([
            'old_password' => 'required|current_password',
            'new_password' => 'required|confirmed',
        ]);
        $user = User::find(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();
        $request->session()->regenerate();
        return redirect('/')->with('success', 'Password berhasil diubah!');

    }
    //fungsi logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
