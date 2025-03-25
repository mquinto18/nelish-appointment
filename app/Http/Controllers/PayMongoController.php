<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class PayMongoController extends Controller
{
    private $paymongoSecretKey;

    public function __construct()
    {
        $this->paymongoSecretKey = env('PAYMONGO_SECRET_KEY');

        if (!$this->paymongoSecretKey) {
            throw new \Exception("PAYMONGO_SECRET_KEY is missing in .env file");
        }
    }

    public function gcashPayment(Request $request)
    {
        $client = new Client();
        $amount = $request->amount; // Retrieve amount from form input (already multiplied by 100)

        try {
            $response = $client->request('POST', 'https://api.paymongo.com/v1/links', [
                'json' => [
                    'data' => [
                        'attributes' => [
                            "amount" => (int) $request->amount, // Use the amount from the form
                            'description' => 'Appointment Payment',
                            'remarks' => 'Booking Payment via GCash',
                        ],
                    ],
                ],
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode(env('PAYMONGO_SECRET_KEY') . ':'),
                    'Content-Type' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            // Redirect the user to the PayMongo checkout link
            return redirect()->to($data['data']['attributes']['checkout_url']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function paymentSuccess()
    {
        return view('payment.success');
    }

    public function paymentFailed()
    {
        return view('payment.failed');
    }
}
