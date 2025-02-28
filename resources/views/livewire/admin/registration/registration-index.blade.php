<!-- Table Section -->
<div class="max-w-full px-4 py-6 sm:px-6 lg:px-8  mx-auto"
x-data="{
    showModal: false,  
    showModalEvent: false,
    showModalEventCategories: false,
    showModalEventCategoryOptions: false,
    showModalUsers: false,
    handleKeydown(event) {
        if (event.keyCode == 191) {
            this.showModal = true; 
            this.showModalEvent = true;
            this.showModalEventCategories = true;
            this.showModalEventCategoryOptions = true;
            this.showModalUsers = true;
        }
        if (event.keyCode == 27) {
            this.showModal = false; 
            this.showModalEvent = false;
            this.showModalEventCategories = true;
            this.showModalEventCategoryOptions = true;
            this.showModalUsers = true;
            $wire.search = '';
        }

    },
    saerch_project() {
        this.showModal = false;
        {{-- $wire.search = '';  --}}
    }

}"
>

    <!-- Loading for list -->
    <div wire:loading style="color: #64d6e2" class="la-ball-clip-rotate-pulse la-3x preloader">
        <div></div>
        <div></div>
    </div>

    <!-- Card -->
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
            <!-- Header -->
            <div class=" px-3 py-2 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                        Tournament Filters
                    </h2>
                    
                </div>

                <div class="text-nowrap">
                    <!-- tournament  -->
                        <button 
                            @click="showModal = true" type="button"
                            @keydown.window="handleKeydown" 
                            class="py-2 px-3 max-w-48 inline-flex items-center gap-x-2  border-2 border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            {{-- href="{{ route('schedule.index') }}"> --}}
                            >
                            
                            @if(!empty($selected_tournament))
                                <span class="text-gntf_green-500 overflow-hidden text-nowrap">{{ $selected_tournament->name }}</span> 
                            @else  
                                Tournament

                            @endif
                            
                            <svg class="shrink-0 size-[.8em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                            
                            
                        </button> 
                    <!-- ./ tournament  -->

                    <!-- tournament event -->
                        <button 
                            @click="showModalEvent = true" type="button"
                            @keydown.window="handleKeydown" 
                            class="max-w-48 py-2 px-3 inline-flex items-center gap-x-2  border-2 border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            
                            >
                            
                            @if(!empty($selected_tournament_event))
                                <span class="text-gntf_green-500 overflow-hidden text-nowrap">{{ $selected_tournament_event->name }}</span> 
                            @else  
                                Event

                            @endif
                            
                            <svg class="shrink-0 size-[.8em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                            
                            
                        </button> 
                    <!-- ./ tournament event -->

                    <!-- tournament event category -->
                        <button 
                            @click="showModalEventCategories = true" type="button"
                            @keydown.window="handleKeydown" 
                            class="max-w-48 py-2 px-3 inline-flex items-center gap-x-2  border-2 border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            
                            >
                            
                            @if(!empty($selected_tournament_event_category))
                                <span class="text-gntf_green-500 overflow-hidden text-nowrap">{{ $selected_tournament_event_category->name }}</span> 
                            @else  
                                Category

                            @endif
                            
                            <svg class="shrink-0 size-[.8em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                            
                            
                        </button> 
                    <!-- ./ tournament event category -->

                    <!-- tournament event category_option -->
                        <button 
                            @click="showModalEventCategoryOptions = true" type="button"
                            @keydown.window="handleKeydown" 
                            class="max-w-48 py-2 px-3 inline-flex items-center gap-x-2  border-2 border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            
                            >
                            
                            @if(!empty($selected_tournament_event_category_option))
                                <span class="text-gntf_green-500 overflow-hidden text-nowrap">{{ $selected_tournament_event_category_option->name }}</span> 
                            @else  
                                Division

                            @endif
                            
                            <svg class="shrink-0 size-[.8em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                            
                            
                        </button>   
                    <!-- ./ tournament event category_option -->

                    <!-- player -->
                        <button 
                        @click="showModalUsers = true" type="button"
                        @keydown.window="handleKeydown" 
                        class="max-w-48 py-2 px-3 inline-flex items-center gap-x-2  border-2 border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        
                        >
                        
                        @if(!empty($selected_user))
                            <span class="text-gntf_green-500 overflow-hidden text-nowrap">{{ $selected_user->name }}</span> 
                        @else  
                            Search Player

                        @endif
                        
                        <svg class="shrink-0 size-[.8em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                        
                        
                    </button> 
                <!-- ./ player -->


                </div>
            </div>
            </div>
        </div>
        </div>
    </div>




    <!-- Card -->
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
            <!-- Header -->
            <div class=" px-3 py-2 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
                <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                    Registrations
                </h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Listing of tournament registrations
                </p>
                </div>

                <div>
                <div class="inline-flex gap-x-2">


                    <input type="text" wire:model.live="search"
                        class="min-w-32 py-2 px-3 inline-flex items-center gap-x-2 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Search">

                    

                    

                    <div class="inline-flex items-center gap-x-2">

                        <select wire:model.live="sort_by_registration_status" class="py-2 px-3 pe-9 block max-w-40 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                            <option value="">Sort By Registration Status</option>
                            <option value="pending">Pending</option>
                            <option value="otp_sent">OTP Sent</option> 
                            <option value="signed">Signed</option> 
                            <option value="guardian_otp_sent">Guardian OTP Sent</option> 
                            <option value="guardian_signed">Guardian signed</option> 
                            <option value="complete">Complete</option> 
                        </select>
                    </div>


                    <div class="inline-flex items-center gap-x-2">

                        <select wire:model.live="sort_by_payment_status" class="py-2 px-3 pe-9 block max-w-40 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                            <option value="">Sort By Payment Status</option>
                            <option value="paid">PAID</option>
                            <option value="not_paid">NOT PAID</option> 
                        </select>
                    </div>

                    <div class="inline-flex items-center gap-x-2">

                        <select wire:model.live="sort_by_gender" class="py-2 px-3 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                            <option value="">Sort By Gender</option>
                            <option>Male</option>
                            <option>Female</option> 
                        </select>
                    </div>
 

                    <div class="inline-flex items-center gap-x-2">

                        <select wire:model.live="sort_by" class="py-2 px-3 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                            <option value="">Sort By</option>
                            <option>Name A - Z</option>
                            <option>Name Z - A</option>
                            <option>Latest Added</option>
                            <option>Oldest Added</option>
                            <option>Latest Updated</option>
                            <option>Oldest Updated</option>
                        </select>
                    </div>



                    {{-- @if( Auth::user()->can('activity log delete') || Auth::user()->hasRole('DSI God Admin')) --}}
                        <button
                            onclick="confirm('Are you sure, you want to delete this records?') || event.stopImmediatePropagation()"
                            wire:click.prevent="deleteSelected"
                            {{ $count == 0 ? 'disabled' : '' }}
                            class="text-nowrap py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-red-500 text-white shadow-sm hover:bg-red-50 hover:text-red-600 hover:border-red-500 focus:outline-red-500 focus:text-red-500 focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" >
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                            Delete ({{ $count }})
                        </button>
                    {{-- @endif --}}

                    <!-- create -->
                    <a href="{{ !empty($add_route_with_tournament_event_id) ? $add_route_with_tournament_event_id : route('dashboard') }}"
                        class="text-nowrap py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-yellow-500 text-white shadow-sm hover:bg-yellow-50 hover:text-yellow-600   hover:border-yellow-500 focus:outline-yellow-500 focus:text-yellow-500 focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" >
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm144 276c0 6.6-5.4 12-12 12h-92v92c0 6.6-5.4 12-12 12h-56c-6.6 0-12-5.4-12-12v-92h-92c-6.6 0-12-5.4-12-12v-56c0-6.6 5.4-12 12-12h92v-92c0-6.6 5.4-12 12-12h56c6.6 0 12 5.4 12 12v92h92c6.6 0 12 5.4 12 12v56z"/></svg>
                    </a>


                    
                    <!-- reset -->
                    <a href="{{ route('player_registration.index') }}"
                        class="text-nowrap py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-gntf_green-500 text-white shadow-sm hover:bg-gntf_green-50 hover:text-gntf_green-600   hover:border-gntf_green-500 focus:outline-gntf_green-500 focus:text-gntf_green-500 focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" >
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M105.1 202.6c7.7-21.8 20.2-42.3 37.8-59.8c62.5-62.5 163.8-62.5 226.3 0L386.3 160 352 160c-17.7 0-32 14.3-32 32s14.3 32 32 32l111.5 0c0 0 0 0 0 0l.4 0c17.7 0 32-14.3 32-32l0-112c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 35.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0C73.2 122 55.6 150.7 44.8 181.4c-5.9 16.7 2.9 34.9 19.5 40.8s34.9-2.9 40.8-19.5zM39 289.3c-5 1.5-9.8 4.2-13.7 8.2c-4 4-6.7 8.8-8.1 14c-.3 1.2-.6 2.5-.8 3.8c-.3 1.7-.4 3.4-.4 5.1L16 432c0 17.7 14.3 32 32 32s32-14.3 32-32l0-35.1 17.6 17.5c0 0 0 0 0 0c87.5 87.4 229.3 87.4 316.7 0c24.4-24.4 42.1-53.1 52.9-83.8c5.9-16.7-2.9-34.9-19.5-40.8s-34.9 2.9-40.8 19.5c-7.7 21.8-20.2 42.3-37.8 59.8c-62.5 62.5-163.8 62.5-226.3 0l-.1-.1L125.6 352l34.4 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L48.4 288c-1.6 0-3.2 .1-4.8 .3s-3.1 .5-4.6 1z"/></svg>
                    </a>
                </div>
                </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                <thead class="bg-gray-50 dark:bg-neutral-800">
                <tr>
                    <th scope="col" class="px-2 py-3 text-start">
                        <label for="hs-at-with-checkboxes-main" class="flex">
                            <input
                                type="checkbox"
                                wire:model.live="selectAll"
                                wire:click="toggleSelectAll"
                                wire:change="updateSelectedCount"
                                class="shrink-0 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                id="hs-at-with-checkboxes-main">
                            <span class="sr-only">Checkbox</span>
                        </label>
                    </th>

                    

                    <th scope="col" class="px-2 py-3 text-start">
                        <div class="flex items-center gap-x-2">
                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                            User
                            </span>
                        </div>
                    </th>


                    <th scope="col" class="px-2 py-3 text-start">
                        <div class="flex items-center gap-x-2">
                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                            Registered Tournament Events
                            </span>
                        </div>
                    </th>


                    <th scope="col" class="px-2 py-3 text-start">
                        <div class="flex items-center gap-x-2">
                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                            Payment Status
                            </span>
                        </div>
                    </th>
 
                    <th scope="col" class="px-2 py-3 text-start">
                        <div class="flex items-center gap-x-2">
                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                            Registration Status
                            </span>
                        </div>
                    </th>

                    <th scope="col" class="px-2 py-3 text-start">
                        <div class="flex items-center gap-x-2">
                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                            Total Payment
                            </span>
                        </div>
                    </th>


                    <th scope="col" class="px-2 py-3 text-start">
                        <div class="flex items-center gap-x-2">
                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                Sign Status
                            </span>
                        </div>
                    </th>
 

                    



                    <th scope="col" class="px-2 py-3 text-start">
                        <div class="flex items-center gap-x-2">
                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                            Modified
                            </span>
                        </div>
                    </th>

                    <th scope="col" class="px-6 py-3 text-end"></th>
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">

                    @if(!empty($player_registrations) && count($player_registrations) > 0)
                        @foreach ($player_registrations as $player_registration)
                            <tr>
                                <td class="w-4 whitespace-nowrap">
                                    <div class="px-2 py-2">
                                        <label for="data_{{ $player_registration->id }}" class="flex">
                                            <input type="checkbox"
                                            wire:model="selected_records"
                                            wire:change="updateSelectedCount"
                                            class="shrink-0 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                            id="data_{{ $player_registration->id }}"
                                            value="{{ $player_registration->id }}"
                                            >
                                            <span class="sr-only">Checkbox</span>
                                        </label>
                                    </div>
                                </td>

 

                                {{-- <td class="size-auto whitespace-nowrap">
                                    <div class="px-2 py-2">
                                        <div class="flex items-center gap-x-3">
                                            <div class="grow">
                                                <span class="block text-sm text-gray-500 dark:text-neutral-500">
                                                    
                                                </span>

                                                <span class="block text-sm text-gray-500 dark:text-neutral-500">
                                                    
                                                </span>

                                                <span class="block text-sm text-gray-500 dark:text-neutral-500">
                                                    {{ $player_registration->user->phone_number }}
                                                </span>

                                                <span class="block text-sm text-gray-500 dark:text-neutral-500">
                                                    {{ $player_registration->user->home }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td> --}}

                                <td class="size-px whitespace-nowrap">
                                    <div class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3">
                                        <div class="flex items-center gap-x-3 gap-y-1">
                                            <div class="grow">
                                                 

                                                <span class=" text-sm text-gray-800 font-bold dark:text-neutral-500 flex items-center  gap-x-2 mb-1">
                                                    <svg class="shrink-0 size-4"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"/></svg>
                                                    {{ $player_registration->user->name }}
                                                </span>

                                                <span class=" text-sm text-gray-500 font-bold dark:text-neutral-500 flex items-center  gap-x-2 mb-1">
                                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M176 288a112 112 0 1 0 0-224 112 112 0 1 0 0 224zM352 176c0 86.3-62.1 158.1-144 173.1l0 34.9 32 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-32 0 0 32c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-32-32 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l32 0 0-34.9C62.1 334.1 0 262.3 0 176C0 78.8 78.8 0 176 0s176 78.8 176 176zM271.9 360.6c19.3-10.1 36.9-23.1 52.1-38.4c20 18.5 46.7 29.8 76.1 29.8c61.9 0 112-50.1 112-112s-50.1-112-112-112c-7.2 0-14.3 .7-21.1 2c-4.9-21.5-13-41.7-24-60.2C369.3 66 384.4 64 400 64c37 0 71.4 11.4 99.8 31l20.6-20.6L487 41c-6.9-6.9-8.9-17.2-5.2-26.2S494.3 0 504 0L616 0c13.3 0 24 10.7 24 24l0 112c0 9.7-5.8 18.5-14.8 22.2s-19.3 1.7-26.2-5.2l-33.4-33.4L545 140.2c19.5 28.4 31 62.7 31 99.8c0 97.2-78.8 176-176 176c-50.5 0-96-21.3-128.1-55.4z"/></svg>
                                                    {{ ucfirst($player_registration->user->gender) }}
                                                </span>

                                                <span class=" text-sm text-gray-500 dark:text-neutral-500 flex items-center  gap-x-2 mb-1">
                                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-208L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg>
                                                    {{ $player_registration->user->email }}
                                                </span>

                                                <span class=" text-sm text-gray-500 dark:text-neutral-500 flex items-center  gap-x-2 mb-1">
                                                      
                                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>
                                                    {{ $player_registration->user->phone_number }}
                                                </span>

                                                <span class=" text-sm text-gray-500 dark:text-neutral-500 flex items-center  gap-x-2 mb-1">
                                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M575.8 255.5c0 18-15 32.1-32 32.1l-32 0 .7 160.2c0 2.7-.2 5.4-.5 8.1l0 16.2c0 22.1-17.9 40-40 40l-16 0c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1L416 512l-24 0c-22.1 0-40-17.9-40-40l0-24 0-64c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32 14.3-32 32l0 64 0 24c0 22.1-17.9 40-40 40l-24 0-31.9 0c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2l-16 0c-22.1 0-40-17.9-40-40l0-112c0-.9 0-1.9 .1-2.8l0-69.7-32 0c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/></svg>
                                                    {{ $player_registration->user->home }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="size-auto whitespace-nowrap w-fit text-wrap  ">
                                    <div class="px-2 py-2 max-w-[500px]   max-h-56 overflow-y-auto">
                                        <span class=" text-sm text-gray-800 font-bold dark:text-neutral-500  mb-1">
                                           
                                            {!! $player_registration->tournament->name !!} 
                                        </span>
                                        @if($player_registration->registered_options->isNotEmpty())
                                            <ul class="marker:text-blue-600 list-disc ps-5 space-y-1 text-sm text-gray-600 text-nowrap dark:text-neutral-400">
                                                @foreach ($player_registration->registered_options->groupBy([
                                                    'tournament_event.name',
                                                    'tournament_event_category.name'
                                                ]) as $eventName => $categories)
                                                    <li class="font-semibold text-gntf_green-500 dark:text-white">
                                                        {{ $eventName }}
                                                        <ul class="ps-5">
                                                            @foreach ($categories as $categoryName => $options)
                                                                <li class="text-gray-700 dark:text-neutral-400">
                                                                    <span class="text-gray-500">{{ $categoryName }} ||  </span>
                                                                    {{ $options->pluck('tournament_event_category_option.name')->unique()->implode(', ') }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                         
                                    </div>
                                </td>
 

                                <td class="size-auto whitespace-nowrap">
                                    <div class="px-2 py-2 max-w-96 text-wrap text-sm  text-gray-800 ">
                                        
                                        {{-- {!! $player_registration->getStatus() !!} --}} 

                                          
                                        <span class="    dark:text-neutral-500  ">
                                            {!! $player_registration->getPaymentStatus() !!}
                                        </span> 
                                      
                                         
                                    </div>
                                </td>

                                <td class="size-auto whitespace-nowrap">
                                    <div class="px-2 py-2 max-w-96 text-wrap text-sm  text-gray-800 ">
                                        
                                        {{-- {!! $player_registration->getStatus() !!} --}} 

                                          
                                        <span class="    dark:text-neutral-500  ">
                                            {!! $player_registration->getRegistrationStatus() !!}
                                        </span> 
                                      
                                         
                                    </div>
                                </td>

                                
                                <td class="size-auto whitespace-nowrap">
                                    <div class="px-2 py-2 max-w-96 text-wrap text-sm  text-gray-800 ">
                                        
                                        {{-- {!! $player_registration->getStatus() !!} --}} 

                                          
                                        <span class="    dark:text-neutral-500  ">
                                            {!! $player_registration->total_payment !!}
                                        </span> 
                                      
                                         
                                    </div>
                                </td>

                                <td class="size-auto whitespace-nowrap">
                                    <div class="px-2 py-2 max-w-96 text-wrap text-sm  text-gray-800 ">
                                        
                                        {{-- {!! $player_registration->getStatus() !!} --}} 

                                          
                                        <span class="block text-sm text-gray-500 dark:text-neutral-500">
                                            
                                            @if(!empty($player_registration->player_signed_at))

                                                Player Signed at 
                                                <br> <strong>{{ \Carbon\Carbon::parse($player_registration->player_signed_at)->format('M d, Y') }}</strong>  <br>
                                            @else 
                                             
                                                <strong> 
                                                    NOT SIGNED 
                                                </strong> <br>
                                            @endif 

                                            @if(!empty($player_registration->player_guardian_signed_at))
                                                Guardian Signed at 
                                                <br> <strong>{{ \Carbon\Carbon::parse($player_registration->player_guardian_signed_at)->format('h:i A') }}</strong> <br>
                                            @endif   

                                             


                                        </span>
                                         
                                    </div>
                                </td>

 




                                <td class="size-auto whitespace-nowrap">
                                    <div class="px-2 py-2">
                                        <div class="flex items-center gap-x-3">
                                        <div class="grow">

                                            {{-- <span class="block text-sm text-gray-800 dark:text-neutral-500">
                                                {!! $project->getStatus() !!}
                                            </span> --}}


                                            <span class="block text-sm text-gray-500 dark:text-neutral-500">
                                                Updated at 
                                                <br> <strong>{{ \Carbon\Carbon::parse($player_registration->updated_at)->format('M d, Y') }}</strong> 
                                                <br> <strong>{{ \Carbon\Carbon::parse($player_registration->updated_at)->format('h:i A') }}</strong>
                                                <br>Created by 
                                                <br> <strong>{{ $player_registration->creator ? $player_registration->creator->name : '' }}</strong>
                                                
                                            </span>
                                        </div>
                                        </div>
                                    </div>
                                </td>




                                <td class="w-4 whitespace-nowrap">
                                    <div class="px-2 py-2">

                                        @if( Auth::user()->can('registration show') ||  Auth::user()->hasRole('DSI God Admin'))
                                            <!-- show / singing and status  -->
                                            <a href="{{ route('player_registration.show',['player_registration' => $player_registration->id]) }}" class="py-2 px-3 inline-flex items-center gap-x-2  text-sm font-medium rounded-lg border border-transparent bg-yellow-600 text-white hover:bg-yellow-700 focus:outline-none focus:bg-yellow-700 disabled:opacity-50 disabled:pointer-events-none">
                                                
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336l24 0 0-64-24 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l48 0c13.3 0 24 10.7 24 24l0 88 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-80 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                                            </a>
                                        @endif

                                        @if( Auth::user()->can('registration edit') ||  Auth::user()->hasRole('DSI God Admin'))
                                            <!-- edit -->
                                            <a href="{{ route('player_registration.edit',['player_registration' => $player_registration->id]) }}" class="py-2 px-3 inline-flex items-center gap-x-2  text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z"/></svg>
                                            </a>
                                        @endif

                                        <!-- delete -->
                                        @if( Auth::user()->can('registration delete') ||  Auth::user()->hasRole('DSI God Admin'))
                                            <button
                                            
                                            
                                            onclick="confirm('Are you sure, you want to delete this record?') || event.stopImmediatePropagation()"
                                            wire:click.prevent="delete({{ $player_registration->id }})"
                                            type="button" class="py-2 px-3 inline-flex items-center gap-x-2  text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.7 23.7 0 0 0 -21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0 -16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"/></svg>
                                            </button>
                                        @endif



                                    </div>
                                </td>



                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                    No records found
                                    </span>
                                </div>
                            </th>
                        </tr>
                    @endif
                </tbody>
            </table>
            <!-- End Table -->

            <!-- Footer -->
            <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-neutral-700">
                {{ $player_registrations->links() }}

                <div class="inline-flex items-center gap-x-2">
                    <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Showing:
                    </p>
                    <div class="max-w-sm space-y-3">
                    <select wire:model.live="record_count" class="py-2 px-3 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                        <option>200</option>
                    </select>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-neutral-400">
                        {{ count($player_registrations) > 0 ? 'of '.$player_registrations->total()  : '' }}
                    </p>
                </div>


            </div>
            <!-- End Footer -->


            </div>
        </div>
        </div>
    </div>
    <!-- End Card -->

    <!-- Tournament modal-->
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
                                    wire:model.live.throttle.500ms="tournament_search" type="text" id="searchInput"
                                    name="searchInput"
                                    class="block w-full flex-1 py-2 px-3 mt-2 outline-none border-none rounded-md bg-slate-100"
                                    placeholder="Search for tournament name ..." @keydown.slash.window="searchPosts" />
                                </form>
                                <div class="mt-2 w-full overflow-hidden rounded-md bg-white">

                                    
                                        @if(!empty($results) && count($results) > 0)
                                            <div class=" py-2 px-3 border-b border-slate-200 text-sm font-medium text-slate-500">

                                                All Tournaments <strong>(Click to select a tournament)</strong>

                                            </div>

                                            @foreach ($results as $result)
                                                <div class="cursor-pointer py-2 px-3 hover:bg-slate-100 bg-white border border-gray-200 shadow-sm rounded-xl mb-1"
                                                wire:click="search_tournament('{{  $result->id }}')"
                                                @click="showModal = false"
                                                >
                                                    <p class="text-sm font-medium text-gray-600 cursor-pointer flex items-center gap-3">
                                                        

                                                        <div class="max-w-full text-wrap ">
                                                            <div class="px-2 py-2   text-wrap">
                                                                




                                                                <span class="text-sm text-gray-600 dark:text-neutral-400">
                                                                    <strong class="bg-gntf_green-500 text-white px-2 py-1 rounded-lg">{{ $result->name }}</strong>
                                                                    <hr class="mb-1">
                                                                    <span class="">
                                                                        Events: <span class="font-bold">{{ $result->events->count() ? $result->events->count() : 0}}</span> 
                                                                    </span>
                                                                    <hr class="mt-1">
                                                                    
                                                                    <span class="text-gray-500">
                                                                        {{ \Carbon\Carbon::parse($result->start_date)->format('M d, Y') }} 
                                                                        @if(!empty($result->end_date))
                                                                        to {{ \Carbon\Carbon::parse($result->end_date)->format('M d, Y') }}
                                                                        @endif
                                                                    </span>
                                                                    
                                                                    <hr>
                                                                    <span class="text-gray-500">
                                                                        Finance: <span class="text-gntf_green-500">{{ $result->finance }}</span> 
                                                                    </span>
                                                                    <hr>
                                                                    <span class="text-gray-500">
                                                                        Director: <span class="text-gntf_green-500">{{ $result->director }}</span> 
                                                                    </span>
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
                                                                Tournament not found
                                                            </h3>
                                                            <p class="text-sm text-gray-700 dark:text-neutral-400">

                                                                Search for tournament name
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
    <!-- ./ Tournament modal-->

    <!-- Tournament Event modal-->
    @teleport('body')
        <div x-show="showModalEvent" x-trap="showModalEvent" class="relative z-10 " aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <!-- <div class="fixed inset-0 z-10 w-screen overflow-y-auto py-10"> -->
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto py-10">
                <div class="flex justify-center p-4 sm:p-0">
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div @click.outside="showModalEvent = false" class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="w-full px-1 pt-1" x-data="{
                                searchPosts(event) {
                                    document.getElementById('searchInput').focus();
                                    event.preventDefault();
                                }
                            }">
                                <form action="" autocomplete="off">
                                    <input
                                    autocomplete="off"
                                    wire:model.live.throttle.500ms="tournament_event_search" type="text" id="searchInput"
                                    name="searchInput"
                                    class="block w-full flex-1 py-2 px-3 mt-2 outline-none border-none rounded-md bg-slate-100"
                                    placeholder="Search for tournament event name ..." @keydown.slash.window="searchPosts" />
                                </form>
                                <div class="mt-2 w-full overflow-hidden rounded-md bg-white">

                                    
                                        @if(!empty($event_results) && count($event_results) > 0)
                                            <div class=" py-2 px-3 border-b border-slate-200 text-sm font-medium text-slate-500">

                                                All Tournament Events <strong>(Click to select a tournament event)</strong>

                                            </div>

                                            @foreach ($event_results as $result)
                                                <div class="cursor-pointer py-2 px-3 hover:bg-slate-100 bg-white border border-gray-200 shadow-sm rounded-xl mb-1"
                                                wire:click="search_tournament_event('{{  $result->id }}')"
                                                @click="showModalEvent = false"
                                                >
                                                    <p class="text-sm font-medium text-gray-600 cursor-pointer flex items-center gap-3">
                                                        

                                                        <div class="max-w-full text-wrap ">
                                                            <div class="px-2 py-2   text-wrap">
                                                                




                                                                <span class="text-sm text-gray-600 dark:text-neutral-400">
                                                                    <strong class="font-bold bg-gntf_green-500 text-white   px-2 py-1 rounded-lg">{{ $result->name }}</strong>
                                                                    <hr class="mb-1">
                                                                    <span class="">
                                                                        Tournament: <span class="font-bold text-gntf_green-500   px-2 py-1 rounded-lg">{{ $result->tournament->name ? $result->tournament->name : ''}}</span> 
                                                                    </span>
                                                                    <hr class="mt-1">
                                                                    
                                                                   

                                                                    @if(!empty($result->categories) && count($result->categories) > 0)
                                                                        <hr class="mb-1">
                                                                        <span class="">
                                                                            <span class="">Categories ({{ $result->categories->count() }}): </span> 
                                                                        </span>
                                                                        <hr class="mt-1">

                                                                        @foreach ($result->categories as $category)
                                                                            <span class="">
                                                                                <span class="font-bold text-gray-500   px-2 py-1 rounded-lg">{{ $category->name }}</span> 
                                                                            </span> 
                                                                            @if(!empty($category->options) && count($category->options) > 0)
                                                                                <!-- Options -->
 
                                                                                <div class=" px-2 py-1 flex items-center gap-x-2">
                                                                                    @foreach ($category->options as $option)
                                                                                        <div class="text-sm text-gray-500">
                                                                                            {{ $option->name }}
                                                                                        </div>

                                                                                    @endforeach
                                                                                </div>  
                                                                            
                                                                                
                                                                                <hr class="mt-1">
                                                                            @endif
                                                                            

                                                                        @endforeach

                                                                    @else 
                                                                        <span class="">
                                                                            <span class="font-bold text-gray-500   px-2 py-1 rounded-lg">No Categories created</span> 
                                                                        </span>
                                                                        <hr class="mt-1">
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
                                                                Tournament Event not found
                                                            </h3>
                                                            <p class="text-sm text-gray-700 dark:text-neutral-400">

                                                                Search for tournament event name
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
    <!-- ./ Tournament Event modal-->


    <!-- Tournament Event Categories modal-->
    @teleport('body')
        <div x-show="showModalEventCategories" x-trap="showModalEventCategories" class="relative z-10 " aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <!-- <div class="fixed inset-0 z-10 w-screen overflow-y-auto py-10"> -->
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto py-10">
                <div class="flex justify-center p-4 sm:p-0">
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div @click.outside="showModalEventCategories = false" class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="w-full px-1 pt-1" x-data="{
                                searchPosts(event) {
                                    document.getElementById('searchInput').focus();
                                    event.preventDefault();
                                }
                            }">
                                <form action="" autocomplete="off">
                                    <input
                                    autocomplete="off"
                                    wire:model.live.throttle.500ms="tournament_event_category_search" type="text" id="searchInput"
                                    name="searchInput"
                                    class="block w-full flex-1 py-2 px-3 mt-2 outline-none border-none rounded-md bg-slate-100"
                                    placeholder="Search for tournament event category name ..." @keydown.slash.window="searchPosts" />
                                </form>
                                <div class="mt-2 w-full overflow-hidden rounded-md bg-white">

                                    
                                        @if(!empty($event_category_results) && count($event_category_results) > 0)
                                            <div class=" py-2 px-3 border-b border-slate-200 text-sm font-medium text-slate-500">

                                                All Tournament Event categories <strong>(Click to select a tournament event category)</strong>

                                            </div>

                                            @foreach ($event_category_results as $result)
                                                <div class="cursor-pointer py-2 px-3 hover:bg-slate-100 bg-white border border-gray-200 shadow-sm rounded-xl mb-1"
                                                wire:click="search_tournament_event_category('{{  $result->id }}')"
                                                @click="showModalEventCategories = false"
                                                >
                                                    <p class="text-sm font-medium text-gray-600 cursor-pointer flex items-center gap-3">
                                                        

                                                        <div class="max-w-full text-wrap ">
                                                            <div class="px-2 py-2   text-wrap">
                                                                




                                                                <span class="text-sm text-gray-600 dark:text-neutral-400">
                                                                    <strong class="font-bold bg-gntf_green-500 text-white   px-2 py-1 rounded-lg">{{ $result->name }}</strong>
                                                                    <hr class="mb-1">
                                                                     

                                                                 
                                                                    {{-- <span class="">
                                                                        <span class="font-bold text-gray-500   px-2 py-1 rounded-lg">{{ $category->name }}</span> 
                                                                    </span>  --}}
                                                                    @if(!empty($result->options) && count($result->options) > 0)
                                                                        <!-- Options -->

                                                                        <div class=" px-2 py-1 flex items-center gap-x-2">
                                                                            @foreach ($result->options as $option)
                                                                                <div class="text-sm text-gray-500">
                                                                                    {{ $option->name }}
                                                                                </div>

                                                                            @endforeach
                                                                        </div>  
                                                                    
                                                                        
                                                                        <hr class="mt-1">
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
                                                                Tournament Event Category not found
                                                            </h3>
                                                            <p class="text-sm text-gray-700 dark:text-neutral-400">

                                                                Search for tournament event category name
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
    <!-- ./ Tournament Event Categories modal-->



    <!-- Tournament Event Category Options modal-->
    @teleport('body')
        <div x-show="showModalEventCategoryOptions" x-trap="showModalEventCategoryOptions" class="relative z-10 " aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <!-- <div class="fixed inset-0 z-10 w-screen overflow-y-auto py-10"> -->
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto py-10">
                <div class="flex justify-center p-4 sm:p-0">
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div @click.outside="showModalEventCategoryOptions = false" class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="w-full px-1 pt-1" x-data="{
                                searchPosts(event) {
                                    document.getElementById('searchInput').focus();
                                    event.preventDefault();
                                }
                            }">
                                <form action="" autocomplete="off">
                                    <input
                                    autocomplete="off"
                                    wire:model.live.throttle.500ms="tournament_event_category_option_search" type="text" id="searchInput"
                                    name="searchInput"
                                    class="block w-full flex-1 py-2 px-3 mt-2 outline-none border-none rounded-md bg-slate-100"
                                    placeholder="Search for tournament division name ..." @keydown.slash.window="searchPosts" />
                                </form>
                                <div class="mt-2 w-full overflow-hidden rounded-md bg-white">

                                    
                                        @if(!empty($event_category_option_results) && count($event_category_option_results) > 0)
                                            <div class=" py-2 px-3 border-b border-slate-200 text-sm font-medium text-slate-500">

                                                All Tournament divisions <strong>(Click to select a tournament division)</strong>

                                            </div>

                                            @foreach ($event_category_option_results as $result)
                                                <div class="cursor-pointer py-2 px-3 hover:bg-slate-100 bg-white border border-gray-200 shadow-sm rounded-xl mb-1"
                                                wire:click="search_tournament_event_category_option('{{  $result->id }}')"
                                                @click="showModalEventCategoryOptions = false"
                                                >
                                                    <p class="text-sm font-medium text-gray-600 cursor-pointer flex items-center gap-3">
                                                        

                                                        <div class="max-w-full text-wrap ">
                                                            <div class="px-2 py-2   text-wrap">
                                                                




                                                                <span class="text-sm text-gray-600 dark:text-neutral-400">
                                                                   
                                                                    <span class="bg-gntf_green-500 text-white px-2 py-1 rounded-lg mb-1">
                                                                        {{ $result->name }}
                                                                    </span>
                                                                    <hr class="mb-1">
                                                                    <strong>{{ $result->tournament_event_category->tournament_event->name }}</strong> 
                                                                    <hr class="mb-1">
                                                                    <strong>{{ $result->tournament_event_category->name }}</strong>
                                                                    



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
                                                                Tournament division not found
                                                            </h3>
                                                            <p class="text-sm text-gray-700 dark:text-neutral-400">

                                                                Search for tournament division name
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
    <!-- ./ Tournament Event Category Options modal-->


    <!-- Tournament Event Category Options modal-->
    @teleport('body')
        <div x-show="showModalUsers" x-trap="showModalUsers" class="relative z-10 " aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <!-- <div class="fixed inset-0 z-10 w-screen overflow-y-auto py-10"> -->
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto py-10">
                <div class="flex justify-center p-4 sm:p-0">
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div @click.outside="showModalUsers = false" class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
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

                                    
                                        @if(!empty($players_users) && count($players_users) > 0)
                                            <div class=" py-2 px-3 border-b border-slate-200 text-sm font-medium text-slate-500">

                                                All Players <strong>(Click to select a player)</strong>

                                            </div>

                                            @foreach ($players_users as $result)
                                                <div class="cursor-pointer py-2 px-3 hover:bg-slate-100 bg-white border border-gray-200 shadow-sm rounded-xl mb-1"
                                                wire:click="search_user('{{  $result->id }}')"
                                                @click="showModalUsers = false"
                                                >
                                                    <p class="text-sm font-medium text-gray-600 cursor-pointer flex items-center gap-3">
                                                        

                                                        <div class="max-w-full text-wrap ">
                                                            <div class="px-2 py-2   text-wrap">
                                                                




                                                                <span class="text-sm text-gray-600 dark:text-neutral-400">
                                                                   
                                                                    <span class="bg-gntf_green-500 text-white px-2 py-1 rounded-lg mb-1">
                                                                        {{ $result->name }}
                                                                    </span>
                                                                    <hr class="mb-1">
                                                                    <strong>{{ $result->phone_number }}</strong> 
                                                                    <hr class="mb-1">
                                                                    <strong>{{ $result->email }}</strong>
                                                                    

                                                                    

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
                                                                Player not found
                                                            </h3>
                                                            <p class="text-sm text-gray-700 dark:text-neutral-400">

                                                                Search for player name
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
    <!-- ./ Tournament Event Category Options modal-->

</div>
<!-- End Table Section -->



