<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Hash;
use Session;
use App\User;

class LoginController extends Controller
{
    function auth(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'loginas' => 'required'
        ]);
    	$user = User::where('email',$request->email)->first();
    	if($user){
    		if(Hash::check($request->password,$user->password)) {
         		// dd('sukses');
         		$ses = [
         			'id' => $user->id,
         			'name' => $user->name,
         			'email' => $user->email
         		];
                if($user->hasRole($request->loginas)){
                    session::put(['isLogin' => $ses]);
                    return redirect($request->loginas);
                }else{
                    return redirect('/');
                }
    		}else{
    			dd('fail');
    		}
    	}else{
    		dd('fail');
    	}
    }

    function logout(Request $request){
    	$request->session()->flush();
    	return redirect('/');
    }


    function asignRole(){
    	$user = User::find(2);
    	$user->assignRole('kasir');
    	dd($user);
    }

}
