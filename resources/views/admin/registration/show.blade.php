<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('Registration Information') }}
        </h2>
    </x-slot>
    <livewire:admin.registration.registration-show :id="$player_registration->id" />



</x-app-layout>