<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Activity Logs') }}
        </h2>
    </x-slot>

    <livewire:activity-logs.activity-logs-list />



</x-app-layout>