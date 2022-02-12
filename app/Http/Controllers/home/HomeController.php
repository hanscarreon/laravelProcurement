<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Products;
use Exception;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getAllProducts(Request $req)
    {
        $data['message'] = '';
        $data['status'] = false;
        $data['body'] = [];
        try {
            $productModel = new Products();
            $productModel = $productModel->where('products.product_status', 'active');
            $productModel = $productModel->get();

            $msg = count($productModel).' found';
            return $this->successResponse(
                $msg,
                $productModel,
            );
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
