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
            $inputData = $req->input();

            if ($validator->fails()) {
                return $this->errorResponse(
                    $validator->errors()->messages(),
                    $inputData,
                );
            }

            $file = $req->file('product_img');
            $inputData['product_img'] = null;
            if ($file) {
                $extension = $file->extension();
                $new_image_name = strval($this->generateUid()) . '.' . $extension;
                $file->move(public_path('image/products/'), $new_image_name);
                $inputData['product_img'] = 'image/products' . $new_image_name;
            }

            $inputData['product_name'] = $this->clean_input($inputData['product_name']);
            $inputData['ac_firebase_id'] = $this->clean_input($inputData['ac_firebase_id']);
            $inputData['product_description'] = $this->clean_input($inputData['product_description']);
            $inputData['product_category'] = $this->clean_input($inputData['product_category']);
            $inputData['product_min_bid'] = $this->clean_input($inputData['product_min_bid']);
            $inputData['product_start_date'] = $this->clean_input($inputData['product_start_date']);
            $inputData['product_end_date'] = $this->clean_input($inputData['product_end_date']);
            // clean all input
            $inputData['product_created_at'] = $this->getDatetimeNow();
            $id = Products::insertGetId($inputData);
            $inputData['product_id'] = $id;
            return $this->successResponse(
                'successfully created!',
                $inputData,
            );
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function updateProduct(Request $req)
    {

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

            $inputData = $req->input();

            if ($validator->fails()) {
                return $this->errorResponse(
                    $validator->errors()->messages(),
                    $inputData,
                );
            }

            $inputData['product_name'] = $this->clean_input($inputData['product_name']);
            $inputData['product_description'] = $this->clean_input($inputData['product_description']);
            $inputData['product_min_bid'] = $this->clean_input($inputData['product_min_bid']);
            $inputData['product_category'] = $this->clean_input($inputData['product_category']);
            $inputData['product_start_date'] = $this->clean_input($inputData['product_start_date']);
            $inputData['product_end_date'] = $this->clean_input($inputData['product_end_date']);
            // clean all input
            $inputData['product_updated_at'] = $this->getDatetimeNow();
            $updated_data = Products::where('product_id', $id)->update($inputData);
            return $this->successResponse(
                'successfully updated',
                $updated_data,
            );
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function deleteProduct(Request $req)
    {

        try {
            $id = $req->id;

            $inputData['product_status'] = 'deleted';
            // clean all input
            $inputData['product_updated_at'] = $this->getDatetimeNow();
            $updated_data = Products::where('product_id', $id)->update($inputData);
            return $this->errorResponse(
                'successfully deleted',
                $updated_data,
            );
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function getProducts(Request $req)
    {

        try {
            $productModel = new Products();

            $product_id = $req->id;

            if ($product_id != 'product_id') {
                $productModel = $productModel->where('products.ac_firebase_id', $product_id);
            }

            $productModel = $productModel->where('products.product_status', 'active');
            $productModel = $productModel->get();

            if (count($productModel) >= 1) {
                $this->data['status'] = true;
            }
            $msg = count($productModel) . ' found';
            return $this->errorResponse(
                $msg,
                $productModel,
            );
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function getProductById(Request $req)
    {
        try {
            $productModel = new Products();

            $product_id = $req->id;

            if ($product_id != 'product_id') {
                $productModel = $productModel->where('products.product_id', $product_id);
            }

            $productModel = $productModel->where('products.product_status', 'active');
            $productModel = $productModel->get();
            if (count($productModel) >= 1) {
                $this->data['status'] = true;
            }
            $msg = count($productModel) . ' found';
            return $this->errorResponse(
                $msg,
                $productModel,
            );
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
