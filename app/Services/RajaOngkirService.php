<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\ShippingCostCache;
use Carbon\Carbon;

class RajaOngkirService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.rajaongkir.url');
        $this->apiKey  = config('services.rajaongkir.key');
    }

    protected function request($endpoint, $params = [])
    {
        return Http::withHeaders([
            'key' => $this->apiKey
        ])->post($this->baseUrl . $endpoint, $params)->json();
    }

    public function getShippingCost($originCityId, $destinationCityId, $weight, $courier)
    {
        // 1️⃣ cek cache
        $cache = ShippingCostCache::where([
            'origin_id' => $originCityId,
            'destination_id' => $destinationCityId,
            'courier' => $courier,
            'weight' => $weight
        ])
            ->where('expired_at', '>', now())
            ->first();

        if ($cache) {
            return $cache;
        }

        // 2️⃣ hit RajaOngkir
        $response = $this->request('/cost', [
            'origin' => $originCityId,
            'destination' => $destinationCityId,
            'weight' => $weight,
            'courier' => $courier
        ]);

        $result = $response['rajaongkir']['results'][0]['costs'][0];

        // 3️⃣ simpan cache
        return ShippingCostCache::create([
            'origin_type' => 'city',
            'origin_id' => $originCityId,
            'destination_type' => 'city',
            'destination_id' => $destinationCityId,
            'courier' => $courier,
            'weight' => $weight,
            'service' => $result['service'],
            'service_description' => $result['description'],
            'cost' => $result['cost'][0]['value'],
            'etd' => (int) $result['cost'][0]['etd'],
            'expired_at' => now()->addHours(6)
        ]);
    }
}
