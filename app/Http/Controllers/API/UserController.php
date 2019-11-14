<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use App\Models\Order;
use App\Models\User;

use Carbon\Carbon;
//use function GuzzleHttp\Promise\queue;
use http\Env\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Validator;
use Illuminate\Http\Request;
//use Kreait\Firebase\Exception\FirebaseException;
use App\Models\ConfirmRegister;
use App\Notifications\RegisterRequest;
use App\Notifications\RegisterSuccess;

class UserController extends Controller
{


    public function register(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|unique:users,username',
                'email' => 'required|unique:users,email',
                'name' => 'required',
                'password' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'images.*' => 'image|mimes:jpg,jpeg,png',
                'role' => 'numeric|max:2:',
            ]);
            if ($validator->fails()) {
                return $this->fail($validator->errors(), $validator->messages()->first(), "Fail", 401);
            }
            $input = $request->all();
            $input['password'] = bcrypt($request->get('password'));
            $user = User::create($input);

            // If isset role
            if($request->has('role')){
                $user->role = $request->get('role');
                $user->save();
            }

            if ($user) {
                // if add images
                if ($request->hasFile('images')) {

                    $user->addAllMediaFromRequest('images')->each(function ($fileImages) {
                        $fileImages->toMediaCollection("image-user");

                    });
                }

                $confirm_register = ConfirmRegister::updateOrCreate(
                    ['email' => $user->email],
                    [
                        'email' => $user->email,
                        'token'=> Str::random(100)
                    ]
                );
                if($confirm_register){
                    $user->notify(new RegisterRequest($confirm_register->token));
                    return response()->json([
                        'message' => 'We have e-mailed your register account link!',
                        'result' => 200,
                        'data' => $user,
                    ]);
                }
            }
            return $this->success($user, " Register Successful");
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function confirmRegister(Request $request){
        try{
            $validator = Validator::make($request->all(),[
               'email' => 'required|email',
               'token' => 'required',
            ]);
            if($validator->fails()){
                return $this->fail($validator->errors(), $validator->messages()->first(), "Fails", 401);
            }

            //Delete all users over 1 hour not active
            $list_user = User::all();
            $list_email_confirm = ConfirmRegister::all();
            if($list_user){
                foreach($list_user as $user){

                    // Users out of date confirm register
                    if(Carbon::parse($user->created_at)->addMinutes(60)->isPast()){
                            if($user->status == User::deactive){
                                // delete images
                                foreach($user->media as $media){
                                    $media->delete();
                                }
                                // delete email need confirm
                                if($list_email_confirm){
                                    foreach($list_email_confirm as $email){
                                        if($user->email == $email->email){
                                            $email->delete();
                                        }
                                    }
                                }

                                $user->delete();
                            }
                    }

                }
            }
            //
            // $confirm_register = ConfirmRegister::where('email', $request->get('email'))->where('token', $request->get('token'))->first();
            // OR
            $confirm_register = ConfirmRegister::whereEmailAndToken($request->get('email'), $request->get('token'))->first();

            if(!$confirm_register){
                return response()->json([
                    'message' => 'This register token is invalid',
                ]);
            }
            //
            $user =  User::where('email',$confirm_register->email)->first();
            if(!$user){
                return response()->json([
                   'message' => 'Cannot find user with that email address',
                ]);
            }
            //
            if(Carbon::parse($confirm_register->created_at)->addMinutes(60)->isPast()){
                $confirm_register->delete();
                return response()->json([
                    'message' => 'This register token is invalid.'
                ], 404);
            }
            //
            if($confirm_register && $user){
                $user->status = 1;
                $user->save();
                $confirm_register->delete();
                $user->notify(new RegisterSuccess($user));
                return $this->success($user,'Confirm account successful');
            }


        }
        catch(\ Exception $e){
            return $this->error($e);
        }


    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => "required",
                'password' => 'required',
                'remember_me' => 'boolean',
                'device_token' => 'required',
                'mac_address' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->fail($validator->errors(), $validator->messages()->first(), 'Fail', 401);
            }
            $credentials = ['username' => $request->get('username'), 'password' => $request->get('password')];

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Username or password incorrect',
                ], 401);
            }
//            if(Auth::attempt($credentials) && Auth::user()->role == User::Member){
//                return response()->json([
//                   'message' => 'You do not have permission to log in to the admin system',
//                ]);
//            }

            $user = Auth::user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            if ($request->has('remember_me')) {
                $token->expires_at = Carbon::now()->addWeeks(1);
            }
            $token->save();
            $user->token_type = "Bearer";
            $user->access_token = $tokenResult->accessToken;
            $user->expires_at = Carbon::parse($tokenResult->token->expires_at)->toDateTimeString();
            $user->store;

            $device = DeviceToken::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'user_id' => $user->id,
                    'device_token' => str_replace('%3A',':', $request->get('device_token')),
                    'mac_address' => $request->get('mac_address'),
                ]
            );

            // Or
