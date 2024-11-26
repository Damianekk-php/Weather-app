<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\City;

class LoadCitiesFromJson extends Command
{
    protected $signature = 'load:cities';

    protected $description = 'Załadowanie miast z pliku JSON do bazy danych';

    public function handle()
    {
        $jsonFile = storage_path('app/city.list.json');

        if (!file_exists($jsonFile)) {
            $this->error('Plik city.list.json nie istnieje w storage/app');
            return;
        }

        $cities = json_decode(file_get_contents($jsonFile), true);

        foreach ($cities as $city) {
            if ($city['country'] === 'PL') {
                City::updateOrCreate(
                    ['id' => $city['id']],
                    [
                        'name' => $city['name'],
                        'country' => $city['country'],
                        'lat' => $city['coord']['lat'],
                        'lon' => $city['coord']['lon'],
                    ]
                );
            }
        }

        $this->info('Miasta zostały załadowane do bazy danych!');
    }
}
