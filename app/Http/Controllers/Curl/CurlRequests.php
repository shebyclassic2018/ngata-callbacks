<?php

namespace App\Http\Controllers\Curl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CurlRequests extends Controller
{
    //

    public static function _curlpost($url, $data)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'accept: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }


    public static function _openapi_curlpost($data)
    {
        if (env('Message_Env') === 'local') {
            return CurlRequests::_curlpost('http://127.0.0.1:8001/request/callback-processor', $data);
        } else {
            return CurlRequests::_curlpost('http://openapi.ngata.co.tz/request/callback-processor', $data);
        }
    }
}
