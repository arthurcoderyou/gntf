<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/png" href="{{ asset('images/dsi-logo.png') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> 


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="preload" as="image" href="{{ asset("images/guam_tennis_team.jpg") }}">
        <style>
            .custom-bg {
                background-image: url('{{ asset("images/tennis.jpg") }}');
                background-size: cover;
                background-position: center;
            }
        </style>


    </head>
    <body class="font-sans text-gray-900 antialiased custom-bg "  >
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-500/50 ">


            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white/80 shadow-md overflow-hidden sm:rounded-lg ">

                <div class="mb-4">
                    <a href="/" wire:navigate>
                        <x-application-logo class="w-auto shrink-0 fill-current text-gray-500 bg-gntf_green-500 p-1 rounded-lg" />
                    </a>
                </div>


                {{ $slot }}
            </div>
        </div>
    </body>
</html>
