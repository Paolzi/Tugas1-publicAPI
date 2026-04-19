<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\WeatherService; // Import Service yang tadi dibuat

class WeatherController extends Controller
{
    protected $weatherService;

    // Dependency Injection: Masukkan service ke dalam controller
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function index()
    {
        return view('weather');
    }

    public function check(Request $request)
    {
        $request->validate(['city' => 'required|string|max:100']);

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'q'     => $request->city,
            'appid' => env('OPENWEATHER_API_KEY'),
            'units' => 'metric',
            'lang'  => 'id'
        ]);

        if ($response->failed()) {
            return back()->with('error', 'Kota tidak ditemukan. Coba cek ejaan nama kota.');
        }

        $data = $response->json();

        // Panggil logika dari Service
        $recommendation = $this->weatherService->getClothingRecommendation(
            $data['main']['temp'],
            $data['weather'][0]['main']
        );

        return view('weather', [
            'data' => $data,
            'recommendation' => $recommendation
        ]);
    }
}

