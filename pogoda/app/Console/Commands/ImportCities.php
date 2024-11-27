<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\City;
use Illuminate\Support\Facades\File;

class ImportCities extends Command
{
    protected $signature = 'cities:import';
    protected $description = 'Import cities from city.list.json';

    public function handle()
    {
        $path = storage_path('app/city.list.json');
        $citiesData = json_decode(File::get($path), true);

        foreach ($citiesData as $city) {
            if ($city['country'] === 'PL') { // Tylko miasta w Polsce
                City::updateOrCreate(
                    ['api_city_id' => $city['id']],
                    ['name' => $city['name']]
                );
            }
        }

        $this->info('Cities imported successfully.');
    }
}
