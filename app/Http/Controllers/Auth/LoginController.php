<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showAdminLogin() {
        return view('admin.auth.login');
    }

    public function adminLogin(Request $request){
        $request->validate([
            'email'     => 'required|exists:users,email',
            'password'  => 'required|min:8'
        ]);

        $check_user = User::where('email', $request->email)->where('role_id', 1)->first();

        if ($check_user && Hash::check($request->password, $check_user->password)) {
            Auth::login($check_user);

            return redirect()->intended('admin/tickets');
        } else {
            return redirect()->back()->withErrors(['email' => __('auth.failed')]);
        }
    }

    public function showUserLogin() {
        return view('user.auth.login');
    }

    public function userLogin(Request $request){
        $request->validate([
            'email'     => 'required|exists:users,email',
            'password'  => 'required|min:8'
        ]);

        $check_user = User::where('email', $request->email)->where('role_id', 2)->first();

        if ($check_user && Hash::check($request->password, $check_user->password)) {
            Auth::login($check_user);

            return redirect()->intended('user/tickets');
        } else {
            return redirect()->back()->withErrors(['email' => __('auth.failed')]);
        }
    }

    public function showUserRegister() {
        return view('user.auth.register');
    }

    public function userRegister(Request $request){
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role_id'   => 2,
        ]);

        Auth::login($user);

        return redirect()->intended('user/tickets');
    }

    public function logout(){
        if(@auth()->user()->role?->name == 'admin'){
            Auth::guard('web')->logout();

            return redirect(url('/admin'));
        }

        Auth::guard('web')->logout();

        return redirect(url('/login'));
    }
}
