<?php

namespace App\Http\Controllers;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PayPalController extends Controller
{
    public function index()
    {
        return view('payment');
    }

    public function payment(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.payment.success'),
                "cancel_url" => route('paypal.payment.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => Session::get('total')
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
                ->route('paypal.payment.cancel')
                ->with('error', 'Something went wrong.');
        } else {
            return redirect()
                ->route('paypal')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function paymentCancel()
    {
        return redirect()
            ->route('paypal')
            ->with('error', 'You have canceled the transaction.');
    }

    public function paymentSuccess(Request $request)
{
    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $provider->getAccessToken();
    $response = $provider->capturePaymentOrder($request['token']);

    if (isset($response['status']) && $response['status'] == 'COMPLETED') {
        $order_id = Session::get('order_id');
        $order_status = 'paid';
        $transaction_id = $response['id'];
        $payment_date = now()->toDateString();

        // Update the order status
        DB::table('orders')->where('id', $order_id)->update(['status' => $order_status]);

        // Insert the payment record
        DB::table('payments')->insert([
            'order_id' => $order_id,
            'transaction_id' => $transaction_id,
            'date' => $payment_date,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Fetch the updated order data
        $order = DB::table('orders')->where('id', $order_id)->first();

        if ($order) {
            // Calculate the delivery date
            $delivery_date = \Carbon\Carbon::parse($order->date)->addDays(2)->toDateString();

            // Clear the cart
            Session::forget('cart');

            return redirect()
                ->route('thank.you', ['order_id' => $order_id])
                ->with('delivery_date', $delivery_date);
        } else {
            return redirect()
                ->route('paypal')
                ->with('error', 'Order not found.');
        }
    } else {
        return redirect()
            ->route('paypal')
            ->with('error', $response['message'] ?? 'Something went wrong.');
    }
}

    public function thankYou($order_id)
    {
        $delivery_date = Session::get('delivery_date');

        return view('thank-you', compact('order_id', 'delivery_date'));
    }

}
