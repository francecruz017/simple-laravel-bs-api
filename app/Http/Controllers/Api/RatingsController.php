<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Ratings;

class RatingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ratings = Ratings::get();

        return response($ratings, 200);
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
        $ratings = Ratings::find($id);

        return response($ratings, 200);
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
        $ratings = Ratings::find($id);
        if($ratings->delete()) {
            return response(["message" => "Deleted"], 200);
        }
    }

    public function save($request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'rating' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response(["message"=> "Error"], 400);
        }

        if(!$id) {
            $ratings = new Ratings;
        } else {
            $ratings = Ratings::find($id);
        }

        $ratings->member_id = $request->member_id;
        $ratings->product_id = $request->product_id;
        $ratings->rating = $request->rating;
        $ratings->comment = $request->input("comment", "");
        
        if($ratings->save()) {
            return response(["message" => "product saved"], 200);
        }
    }
}
