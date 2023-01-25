<?php

namespace App\Http\Controllers;

use App\Product;
use Validator;
use Illuminate\Http\Request;

class ApiProductController extends Controller
{

    public function createData(Request $request){

      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'price' => 'required|numeric',
        'desc' => 'required|max:100'
      ]);

      if($validator->fails()){
        return response()->json([
          'error' => $validator->errors()
        ]);
      }

      Product::create([
        'name' => $request->name,
        'price' => $request->price,
        'desc' => $request->desc,
      ]);
      return response()->json([
        'message' => 'Success create data'
      ]);
    }

    public function getAllData(){
        $product = Product::all();
        return response()->json([
          'productAll' => $product
        ]);
    }

    public function getData($id){
      $product = Product::findOrFail($id);
      return response()->json([
        'product' => $product
      ]);
    }

    public function searchData(Request $request){
      $product = Product::where('name','LIKE','%'. $request->name.'%')->get();
      return response()->json([
        'productSearch' => $product
      ]);
    }

    public function updateData(Request $request, $id){
      $products = Product::findOrFail($id)->update(
        [
          'name' => $request->name,
          'price' => $request->price,
          'desc' => $request->desc,
        ]);
        return response()->json([
          'message' => 'success update data'
        ]);
    }

    public function deleteData($id){
      $data = Product::destroy($id);
      return response()->json([
        'data' => $data,
        'messages' => 'success delete data'
      ]);
    }
}
