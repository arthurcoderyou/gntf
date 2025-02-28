<!-- Card Section -->
<div class="max-w-[85rem] px-4 py-6 sm:px-6 lg:px-8  mx-auto"

    x-data="{
        showModalPlayerSign: false,   
        showModalGuardianSign: false, 
        handleKeydown(event) {
            if (event.keyCode == 191) {
                this.showModalPlayerSign = true; 
                this.showModalGuardianSign = true; 
            }
            if (event.keyCode == 27) {
                this.showModalPlayerSign = false;   
                this.showModalGuardianSign = false;   
            }

        },
    }"
>

     

    <div wire:loading class="loading-overlay">
        <div  style="color: #64d6e2" class="la-ball-clip-rotate-pulse la-3x preloader">
            <div></div>
            <div></div>
        </div>
    </div>
    

    <form wire:submit="save">
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
                 {{-- <div class="col-span-12  sm:col-span-4 mb-4  ">
                         
                    <div>
                        <hr class="mb-2">
                        <span class="block text-start text-lg font-medium text-gray-800   dark:text-neutral-200">
                            Registration details of <span class="text-gntf_green-500 font-bold">{{ $user->name }} </span> 
                            for the tournament  <span class="text-gntf_green-500 font-bold">{{ $tournament->name }}</span> 
                        </span>
                        <hr class="mt-2">
                    </div>
                </div>  --}}



                <!-- Invoice -->
                <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto my-4 sm:my-10">
                    <!-- Grid -->
                    <div class="mb-5 pb-5 flex justify-between items-center border-b border-gray-200 dark:border-neutral-700">
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-800 dark:text-neutral-200">
                                Registration Details
                            </h2>
                        </div>
                        <!-- Col -->
                    
                        {{-- <div class="inline-flex gap-x-2">
                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" href="#">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                            Invoice PDF
                            </a>
                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" href="#">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                            Print
                            </a>
                        </div> --}}
                        <!-- Col -->
                    </div>
                    <!-- End Grid -->
                
                    <!-- Grid -->
                    <div class="grid md:grid-cols-2 gap-3">
                        <div>
                            <div class="grid space-y-3">
                                {{-- <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                                    <dt class="min-w-36 max-w-[200px] text-gray-500 dark:text-neutral-500">
                                    Billed to:
                                    </dt>
                                    <dd class="text-gray-800 dark:text-neutral-200">
                                        <a class="inline-flex items-center gap-x-1.5 text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500" href="#">
                                            sara@site.com
                                        </a>
                                    </dd>
                                </dl> --}}
                    
                                <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                                    <dt class="min-w-36 max-w-[200px] text-gray-500 dark:text-neutral-500">
                                    Registered User:
                                    </dt>
                                    <dd class="font-medium text-gray-800 dark:text-neutral-200">
                                        <span class="block font-semibold">{{ $user->name }}</span>
                                        <span class="block  ">{{ ucfirst($user->gender) }}</span>
                                
                                    </dd>
                                </dl>

                                <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                                    <dt class="min-w-36 max-w-[200px] text-gray-500 dark:text-neutral-500">
                                    Home:
                                    </dt>
                                    <dd class="font-medium text-gray-800 dark:text-neutral-200"> 
                                        <address class="not-italic font-normal">
                                            {{ $user->home }}
                                        </address>
                                    </dd>
                                </dl>

                                <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                                    <dt class="min-w-36 max-w-[200px] text-gray-500 dark:text-neutral-500">
                                    Email:
                                    </dt>
                                    <dd class="text-gray-800 dark:text-neutral-200">
                                        <a class="inline-flex items-center gap-x-1.5 text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500" href="mailto:{{ $user->email }}">
                                            {{ $user->email }}
                                        </a>
                                        
                                    </dd>
                                </dl>

                                <!-- If the player has joined a junior event, the parent signature is required-->
                                @if($guardian_required)
                                    <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                                        <dt class="min-w-36 max-w-[200px] text-gray-500 dark:text-neutral-500">
                                        Guardian Name:
                                        </dt>
                                        <dd class="text-gray-800 dark:text-neutral-200">

                                            <!-- If the player has joined a junior event, the parent signature is required-->
                                            @if(!empty($user->guardian_name))
                                                {{ $user->guardian_name }} 
                                            @else 
                                                NOT SET

                                            @endif
                                             
                                        </dd>
                                    </dl>

                                    <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                                        <dt class="min-w-36 max-w-[200px] text-gray-500 dark:text-neutral-500">
                                        Guardian Relationship:
                                        </dt>
                                        <dd class="text-gray-800 dark:text-neutral-200">

                                            <!-- If the player has joined a junior event, the parent signature is required-->
                                            @if(!empty($user->relationship))
                                                {{ $user->relationship }} 
                                            @else 
                                                NOT SET

                                            @endif
                                             
                                        </dd>
                                    </dl>

                                    <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                                        <dt class="min-w-36 max-w-[200px] text-gray-500 dark:text-neutral-500">
                                        Guardian Email:
                                        </dt>
                                        <dd class="text-gray-800 dark:text-neutral-200">

                                            <!-- If the player has joined a junior event, the parent signature is required-->
                                            @if(!empty($user->guardian_email))
                                                <a class="inline-flex items-center gap-x-1.5 text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500" href="mailto:{{ $user->guardian_email }}">
                                                    {{ $user->guardian_email }}
                                                </a>
                                            @else 
                                                NOT SET
    
                                            @endif
                                            
                                            <p class="text-gray-500 text-sm">You had joined a junior event. Guardian verification is required</p>
                                            
                                        </dd>
                                    </dl>
                                @endif
                        
                                <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                                    <dt class="min-w-36 max-w-[200px] text-gray-500 dark:text-neutral-500">
                                    Phone Number:
                                    </dt>
                                    <dd class="font-medium text-gray-800 dark:text-neutral-200">
                                    {{-- <span class="block font-semibold">Sara Williams</span> --}}
                                    <address class="not-italic font-normal">
                                        {{ $user->phone_number }}
                                    </address>
                                    </dd>
                                </dl>

                                

                            </div>
                        </div>
                        <!-- Col -->
                    
                        <div>
                            <div class="grid space-y-3">
                                <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                                    <dt class="min-w-36 max-w-[200px] text-gray-500 dark:text-neutral-500">
                                        Registration Status:
                                    </dt>
                                    <dd class="font-medium text-gray-800 dark:text-neutral-200">
                                        {{ $player_registration->getRegistrationStatus() }}
                                    </dd>
                                </dl>
                        
                                <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                                    <dt class="min-w-36 max-w-[200px] text-gray-500 dark:text-neutral-500">
                                        Payment Status:
                                    </dt>
                                    <dd class="font-medium text-gray-800 dark:text-neutral-200">
                                        {{ $player_registration->getPaymentStatus() }}
                                    </dd>
                                </dl>
                        
                                <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                                    <dt class="min-w-36 max-w-[200px] text-gray-500 dark:text-neutral-500">
                                        Total Payment:
                                    </dt>
                                    <dd class="font-medium text-gray-800 dark:text-neutral-200">
                                        {{ $player_registration->total_payment }}
                                    </dd>
                                </dl>
                        
                                <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                                    <dt class="min-w-36 max-w-[200px] text-gray-500 dark:text-neutral-500">
                                        Player Signed at:
                                    </dt>
                                    <dd class="font-medium text-gray-800 dark:text-neutral-200">
                                        @if(!empty($player_registration->player_signed_at))

                                            {{ \Carbon\Carbon::parse($player_registration->player_signed_at)->format('M d, Y h:i A') }} 
                                        @else 
                                            <span class="flex items-center justify-between gap-x-4">
                                                <span class="block">
                                                    NOT SIGNED 
                                                </span>


                                                <button class="block text-blue-500 font-bold"
                                                    type="button"
                                                    wire:click="sendOTPCode()"
                                                    >
                                                    @if(!empty($existing_player_sign_otp))
                                                        RE-SEND OTP CODE
                                                    @else 
                                                        SEND OTP CODE
                                                    @endif
                                                </button>

                                                @if(!empty($existing_player_sign_otp))
                                                    <button class="block text-gntf_green-500 font-bold"
                                                        type="button"
                                                        @click="showModalPlayerSign = true" type="button"
                                                        @keydown.window="handleKeydown" 
                                                        >
                                                        CLICK TO SIGN
                                                    </button>
                                                @endif
                                            </span>
                                            @if(!empty($existing_player_sign_otp))
                                                <span class="block text-gray-500">
                                                    OTP code sent {{  \Carbon\Carbon::parse($existing_player_sign_otp->updated_at)->diffForHumans() }}
                                                </span>
                                            @endif

                                        @endif 
        
                                    </dd>
                                </dl>


                                <!-- If the player has joined a junior event, the parent signature is required-->
                                @if($guardian_required)
                                    <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                                        <dt class="min-w-36 max-w-[200px] text-gray-500 dark:text-neutral-500">
                                            Guardian Signed at:
                                        </dt>
                                        <dd class="font-medium text-gray-800 dark:text-neutral-200">

                                            <!-- If the player has joined a junior event, the parent signature is required-->
                                            @if(!empty($user->guardian_email))
                                                @if(!empty($player_registration->player_guardian_signed_at))

                                                    {{ \Carbon\Carbon::parse($player_registration->player_guardian_signed_at)->format('M d, Y h:i A') }} 
                                                @else 
                                                    <span class="flex items-center justify-between gap-x-4">
                                                        <span class="block">
                                                            NOT SIGNED 
                                                        </span>


                                                        <button class="block text-blue-500 font-bold"
                                                            type="button"
                                                            wire:click="sendOTPCodeForGuardian()"
                                                            >
                                                            @if(!empty($existing_guardian_player_sign_otp))
                                                                RE-SEND OTP CODE
                                                            @else 
                                                                SEND OTP CODE
                                                            @endif
                                                        </button>

                                                        @if(!empty($existing_guardian_player_sign_otp))
                                                            <button class="block text-gntf_green-500 font-bold"
                                                                type="button"
                                                                @click="showModalGuardianSign = true" type="button"
                                                                @keydown.window="handleKeydown" 
                                                                >
                                                                CLICK TO SIGN
                                                            </button>
                                                        @endif
                                                    </span>
                                                    @if(!empty($existing_guardian_player_sign_otp))
                                                        <span class="block text-gray-500">
                                                            OTP code sent {{  \Carbon\Carbon::parse($existing_guardian_player_sign_otp->updated_at)->diffForHumans() }}
                                                        </span>
                                                    @endif

                                                @endif 
                                            @else 
                                                <a class="inline-flex items-center gap-x-1.5 text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500" 
                                                href="{{ route('profile') }}">
                                                    Click to Update Profile and add Guardian Email
                                                </a>
                                            @endif
                                        </dd>
                                    </dl>

                                @endif

                            </div>
                        </div>
                        <!-- Col -->
                    </div>
                    <!-- End Grid -->
                    
                    <!-- Double Events -->

                    @if(!empty($player_registration->registered_doubles_options))
                    <div class="mt-6 border border-gray-200 p-4 rounded-lg space-y-4 dark:border-neutral-700">
                    
                        <div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                                    Double Events
                                </h2>
                            </div>
                             
                            @foreach ($player_registration->registered_doubles_options as $option)
                                <hr  >
                                <!-- Grid -->
                                <div class="grid md:grid-cols-2 gap-y-3 p-2">
                                    <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                                        {{-- <dt class="min-w-36   text-gray-500 dark:text-neutral-500">
                                        {{ $option->tournament_event_category->name }}
                                        </dt> --}}
                                        <dd class=" text-gray-500 ">
                                            <span class="block  ">
                                                Event: 
                                                <span class="font-medium text-gray-800">{{ $option->tournament_event->name }}</span> 
                                            </span>
                                            <span class="block  ">
                                                Category:  
                                                <span class="font-medium text-gray-800">{{ $option->tournament_event_category->name }}</span> 
                                            </span>

                                            <span class="block  ">
                                                Division:  
                                                <span class="font-medium text-gray-800">{{ $option->tournament_event_category_option->name }}</span> 
                                            </span>
                                    
                                        </dd>
                                    </dl>

                                    <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                                        {{-- <dt class="min-w-36   text-gray-500 dark:text-neutral-500">
                                        {{ $option->tournament_event_category->name }}
                                        </dt> --}}
                                        <dd class=" text-gray-500 ">
                                            <span class="block  ">
                                                Partner: 
                                                <span class="font-medium text-gray-800">{{ $option->partner->name }}</span> 
                                            </span>
                                            <span class="block  ">
                                                Status:  

                                                {!! \App\Models\RegisteredOptions::validateDoublesPartner($option->tournament_event_category_option->id, $option->doubles_partner_user_id)  !!} 
                                            </span>

                                            {{-- <span class="block  ">
                                                Division:  
                                                <span class="font-medium text-gray-800">{{ $option->tournament_event_category_option->name }}</span> 
                                            </span> --}}
                                    
                                        </dd>
                                    </dl>


                                    

                                </div>
                                <hr  >
                            @endforeach


                        </div>
                    </div>
                    <!-- ./Double Events -->
                    @endif



                    <!-- Grid -->
                    <div class="col-span-12  sm:col-span-8 grid grid-cols-12 gap-x-2 border-4 border-double border-black mt-2 p-2 ">

                         
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


                    <!-- Table -->
                    <div class="mt-6 border border-gray-200 p-4 rounded-lg space-y-4 dark:border-neutral-700">

                    <div class="hidden sm:grid sm:grid-cols-6">
                        <div class="sm:col-span-2 text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Event</div>
                        <div class="sm:col-span-2 text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Category</div>
                        <div class="text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Division</div>
                        <div class="text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Amount</div>
                    </div>
                

                    @if($player_registration->registered_options->isNotEmpty()) 
                        @foreach ($player_registration->registered_options as $option)


                            <div class="hidden sm:block border-b border-gray-200 dark:border-neutral-700">
                            </div> 
                            <div class="grid grid-cols-3 sm:grid-cols-6 gap-2">
                                <div class="col-span-full sm:col-span-2">
                                    <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Event</h5>
                                    <p class="font-medium text-gray-800 dark:text-neutral-200">{{ $option->tournament_event->name }}</p>
                                </div>
                                <div class="col-span-full sm:col-span-2">
                                    <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Category</h5>
                                    <p class="text-gray-800 dark:text-neutral-200">{{ $option->tournament_event_category->name }}</p>
                                </div>
                                <div>
                                    <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Division</h5>
                                    <p class="text-gray-800 dark:text-neutral-200">
                                        {{ $option->tournament_event_category_option->name }} 
                                        
                                        @if($option->tournament_event_category->type == "doubles")
                                        <br>
                                            <span class="text-sm text-gray-500">
                                                Partner: {{ $option->partner->name ?? '' }}
                                            </span>
                                        
                                        @endif

                                    
                                    </p>
                                </div>
                                <div>
                                    <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Amount</h5>
                                    <p class="sm:text-end text-gray-800 dark:text-neutral-200">
                                        <input type="number"
                                        wire:model.live="tournamentFees.{{ $option->id }}"
                                        @if( (Auth::user()->hasRole('DSI God Admin')) )

                                        @else
                                            readonly
                                        @endif
                                        class="rounded-lg border border-gray-300 text-sm text-end p-1 w-full" placeholder="0"
                                            >

                                    </p>
                                </div>
                            </div>
                        @endforeach

                    @endif


                    <div class="hidden sm:block border-b border-gray-200 dark:border-neutral-700">
                    </div> 


                    <!-- Flex -->
                    <div class="mt-8 flex sm:justify-end">
                        <div class="w-full max-w-2xl sm:text-end space-y-2">
                        <!-- Grid -->
                        <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                            {{-- <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                            <dt class="col-span-3 text-gray-500 dark:text-neutral-500">Subotal:</dt>
                            <dd class="col-span-2 font-medium text-gray-800 dark:text-neutral-200">$2750.00</dd>
                            </dl> --}}

                            <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                                <dt class="col-span-3 text-gray-500 dark:text-neutral-500">Total:</dt>
                                <dd class="col-span-2 font-medium text-gray-800 dark:text-neutral-200">
                                    <input type="number"
                                    wire:model="total_payment"
                                    @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('DSI God Admin'))

                                    @else 
                                        readonly
                                    @endif
                                    class="rounded-lg border border-gray-300 text-sm text-end p-1" placeholder="0"
                                        >

                                    @error('total_payment')
                                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                    @enderror
 
                                </dd>
                            </dl>

                            @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('DSI God Admin'))

                                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm mt-2">
                                    <dt class="col-span-3 text-gray-500 dark:text-neutral-500">GNTF Member?:</dt>
                                    <dd class="col-span-2 font-medium text-gray-800 dark:text-neutral-200">
                                        <select 
                                        wire:model.live="gntf_member"
                                        class="py-1 px-2 w-fit min-w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50">
                                             
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        @error('gntf_member')
                                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                        @enderror
                                    </dd>
                                </dl>

                                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm mt-2">
                                    <dt class="col-span-3 text-gray-500 dark:text-neutral-500">Payment Status:</dt>
                                    <dd class="col-span-2 font-medium text-gray-800 dark:text-neutral-200">
                                        <select 
                                        wire:model="payment_status"
                                        class="py-1 px-2 w-fit min-w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50">
                                            <option selected=""  >Select payment status</option>
                                            <option value="paid">Paid</option>
                                            <option value="not_paid">Not Paid</option>
                                        </select>
                                        @error('payment_status')
                                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                        @enderror
                                    </dd>
                                </dl>
                                
                                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm mt-2">
                                    <dt class="col-span-3 text-gray-500 dark:text-neutral-500">Registration Status:</dt>
                                    <dd class="col-span-2 font-medium text-gray-800 dark:text-neutral-200">
                                        <select 
                                        wire:model="registration_status"
                                        class="py-1 px-2 w-fit min-w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50">
                                            <option selected=""  >Select registration status</option>
                                            <option value="pending">Pending</option>
                                            <option value="otp_sent">OTP Sent</option>
                                            <option value="signed">Signed</option>
                                            <option value="guardian_otp_sent">Guardian OTP Sent</option>
                                            <option value="guardian_signed">Guardian Signed</option>
                                            <option value="complete">Complete</option>
                                        </select>
                                        @error('registration_status')
                                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                        @enderror
                                    </dd>
                                </dl>
                                


                                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                                    <dt class="col-span-3 text-gray-500 dark:text-neutral-500"></dt>
                                    <dd class="col-span-2 font-medium text-gray-800 dark:text-neutral-200">
                                        
                                        <button
                                            onclick="confirm('Are you sure, you want to save this record?   ') || event.stopImmediatePropagation()"
                                            wire:click.prevent="save"
                                            type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                            Save
                                        </button>
                                    </dd>
                                </dl>
                            @endif


                            {{-- <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                            <dt class="col-span-3 text-gray-500 dark:text-neutral-500">Tax:</dt>
                            <dd class="col-span-2 font-medium text-gray-800 dark:text-neutral-200">$39.00</dd>
                            </dl>

                            <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                            <dt class="col-span-3 text-gray-500 dark:text-neutral-500">Amount paid:</dt>
                            <dd class="col-span-2 font-medium text-gray-800 dark:text-neutral-200">$2789.00</dd>
                            </dl>

                            <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                            <dt class="col-span-3 text-gray-500 dark:text-neutral-500">Due balance:</dt>
                            <dd class="col-span-2 font-medium text-gray-800 dark:text-neutral-200">$0.00</dd>
                            </dl> --}}
                        </div>
                        <!-- End Grid -->
                        </div>
                    </div>
                    <!-- End Flex -->




                 
                </div>
                <!-- End Invoice -->



            </div>
        </div>

    </form>

    


    <!--Player Sign modal-->
    @teleport('body')
        <div x-show="showModalPlayerSign" x-trap="showModalPlayerSign" class="relative z-10 " aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <!-- <div class="fixed inset-0 z-10 w-screen overflow-y-auto py-10"> -->
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto py-10">
                <div class="flex justify-center p-4 sm:p-0">
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div @click.outside="showModalPlayerSign = false" class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="w-full px-1 pt-1"  ">
                                <form wire:submit="confirm_player_sign" autocomplete="off" class="text-center">

                                    <p class="text-gntf_green-500">
                                        Verify OTP Code 

                                        @if(!empty($existing_player_sign_otp))
                                            <span class="block text-gray-500">
                                                OTP code sent {{  \Carbon\Carbon::parse($existing_player_sign_otp->updated_at)->diffForHumans() }}
                                            </span>
                                        @endif
                                    </p>

                                    <input
                                    autocomplete="off"
                                    wire:model="player_sign_otp_code" type="text" id="searchInput"
                                    name="searchInput"
                                    class="block w-full text-center flex-1 py-2 px-3 mt-2 outline-none border-none rounded-md bg-slate-100"
                                    placeholder=""   />

                                    @error('player_sign_otp_code')
                                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                    @enderror


                                    <button
                                        type="submit"
                                        class="p-2 rounded-lg bg-blue-500 text-white mt-2 mx-auto">
                                        Confirm
                                    </button>


                                </form>
                                 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endteleport
    <!-- ./Player Sign modal-->

    <!--Guardian Sign modal-->
    @teleport('body')
        <div x-show="showModalGuardianSign" x-trap="showModalGuardianSign" class="relative z-10 " aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <!-- <div class="fixed inset-0 z-10 w-screen overflow-y-auto py-10"> -->
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto py-10">
                <div class="flex justify-center p-4 sm:p-0">
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div @click.outside="showModalGuardianSign = false" class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="w-full px-1 pt-1"  ">
                                <form wire:submit="confirm_player_guardian_sign" autocomplete="off" class="text-center">

                                    <p class="text-gntf_green-500">
                                        Verify Guardian OTP Code 

                                        @if(!empty($existing_guardian_player_sign_otp))
                                            <span class="block text-gray-500">
                                                OTP code sent {{  \Carbon\Carbon::parse($existing_guardian_player_sign_otp->updated_at)->diffForHumans() }}
                                            </span>
                                        @endif
                                    </p>

                                    <input
                                    autocomplete="off"
                                    wire:model="player_guardian_sign_otp_code" type="text" id="searchInput"
                                    name="searchInput"
                                    class="block w-full text-center flex-1 py-2 px-3 mt-2 outline-none border-none rounded-md bg-slate-100"
                                    placeholder=""   />

                                    @error('player_guardian_sign_otp_code')
                                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                    @enderror


                                    <button
                                        type="submit"
                                        class="p-2 rounded-lg bg-blue-500 text-white mt-2 mx-auto">
                                        Confirm
                                    </button>


                                </form>
                                 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endteleport
    <!-- ./Guardian Sign modal-->

</div>
