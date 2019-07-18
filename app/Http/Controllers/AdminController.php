<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\product_price;
use Response;

class AdminController extends Controller
{
    function index(){
        $data = product::with('price')->get();
        // dd($data);
    	return view('pages.admin',compact('data'));
    }

    function create(){

    }

    function store(Request $request){
        $product = [
            "product_code"=>'A-01',
            "product_name"=>$request->name,
            "product_slug"=>str_replace(' ','-',$request->name),
            // "product_img"=>'A-01',
            // "product_description"=>'A-01',
            "stock"=>$request->stock
        ];
        $dt = product::create($product);
        $price = [
            "product_id"=>$dt->id,
            "currency"=>'Rp',
            "original_price"=>$request->purchase,
            "publish_price"=>$request->selling
        ];
        product_price::create($price);
        $data = product::with('price')->get();
        return Response::json($data);
    }

    function show($id){
        $data  = product::with('price')->find($id);
        return Response::json($data);
    }

    function edit($id){

    }

    function update(Request $request, $id){
        $data = [
            "product_name"=>$request->name,
            "product_slug"=>str_replace(' ','-',$request->name),
            "stock"=>$request->stock
        ];
        $price = [
            "original_price"=>$request->purchase,
            "publish_price"=>$request->selling
        ];
        $product = product::find($id);
        $productPrice = product_price::where('product_id',$id)->first();
        $product->update($data);
        $productPrice->update($price);
        $data = product::with('price')->find($id);
        return Response::json($data);
    }

    function destroy($id){
    	$data = product::find($id)->delete();
        return Response::json($data);
    }

}
