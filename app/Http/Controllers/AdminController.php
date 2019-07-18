<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;

class AdminController extends Controller
{
    function index(){
    	$data = product::all();
    	return view('pages.admin',compact('data'));
    }

    function create(){

    }

    function store(Request $request){
    	// $userId = $request->user_id;
     //    $user   =   product::updateOrCreate(['id' => $userId],
     //                ['name' => $request->name, 'email' => $request->email]);
    	dd($request->all());
        $data = product::create($request->all());
    
        return Response::json($data);
    }

    function show(){

    }

    function edit($id){
    	$where = array('id' => $id);
        $user  = product::where($where)->first();
 
        return Response::json($user);
    }

    function update(){

    }

    function destroy($id){
    	$user = product::where('id',$id)->delete();
   
        return Response::json($user);
    }

}
