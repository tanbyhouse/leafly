<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CareGuide;

class CareGuideSeeder extends Seeder
{
    public function run(): void
    {
        CareGuide::insert([
            [
                'name' => 'Cabai Rawit',
                'watering' => 'Siram pagi dan sore',
                'fertilizing' => 'Pupuk NPK tiap 2 minggu',
                'lighting' => 'Sinar matahari penuh',
                'tips' => 'Gunakan tanah gembur'
            ],
            [
                'name' => 'Tanaman Hias',
                'watering' => '2–3 kali seminggu',
                'fertilizing' => 'Pupuk cair bulanan',
                'lighting' => 'Cahaya tidak langsung',
                'tips' => 'Jangan overwatering'
            ],
        ]);
    }
}
