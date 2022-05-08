<?php

namespace App\Http\Controllers\Callback;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Curl\CurlRequests;

class AirtelController extends Controller
{
    public function CallbackReceiver(Request $req) {
        if ($req->transaction->status_code === 'TS') {
           $data = array(
               'status_code' => $req->status_code,
               "tpconversation_id" =>  $req->id
           );
           return CurlRequests::_openapi_curlpost($data);
        }
    }
}
