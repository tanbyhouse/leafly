<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OngkirService
{
    protected string $key;
    protected string $base;

    public function __construct()
    {
        $this->key  = config('services.rajaongkir.key');
        $this->base = rtrim(config('services.rajaongkir.base_url'), '/');
    }

    private function client()
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->key,
            'Accept' => 'application/json',
        ]);
    }

    public function getProvinces(): array
    {
        $res = $this->client()->get(
            $this->base . '/api/rajaongkir/domestic-destination/province'
        )->json();

        return $res['data'] ?? [];
    }

    public function getCities(int $provinceId): array
    {
        $res = $this->client()->get(
            $this->base . '/api/rajaongkir/domestic-destination/city',
            ['province_id' => $provinceId]
        )->json();

        return $res['data'] ?? [];
    }

    public function calculate(int $origin, int $destination, int $weight, string $courier): array
    {
        $res = $this->client()->post(
            $this->base . '/api/rajaongkir/domestic-cost',
            [
                'origin' => $origin,
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courier,
            ]
        )->json();

        if (!isset($res['data'][0]['costs'][0]['cost'][0])) {
            throw new \Exception('Ongkir tidak ditemukan');
        }

        $service = $res['data'][0]['costs'][0];
        $cost = $service['cost'][0];

        return [
            'service' => $service['service'],
            'cost' => $cost['value'],
            'etd' => $cost['etd'] ?? '',
        ];
    }
}
