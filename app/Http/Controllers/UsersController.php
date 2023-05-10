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
}
