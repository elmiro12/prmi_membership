<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MembershipType;
use App\Models\Merchandise;

class MembershipTypeSeeder extends Seeder
{
    public function run(): void
    {
        // Get IDs of merchandise
        $sticker = Merchandise::where('name', 'Sticker')->first()->id ?? null;
        $ganci = Merchandise::where('name', 'Gantungan Kunci')->first()->id ?? null;
        $kaos = Merchandise::where('name', 'Kaos')->first()->id ?? null;
        $jaket = Merchandise::where('name', 'Jaket / Hoodie')->first()->id ?? null;

        $types = [
            [
                'type' => 'Silver', 
                'amount' => 100000, 
                // Filter out nulls just in case
                'merchandise' => array_values(array_filter([$sticker, $ganci]))
            ],
            [
                'type' => 'Gold', 
                'amount' => 200000, 
                'merchandise' => array_values(array_filter([$sticker, $ganci, $kaos]))
            ],
            [
                'type' => 'Platinum', 
                'amount' => 500000, 
                'merchandise' => array_values(array_filter([$sticker, $ganci, $kaos, $jaket]))
            ],
        ];

        foreach ($types as $type) {
            MembershipType::create($type);
        }
        MembershipType::create([
            'id' => 11,
            'type' => 'PRMI Member',
            'amount' => 0,
            'merchandise' => []
        ]);
    }
}
