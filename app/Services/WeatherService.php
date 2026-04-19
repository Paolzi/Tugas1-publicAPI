<?php

namespace App\Services;

class WeatherService
{
    public function getClothingRecommendation($temp, $condition)
    {
        $condition = strtolower($condition);

        return match (true) {
            str_contains($condition, 'rain') || str_contains($condition, 'drizzle')
                => "Hujan terdeteksi! Gunakan jaket waterproof dan bawa payung.",

            $temp < 15  => "Suhu sangat dingin ({$temp}°C). Gunakan sweater tebal atau coat.",
            $temp < 23  => "Udara sejuk. Pakaian lengan panjang atau hoodie ringan sudah cukup.",
            $temp < 30  => "Cuaca cerah/berawan. Gunakan kaos katun yang nyaman.",
            default     => "Cuaca sangat terik ({$temp}°C). Gunakan pakaian tipis dan jangan lupa sunscreen!",
        };
    }
}
