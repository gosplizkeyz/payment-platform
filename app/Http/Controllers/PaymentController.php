<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Models\Business;

class PaymentController extends Controller
{
    public function pay(Request $request, PaymentService $service)
    {
        $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'amount' => 'required|integer|min:100',
        ]);

        $business = Business::findOrFail($request->business_id);

        $reference = $service->process($business, $request->amount);

        // Detect JSON request (Postman) vs Browser
        if ($request->wantsJson()) {
            return response()->json(['reference' => $reference]);
        }

        // Browser: redirect back with success message
        return redirect()->back()->with('success', $reference);
    }
}
