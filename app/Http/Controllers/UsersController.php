<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    //
    public function create(){
        return view('users.create');
    }

    public function show(User $user){
        // compact 创建一个叫user的
        return view('users.show',compact('user'));
    }

    // 注册
    public function store(Request $request){
//        unique:users 唯一性验证 ,这里是针对users数据表进行验证  email 格式验证
//        confirmed 密码匹配验证 判断两次输入的密码是否相同
        $request->validate([
            'name'     => 'required|unique:users|max:50',
            'email'    => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6|max:16'
        ]);

        $user = User::create([
           'name'     => $request->name,
           'email'    => $request->email,
           'password' => bcrypt($request->password),
        ]);
        session()->flash('success','注册成功');
        return redirect()->route('users.show',[$user]);

    }

}
