<?php

namespace App\Http\Controllers\user;

use App\Accounts;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function getUser(Request $req)
    {
        try {
            $userModel = new Accounts();
            $user_id = $req->id;

            if ($user_id != 'user_id') {
                $userModel = $userModel->where('accounts.ac_firebase_id', $user_id );
            }
            $userModel = $userModel->get();
            $msg = count($userModel).' found';
            return $this->successResponse(
                $msg,
                $userModel,
            );
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function updateProfile(Request $req)
    {
        try {
            $id = $req->id;
            $validator = Validator::make($req->input(), [
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
            

            $inputData['ac_first_name'] = $this->clean_input($inputData['ac_first_name']);
            $inputData['ac_last_name'] = $this->clean_input($inputData['ac_last_name']);
            // clean all input
            $inputData['ac_updated_at'] = $this->getDatetimeNow();
            $updated_data = Accounts::where('ac_firebase_id',$id)->update($inputData); 
            return $this->successResponse(
                'successfully updated!',
                $updated_data,
            );
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
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

            $inputData = $req->input();
            if ($validator->fails()) {
                return $this->errorResponse(
                    $validator->errors()->messages(),
                    $inputData,
                );
            }

            $inputData = $req->input();
            $inputData['ac_facebook'] = $this->clean_input($inputData['ac_facebook']);
            $inputData['ac_instagram'] = $this->clean_input($inputData['ac_instagram']);
            // clean all input
            $inputData['ac_updated_at'] = $this->getDatetimeNow();
            $updated_data = Accounts::where('ac_firebase_id',$id)->update($inputData); 
            return $this->successResponse(
                'successfully updated!',
                $updated_data,
            );
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    
}
