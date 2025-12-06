<?php

namespace App\Services;

class OngkirService
{
    /**
     * Hitung ongkir manual (GRATIS - tanpa API)
     */
    public function hitungOngkir($kotaTujuan, $berat, $kurir = 'reguler')
    {
        // Tarif base per kg (dalam rupiah)
        $tarifPerKg = [
            'reguler' => 8000,  // 8000/kg
            'express' => 15000, // 15000/kg
        ];

        // Konversi gram ke kg
        $beratKg = ceil($berat / 1000);

        // Hitung ongkir
        $ongkir = $beratKg * $tarifPerKg[$kurir];

        // Minimal ongkir 10.000
        $ongkir = max($ongkir, 10000);

        // Estimasi hari
        $estimasi = $kurir === 'express' ? 1 : 3;

        return [
            'kurir' => $kurir === 'express' ? 'Express (Next Day)' : 'Reguler (JNE/J&T)',
            'layanan' => $kurir,
            'biaya' => $ongkir,
            'estimasi_hari' => $estimasi,
            'estimasi_tiba' => now()->addDays($estimasi)->format('d M Y'),
        ];
    }
}
