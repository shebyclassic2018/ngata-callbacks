<?php

namespace App\Http\Controllers\SMS;

use Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SMSController extends Controller
{
    //

    static function bearerToken() {
        $url = "https://sms.opestechnologies.co.tz/api/get-api-key";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array("Content-Type: application/json",);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $name = env('SMS_API_NAME');
        $password = env('SMS_API_PASSWORD');
        $data = <<<DATA
        {"name":"$name",
        "password":"$password"}
        DATA;

        // dd($data);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl,  CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        
        return json_decode($resp)->success->token;
    }

    // OPES TECHNOLOGIES SMS
    static function sendMessageOPES($message, $recipient)
    {

        $url = "https://sms.opestechnologies.co.tz/api/messages/send";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Authorization: Bearer " . SMSController::bearerToken(),
            "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $recipient = SMSController::validRecipient($recipient);
        $sender = env('SMS_API_SENDER');
        $channel = env('SMS_API_CHANNEL');
        $data = <<<DATA
        {"messages": [{
            "sender": "$sender",
            "channel": "$channel",
            "text": "$message",
            "msisdn": "$recipient",
            "msg_id": 1
          }]
        }
        DATA;

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        return json_decode($resp);
    }

    static function sendMessage($message, $phone, $user_id = 1) {
        if (env('Message_Env') == 'local' || env('Message_Env') == 'Local') {
            $result = SMSController::sendMessageOPES($message, $phone);
        } else if (env('Message_Env') == 'production' || env('Message_Env') == 'Production'){
            $result = SMSController::sendMessageBLSM($message, $phone, $user_id);
        }
        
        if (isset($result->successful)) {
            $result = "success";
        } else {
            foreach($result as $row) {
                if(isset($row->message)) {
                    $result = "success";
                } else {
                    $result = null;
                }
            }
            
            if (isset($result)) {
               $result = "success";
            } else {
                $result = "failed";
            }
        }
        return $result;
    }

    static function sendMessageBLSM($message, $recipient, $recipient_id) {
        $recipient = SMSController::validRecipient($recipient);            
        $api_key = env('SMS_API_KEY');
        $secret_key = env('SMS_API_SECRET');
        $postData = array(
            'source_addr' => env('SMS_SENDER'),
            'encoding'=>0,
            'schedule_time' => '',
            'message' => $message,
            'recipients' => [
                array('recipient_id' => '1','dest_addr'=> $recipient)
                ]
        );
        $Url ='https://apisms.beem.africa/v1/send';
        $ch = curl_init($Url);
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Authorization:Basic ' . base64_encode("$api_key:$secret_key"),
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($postData)
        ));
        $response = curl_exec($ch);
        if($response === FALSE){
            die(curl_error($ch));
        }
        $response = json_decode($response);
        return $response;
    }

    static function validRecipient($recipient) {
        if (strlen($recipient)) {
            if (substr($recipient, 0, 4) == "+255") {
                $recipient = str_replace('+255', '255', $recipient);
            } else if (substr($recipient, 0, 1) == '0') {
                $recipient = '255' . substr($recipient, 1, 9);
            } else if (substr($recipient, 0, 3) == "255") {

            } else {
                return false;
            }
        } else {
            return false;
        }
        return $recipient;
    }

    public static function sms(string $type, int $user_id = 0){
        switch ($type) {
            case 'otp': 
                return "Your verification code is " . SMSController::generateOTP($user_id);
        }
    }

    private static function generateOTP(int $user_id) {
        $code = random_int(100000, 999999);
        DB::table('otp_codes')->insert([
            'codes' => $code,
            'user_id' => $user_id
        ]);
        return $code;
    }
}
