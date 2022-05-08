<?php

namespace App\Http\Controllers\Callback;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Curl\CurlRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\SMS\SMSController;

class VodacomController extends Controller
{
    public function CallbackReceiver(Request $req) {
       
        if ($req->input_ResponseCode === 'INS-0') {
           $data = array(
               'status_code' => $req->input_ResponseCode,
               "tpconversation_id" =>  $req->input_ThirdPartyConversationID,
           );
           return CurlRequests::_openapi_curlpost($data);
        } else {
            $data = array(
                'status_code' => $req->input_ResponseCode,
                "tpconversation_id" =>  $req->input_ThirdPartyConversationID,
            );
            return CurlRequests::_openapi_curlpost($data);
        }
    }
}
