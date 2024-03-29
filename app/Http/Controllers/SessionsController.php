<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        // 只让未登录用户访问登录页面：
        $this->middleware('guest',[
           'only' => ['create']
        ]);
    }

    //
    public function create(){
        return view('sessions.create');
    }

    public function store(Request $request){
        $credentials = $request->validate([
           'email'    => 'required|email|max:255',
           'password' => 'required'
        ]);
        //  attempt()第一个参数为需要进行用户身份认证的数组，第二个参数为是否为用户开启『记住我』功能的布尔值
        if (Auth::attempt($credentials,$request->has('remember'))){
            // 登录成功后的相关操作
            session()->flash('success','欢迎回来');
            $fallback = route('users.show',Auth::user());
            return redirect()->intended($fallback);
        }else{
           // 登录失败后的相关操作
            session()->flash('danger','很抱歉，您的密码和邮箱不匹配');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(){
        Auth::logout();
        session()->flash('success','成功退出');
        return redirect('login');
    }

}
