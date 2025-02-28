<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl   leading-tight">
            {{ __('Permissions') }}
        </h2>
    </x-slot>

    <livewire:admin.permission.permission-list />



</x-app-layout>
