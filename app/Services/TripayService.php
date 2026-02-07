<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TripayService
{
    protected $apiKey;
    protected $privateKey;
    protected $merchantCode;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.tripay.api_key');
        $this->privateKey = config('services.tripay.private_key');
        $this->merchantCode = config('services.tripay.merchant_code');
        $this->baseUrl = config('services.tripay.base_url');
    }

    public function getPaymentChannels()
    {
        $response = Http::withToken($this->apiKey)
            ->get($this->baseUrl . '/merchant/payment-channel');

        return $response->json();
    }

    public function requestTransaction($method, $merchantRef, $amount, $customerData, $orderItems)
    {
        $data = [
            'method'         => $method,
            'merchant_ref'   => $merchantRef,
            'amount'         => $amount,
            'customer_name'  => $customerData['name'],
            'customer_email' => $customerData['email'],
            'customer_phone' => $customerData['phone'],
            'order_items'    => $orderItems,
            'callback_url'   => route('tripay.callback'),
            'return_url'     => route('orders.show', ['order' => $merchantRef]), // Assuming merchant_ref is order ID or we have a way to map it
            'expired_time'   => (time() + (24 * 60 * 60)), // 24 hours
            'signature'      => $this->generateSignature($merchantRef, $amount)
        ];

        $response = Http::withToken($this->apiKey)
            ->post($this->baseUrl . '/transaction/create', $data);

        return $response->json();
    }

    public function detailTransaction($reference)
    {
        $response = Http::withToken($this->apiKey)
            ->get($this->baseUrl . '/transaction/detail', [
                'reference' => $reference
            ]);

        return $response->json();
    }

    protected function generateSignature($merchantRef, $amount)
    {
        return hash_hmac('sha256', $this->merchantCode . $merchantRef . $amount, $this->privateKey);
    }
}
