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
        $data['status'] =  false;
        $data['data'] =  [];
        $data['message'] =  [];
        try {

            $validator = Validator::make($req->input(), [
                'bp_product_id' => ['required'],
                'bp_firebase_user_id' => ['required', 'string',],
                'bp_comment' => ['required', 'string',],
                'bp_ammount_bid' => ['required',]
            ]);

            if ($validator->fails()) {
                $data['message'] = $validator->errors();
                return $data;
            }
            $inputData = $req->input();
            $inputData['bp_product_id'] = $this->clean_input($inputData['bp_product_id']);
            $inputData['bp_firebase_user_id'] = $this->clean_input($inputData['bp_firebase_user_id']);
            $inputData['bp_ammount_bid'] = $this->clean_input($inputData['bp_ammount_bid']);
            $inputData['bp_comment'] = $this->clean_input($inputData['bp_comment']);
            // clean all input
            $inputData['bp_created_at'] = $this->getDatetimeNow();
            $id = BidProducts::insertGetId($inputData); // save dynamic key  value pairs, key must exist as cols in db
            $inputData['id'] = $id;
            // $this->send_verification($user_data);
            $data['message'] = "successfully bid!";
            $data['data'] = $inputData;
            $data['status'] =  true;
            return $data;
        } catch (Exception $e) {
            $data['message'] = $e;
            return $data;
        }
    }
}
