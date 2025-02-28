<!-- Card Section -->
<div class="max-w-[85rem] px-4 py-6 sm:px-6 lg:px-8  mx-auto"

    x-data="{
        showModal: false,  
        showModalEvent: false,
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
    

    <form wire:submit="save">
        <!-- Card -->
        <div class="bg-white rounded-xl shadow dark:bg-neutral-900">


            <div class="  p-4">

                <div class="sm:col-span-12">
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

                    
                </div>
                <!-- End Col -->
 
                <!-- Grid -->
                <div class="grid grid-cols-12 gap-x-2  ">

                    

                    <div class="space-y-2 col-span-12  sm:col-span-4 ">
                        <label for="name" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                            Category Name
                        </label>

                        <input
                        autofocus autocomplete="name"
                        wire:model="name"
                        id="name" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="">

                        @error('name')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror


                    </div>

                    <div class="space-y-2 col-span-12  sm:col-span-4 ">
                        <label for="status" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                            Tournament
                        </label> 
                        
 
                        <button 
                            @click="showModal = true" type="button"
                            @keydown.window="handleKeydown" 
                            class="py-2 px-3 pe-11 block w-full  border-2 border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            {{-- href="{{ route('schedule.index') }}"> --}}
                            >
                            <div class="flex items-center  justify-between">

                                @if(!empty($selected_tournament))
                                    <span class="text-gntf_green-500">{{ $selected_tournament->name }}</span> 
                                @else  
                                    Search Tournament

                                @endif
                                
                                <svg class="shrink-0 size-[.8em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                            </div>
                            
                        </button> 



                        @error('tournament_id')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror


                    </div>


                    <div class="space-y-2 col-span-12  sm:col-span-4 ">
                        <label for="status" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                            Tournament Event
                        </label> 
                        
 
                        <button 
                            @click="showModalEvent = true" type="button"
                            @keydown.window="handleKeydown" 
                            class="py-2 px-3 pe-11 block w-full  border-2 border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            {{-- href="{{ route('schedule.index') }}"> --}}
                            >
                            <div class="flex items-center  justify-between">

                                @if(!empty($selected_tournament_event))
                                    <span class="text-gntf_green-500">{{ $selected_tournament_event->name }}</span> 
                                @else  
                                    Search Event

                                @endif
                                
                                <svg class="shrink-0 size-[.8em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                            </div>
                            
                        </button> 



                        @error('tournament_id')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror


                    </div>
                    

                    <div class="space-y-2 col-span-12  sm:col-span-4 ">
                        <label for="allowed_gender" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                            Allowed Gender
                        </label> 
                        <select 
                        wire:model.live="allowed_gender"
                        id="allowed_gender" name="allowed_gender"
                        class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            <option selected="">Select allowed gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option> 
                            <option value="both">Both</option> 
                            <option value="mixed">Mixed</option> 
                        </select>


                        @error('allowed_gender')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror


                    </div>

                    <div class="space-y-2 col-span-12  sm:col-span-4 ">
                        <label for="type" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                            Type
                        </label> 
                        <select 
                        wire:model.live="type"
                        id="type" name="type"
                        class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            <option selected="">Select type</option>
                            <option value="singles">Singles</option>
                            <option value="doubles">Doubles</option> 
                            {{-- <option value="mixed">Mixed</option>  --}}
                        </select>


                        @error('type')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror


                    </div>

                    <div class="space-y-2 col-span-12  sm:col-span-4 ">
                        <label for="status" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                            Status
                        </label> 
                        <select 
                        wire:model.live="status"
                        id="status" name="status"
                        class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            <option selected="">Select status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option> 
                        </select>


                        @error('status')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror


                    </div>

 

                </div> 

                @if( Auth::user()->can('division edit') ||  Auth::user()->hasRole('DSI God Admin'))
                <div class="grid grid-cols-12 gap-x-2  ">
                    <!-- Phone -->
                    <div class="space-y-2 col-span-12   ">

                        <label for="status" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                            Category Options
                        </label> 

                        @foreach ($category_options as $index => $category_option)
                            <input
                                wire:model.live="category_options.{{ $index }}"
                                id="category_option_{{ $index }}"
                                type="text"
                                class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                placeholder="Enter category option label">

                            @if($index === count($category_options) - 1) <!-- Only show "Add phone" on the last input -->
                                <p class="mt-3">
                                    <a wire:click.prevent="addCategoryOption" class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500" href="#">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
                                        Add category option
                                    </a>
                                </p>
                            @endif
                        @endforeach

                    </div>
                    <!-- End Col -->

                     
                <!-- ./Phone -->

                </div>
                @endif


                
                <div class="mt-5 flex justify-center gap-x-2">

                    

                    <a href="{{ !empty($cancel_route) ? $cancel_route : route('tournament_event.index') }}" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">
                        Cancel
                    </a>

                    {{-- @if($status == "inactive") --}}
                        <button type="submit" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        Save
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
                                                                    <strong>{{ $result->name }}</strong>
                                                                    <hr class="mb-1">
                                                                    <span class="bg-gntf_green-500 text-white px-2 py-1 rounded-lg">
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
                                                                    <strong>{{ $result->name }}</strong>
                                                                    <hr class="mb-1">
                                                                    <span class="">
                                                                        Tournament: <span class="font-bold text-gntf_green-500   px-2 py-1 rounded-lg">{{ $result->tournament->name ? $result->tournament->name : ''}}</span> 
                                                                    </span>
                                                                    <hr class="mt-1">


                                                                    @if(!empty($result->categories) && count($result->categories) > 0)
                                                                        <hr class="mb-1">
                                                                        <span class="">
                                                                            <span class="font-bold bg-gntf_green-500 text-white   px-2 py-1 rounded-lg">Categories ({{ $result->categories->count() }}): </span> 
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
    <!-- ./ Tournament Event modal-->




</div>
<!-- End Card Section -->
 