<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    
   

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" =>  "required|email",
            "password" =>  "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => false, "message" => $validator->errors()->first(), "data" => $validator->errors()]);
        }

        try {

            $user = User::where("email", $request->email)->first();

            if (is_null($user)) {
                return response()->json(["status" => false, "message" => "Failed! email not found", "data" => []]);
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user =  User::find(Auth::id());
                $token =  $user->createToken('token')->plainTextToken;
                $user->save();
                return response()->json(["status" => true, "message" => "","token"=>$token, "data" => $user]);

            } else {
                return response()->json(["status" => false, "message" => "Whoops! Invalid Credential", "data" => []]);
            }
        } catch (\Throwable $th) {
            return $this->sendServerError($th);
        }
    }



    public function profile()
    {
        try {

            // return Helper::test();
            $user = User::find(auth()->id(),['name','phone']);
            return response()->json(["status" => true, "message" => "", "data" => $user]);
           
        } catch (\Throwable $th) {
            return $this->sendServerError($th);
        }
    }




    
}
