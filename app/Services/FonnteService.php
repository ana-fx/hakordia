<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.fonnte.com';

    public function __construct()
    {
        $this->apiKey = env('FONNTE_API_KEY');
        if (empty($this->apiKey)) {
            throw new \Exception('FONNTE_API_KEY tidak ditemukan di .env');
        }
    }

    public function checkNumber($number)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey
            ])->get($this->baseUrl . '/device');

            if ($response->successful()) {
                $data = $response->json();
                Log::info('Fonnte device status: ' . json_encode($data));
                return $data;
            }

            throw new \Exception('Failed to check Fonnte status: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Error checking Fonnte status: ' . $e->getMessage());
            throw $e;
        }
    }

    public function sendMessage($target, $message)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey
            ])->post($this->baseUrl . '/send', [
                'target' => $target,
                'message' => $message
            ]);

            $responseData = $response->json();

            if ($response->successful() && isset($responseData['status']) && $responseData['status'] === true) {
                return [
                    'success' => true,
                    'message' => 'Message sent successfully',
                    'data' => $responseData
                ];
            }

            return [
                'success' => false,
                'message' => $responseData['message'] ?? 'Unknown error',
                'data' => $responseData
            ];
        } catch (\Exception $e) {
            Log::error('Error sending message via Fonnte: ' . $e->getMessage());
            throw $e;
        }
    }
}
