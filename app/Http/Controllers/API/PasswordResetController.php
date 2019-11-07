<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\Models\User;
use App\Models\PasswordReset;

class PasswordResetController extends Controller
{
    public function  sendMailResetPass(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'email' => 'required|email',
            ]);
            if($validator->fails()){
                return $this->fail($validator->errors(), $validator->messages()->first(), "fail", 401);
            }
            $user = User::whereEmail($request->email)->first();
            if(!$user){
                return response()->json([
                   'message' => 'Cannot find user with that email address ! Please try again',
                ]);
            }
            $passwordReset = PasswordReset::updateOrCreate(
                ['email' => $user->email],
                [
                    'email' => $user->email,
                    'token'=> Str::random(60),
                ]
            );
            if($user && $passwordReset){
                $user->notify(new PasswordResetRequest($passwordReset->token));
                return response()->json([
                   'message' => 'We have e-mailed your password reset link',
                ]);
            }

        }
        catch(\Exception $e){
            return $this->error($e);
        }
    }

    public function find(Request $request){
        try{
            $passwordReset = PasswordReset::where('token',$request->token)->first();
            if(!$passwordReset){
                return response()->json([
                   'message'=> 'This password reset token is invalid.',
                ]);
            }
            if(Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()){
                $passwordReset->delete();
                return response()->json([
                   'message' => 'This password reset token is invalid',
                ],404);

            }

            return $this->success($passwordReset,"User need reset password");
        }
        catch(\ Exception $e){
            return $this->error($e);
        }

    }

    public function resetPassword(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'email' => 'required|email',
                'token' => 'required',
                'new_password' => 'required',
                're_new_password' => 'required|same:new_password',
            ]);
            if($validator->fails()){
                return $this->fail($validator->errors(),$validator->messages()->first(), 'Fail',401);
            }

            $passwordReset = PasswordReset::where('email', $request->get('email'))->where('token', $request->get('token'))->first();
            if(!$passwordReset){
                $this->response()->json([
                   'message' => 'This password reset token is invalid',
                ]);
            }
            $user = User::where('email',$passwordReset->email)->first();

            if(!$user){
                $this->response()->json([
                    'message' => 'Cannot find user with that email address',
                ]);
            }
            $user->password = bcrypt($request->get('new_password'));
            $user->save();
            $passwordReset->delete();
            $user->notify(new PasswordResetSuccess($passwordReset));

            return $this->success($user, " Reset Password Successful");
        }
        catch(\ Exception $e){
            return $this->error($e);
        }


    }
}
