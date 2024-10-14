<?php

namespace App\Http\Controllers\Web\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\Plan;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment(Request $request, ?Plan $plan)
    {
        return view('web.payment', compact('plan'));
    }

    public function prepare(PaymentRequest $paymentRequest, Plan $plan)
    {
        
    }
}
