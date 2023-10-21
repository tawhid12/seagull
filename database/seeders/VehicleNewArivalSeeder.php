<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehicle\NewArival;
use DB;
use Carbon\Carbon;
class VehicleNewArivalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        NewArival::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $csvFile = fopen(base_path("database/data/new_arival.csv"), "r");
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            NewArival::create(array(
                //"id" => trim($data['0']),
                "country_id" => trim($data['0']),
                "vehicle_id" => trim($data['1']),
                "created_by" => (trim($data['2'])),
                "updated_by" => (trim($data['3'])),
                "created_at" => (trim($data['4'])),
                "updated_at" => Carbon::now()
            ));
        }
        fclose($csvFile);
    }
}
