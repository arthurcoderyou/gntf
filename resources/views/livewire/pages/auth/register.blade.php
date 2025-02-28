<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $gender = '';
    public string $guardian_email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required' ],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'guardian_email' => ['nullable', 'string', 'lowercase', 'email', 'max:255',  ],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // $validated['password'] = Hash::make($validated['password']);

        // event(new Registered($user = User::create($validated)));

        // Auth::login($user);

        // // $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
        // redirect()->intended(route('dashboard'));

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        // Assign the "User" role
        $user->assignRole('User');

        event(new Registered($user));

        Auth::login($user);

        redirect()->intended(route('dashboard'));
        
    }
}; ?>

<div>
    <form wire:submit="register">

        <div wire:loading class="loading-overlay">
            <div style="color: #64d6e2" class="la-ball-clip-rotate-pulse la-3x preloader">
                <div></div>
                <div></div>
            </div>
        </div>
        <!-- Name -->
        <div> 
            <x-input-label for="name" >
                Full Name <span class="text-red-500">*</span>
            </x-input-label> 
             
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email"  >
                Email <span class="text-red-500">*</span>
            </x-input-label>

            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>


        {{-- <!-- Guardian Email Address -->
        <div class="mt-4">
            <x-input-label for="guardian_email"   >
                Guardian Email 
            </x-input-label>


            <x-text-input wire:model="guardian_email" id="guardian_email" class="block mt-1 w-full" type="email" name="guardian_email" autocomplete="username" />
            <x-input-error :messages="$errors->get('guardian_email')" class="mt-2" />
        </div> --}}


        <!-- gender -->
        <div class="mt-4">
            <x-input-label for="gender"   >
                Gender <span class="text-red-500">*</span>
            </x-input-label>
            {{-- <x-text-input wire:model="email" id="gender" class="block mt-1 w-full" type="gender" name="gender" required autocomplete="username" /> --}}
            <select 
            wire:model="gender" id="gender" name="gender" required autocomplete="username"
            class="mt-1 py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                <option selected="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

       

 

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password"  >
                Password <span class="text-red-500">*</span>
            </x-input-label>

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" >
                Confirm Password <span class="text-red-500">*</span>
            </x-input-label>


            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
