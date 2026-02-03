<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Merchandise;

class MerchandiseSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'Sticker',
            'Gantungan Kunci',
            'Kaos',
            'Jaket / Hoodie',
            'Topi',
            'ID Card',
            'Syal'
        ];

        foreach ($items as $item) {
            Merchandise::create(['name' => $item]);
        }
    }
}
