<?php

use App\Models\Payment\PaymentService;

if (!function_exists('AppointmentSourceAccount')) {
    function AppointmentSourceAccount() {
        return PaymentService::where('serviceName', 'Appointment')->first()->accountNumber;
    }
}