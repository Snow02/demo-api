<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Messaging\Message;

class FirebaseController extends Controller
{
    protected $userRepository;
    protected $database;
    protected $firebase;




    public function sendNotification()
    {
        try{
            $serviceAccount = ServiceAccount::fromJsonFile(public_path('firebase/testing-api-96559-firebase-adminsdk-efyyb-5eedbf0a0d.json'));
            $factory  = (new Factory())
                            ->withServiceAccount($serviceAccount)
                            ->withDatabaseUri('https://testing-api-96559.firebaseio.com');


            $messaging = $factory->createMessaging();

            $deviceToken = 'BA5ScR2hLda6MPfQoZkGuW_6yEiHnTXYnCDYegGlVGBDoJErUZ3tcvppnmaSo5PEsc3XckkAwGIawccQKbKD3s0';
            $title = "Hello";
            $body = "Test push notification";
            $data = [
                'name' => 'Tran Anh',
                'email' => 'gs.hoanganh@gmail.com',
            ];
            $message = CloudMessage::withTarget('token', $deviceToken)
                ->withNotification(Notification::create($title, $body))
                ->withData($data);

            $messaging->send($message);
            return response()->json('','Push notification success');
        }
        catch (\ Exception $e){
            return $this->error($e);
        }

    }

}
