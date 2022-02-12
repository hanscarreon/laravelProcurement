<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


// tools
use Illuminate\Support\Faceds\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Accounts;
use Exception;

class accountsController extends Controller
{
    //
    public function registerUser(Request $req)
    {
        $data['status'] =  false;
        $data['data'] =  [];
        $data['message'] =  [];
        try {

            $validator = Validator::make($req->input(), [
                'ac_email' => ['required', 'email', 'unique:accounts'],
                'ac_firebase_id' => ['required', 'string', 'unique:accounts'],
                'ac_first_name' => ['required', 'min:3', 'string'],
                'ac_last_name' => ['required', 'min:3', 'string'],
            ]);
            $inputData = $req->input();

            if ($validator->fails()) {
                return $this->errorResponse(
                    $validator->errors()->messages(),
                    $inputData,
                );
            }

            $inputData['ac_email'] = $this->clean_input($inputData['ac_email']);
            $inputData['ac_first_name'] = $this->clean_input($inputData['ac_first_name']);
            $inputData['ac_last_name'] = $this->clean_input($inputData['ac_last_name']);
            $inputData['ac_firebase_id'] = $this->clean_input($inputData['ac_firebase_id']);
            // clean all input
            $inputData['ac_created_at'] = $this->getDatetimeNow();
            $user_id = Accounts::insertGetId($inputData); // save dynamic key  value pairs, key must exist as cols in db
            $inputData['ac_id'] = $user_id;
            return $this->successResponse(
                'successfully registered!',
                $inputData,
            );
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
