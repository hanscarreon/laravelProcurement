<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Products;


class ProductController extends Controller
{
    public function createProduct(Request $req)
    {
        $data['status'] =  false;
        $data['data'] =  [];
        $data['message'] =  [];
        try {

            $validator = Validator::make($req->input(), [
                'product_name' => ['required', 'min:3', 'string'],
                'ac_firebase_id' => ['required', 'string', 'unique:accounts'],
                'product_description' => ['required', 'min:3', 'string'],
            ]);

            if ($validator->fails()) {
                $data['message'] = $validator->errors();
                return $data;
            }

            $input_data = $req->input();
            $input_data['product_name'] = $this->clean_input($input_data['product_name']);
            $input_data['ac_firebase_id'] = $this->clean_input($input_data['ac_firebase_id']);
            $input_data['product_description'] = $this->clean_input($input_data['product_description']);
            // clean all input
            $input_data['product_created_at'] = $this->getDatetimeNow();
            $id = Products::insertGetId($input_data); // save dynamic key  value pairs, key must exist as cols in db
            $input_data['product_id'] = $id;
            // $this->send_verification($input_data);
            $data['message'] = "successfully registered!";
            $data['data'] = $input_data;
            $data['status'] =  true;
            return $data;
        } catch (Exception $e) {
            $data['message'] = $e;
            return $data;
        }
    }
}
