<?php

namespace App\Http\Controllers;

use App\Http\Requests\auth\StoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function Login()
    {
        if (Auth::check()) {
            return redirect()->route('user.index');
        } else {
            return view('auth.login');
        }
    }

    public function postlogin(StoreRequest $request)
    {
        $data = $request->only('email', 'password');
        if (Auth::attempt($data)) {
            if (Auth::user()->is_admin == 1) {
                return redirect()->route('user.index');
            } else
                return redirect()->route('client.index');
        } else {
            return redirect()->route('auth.login');
        }
    }


    public function postloginclient(StoreRequest $request){
        $data = $request->only('email', 'password');
        if (Auth::attempt($data)) {           
                return redirect()->route('client.index');
        } else {
            return redirect()->route('client.login');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login');
    }
    public function logoutClient(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('client.login');
    }

    public function signup(StoreRequest $request)
    {
        $data = $request->all();
        $data = $request->except('_token', 'name');
        $data['password'] = bcrypt($request->password);
        $data['created_at'] = new \DateTime();
        $data['updated_at'] = new \DateTime();
        $data['is_admin'] = 2;
        $data['status'] = 1;
        DB::table('users')->insert($data);
        $user = DB::table('users')->where('email', $request->email)->first();
        $user_info = $request->except('_token', 'email', 'password', 'is_admin', 'status');

        $path = public_path('image/imageUsers/user_' . $user->id);
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $user_info['user_id'] = $user->id;
        $user_info['created_at'] = new \DateTime();
        $user_info['updated_at'] = new \DateTime();
        DB::table('user_info')->insert($user_info);
        return redirect()->route('client.index')->with('success', 'User created successfully.');
    }

}