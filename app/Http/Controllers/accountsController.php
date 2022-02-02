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

            if ($validator->fails()) {
                $data['message'] = $validator->errors();
                return $data;
            }

            $user_data = $req->input();
            $user_data['ac_email'] = $this->clean_input($user_data['ac_email']);
            $user_data['ac_first_name'] = $this->clean_input($user_data['ac_first_name']);
            $user_data['ac_last_name'] = $this->clean_input($user_data['ac_last_name']);
            $user_data['ac_firebase_id'] = $this->clean_input($user_data['ac_firebase_id']);
            // clean all input
            $user_data['ac_created_at'] = $this->getDatetimeNow();
            $user_id = Accounts::insertGetId($user_data); // save dynamic key  value pairs, key must exist as cols in db
            $user_data['ac_id'] = $user_id;
            // $this->send_verification($user_data);
            $data['message'] = "successfully registered!";
            $data['data'] = $user_data;
            $data['status'] =  true;
            return $data;
        } catch (Exception $e) {
            $data['message'] = $e;
            return $data;
        }
    }
}
