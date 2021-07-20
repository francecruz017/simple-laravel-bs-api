<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Products;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::get();

        return response($products, 200);
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
        $products = Products::find($id);

        return response($products, 200);
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
        $products = Products::find($id);
        if($products->delete()) {
            return response(["message" => "Deleted"], 200);
        }
    }

    public function save($request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:85',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response(["message"=> "Error"], 400);
        }

        if(!$id) {
            $products = new Products;
        } else {
            $products = Products::find($id);
        }

        $products->name = $request->name;
        $products->price = $request->price;
        if($products->save()) {
            return response(["message" => "product saved"], 200);
        }
    }
}
