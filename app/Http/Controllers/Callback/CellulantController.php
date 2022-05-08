<?php

namespace App\Http\Controllers\Callback;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Curl\CurlRequests;
use App\Http\Controllers\SMS\SMSController;

class CellulantController extends Controller
{
    //
    public function cellulantCallback(Request $req)
    {
        // $string = $req->all();
        // SMSController::sendMessage($string['requestStatusCode'], '0745681617');
        $decodedResponse = $req->all();
        if ($decodedResponse["requestStatusCode"] == 178) {
            /**
             * Write your code here
             * 1. Log the transaction to the database
             * 2. Validate the transaction
             * 3. respond back appropriately
             */


            $response = array(
                "statusCode" => 183,
                "statusDescription" => "Successful payment",
                "checkoutRequestID" => $decodedResponse["checkoutRequestID"],
                "merchantTransactionID" => $decodedResponse["merchantTransactionID"],
                "receiptNumber" => ""
            );
        } else {
            $response = array(
                "statusCode" => 180,
                "statusDescription" => "failed payment",
                "checkoutRequestID" => $decodedResponse["checkoutRequestID"],
                "merchantTransactionID" => $decodedResponse["merchantTransactionID"],
                "receiptNumber" => ""
            );
        }
        return response()->json($response);
    }

    public function CallbackReceiver(Request $req)
    {
         $decodedResponse = $req->all();
        if ($req->requestStatusCode == 178) {
            $data = array(
                'status_code' => 183,
                "tpconversation_id" =>  $req->merchantTransactionID
            );
            $response = array(
                "statusCode" => 183,
                "statusDescription" => "Successful payment",
                "checkoutRequestID" => $decodedResponse["checkoutRequestID"],
                "merchantTransactionID" => $decodedResponse["merchantTransactionID"],
                "receiptNumber" => ""
            );
            CurlRequests::_openapi_curlpost($data);
        } else {
            $response = array(
                "statusCode" => 180,
                "statusDescription" => "failed payment",
                "checkoutRequestID" => $decodedResponse["checkoutRequestID"],
                "merchantTransactionID" => $decodedResponse["merchantTransactionID"],
                "receiptNumber" => ""
            );
        }

        return response()->json($response);
    }
}
