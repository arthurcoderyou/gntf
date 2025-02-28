<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('Tournaments Events') }}
        </h2>
    </x-slot>
    <livewire:admin.tournament-event.tournament-event-edit :id="$tournament_event->id" />



</x-app-layout>