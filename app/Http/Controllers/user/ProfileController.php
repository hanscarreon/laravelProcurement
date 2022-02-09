<?php

namespace App\Http\Controllers\user;

use App\Accounts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function getUser(Request $req)
    {
        $data['message'] = '';
        $data['status'] = false;
        $data['body'] = [];

        try {
            $userModel = new Accounts();
            $user_id = $req->id;

            if ($user_id != 'user_id') {
                $userModel = $userModel->where('accounts.ac_firebase_id', $user_id );
            }
            $userModel = $userModel->get();
            if(count($userModel) >= 1){
                $data['status'] = true;
            }

            $data['body'] = $userModel;
            return $data;

        } catch (\Exception $e) {
            $data['message'] = $e;
            return $data;
        }
    }

    public function updateProfile(Request $req)
    {
        $data['status'] = false;
        $data['data'] = [];
        $data['message'] = [];
        try {
            $id = $req->id;
            $validator = Validator::make($req->input(), [
                'ac_first_name' => ['required', 'min:3', 'string'],
                'ac_last_name' => ['required', 'min:3', 'string'],
            ]);

            if ($validator->fails()) {
                $data['message'] = $validator->errors();
                return $data;
            }

            $input_data = $req->input();
            $input_data['ac_first_name'] = $this->clean_input($input_data['ac_first_name']);
            $input_data['ac_last_name'] = $this->clean_input($input_data['ac_last_name']);
            // clean all input
            $input_data['ac_updated_at'] = $this->getDatetimeNow();
            $updated_data = Accounts::where('ac_firebase_id',$id)->update($input_data); 
            $data['message'] = 'successfully updated';
            $data['data'] = $updated_data;
            $data['status'] = true;
            return $data;
        } catch (\Exception $e) {
            $data['message'] = $e;
            return $data;
        }
    }

    public function submitUpdateSocialProfile(Request $req)
    {
        $data['status'] = false;
        $data['data'] = [];
        $data['message'] = [];
        try {
            $id = $req->id;
            $validator = Validator::make($req->input(), [
                'ac_facebook' => ['required', 'min:3', 'string'],
                'ac_instagram' => ['required', 'min:3', 'string'],
            ]);

            if ($validator->fails()) {
                $data['message'] = $validator->errors();
                return $data;
            }

            $input_data = $req->input();
            $input_data['ac_facebook'] = $this->clean_input($input_data['ac_facebook']);
            $input_data['ac_instagram'] = $this->clean_input($input_data['ac_instagram']);
            // clean all input
            $input_data['ac_updated_at'] = $this->getDatetimeNow();
            $updated_data = Accounts::where('ac_firebase_id',$id)->update($input_data); 
            $data['message'] = 'successfully updated';
            $data['data'] = $updated_data;
            $data['status'] = true;
            return $data;
        } catch (\Exception $e) {
            $data['message'] = $e;
            return $data;
        }
    }

    
}
