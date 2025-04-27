<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Gender;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gender::truncate();
        $now = Carbon::now();

        $gender = [
            'Male', 'Female',
        ];

        DB::table('genders')->insert(
            collect($gender)->map(fn($gen) => [
                'gender' => $gen,
                'created_at' => $now,
                'updated_at' => $now
            ])->toArray()
        );
    }
}