//            $device = DeviceToken::where('user_id', $user->id)->first();
//            if($device){
//                $device->update([
//                   'device_token' => str_replace("%3A" , ":" ,$request->get('device_token')),
//                    'mac_address' => $request->get('mac_address'),
//                ]);
//            }
//            else{
//                $user->deviceToken()->create([
//                    'device_token' => str_replace("%3A" , ":" ,$request->get('device_token')),
//                    'mac_address' => $request->get('mac_address'),
//                ]);
//            }

            return $this->success($user, "Login successful");
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = Auth::user();
            $user->token()->revoke();
            return $this->success($user, 'Logout Successful');
        } catch (\ Exception $e) {
            return $this->error($e);
        }
    }

    public function getUserLogin(Request $request)
    {
        try {
            $user = Auth::user();
            $media_urls = [];
            foreach ($user->media as $media) {
                $media_urls[] = [
                    'origin_url' => $media->getFullUrl(),
                    'thumbnail_url' => $media->getFullUrl('thumb'),
                ];
            }
            $user->images = count($media_urls) ? $media_urls : null;
            $user->avatar = count($media_urls) ? $media_urls[0] : null;
            return $this->success($user, "Info User Login");
        } catch (\ Exception $e) {
            return $this->error($e);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'required',
                're_new_password' => 'required|same:new_password',
            ]);
            if ($validator->fails()) {
                return $this->fail($validator->errors(), $validator->messages()->first(), 'Fail', 401);
            }
            $user = Auth::user();
            $old_password = $request->get('old_password');
            $check = Auth::guard('web')->attempt([
                'email' => $user->email,
                'password' => $old_password,
            ]);
            $new_password = $request->get('new_password');
            if ($new_password == $old_password) {
                return response()->json([
                    'message' => 'Cannot reuse old password',
                ]);
            }
            $user->password = bcrypt($new_password);
            $user->token()->revoke();
            $tokenResult = $user->createToken('New Token ');
            $token = $tokenResult->accessToken;
            $user->save();
            $user->accessToken = $token;
            $user->store;
            return $this->success($user, 'Change Password Successful');
        } catch (\ Exception $e) {
            return $this->error($e);
        }
    }

    public function updateUserLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'email',
                'images.*' => 'image|mimes:jpg,jpeg,png',
            ]);
            if ($validator->fails()) {
                return $this->fail($validator->errors(), $validator->messages()->first(), 'Fail', 401);
            }
            $user = Auth::user();
            $new_user = $user->update([
                'name' => $request->get('name'),
                'username' => $user->username,
                'email' => $request->has('email') ? $request->get('email') : $user->email,
                'phone' => $request->phone,
                'address' => $request->get('address'),
            ]);
            if ($request->hasFile('images')) {
                foreach ($user->media as $img) {
                    $img->delete();
                }
                $user->addAllMediaFromRequest('images')->each(function ($file_img) {
                    $file_img->toMediaCollection('image-user');
                });
            }
            return $this->success($user, "Update Info User Successful");
        } catch (\ Exception $e) {
            return $this->error($e);
        }
    }

    public function deleteUserLogin(Request $request)
    {
        try {
            $user = Auth::user();
            foreach ($user->media as $media) {
                $media->delete();
            }
            $user->delete();
            return $this->success($user, "Delete Successful");
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function sendMail(Request $request)
    {
        try {
            Mail::raw('Hi, welcome user!', function ($message) {
                $message->to('gs.hoanganh@gmail.com')
                    ->subject('test');
            });
        } catch (\ Exception $e) {
            return $this->error($e);
        }
    }


    public function getListUsers(Request $request){
        try{
            $list_users = [22,34];

            $users = User::findOrFail([$list_users]);
            return $this->success($users, "List Users");
        }
        catch(\Exception $e){
            return $this->error($e);
        }
    }

        public function editUserById(Request $request){
        try{
           $validator = Validator::make($request->all(), [
               'name' => 'required',
                'email' => 'required|email',
                'address' => 'required',
                'phone' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->fail($validator->errors(), $validator->messages()->first(), 'Fail', 401);
            }
             User::findOrFail($request->id)->update([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'address' => $request->get('address'),
            ]);
            return $this->success(User::findOrFail($request->id), ' Update User Successful');

        }catch(\ Exception $e){
            return $this->error($e);
        }



    }

    public function deleteUserById(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            $user->delete();
            return $this->success($user, ' Delete User Successful');
        } catch (\ Exception $e) {
            return $this->error($e);
        }
    }

    public function uploadImages(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [

                'images.*' => 'required|image|mimes:jpg,jpeg,png'
            ]);
            if ($validator->fails()) {
                return $this->fail($validator->errors(), $validator->messages()->first(), 'Fail', 401);
            }
            $user = User::findOrFail($request->id);
            if($user){
                if($request->hasFile('images')){
                    $user->addAllMediaFromRequest('images')->each(function($file){
                        $file->toMediaCollection('image - user');
                    });

                    return response()->json([
                        'message' => ' Upload success',

                    ]);
                }
            }


        } catch (\ Exception $e) {
            return $this->error($e);
        }
    }



}
