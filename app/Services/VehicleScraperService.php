<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VehicleScraperService
{
    public function scrapePlates(array $plates)
    {
        // Make sure you've set SCRAPER_API_URL in your .env file.
        $url = config('services.scraper_api.url');

        $response = Http::post($url, [
            'plates' => $plates,
        ]);

        if ($response->successful()) {
            return $response->json();
        }


        $response = Http::withOptions([
            'debug' => true, // outputs to STDERR — visible in CLI if you're running php artisan serve
        ])->post($url, [
            'plates' => $plates,
        ]);

        throw new \Exception("Failed to scrape vehicles: " . $response->body());
    }
  



}
