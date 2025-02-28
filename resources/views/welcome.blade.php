<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
         <!-- Hero -->
        <div class="relative overflow-hidden">
            <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="max-w-2xl text-center mx-auto">
                

                @php 
                    $active_tournament = \App\Models\Tournament::getActiveTournament();
                @endphp
                <h1 class="block text-lg font-bold text-gntf_green-500 sm:text-4xl md:text-5xl dark:text-white" >{{ !empty($active_tournament) ? $active_tournament->name : '' }}</h1>

                <p class="mt-3 text-lg text-gntf_green-500 dark:text-neutral-400">Guam National <span class="text-gntf_green-400">Tennis </span> Federation</p>

                
                <!-- Buttons -->
                <div class="mt-8 gap-3 flex justify-center">
                    @guest
                        <a class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gntf_green-600 text-white hover:bg-gntf_green-700 focus:outline-none focus:bg-gntf_green-700 disabled:opacity-50 disabled:pointer-events-none" href="{{ route('register') }}">
                            Register
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                        <a class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800  border-gntf_green-500 " href="{{ route('login') }}">
                            
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#1fa147" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"/></svg>
                            Login
                        </a>
                    @endguest

                    @auth
                        <a class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gntf_green-600 text-white hover:bg-gntf_green-700 focus:outline-none focus:bg-gntf_green-700 disabled:opacity-50 disabled:pointer-events-none" href="{{ route('dashboard') }}">
                            Dashboard
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                        </a>

                    @endauth
                    
                </div>
                <!-- End Buttons -->
                
            </div>
        
                <div class="mt-10 relative max-w-5xl mx-auto">
                    <div class="w-full object-cover h-96 sm:h-[480px] bg-[url('https://media.istockphoto.com/id/1483011696/photo/tennis-ball-racket-and-court-ground-with-mockup-space-blurred-background-or-outdoor-sunshine.jpg?s=612x612&w=0&k=20&c=XHTdIS788Vry0iNFL04YaTfOoxAEojz4RqSz-ZA5fZY=')] bg-no-repeat bg-center bg-cover rounded-xl"></div>
            
                
            
                    <div class="absolute bottom-12 -start-20 -z-[1] size-48 bg-gradient-to-b from-orange-500 to-white p-px rounded-lg dark:to-neutral-900">
                    <div class="bg-white size-48 rounded-lg dark:bg-neutral-900"></div>
                    </div>
            
                    <div class="absolute -top-12 -end-20 -z-[1] size-48 bg-gradient-to-t from-blue-600 to-cyan-400 p-px rounded-full">
                    <div class="bg-white size-48 rounded-full dark:bg-neutral-900"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Hero -->
    </body>
</html>
