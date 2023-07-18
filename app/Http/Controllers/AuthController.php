<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function createLogin()
    {
        return view('auth.login');
    }

    public function createRegister()
    {
        return view('auth.register');
    }

    public function storeLogin(Request $request)
    {
        // $request->flash();
        $validation = $request->validate([
            'email'=>'required',
            'password'=>'required|min:6'
        ],[
            'email.required'=>'Bạn bắt buộc phải nhập email',
            'password.required'=>'Bạn bắt buộc phải nhập mật khẩu',
            'password.min'=>'Mật khẩu phải hớn hơn 5 kí tự'
        ]);

        try{
            $userLogin = User::where('email', $request->email)->first();
            if(!$userLogin){
                return redirect()->back()->withErrors('Email không đúng');
            }
            if(!Hash::check($request->password, $userLogin->password)){
                return redirect()->back()->withErrors('Mật khẩu không khớp');
            }
            $request->session()->regenerate();
            $request->session()->put('user.id', $userLogin->id);
            $request->session()->put('user.name', $userLogin->name);
            $request->session()->put('user.email', $userLogin->email);
            $request->session()->put('user.role', $userLogin->role);
            // $rememberToken = md5(uniqid(rand(), true));
            return redirect()->route('home')->with('status','Đăng nhập thành công');
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Server error');
        }
    }
    
    public function storeRegister(Request $request)
    {
        $validation = $request->validate([
            'email'=>'required',
            'password'=>'required|min:6|confirmed',
            'name'=>'required'
        ],[
            'email.required'=>'Bạn bắt buộc phải nhập email',
            'name.required'=>'Bạn bắt buộc phải nhập tên',
            'password.required'=>'Bạn bắt buộc phải nhập mật khẩu',
            'password.min'=>'Mật khẩu phải hớn hơn 5 kí tự',
            'password.confirmed'=>'Mật khẩu không khớp'
        ]);

        try{
            $userExist = User::where('email', $request->email)->first();
            if($userExist){
                return redirect()->back()->withErrors('Email đã tồn tại');
            }
            // $rememberToken = md5(uniqid(rand(), true));
            User::create([
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'name'=>$request->name,
                'role'=>'USER',
            ]);
            return redirect()->route('login')->with('status','Đăng kí thành công');
        }
        catch(Exception $e){
            return redirect()->back()->withErrors('Lỗi server');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();//regenerate and delete all data in previous session
        return redirect()->route('login')->with('status','Đăng xuất thành công');
    }
}
