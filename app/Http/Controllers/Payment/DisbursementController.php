<?php

namespace App\Http\Controllers\Payment;

use App\Models\NgataTarif;
use Illuminate\Http\Request;
use Spatie\ArrayToXml\ArrayToXml;
use App\Http\Controllers\Controller;
use App\Models\Payment\PaymentService;
use App\Models\Payment\AppointmentDisbursement;

class DisbursementController extends Controller
{
    function disbursement()
    {
        // $remarkableType = $elligiblefeedback->remarkable_type;
        // $remarkableId = $elligiblefeedback->remarkable_id;

        // $financials = Financial::where('financialable_type', $remarkableType)
        // ->where('financialable_id', $remarkableId)->first();

        // return $financials;

        $appointment_disbursement = AppointmentDisbursement::join('feedback as f', ['f.id' => 'appointment_disbursements.feedback_id'])
            ->join('financials as fin', ['financialable_type' => 'remarkable_type', 'remarkable_id' => 'financialable_id'])
            ->join('appointments as app', ['app.id' => 'f.appointment_id'])
            ->join('ngata_tarifs as ng', ['ng.id' => 'tarif_id'])
            ->where('tarif_id', 1)
            ->where('app.visit_status', 'Completed')
            ->get();

        if (count($appointment_disbursement) > 0) {
            $payload['disbursementList'] = [];
            foreach ($appointment_disbursement as $row) {
                $payload['disbursementList']['source_account'] = $this->AppointmentSourceAccount();
                $payload['disbursementList']['amount'] = $row->amount;
                $payload['disbursementList']['payments'] = [
                    [
                        'destination_account' => "005342123445",
                        'currencyCode' => 'TZS',
                        'amountToDisburse' => (($row->guider / 100) * $row->amount),
                        'Narration' => "Agent payment",
                        'transaction_commision' => ''
                    ], [
                        'destination_account' => $this->AppointmentSourceAccount(),
                        'currencyCode' => 'TZS',
                        'amountToDisburse' => (($row->system / 100) * $row->amount),
                        'Narration' => "Commision",
                        'transaction_commision' => ''
                    ]
                ];
                $payload['disbursementList']['statusCode'] = 183;
                $payload['disbursementList']['statusDescription'] = "success";
            }
        } else {
            $payload['disbursementList']['statusCode'] = 180;
            $payload['disbursementList']['statusDescription'] = "No record found";
        }

        return ArrayToXml::convert($payload);
    }

    function array_to_xml($array, &$xml)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xml->addChild($key);
                    $this->array_to_xml($value, $subnode);
                } else {
                    $this->array_to_xml($value, $subnode);
                }
            } else {
                $xml->addChild($key, $value);
            }
        }
    }

    function AppointmentSourceAccount()
    {
        return PaymentService::where('serviceName', 'Appointment')->first()->accountNumber;
    }
}
