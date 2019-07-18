<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\product_price;
use App\Models\order;
use Response;

class KasirController extends Controller
{
    function index(){
        $data = product::with('price')->get();
    	return view('pages.kasir',compact('data'));
    }

    function list(Request $request){
        $x = explode(',',$request->name);
        $data = [
            "product_id" => $x[0],
            "customer_name" => $x[1],
            "order_price_total" => $x[2]*$request->qty,
            "order_qty" => $request->qty,
        ];
        return Response::json($data);
    }

    function store(Request $request){
        $data = json_decode($request->data, TRUE);
        // $uniq = "POS-".date('m');
        order::insert($data);
        // date("Y-m-d H:i:s");
        return Response::json(['status'=>true]);
        // dd($data);
    }

}
