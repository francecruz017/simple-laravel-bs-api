<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Orders;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Orders::get();

        return response($orders, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->save($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Orders::find($id);

        return response($order, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->save($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orders = Orders::find($id);
        if($orders->delete()) {
            return response(["message" => "Deleted"], 200);
        }
    }

    public function save($request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'total_price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response(["message"=> "Error"], 400);
        }

        if(!$id) {
            $orders = new Orders;
        } else {
            $orders = Orders::find($id);
        }
        
        $orders->member_id = $request->member_id;
        $orders->product_id = $request->product_id;
        $orders->quantity = $request->quantity;
        $orders->total_price = $request->total_price;

        if($orders->save()) {
            return response(["message" => "orders saved"], 200);
        }
    }
}
