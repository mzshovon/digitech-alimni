<?php

namespace Database\Seeders;

use App\Models\Election;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ElectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Election::count() == 0) {
            $data = [
                "title"=>"Annual Committe Election",
                "start_date" => Carbon::now()->format("d-m-Y"),
                "end_date" => Carbon::now()->addMonths(2)->format("d-m-Y"),
            ];
            Election::insert($data);
        }
    }
}
