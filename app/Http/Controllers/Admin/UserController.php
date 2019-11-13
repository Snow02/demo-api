<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function  getListUsers(){
        $users= User::all();
        return view('admin.list',compact('users'));
    }
    public function getEdit(Request $request, $id){
        $user = User::findOrFail($id);
        return view('admin.edit',compact('user'));
    }

    public function getAdd(){
        return view('admin.add');
    }
    public function upload(){
        return view('admin.upload');
    }



}
