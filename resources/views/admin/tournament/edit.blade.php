<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('Tournaments') }}
        </h2>
    </x-slot>
    <livewire:admin.tournament.tournament-edit :id="$tournament->id" />



</x-app-layout>