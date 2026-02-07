<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RajaOngkirService
{
    protected $apiKey;
    protected $baseUrl;
    protected $origin;

    public function __construct()
    {
        $this->apiKey = config('services.rajaongkir.key');
        $this->baseUrl = config('services.rajaongkir.base_url');
        $this->origin = config('services.rajaongkir.origin');
    }

    public function getProvinces()
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl . '/province');

        return $response->json();
    }

    public function getCities($provinceId = null)
    {
        $params = [];
        if ($provinceId) {
            $params['province'] = $provinceId;
        }

        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl . '/city', $params);

        return $response->json();
    }

    public function getSubdistricts($cityId)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl . '/subdistrict', [
            'city' => $cityId
        ]);

        return $response->json();
    }

    public function getCost($destination, $weight, $courier, $destinationType = 'subdistrict')
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->post($this->baseUrl . '/cost', [
            'origin' => $this->origin,
            'originType' => 'city', // Assuming shop location is a city
            'destination' => $destination,
            'destinationType' => $destinationType,
            'weight' => $weight,
            'courier' => $courier
        ]);

        return $response->json();
    }
}
