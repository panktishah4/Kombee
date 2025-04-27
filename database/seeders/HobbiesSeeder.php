<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Hobby;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HobbiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hobby::truncate();
        $now = Carbon::now();

        $hobbies = [
            'Reading', 'Traveling', 'Sports'
        ];

        DB::table('hobbies')->insert(
            collect($hobbies)->map(fn($hobby) => [
                'name' => $hobby,
                'created_at' => $now,
                'updated_at' => $now
            ])->toArray()
        );

    }
}
