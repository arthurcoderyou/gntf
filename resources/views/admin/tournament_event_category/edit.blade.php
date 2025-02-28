<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('Tournament Event Categories') }}
        </h2>
    </x-slot>
    <livewire:admin.tournament-event-category.tournament-event-category-edit :id="$tournament_event_category->id" />



</x-app-layout>