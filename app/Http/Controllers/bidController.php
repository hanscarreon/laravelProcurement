<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// tools
use Illuminate\Support\Facades\Validator;

use App\BidProducts;
use Exception;

class bidController extends Controller
{
    //

    public function submitBid(Request $req)
    {
        try {

            $validator = Validator::make($req->input(), [
                'bp_product_id' => ['required'],
                'bp_firebase_user_id' => ['required', 'string',],
                'bp_comment' => ['required', 'string',],
                'bp_ammount_bid' => ['required',]
            ]);

            $inputData = $req->input();
            if ($validator->fails()) {
                return $this->errorResponse(
                    $validator->errors()->messages(),
                    $inputData,
                );
            }
            $inputData['bp_product_id'] = $this->clean_input($inputData['bp_product_id']);
            $inputData['bp_firebase_user_id'] = $this->clean_input($inputData['bp_firebase_user_id']);
            $inputData['bp_ammount_bid'] = $this->clean_input($inputData['bp_ammount_bid']);
            $inputData['bp_comment'] = $this->clean_input($inputData['bp_comment']);
            // clean all input
            $inputData['bp_created_at'] = $this->getDatetimeNow();
            $id = BidProducts::insertGetId($inputData); // save dynamic key  value pairs, key must exist as cols in db
            $inputData['id'] = $id;
            return $this->successResponse(
                'successfully bid!',
                $inputData,
            );
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function getProductBid(Request $req)
    {
        
        try {

            $product_id = $req->id;

            $bidModel = new BidProducts();
            $bidModel = $bidModel->join('accounts', 'accounts.ac_firebase_id', 'bid_products.bp_firebase_user_id');
            $bidModel = $bidModel->where('bid_products.bp_status', 'active');
            $bidModel = $bidModel->where('bid_products.bp_product_id', $product_id);
            
            $bidModel = $bidModel->get();

            $msg = count($bidModel)." bid data found";
            return $this->successResponse(
                $msg,
                $bidModel,
            );
            
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
