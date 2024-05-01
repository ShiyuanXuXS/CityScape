<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!--meta for SEO-->
        <meta name='description' content='{{ config('app.name', 'Laravel') }}, online reservation for hotels,including Vieux-Montréal Suites in Montreal, Québec Quaint Inns in Quebec City, Ottawa Riverview Suites in Ottawa and Toronto Central Plaza in Toronto. '>
        <meta name="keywords" content="hotel, reservation, {{ config('app.name', 'Laravel') }}">
        <meta name="robots" content="noindex, nofollow">
        <link rel="canonical" href="{{ env('APP_URL') }}">
        
        <meta property="og:title" content="{{ config('app.name', 'Laravel') }}">
        <meta property="og:description" content="{{ config('app.name', 'Laravel') }}, online reservation for hotels,including Vieux-Montréal Suites in Montreal, Québec Quaint Inns in Quebec City, Ottawa Riverview Suites in Ottawa and Toronto Central Plaza in Toronto. ">
        <meta property="og:image" content="{{ route('home') }}/images/logo-transparent-png.png">
        <meta property="og:url" content="{{ env('APP_URL') }}">
        
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ config('app.name', 'Laravel') }}">
        <meta name="twitter:description" content="{{ config('app.name', 'Laravel') }}, online reservation for hotels,including Vieux-Montréal Suites in Montreal, Québec Quaint Inns in Quebec City, Ottawa Riverview Suites in Ottawa and Toronto Central Plaza in Toronto. ">
        <meta name="twitter:image" content="{{ route('home') }}/images/logo-transparent-png.png">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        <link rel="stylesheet" href="{{ route('home') }}/app.css">
        <script src="{{ route('home') }}/app.js"></script>

    </head>
    <body class="font-sans antialiased">
        
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
            
            <!-- Page Content -->
            <main>
                <div class="bg-fixed bg-cover min-h-screen" style="background-image: url('{{ url('/') }}/images/bg_city_small.jpg')">
                    {{ $slot }}
                </div>
            </main>
        </div>

        {{-- Page Footing --}}
        <footer class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
              <div class="flex justify-between items-center">
                <div>
                  <span class="text-gray-600">© 2023 {{ env('APP_NAME') }}. All rights reserved.</span>
                </div>
                <div>
                  <span class="text-gray-600">Contact: 2340575@johnabbottcollege.net | +1 123-456-7890</span>
                </div>
              </div>
            </div>
          </footer>

    </body>
</html>
