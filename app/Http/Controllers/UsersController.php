<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //except:为黑名单机制，除了show页面不经过中间件Auth过滤，其他都需要过滤，如果没有通过验证，则跳转到指定的页面
    //only:为白名单机制，除了edit页面需要经过中间件Auth过滤，其他都不需要过滤，如果没有通过验证，则跳转到指定的页面
    public function __construct()
    {
        $this->middleware('auth',[
            'except' => 'show','create','store'
        ]);
        //  只让未登录用户访问注册页面：
        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }

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
        //   在 Laravel 中，如果要让一个已认证通过的用户实例进行登录
        Auth::login($user);
        session()->flash('success','注册成功');
        return redirect()->route('users.show',[$user]);

    }

    public function edit(User $user){
        //  authorize 方法接收两个参数，第一个为授权策略的名称，第二个为进行授权验证的数据
        //  这里的update是指授权类里面的update 也就是Policies\UserPolicy.php这个类
        $this->authorize('update',$user);

        return view('users.edit',compact('user'));
    }

    public function update(User $user,Request $request){
        //  authorize 方法接收两个参数，第一个为授权策略的名称，第二个为进行授权验证的数据
        //  这里的update是指授权类里面的update 也就是Policies\UserPolicy.php这个类
        $this->authorize('update',$user);

//        nullable，这意味着当用户提供空白密码时也会通过验证
        $this->validate($request,[
           'name'      => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;

        // 存在password的时候进行更改，没有就不进行更改
        if ($request->password){
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success','个人资料更新成功');

        return redirect()->route('users.show',$user);
    }

}
