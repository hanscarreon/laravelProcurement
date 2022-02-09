<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Products;
use Exception;

class ProductController extends Controller
{
    public function createProduct(Request $req)
    {
        $data['status'] = false;
        $data['data'] = [];
        $data['message'] = [];
        try {
            $validator = Validator::make($req->input(), [
                'product_name' => ['required', 'min:3', 'string'],
                'ac_firebase_id' => ['required', 'string'],
                'product_description' => ['required', 'min:3', 'string'],
                'product_category' => ['required', 'string'],
                'product_min_bid' => ['required', 'integer'],
                'product_start_date' => ['required', 'date', 'after:tomorrow'],
                'product_end_date' => ['required', 'date', 'after:product_start_date'],
            ]);

            if ($validator->fails()) {
                $data['message'] = $validator->errors();
                return $data;
            }

            $file = $req->file('product_img');
            $input_data = $req->input();
            $input_data['product_img'] = null;
            if ($file) {
                $extension = $file->extension();
                $new_image_name = strval($this->generateUid()).'.' . $extension;
                $file->move(public_path('image/products'), $new_image_name);
                $input_data['product_img'] = 'image/products'.$new_image_name;
            }

            $input_data['product_name'] = $this->clean_input($input_data['product_name']);
            $input_data['ac_firebase_id'] = $this->clean_input($input_data['ac_firebase_id']);
            $input_data['product_description'] = $this->clean_input($input_data['product_description']);
            $input_data['product_category'] = $this->clean_input($input_data['product_category']);
            $input_data['product_min_bid'] = $this->clean_input($input_data['product_min_bid']);
            $input_data['product_start_date'] = $this->clean_input($input_data['product_start_date']);
            $input_data['product_end_date'] = $this->clean_input($input_data['product_end_date']);
            // clean all input
            $input_data['product_created_at'] = $this->getDatetimeNow();
            $id = Products::insertGetId($input_data);
            $input_data['product_id'] = $id;
            $input_data['titi'] =  strval($this->generateUid());
            $data['message'] = 'successfully created!';
            $data['data'] = $input_data;
            $data['status'] = true;
            return $data;
        } catch (Exception $e) {
            $data['message'] = $e;
            return $data;
        }
    }

    public function updateProduct(Request $req)
    {
        $data['status'] = false;
        $data['data'] = [];
        $data['message'] = [];
        try {
            $id = $req->id;
            $validator = Validator::make($req->input(), [
                'product_name' => ['required', 'min:3', 'string'],
                'product_description' => ['required', 'min:3', 'string'],
                'product_min_bid' => ['required', 'min:3', 'integer'],
                'product_category' => ['required', 'string'],
                'product_start_date' => ['required', 'date', 'after:tomorrow'],
                'product_end_date' => ['required', 'date', 'after:product_start_date'],
            ]);

            if ($validator->fails()) {
                $data['message'] = $validator->errors();
                return $data;
            }

            $input_data = $req->input();
            $input_data['product_name'] = $this->clean_input($input_data['product_name']);
            $input_data['product_description'] = $this->clean_input($input_data['product_description']);
            $input_data['product_min_bid'] = $this->clean_input($input_data['product_min_bid']);
            $input_data['product_category'] = $this->clean_input($input_data['product_category']);
            $input_data['product_start_date'] = $this->clean_input($input_data['product_start_date']);
            $input_data['product_end_date'] = $this->clean_input($input_data['product_end_date']);
            // clean all input
            $input_data['product_updated_at'] = $this->getDatetimeNow();
            $updated_data = Products::where('product_id', $id)->update($input_data);
            $data['message'] = 'successfully updated';
            $data['data'] = $input_data;
            $data['status'] = true;
            return $data;
        } catch (Exception $e) {
            $data['message'] = $e;
            return $data;
        }
    }

    public function deleteProduct(Request $req)
    {
        $data['status'] = false;
        $data['data'] = [];
        $data['message'] = [];
        try {
            $id = $req->id;

            $input_data['product_status'] = 'deleted';
            // clean all input
            $input_data['product_updated_at'] = $this->getDatetimeNow();
            $updated_data = Products::where('product_id', $id)->update($input_data);
            $data['message'] = 'successfully deleted';
            $data['data'] = $input_data;
            $data['status'] = true;
            return $data;
        } catch (Exception $e) {
            $data['message'] = $e;
            return $data;
        }
    }

    public function getProducts(Request $req)
    {
        $data['message'] = '';
        $data['status'] = false;
        $data['body'] = [];

        try {
            $productModel = new Products();

            $product_id = $req->id;

            if ($product_id != 'product_id') {
                $productModel = $productModel->where('products.ac_firebase_id', $product_id);
            }

            $productModel = $productModel->where('products.product_status', 'active');
            $productModel = $productModel->get();

            if (count($productModel) >= 1) {
                $data['status'] = true;
            }
            $data['body'] = $productModel;
            return $data;
        } catch (\Exception $e) {
            $data['message'] = $e;

            return $data;
        }
    }

    public function getProductById(Request $req)
    {
        $data['message'] = '';
        $data['status'] = false;
        $data['body'] = [];
        try {
            $productModel = new Products();

            $product_id = $req->id;

            if ($product_id != 'product_id') {
                $productModel = $productModel->where('products.product_id', $product_id);
            }

            $productModel = $productModel->where('products.product_status', 'active');
            $productModel = $productModel->get();
            if (count($productModel) >= 1) {
                $data['status'] = true;
            }
            $data['body'] = $productModel;
            return $data;
        } catch (\Exception $e) {
            $data['message'] = $e;

            return $data;
        }
    }
}
