<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';
    public $guardian_email;
    public $guardian_name;
    public $relationship;
    public $home;
    public $phone_number;
    public $gender;
    

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->home = Auth::user()->home;
        $this->phone_number = Auth::user()->phone_number;
        $this->guardian_email = Auth::user()->guardian_email ?? null;
        $this->guardian_name = Auth::user()->guardian_name ?? null;
        $this->relationship = Auth::user()->relationship ?? null;
        $this->gender = Auth::user()->gender;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'guardian_email' => ['nullable', 'string', 'lowercase', 'email', 'max:255',  ],
            'guardian_name' => ['nullable', 'string', 'max:255', 'required_if:guardian_email,!null'], 
            'relationship' => ['nullable', 'string', 'max:255', 'required_if:guardian_email,!null'], 
            'gender' => ['required', ],
        ]);


        if($this->guardian_email == $this->email){
            $this->addError('guardian_email','You cannot use your email as your guardians email');
            return;
        }

        if(!empty($this->guardian_email) && empty($this->guardian_name)){
            $this->addError('guardian_name','The guardian name field is required');
            return;
        }

        if(!empty($this->guardian_email) && empty($this->relationship)){
            $this->addError('relationship','The relationship of the guardian to user is required');
            return;
        }


        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Guardian Email Address -->
        <div class="mt-4">
            <x-input-label for="guardian_email"   >
                Guardian Email 
            </x-input-label>


            <x-text-input wire:model="guardian_email" id="guardian_email" class="block mt-1 w-full" type="email" name="guardian_email" autocomplete="username" />
            <x-input-error :messages="$errors->get('guardian_email')" class="mt-2" />
        </div>

        <!-- Guardian Name -->
        <div class="mt-4">
            <x-input-label for="guardian_name"   >
                Guardian Name 
            </x-input-label>


            <x-text-input wire:model="guardian_name" id="guardian_name" class="block mt-1 w-full" type="text" name="guardian_name" autocomplete="username" />
            <x-input-error :messages="$errors->get('guardian_name')" class="mt-2" />
        </div>

        <!-- Guardian Relationship -->
        <div class="mt-4">
            <x-input-label for="relationship"   >
                Relationship
            </x-input-label>


            <x-text-input wire:model="relationship" id="relationship" class="block mt-1 w-full" type="text" name="relationship" autocomplete="username" />
            <x-input-error :messages="$errors->get('relationship')" class="mt-2" />
        </div>


        <!-- Home-->
        <div class="mt-4">
            <x-input-label for="home"   >
                Home
            </x-input-label>


            <x-text-input wire:model="home" id="home" class="block mt-1 w-full" type="text" name="home" autocomplete="username" />
            <x-input-error :messages="$errors->get('home')" class="mt-2" />
        </div>


         <!-- Phone Number-->
         <div class="mt-4">
            <x-input-label for="phone_number"   >
                Phone Number
            </x-input-label>


            <x-text-input wire:model="phone_number" id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" autocomplete="username" />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

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


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
