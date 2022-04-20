<?php

namespace App\Http\Controllers\Api;

use RsaCrypt;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\ClientRepository;

class UserController extends Controller
{
    public $successStatus = 200;
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function login(Request $req)
    {
        $req->validate([
            'phone' => 'required|string|size:10',
            'password' => 'required|string'
        ]);
        // return Hash::make('password');
        // echo $req->phone;
        if (Auth::attempt(['phone' => $req->phone, 'password' => $req->password])) {
            $user = Auth::user();
            $token =  $user->createToken('MyApp')->accessToken;
            return response()->json([
                'status_code' => 'NHA-200',
                'message' => 'success',
                'token_timeout' => 120,
                'token' => $token

            ], $this->successStatus);
        } else {
            return response()->json([
                'message' => 'unauthorised'
            ], 401);
        }
    }

    function getUID($userId)
    {
        $data = User::where('id', $userId)->get();
        if (count($data) > 0) {
            $arr = [];
            foreach ($data as $row) {
                $arr['user'][] = $row;
            }
            return response()->json($arr, 200);
        } else {
            $arr = <<<DATA
            {"user": [{"id":"undefined"}]}
            DATA;
            return $arr;
        }
    }


    function getNotification(Request $req)
    {
        $arr['notification']["id"] = 18;
        $arr['notification']["channelId"] = "My App";
        $arr['notification']["status"] = "Pending";
        $arr['notification']["body"] = "Hello Ngata team I'm here for you";
        // if (Auth::user()->id == $req->uid) {
        //     $arr['notification']["id"] = 11;
        //     $arr['notification']["channelId"] = "My App";
        //     $arr['notification']["status"] = "Pending";
        //     $arr['notification']["body"] = "Hello Ngata team I'm here for you";
        // } else {
        //     $arr['notification']["id"] = 13;
        //     $arr['notification']["channelId"] = "all";
        //     $arr['notification']["status"] = "Pending";
        //     $arr['notification']["body"] = "Today is my birthday";
        // }

        return response()->json($arr, 200);
    }


    function userKeys()
    {
        // Get the passport client repository
        // $clientRepository = app('Laravel\Passport\ClientRepository');

        // // for machine-to-machine authentication
        // $client = $clientRepository->create(null, 'myclient', '');

        // // gets the client's id and secret
        // $clientSecret = $client->secret;
        // $clientId = $client->id;

        $clientRepository = new ClientRepository();
        $client = $clientRepository->create(32, 'myclient', '');
        $clientSecret = $client->secret;
        $clientId = $client->id;
    }


    function test(Request $req)
    {
        // return $req;
        $crypt = new RsaCrypt();
        $crypt->genKeys(1024);
        $crypt->setPublicKey(storage_path('oauth-public.key'));
        return $crypt->encrypt($req->all());
    }

    function decrypt(Request $req) {
        try {
        $crypt = new RsaCrypt();
        $crypt->setPrivateKey(storage_path('oauth-private.key'));
        return  response()->json(json_decode($crypt->decrypt($req->payload)));
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }


}
