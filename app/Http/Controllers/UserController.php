<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function viewProfile()
    {
        return view('user.profile');
    }

    public function viewManagerUser(Request $request)
    {
        $users = User::all();
        return view('user.manager-user', compact("users"));
    }

    public function changeName(Request $request){
        $request->validate([
            'name'=>'required',
        ],[
            'name.required'=>'Bạn bắt buộc phải nhập tên',
        ]);
        try{
            $userUpdate = User::where('id', $request->session()->get('user.id'))->first();
            $userUpdate->name = $request->name;
            $userUpdate->save();
            $request->session()->put('user.name', $request->name);
            return redirect()->route('profile')->with('status', "Thay đổi tên thành công");
        }
        catch(Exception $e)
        {
            return redirect()->back()->withErrors('Server error');
        }
    }

    public function addNewUser(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'=>'required|unique:users',
            'password'=>'required|min:6',
            'name'=>'required',
            'role'=>'required'
        ],[
            'email.required'=>'Bạn bắt buộc phải nhập email',
            'email.unique'=>'Email đã tồn tại',
            'name.required'=>'Bạn bắt buộc phải nhập tên',
            'password.required'=>'Bạn bắt buộc phải nhập mật khẩu',
            'password.min'=>'Mật khẩu phải hớn hơn 5 kí tự',
        ]);

        if(!$validator->passes()){
            return response()->json([
                'status'=>0,
                'error'=>$validator->errors()
            ]);
        }
        try{
            User::create([
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'name'=>$request->name,
                'role'=>$request->role,
            ]);
            return response()->json([
                'status'=>'oke',
                'message'=>'create successfully'
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'status'=>1,
                'message'=>'Server error'
            ]);
        }
    }

    public function updateUser(Request $request, string $id){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'role'=>'required'
        ],[
            'name.required'=>'Bạn bắt buộc phải nhập tên',
            'role.required'=>'Bạn bắt buộc phải chọn quyền user',
        ]);
        if(!$validator->passes()){
            return response()->json([
                'status'=>0,
                'error'=>$validator->errors()
            ]);
        }
        try{
            $userUpdate = User::where('id', $id)->first();
            $userUpdate->name = $request->name;
            $userUpdate->role = $request->role;
            $userUpdate->save();
            if($request->session()->get('user.id', $id)){
                $request->session()->put('user.name', $request->name);
            }
            return response()->json([
                'status'=>'oke',
                'message'=>'updated successfully'
            ]);
        }
        catch(Exception $e)
        {
            return response()->json([
                'status'=>1,
                'message'=>'Server error'
            ]);
        }
    }

    public function updateUserAccount(Request $request, string $id){
        $validator = Validator::make($request->all(),[
            'email'=>[
                'required',
                Rule::unique('users')->ignore($id),
            ],
            'password'=>'required|min:6|confirmed',
        ],[
            'email.required'=>'Bạn bắt buộc phải nhập email',
            'email.unique'=>'Email đã tồn tại',
            'name.required'=>'Bạn bắt buộc phải nhập tên',
            'password.required'=>'Bạn bắt buộc phải nhập mật khẩu',
            'password.min'=>'Mật khẩu phải hớn hơn 5 kí tự',
            'password.confirmed'=>'Mật khẩu không khớp'
        ]);
        if(!$validator->passes()){
            return response()->json([
                'status'=>0,
                'error'=>$validator->errors()
            ]);
        }
        try{
            $userUpdate = User::where('id', $id)->first();
            $userUpdate->email = $request->email;
            $userUpdate->password = Hash::make($request->password);
            $userUpdate->save();
            if($request->session()->get('user.id', $id)){
                $request->session()->put('user.email', $request->email);
            }
            return response()->json([
                'status'=>'oke',
                'message'=>'updated successfully'
            ]);
        }
        catch(Exception $e)
        {
            return response()->json([
                'status'=>1,
                'message'=>'Server error'
            ]);
        }
    }

    public function deleteUser(Request $request, string $id){
        try{
            User::destroy($id);
            return redirect()->route('update')->with('status','Xóa thành công');
        }catch(Exception $e){
            return redirect()->back()->withErrors('Lỗi server');
        }
    }
}
