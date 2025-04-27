<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::truncate();

        $citiesByState = [
            'Andhra Pradesh' => ['Visakhapatnam', 'Vijayawada', 'Guntur'],
            'Arunachal Pradesh' => ['Itanagar'],
            'Assam' => ['Guwahati', 'Silchar', 'Dibrugarh'],
            'Bihar' => ['Patna', 'Gaya', 'Bhagalpur'],
            'Chhattisgarh' => ['Raipur', 'Bhilai', 'Bilaspur'],
            'Goa' => ['Panaji', 'Margao'],
            'Gujarat' => ['Ahmedabad', 'Surat', 'Vadodara'],
            'Haryana' => ['Gurgaon', 'Faridabad', 'Panipat'],
            'Himachal Pradesh' => ['Shimla', 'Dharamshala'],
            'Jharkhand' => ['Ranchi', 'Jamshedpur', 'Dhanbad'],
            'Karnataka' => ['Bengaluru', 'Mysuru', 'Hubballi'],
            'Kerala' => ['Kochi', 'Thiruvananthapuram', 'Kozhikode'],
            'Madhya Pradesh' => ['Bhopal', 'Indore', 'Jabalpur'],
            'Maharashtra' => ['Mumbai', 'Pune', 'Nagpur'],
            'Manipur' => ['Imphal'],
            'Meghalaya' => ['Shillong'],
            'Mizoram' => ['Aizawl'],
            'Nagaland' => ['Kohima', 'Dimapur'],
            'Odisha' => ['Bhubaneswar', 'Cuttack', 'Rourkela'],
            'Punjab' => ['Ludhiana', 'Amritsar', 'Jalandhar'],
            'Rajasthan' => ['Jaipur', 'Jodhpur', 'Udaipur'],
            'Sikkim' => ['Gangtok'],
            'Tamil Nadu' => ['Chennai', 'Coimbatore', 'Madurai'],
            'Telangana' => ['Hyderabad', 'Warangal'],
            'Tripura' => ['Agartala'],
            'Uttar Pradesh' => ['Lucknow', 'Kanpur', 'Varanasi'],
            'Uttarakhand' => ['Dehradun', 'Haridwar'],
            'West Bengal' => ['Kolkata', 'Asansol', 'Siliguri'],
            'Delhi' => ['New Delhi', 'Dwarka', 'Karol Bagh'],
        ];

        foreach($citiesByState as $statename => $cities){
            $state = State::where('name',$statename)->first();
            if($state){
                foreach($cities as $city){
                    City::create(['name' => $city,'state_id' => $state->id]);
                }
            }
        }
    }
}
