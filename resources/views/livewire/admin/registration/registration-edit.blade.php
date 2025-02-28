<!-- Card Section -->
<div class="max-w-[85rem] px-4 py-6 sm:px-6 lg:px-8  mx-auto"

    x-data="{
        showModal: false,  
        showModalEvent: false,
        option_id: 0,
        handleKeydown(event) {
            if (event.keyCode == 191) {
                this.showModal = true; 
                this.showModalEvent = true;
            }
            if (event.keyCode == 27) {
                this.showModal = false; 
                this.showModalEvent = false;
                $wire.search = '';
            }

        },
    }"
>

     

    {{-- <div  class="loading-overlay"> --}}
        <div wire:loading style="color: #64d6e2" class="la-ball-clip-rotate-pulse la-3x preloader">
            <div></div>
            <div></div>
        </div>
    {{-- </div> --}}
    

    <form wire:submit="register">
        <!-- Card -->
        <div class="bg-white rounded-xl shadow dark:bg-neutral-900">


            <div class="  p-4">

                

                {{-- <div class="sm:col-span-12">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">
                    Submit New Category
                    
                    </h2>

                    @if(empty($selected_tournament) || empty($selected_tournament_event))
                        <p class="text-sm text-red-600 mt-2">Please select tournament and event first before entering data.</p>
                    @endif 


                    @if(!empty($selected_tournament_event))
                        <span class="text-gray-500 block text-sm">
                            Tournament Event: <span class="text-gntf_green-500">{{ $selected_tournament_event->name }}</span> 
                        </span>

                    @endif  

                    @if(!empty($selected_tournament))
                        <span class="text-gray-500 block text-sm">
                            Tournament: <span class="text-gntf_green-500">{{ $selected_tournament->name }}</span> 
                        </span>
 
                    @endif

                    
                </div> --}}

                 <!-- Grid -->
                 <div class="col-span-12  sm:col-span-4 mb-4  ">
                         
                    <div>
                        <hr class="mb-2">
                        <span class="block text-start text-lg font-medium text-gray-800   dark:text-neutral-200">
                            Edit <span class="text-gntf_green-500 font-bold">{{ $user->name }} </span> registration details
                            for the tournament <br> <span class="text-gntf_green-500 font-bold">{{ $tournament->name }}</span> 
                        </span>
                        <hr class="mt-2">
                    </div>
                </div> 

                <!-- Logo and User Information-->
                <div class="grid grid-cols-12 gap-x-2  ">

                   


                    <!-- Grid -->
                    <div class="col-span-12  sm:col-span-4 p-2  ">
                         
                        <img class=" block  my-2 w-64  mx-auto  text-gray-800 " src="{{ asset('storage/uploads/tournament/'.$tournament->logo)  }}" alt="">

                        <div>
                            @if(!empty($tournament->director))
                            <span class="block text-center text-lg font-medium text-gray-800   dark:text-neutral-200">
                                Tournament Director: <span class="text-gntf_green-500 font-bold">{{ $tournament->director }}</span> 
                            </span>
                            @endif

                            @if(!empty($tournament->finance))
                            <span class="block text-center text-lg font-medium text-gray-800   dark:text-neutral-200">
                                Finance: <span class="text-gntf_green-500 font-bold">{{ $tournament->finance }}</span> 
                            </span>
                            @endif
                        </div>
                    </div> 

                    <!-- Grid -->
                    <div class="col-span-12  sm:col-span-8 grid grid-cols-12 gap-x-2 border-4 border-double border-black  p-2 ">

                         
                        <div class="  col-span-12 sm:col-span-12 grid grid-cols-12 gap-x-2  ">
                            <div class="col-span-12 sm:col-span-6">
                                <label for="name" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                                    Name
                                </label>

                                <input
                                autofocus autocomplete="name"
                                wire:model="name"
                                readonly
                                id="name" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="">
                                @error('name')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror

                                <label for="email" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                                    Email
                                </label>

                                <input
                                readonly
                                autofocus autocomplete="email"
                                wire:model="email"
                                id="email" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="">
                                @error('email')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror 


                            </div>
 
                                
                            <div class="col-span-12 sm:col-span-6">
                                <label for="phone_number" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                                    Phone number
                                </label>

                                <input
                                autofocus autocomplete="phone_number"
                                wire:model="phone_number"
                                id="phone_number" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="">

                                @error('phone_number')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror

                                <label for="home" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                                    Home
                                </label>

                                <input
                                autofocus autocomplete="home"
                                wire:model="home"
                                id="home" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="">

                                @error('home')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="col-span-12 grid grid-cols-12 gap-x-2 mt-2 ">

                                <div class="col-span-12 sm:col-span-2  ">
                                    Entry Fee: 
                                </div>

                                <div class="col-span-12 sm:col-span-10 ">
                                    @if(!empty($tournament->fee_descriptions))
                                        @foreach ($tournament->fee_descriptions as $description)
                                            <p>{{ $description->fee_description }}</p> 
                                        @endforeach
                                        
                                    @endif
                                </div>

                                <div class="col-span-12 mt-2 ">
                                    @if(!empty($tournament->fee_notes))
                                        @foreach ($tournament->fee_notes as $fee_note)
                                            <p>
                                                {{ $fee_note->notes }}
                                            </p>
                                        @endforeach
                                        
                                    @endif
                                    
                                    @if(!empty($tournament->fee_sub_notes))
                                        @foreach ($tournament->fee_sub_notes as $fee_sub_note)
                                            <p class="text-sm text-gray-500">
                                                {{ $fee_sub_note->sub_notes }}
                                            </p>
                                        @endforeach
                                        
                                    @endif
                                    
                                </div>

                            </div>

                        </div>
 
 

                        

                    </div> 

                    <!-- Grid -->
                    <div class="col-span-12  p-2  ">
                        @if(!empty($tournament->format_descriptions))
                            @foreach ($tournament->format_descriptions as $format_description)
                                <div>         
                                    <span class="block text-end text-md font-medium text-gray-800   dark:text-neutral-200">
                    
                                        {{  $format_description->description }}
                                    </span> 
                                         
                                </div>
                            @endforeach
                            
                        @endif
                    </div> 

                </div>

                @if(!empty($tournament->events) && count($tournament->events) > 0 )
                    @foreach ($tournament->events as $tournament_event)
                        <div class="grid grid-cols-12 gap-x-2 text-xl font-extrabold border-2 border-black px-2 py-1 ">
                            <!-- Event -->
                            <div class="  col-span-12 flex items-center justify-between  ">

                                <span  class="inline-block  ">
                                    {{ $tournament_event->getFormattedDateRange() }} 
                                </span> 
                                 
                                <span  class="inline-block  ">
                                    {{ $tournament_event->name }} 
                                </span> 

                                <span  class="inline-block  ">
                                    Deadline | {{ $tournament_event->getDeadline() }} 
                                </span> 

                            </div>
                            <!-- End Col -->

                            
                            <!-- ./Event -->

                        </div>


                        <div class="grid grid-cols-12 gap-x-10 text-sm    px-2 py-1 mb-4 ">
                            <!-- Categories -->
                            @if(!empty($tournament_event->categories) && count($tournament_event->categories) > 0 )
                                    @foreach ($tournament_event->categories as $category)

                                    <div class="  col-span-12 sm:col-span-6    ">

                                        <!-- for singles -->
                                        @if($category->type != "doubles")


                                            <div class="grid sm:grid-cols-12 ">
                                                <div class="col-span-12 ">
                                                    <label  for="{{ $category->name }} " class=" p-2 inline-block   text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                                        
                                                        <span class="text-sm text-center text-black font-extrabold ms-1 dark:text-neutral-400">{{ $category->name }} </span>
                                                    </label>
                                                </div>
                                                
                                            
                                               


                                                <div class="col-span-12  grid sm:grid-cols-6 gap-2">
                                                    @if(!empty($category->options) && count($category->options) > 0 )
                                                        @foreach ($category->options as $option)

                                                            <div>
                                                                <label for="options_{{ $option->id }}" class="flex p-2 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                                                    <input wire:model.live="selectedOptions.{{ $option->id }}"
                                                                    type="checkbox" 
                                                                    value="{{ $option->id }}"
                                                                    class="shrink-0 mt-0.5 border-gray-500 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="options_{{ $option->id }}"  >
                                                                    <span class="text-sm text-black ms-1 dark:text-neutral-400">{{ $option->name }}</span>
                                                                </label>
                                                            </div>
                                                                 
                                                            
                                                            
                                                        @endforeach
                                                    @endif
                                                </div>




                                            </div>
 

                                        <!-- for doubles -->
                                        @else 
                                            <div class="grid sm:grid-cols-12 ">
                                                <div class="col-span-12 ">
                                                    <label  for="{{ $category->name }} " class=" p-2 inline-block   text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                                        
                                                        <span class="text-sm text-center text-black font-extrabold ms-1 dark:text-neutral-400">{{ $category->name }} </span>
                                                    </label>
                                                </div>
                                                
                                            
                                            
 
                                                    @if(!empty($category->options) && count($category->options) > 0 )
                                                        @foreach ($category->options as $option)

                                                            <div class="col-span-12 grid sm:grid-cols-12 gap-x-2 mb-1">

                                                                <!-- Check if there are double partner request -->
                                                                @php 
                                                                    $double_partner_request = \App\Models\RegisteredOptions::check_double_partner_request(Auth::user()->id, $option->id);
                                                                @endphp 

                                                                <div class="col-span-4">
                                                                    <label for="options_{{ $option->id }}" class="flex p-2 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                                                        <input wire:model.live="selectedOptions.{{ $option->id }}"
                                                                        type="checkbox" 
                                                                        name="selectedOptions"
                                                                        value="{{ $option->id }}"
                                                                        class="shrink-0 mt-0.5 border-gray-500 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="options_{{ $option->id }}"  >
                                                                        <span class="text-sm text-black ms-1 dark:text-neutral-400">{{ $option->name }}</span>
                                                                    </label>
                                                                </div>

                                                                @if ($category->type === 'doubles')

                                                                    <div class="col-span-8">
                                                                        <div>
                                                                            <label for="hs-trailing-multiple-add-on" class="sr-only">Multiple add-on</label>
                                                                            <div class="flex rounded-lg shadow-sm">
                                                                                <div
                                                                                class="cursor-pointer p-2 rounded-s-md inline-flex items-center min-w-fit border border-e-0 border-gray-200 bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600"
                                                                                @click="
                                                                                    showModal = true;
                                                                                    $wire.set('selected_option_id', '{{ $option->id }}');
                                                                                    $wire.set('selected_allowed_gender', '{{ $category->allowed_gender }}');
                                                                                "

                                                                                @keydown.window="handleKeydown" 
                                                                                type="button"
                                                                               >
                                                                                    <span class="text-sm text-gray-500 dark:text-neutral-400"
                                                                                        
                                                                                        >
                                                                                          
                                                                                        <svg  class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>

                                                                                    </span>
                                                                                </div>

                                                                                <input
                                                                                wire:model.live="selectedPartnerNames.{{ $option->id }}" 
                                                                                readonly type="text" 
                                                                                id="selectedPartnerNames.{{ $option->id }}"  
                                                                                class="p-2 block w-full border-gray-200 shadow-sm   text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Player Partner Name">
                                                                                
                                                                                <div
                                                                                wire:click="remove_selected_partner({{ $option->id }})"
                                                                                class="cursor-pointer p-2 inline-flex items-center min-w-fit rounded-e-md border border-s-0 border-gray-200 bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600">
                                                                                    <span class="text-sm text-gray-500 dark:text-neutral-400">
                                                                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#f5003d" d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg> 
                                                                                    </span>

                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                     <!-- Check if the current user already has a partner on this option -->
                                                                    @if(\App\Models\PlayerRegistration::hasConfirmedPartner($option->id))
                                                                        <div class="col-span-12">
                                                                            <label  class="text-gntf_green-500 p-2 block w-full ">Doubles Partner confirmed</label>
                                                                        </div>

                                                                
                                                                    @else
                                                                        @if(!empty( $double_partner_request) && count( $double_partner_request ) > 0)
                                                                            <div class="col-span-12">
                                                                                

                                                                                <div>
                                                                                    <label  class="text-blue-500 p-2 block w-full ">Doubles Partner requested</label>

                                                                                </div>
                                                                            </div>
                                                                        @endif 
                                                                    @endif 


                                                                @endif

 

                                                            </div>
                                                                
                                                            
                                                            
                                                                                                        
                                                        @endforeach
                                                    @endif 




                                            </div>
                                        @endif


                                    </div>
                                @endforeach

                            @endif
                            <!-- ./ Categories -->

                        </div>


                    @endforeach
               
                @endif

                <!-- tournament information and waiver -->
                <div class="grid grid-cols-12 gap-x-2  ">

                    <!-- Grid -->
                    <div class="col-span-12  sm:col-span-8 grid grid-cols-12 gap-x-2 border-4 border-double border-black  p-2 ">

                         
                        <div class="  col-span-12 sm:col-span-12 grid grid-cols-12 gap-x-2  ">
                           
                                
                             
                            <div class="col-span-12  ">
                               TOURNAMENT FEES
                            </div>

                            @if(!empty($tournament->tournament_fees))
                                @foreach ( $tournament->tournament_fees as $tournament_fee)
                                    <div class="col-span-12 grid grid-cols-12 gap-x-2 mt-1 ">

                                        <div class="col-span-12 sm:col-span-4  ">
                                            {{ $tournament_fee->fee_name }}: 
                                        </div>

                                        <div class="col-span-12 sm:col-span-8 "> 
                                            <p>
                                                @if(!empty($tournament_fee->fee_first_event_payment))
                                                    1st Event ${{ $tournament_fee->fee_first_event_payment }}

                                                    @if(!empty($tournament_fee->fee_additional_event_payment))
                                                        + Additional 
                                                    @endif
                                                @endif

                                                @if(!empty($tournament_fee->fee_additional_event_payment))
                                                    Events ${{ $tournament_fee->fee_additional_event_payment }}
                                                @endif

                                            
                                            </p>  
                                        </div>
        

                                    </div>
                                @endforeach
                                
                            @endif

                        </div>
 
  

                    </div> 




                    <!-- Grid -->
                    <div class="col-span-12  sm:col-span-4 p-2  flex items-center justify-center"> 
                        <div class=" ">
                             
                            @if(!empty($tournament->rule_descriptions))
                                @foreach ($tournament->rule_descriptions as $rule_description)
                                    <div class="block  text-center text-lg font-medium text-gray-800   dark:text-neutral-200">
                                        {{ $rule_description->description }} 
                                    </div>
                                @endforeach
                                
                            @endif
 
                        </div>
                    </div> 


                    <!-- Grid -->
                    <div class="col-span-12   p-2  flex items-center justify-center"> 
                        <div class=" ">
                             
                            @if(!empty($tournament->waiver_descriptions))
                                @foreach ($tournament->waiver_descriptions as $waiver_description)
                                    <div class="block mt-2 text-justify text-sm font-medium text-gray-800   dark:text-neutral-200">
                                        {{ $waiver_description->description }} 
                                    </div>
                                @endforeach
                                
                            @endif
 
                        </div>

 

                    </div> 

                    {{-- <div class="col-span-12 mt-4 text-center ">
                        <input type="checkbox" id="terms" wire:model="acceptTerms"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <label for="terms">
                            I accept the Terms and Conditions 
                        </label>
                        @error('acceptTerms') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div> --}}


                </div>
                <!-- ./ tournament information and waiver -->

                
                <div>

                    {{-- @error('selectedOptions') 
                        <span class="text-red-500">{{ $message }}</span> 
                    @enderror

                    @error('selectedPartners') 
                        <span class="text-red-500">{{ $message }}</span> 
                    @enderror


                    @if ($errors->any())
                        <div class="text-red-500">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif --}}

                    @if ($errors->any())
                         
                        @foreach ($errors->all() as $error) 


                            <div class="mt-2 bg-red-100 border border-red-200 text-sm text-red-800 rounded-lg p-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500" role="alert" tabindex="-1" aria-labelledby="hs-soft-color-danger-label">
                                <span id="hs-soft-color-danger-label" class="font-bold">Error: </span>
                                {{ $error }}
                            </div>


                        @endforeach 
                    @endif 
                    {{-- @foreach ($errors->get('selectedOptions.*') as $errorMessages)
                        @foreach ($errorMessages as $errorMessage)

                            <div class="mt-2 bg-red-100 border border-red-200 text-sm text-red-800 rounded-lg p-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500" role="alert" tabindex="-1" aria-labelledby="hs-soft-color-danger-label">
                                <span id="hs-soft-color-danger-label" class="font-bold">Error: </span>
                                {{ $errorMessage }}
                            </div> 
                        @endforeach
                    @endforeach --}}

                </div>

                
                <div class="mt-5 flex justify-center gap-x-2">

                    

                    <a href="{{ route('player_registration.index') }}" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">
                        Cancel
                    </a>

                    {{-- @if($status == "inactive") --}}
                        <button
                        onclick="confirm('Are you sure, you want to proceed?') || event.stopImmediatePropagation()"
                        wire:click.prevent="register()"
                        type="submit" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        Update
                        </button>

                    {{-- @else 
                        <button
                         onclick="confirm('Are you sure, you want to save this record? You had set the tournament has active and it will be considered and as the active tournament ') || event.stopImmediatePropagation()"
                        wire:click.prevent="save"
                        type="submit" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        Save
                        </button>
                    @endif

                    --}}


                </div>
            </div>
        </div>
        <!-- End Card -->
    </form>
 


    <!-- User modal-->
    @teleport('body')
        <div x-show="showModal" x-trap="showModal" class="relative z-10 " aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <!-- <div class="fixed inset-0 z-10 w-screen overflow-y-auto py-10"> -->
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto py-10">
                <div class="flex justify-center p-4 sm:p-0">
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div @click.outside="showModal = false" class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="w-full px-1 pt-1" x-data="{
                                searchPosts(event) {
                                    document.getElementById('searchInput').focus();
                                    event.preventDefault();
                                }
                            }">
                                <form action="" autocomplete="off">
                                    <input
                                    autocomplete="off"
                                    wire:model.live.throttle.500ms="user_search" type="text" id="searchInput"
                                    name="searchInput"
                                    class="block w-full flex-1 py-2 px-3 mt-2 outline-none border-none rounded-md bg-slate-100"
                                    placeholder="Search for user name ..." @keydown.slash.window="searchPosts" />
                                </form>
                                <div class="mt-2 w-full overflow-hidden rounded-md bg-white">

                                    
                                        @if(!empty($results) && count($results) > 0)
                                            <div class=" py-2 px-3 border-b border-slate-200 text-sm font-medium text-slate-500">

                                                All Users <strong>(Click to select a user to be double partner)</strong>

                                            </div>

                                            @foreach ($results as $result)
                                                <div 
                                                
                                                class="
                                                
                                                @if(\App\Models\PlayerRegistration::userHasConfirmedPartner($result->id,$selected_option_id) )
                                                     opacity-50 
                                                
                                                @endif
                                                    cursor-pointer py-2 px-3 hover:bg-slate-100 bg-white border border-gray-200 shadow-sm rounded-xl mb-1"
                                                @if(!\App\Models\PlayerRegistration::userHasConfirmedPartner($result->id,$selected_option_id) )
                                                    wire:click="update_selected_partner('{{  $result->id }}')"
                                                    @click="showModal = false"
                                                @endif

                                                >
                                                    <p class="text-sm font-medium text-gray-600 cursor-pointer flex items-center gap-3">
                                                        

                                                        <div class="max-w-full text-wrap ">
                                                            <div class="px-2 py-2   text-wrap">
                                                                




                                                                <span class="text-sm text-gray-600 dark:text-neutral-400">
                                                                    <strong>{{ $result->name }}</strong>
                                                                    <hr class="mb-1">
                                                                     
                                                                    @if(\App\Models\PlayerRegistration::isConfirmedPartner($selected_option_id,$result->id))
                                                                        <span class="text-gntf_green-500 font-bold">
                                                                            Confirmed Doubles Partner
                                                                        </span> 
                                                                     <!-- Check if the user has already has a partner on the selected option -->
                                                                    @elseif(\App\Models\PlayerRegistration::userHasConfirmedPartner($result->id,$selected_option_id) )
                                                                        <div class="col-span-12">
                                                                            <label  class="text-red-500 p-2 block w-full ">
                                                                                User already has a partner
                                                                            </label>
                                                                        </div>

                                                                    @else
                                                                        @if(\App\Models\PlayerRegistration::check_double_partner_request(Auth::user()->id, $selected_option_id, $result->id))
                                                                            
                                                                            <span class="text-gray-500 font-bold">
                                                                                Requesting double partner to you
                                                                            </span>
                                                                        @endif
                                                                    @endif   



                                                                </span> 

                                                                    

                                                            </div>
                                                        </div>

                                                        

                                                        {{-- <div class="max-w-full size-auto whitespace-nowrap  ">
                                                            <div class="px-2 py-2   max-h-52 text-wrap overflow-auto">
                                                                <span class="text-sm text-gray-600 dark:text-neutral-400 ">
                                                                    {{ $result->description ? $result->description : '' }}
                                                                </span>
                                                            </div>
                                                        </div> --}}

                                                    </p>
                                                </div>
                                            @endforeach

                                        @else
                                            <div class=" py-2 px-3 border-b border-slate-200 text-sm font-medium text-slate-500">

                                                <div class="mb-2 bg-red-50 border-s-4 border-red-500 p-4 dark:bg-red-800/30" role="alert" tabindex="-1" aria-labelledby="hs-bordered-red-style-label">
                                                    <div class="flex">
                                                        <div class="shrink-0">
                                                            <!-- Icon -->
                                                            <span class="inline-flex justify-center items-center size-8 rounded-full border-4 border-red-100 bg-red-200 text-red-800 dark:border-red-900 dark:bg-red-800 dark:text-red-400">
                                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path d="M18 6 6 18"></path>
                                                                    <path d="m6 6 12 12"></path>
                                                                </svg>
                                                            </span>
                                                            <!-- End Icon -->
                                                        </div>
                                                        <div class="ms-3">
                                                            <h3 id="hs-bordered-red-style-label" class="text-gray-800 font-semibold dark:text-white">
                                                                User not found
                                                            </h3>
                                                            <p class="text-sm text-gray-700 dark:text-neutral-400">

                                                                Search for user name
                                                            </p>
                                                        </div>



                                                    </div>
                                                </div>



                                            </div>
                                        @endif

    

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endteleport
    <!-- ./ User modal-->

</div>
<!-- End Card Section -->
 