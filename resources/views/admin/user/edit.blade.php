<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl   leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>


    <livewire:admin.user.user-edit :id="$user->id"/>



</x-app-layout>
