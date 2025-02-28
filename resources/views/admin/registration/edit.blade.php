<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('Edit Registration') }}
        </h2>
    </x-slot>
    <livewire:admin.registration.registration-edit :id="$player_registration->id" />



</x-app-layout>