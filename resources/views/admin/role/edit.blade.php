<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>
    <livewire:admin.role.role-edit :id="$role->id" />



</x-app-layout>
