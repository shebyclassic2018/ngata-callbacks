<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment\AppointmentPayment;

class PaymentController extends Controller
{
    //

    function getAppointmentByMerchantId($merchantId) {
        $app = AppointmentPayment::where('merchantTransactionId', $merchantId)->get();
        if (count($app) > 0) {
            foreach($app as $row) {
                return $row;
            }
        }

        return response()->json([
            'merchantTransactionID' => $merchantId,
            'status_code' => 'NHA-111',
            'message' => 'No record found'
        ]);
    }

    function pendingAppointment() {
        $app = AppointmentPayment::where('status', 'Pending')->get();
        if (count($app) > 0) {
            $arr = [];
            foreach ($app as $row) {
                $arr[] = $row;
            }
            return response()->json($arr);
        } else {
            return response()->json([
                'status_code' => 'NHA-111',
                'message' => 'No pending payment'
            ]);
        }
    }
    
    function paidAppointment() {
        $app = AppointmentPayment::where('status', 'Paid')->get();
        if (count($app) > 0) {
            $arr = [];
            foreach ($app as $row) {
                $arr[] = $row;
            }
            return response()->json($arr);
        } else {
            return response()->json([
                'status_code' => 'NHA-111',
                'message' => 'No paid payment'
            ]);
        }
    }
}
