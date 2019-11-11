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

    protected $factory;


    public function __construct()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(public_path('firebase/testing-api-96559-firebase-adminsdk-efyyb-5eedbf0a0d.json'));
        $factory  = (new Factory())
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://testing-api-96559.firebaseio.com');
        return $this->factory = $factory;
    }

    public function sendNotification()
    {
        try{
//            $serviceAccount = ServiceAccount::fromJsonFile(public_path('firebase/testing-api-96559-firebase-adminsdk-efyyb-5eedbf0a0d.json'));
//            $factory  = (new Factory())
//                            ->withServiceAccount($serviceAccount)
//                            ->withDatabaseUri('https://testing-api-96559.firebaseio.com');


            $messaging = $this->factory->createMessaging();

            $deviceToken = 'dd-RjnBmjl0:APA91bEmRS36X6nullHP5p8ywXExgUD3wokfjzWsLBp1xKo4kZ0fZ5-fV6KPHWYY9rYidZzdc7qsY4FGzIWmKqisOzHRkRftYE0eLu54yHy3kbZPHORTCU8dOyMVm6KXFAeVqB3MrkVK';
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
            return response()->json([
                'message' => ' Push notification success',
            ]);
        }
        catch (\ Exception $e){
            return $this->error($e);
        }

    }

    public function  getListUser(Request $request){
        try{
            $database = $this->factory->createDatabase();
            $users = $database->getReference('user');
            $users = $users->getValue();
            return $this->success($users,"List Users");
        }catch(\Exception $e){
            return $this->error($e);
        }
    }

}
