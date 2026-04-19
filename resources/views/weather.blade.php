<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeatherCast - Smart Recommendation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .bg-gradient-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="bg-gradient-custom min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full">
        <div class="text-center mb-8 text-white">
            <h1 class="text-3xl font-bold mb-2">WeatherCast</h1>
            <p class="opacity-80">Cek cuaca & rekomendasi pakaian hari ini</p>
        </div>

        <div class="glass rounded-3xl p-8 shadow-2xl">
            <form action="/check" method="POST" class="mb-6">
                @csrf
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <i class="fa-solid fa-location-dot"></i>
                    </span>
                    <input type="text" name="city"
                        class="w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all"
                        placeholder="Masukkan nama kota..." required>
                    <button type="submit"
                        class="absolute right-2 top-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl transition-colors shadow-lg shadow-indigo-200">
                        Cek
                    </button>
                </div>
            </form>

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($data))
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-800 mb-1">{{ $data['name'] }}, {{ $data['sys']['country'] }}</h2>
                    <p class="text-gray-500 capitalize mb-6">{{ $data['weather'][0]['description'] }}</p>

                    <div class="flex items-center justify-center mb-8">
                        <div class="text-6xl font-bold text-gray-900">
                            {{ round($data['main']['temp']) }}°
                        </div>
                        <div class="ml-4 text-left">
                            <p class="text-gray-400 leading-tight">C</p>
                            <p class="text-gray-400 leading-tight">Celsius</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-indigo-50 p-4 rounded-2xl text-center">
                            <i class="fa-solid fa-droplet text-indigo-500 mb-2"></i>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Kelembapan</p>
                            <p class="text-lg font-bold text-gray-800">{{ $data['main']['humidity'] }}%</p>
                        </div>
                        <div class="bg-orange-50 p-4 rounded-2xl text-center">
                            <i class="fa-solid fa-wind text-orange-500 mb-2"></i>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Angin</p>
                            <p class="text-lg font-bold text-gray-800">{{ $data['wind']['speed'] }} m/s</p>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 rounded-2xl text-white shadow-xl">
                        <div class="flex items-center mb-3">
                            <i class="fa-solid fa-shirt mr-3"></i>
                            <span class="font-semibold uppercase tracking-wider text-xs opacity-90">Saran Pakaian</span>
                        </div>
                        <p class="text-left text-sm leading-relaxed">
                            {{ $recommendation }}
                        </p>
                    </div>
                </div>
            @else
                <div class="text-center py-10">
                    <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4 text-indigo-400 text-3xl">
                        <i class="fa-solid fa-cloud-sun"></i>
                    </div>
                    <p class="text-gray-400">Tunggu apa lagi? Yuk cek cuaca kotamu sekarang!</p>
                </div>
            @endif
        </div>

        <p class="text-center mt-8 text-white text-xs opacity-60">
            &copy; 2026 WeatherCast Monolith Project - Muhammad Syaidan Fauzi
        </p>
    </div>

</body>
</html>
