<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VehicleOffenceCheckerService
{protected $endpoint = 'https://tms.tpf.go.tz/api/OffenceCheck';

    /**
     * Fetch offence info for multiple plates.
     */
    public function fetchOffences(array $plates): array
    {
        $results = [];

        foreach ($plates as $plate) {
            try {
                $response = Http::post($this->endpoint, [
                    'vehicle' => $plate,
                ]);

                if ($response->successful()) {
                    $results[$plate] = $response->json();
                } else {
                    $results[$plate] = [
                        'error' => "Failed to fetch",
                        'status' => $response->status(),
                        'message' => $response->body()
                    ];
                }
            } catch (\Throwable $e) {
                Log::error("TPF API error for plate {$plate}: " . $e->getMessage());

                $results[$plate] = [
                    'error' => 'Exception occurred',
                    'message' => $e->getMessage(),
                ];
            }
        }

        return $results;
    }


}
