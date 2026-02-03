<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('settings')->insert([
            'system_name' => 'Madrid Ambon Membership',
            'logo' => null,
            'webbg' => null
        ]);
    }
}
