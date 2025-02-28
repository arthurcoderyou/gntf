<!-- Card Section -->
<div class="max-w-[85rem] px-4 py-6 sm:px-6 lg:px-8  mx-auto">

     

    {{-- <div wire:loading class="loading-overlay"> --}}
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
                        Edit tournament
                    </h2>
                </div>
                <!-- End Col -->
 
                <!-- Grid -->
                <div class="grid grid-cols-12 gap-x-2  ">

                    

                    <div class="space-y-2 col-span-12  sm:col-span-8 ">
                        <label for="name" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                            Name
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
                            Current Event?
                        </label> 
                        <select 
                        wire:model.live="status"
                        id="status" name="status"
                        class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            <option selected="">Select status</option>
                            <option value="active">Yes</option>
                            <option value="inactive">No</option> 
                        </select>


                        @error('status')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror


                    </div>

                    <div class="space-y-2 col-span-12 sm:col-span-4"> 
                        <label for="name" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                            Date Range
                        </label>
                        <input type="text" wire:model.live='daterange' id="daterange" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" readonly
                        placeholder="MM DD, YYYY to MM DD, YYYY"
                        >
                        @error('start_date')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>

                            @php 
                                $conflictingTournaments = \App\Models\Tournament::where(function ($query) use ($start_date, $end_date) {
                                    $query->whereBetween('start_date', [$start_date, $end_date])
                                        ->orWhereBetween('end_date', [$start_date, $end_date])
                                        ->orWhere(function ($query) use ($start_date, $end_date) {
                                            $query->where('start_date', '<=', $start_date)
                                                    ->where('end_date', '>=', $end_date);
                                        });
                                })->get();
                            @endphp 

                            <p class="text-sm text-red-600 mt-2">Conflicting Tournaments: </p>     
                            @foreach ( $conflictingTournaments as  $conflictingTournament)
                                <p class="text-sm   mt-2">
                                    {{ $conflictingTournament->name }}
                                    <span class="block text-sm text-gray-500 dark:text-neutral-500">
                                        {{ \Carbon\Carbon::parse($conflictingTournament->start_date)->format('M d, Y') }}  

                                        @if(!empty($conflictingTournament->end_date))
                                            to {{ \Carbon\Carbon::parse($conflictingTournament->end_date)->format('M d, Y') }}
                                        @endif 
                                    </span> 
                                </p>
                                    
                            @endforeach


                        @enderror 
                    </div>


                    <div class="space-y-2 col-span-12 sm:col-span-4">
                        <label for="director" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                            Director
                        </label>

                        <input
                        autofocus  
                        wire:model="director"
                        id="director" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="">

                        @error('director')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror


                    </div>
 
                    <div class="space-y-2 col-span-12 sm:col-span-4">
                        <label for="finance" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                            Finance
                        </label>

                        <input
                        autofocus  
                        wire:model="finance"
                        id="finance" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="">

                        @error('finance')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror


                    </div>

 

                    <div class="space-y-2 col-span-12     ">
                        

                        @php
                            function isImageMime($filename) {
                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                return in_array($extension, $imageExtensions);
                            }
                        @endphp

                        @if(!empty($tournament_logo))
                        
                            <label for="description" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                                Current Logo
                            </label>
                            <a class="dz-flex dz-flex-wrap dz-gap-x-10 dz-gap-y-2 dz-justify-start dz-w-full  " 
                            href="{{ asset('storage/uploads/tournament/'.$tournament_logo)  }}" target="_blank"
                            > 
                                <div class="dz-flex dz-items-center dz-justify-between dz-gap-2 dz-border dz-rounded dz-border-gray-200 dz-w-full dz-h-auto dz-overflow-hidden dark:dz-border-gray-700">
                                    <div class="dz-flex dz-items-center dz-gap-3">
                                        @if(isImageMime($tournament_logo))
                                            <div class="dz-flex-none dz-w-14 dz-h-14">
                                                <img src="{{ asset('storage/uploads/tournament/'.$tournament_logo)  }}" class="dz-object-fill dz-w-full dz-h-full" alt="{{ $tournament_logo }}">
                                            </div>
                                        
                                        @endif
                                        <div class="dz-flex dz-flex-col dz-items-start dz-gap-1">
                                            <div class="dz-text-center dz-text-slate-900 dz-text-sm dz-font-medium dark:dz-text-slate-100">{{ $tournament_logo }}</div>
                                            </div>
                                    </div>


                                </div> 
                            </a>



                        @endif
                        <label for="description" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                            Upload new logo
                        </label>

                        <livewire:dropzone
                            wire:model="logo"
                            :rules="['file', 'mimes:png,jpeg,jpg', 'max:20480']"
                            />

                            



                        @error('logo')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror


                    </div>

                    <!-- Tournament Fees -->
                    <div class="space-y-2 col-span-12   ">

                        <label for="status" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                            Tournament Fees
                        </label> 

                        @foreach ($fees  as $index => $fee)
                            {{-- <input
                                wire:model.live="fee_descriptions.{{ $index }}"
                                id="category_option_{{ $index }}"
                                type="text"
                                class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                placeholder="Enter tournament fee description"> --}}
                            <div class="grid grid-cols-3">
                                <input type="text" wire:model="fees.{{ $index }}.fee_name" placeholder="Fee Name" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                <input type="number" wire:model="fees.{{ $index }}.fee_first_event_payment" placeholder="First Event Payment" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                <input type="number" wire:model="fees.{{ $index }}.fee_additional_event_payment" placeholder="Additional Event Payment" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            </div>
                            
                            

                            @if($index === count($fees) - 1) <!-- Only show "Add phone" on the last input -->
                                <p class="mt-3">
                                    <a wire:click.prevent="addFee" class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500" href="#">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
                                        Add fee description option
                                    </a>
                                </p>
                            @endif
                        @endforeach

                    </div>
                    <!-- End Tournament Fees -->
                    


                    <!-- Fee Descriptions -->
                    <div class="space-y-2 col-span-12   ">

                        <label for="status" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                            Fee Descriptions
                        </label> 

                        @foreach ($fee_descriptions as $index => $fee_description)
                            <input
                                wire:model.live="fee_descriptions.{{ $index }}"
                                id="category_option_{{ $index }}"
                                type="text"
                                class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                placeholder="Enter tournament fee description">

                            @if($index === count($fee_descriptions) - 1) <!-- Only show "Add phone" on the last input -->
                                <p class="mt-3">
                                    <a wire:click.prevent="addFeeDescription" class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500" href="#">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
                                        Add fee description option
                                    </a>
                                </p>
                            @endif
                        @endforeach

                    </div>
                    <!-- End Fee Descriptions -->
     
                    <!-- Fee notes -->
                    <div class="space-y-2 col-span-12   ">

                        <label for="status" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                            Fee notes
                        </label> 

                        @foreach ($fee_notes as $index => $fee_note)
                            <input
                                wire:model.live="fee_notes.{{ $index }}"
                                id="category_option_{{ $index }}"
                                type="text"
                                class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                placeholder="Enter tournament fee notes">

                            @if($index === count($fee_notes) - 1) <!-- Only show "Add phone" on the last input -->
                                <p class="mt-3">
                                    <a wire:click.prevent="addFeeNote" class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500" href="#">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
                                        Add fee note option
                                    </a>
                                </p>
                            @endif
                        @endforeach

                    </div>
                    <!-- End Fee Descriptions -->
     

                    <!-- Fee sub notes -->
                    <div class="space-y-2 col-span-12   ">

                        <label for="status" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                            Fee sub notes
                        </label> 

                        @foreach ($fee_sub_notes as $index => $fee_sub_note)
                            <input
                                wire:model.live="fee_sub_notes.{{ $index }}"
                                id="category_option_{{ $index }}"
                                type="text"
                                class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                placeholder="Enter tournament fee sub notes">

                            @if($index === count($fee_sub_notes) - 1) <!-- Only show "Add phone" on the last input -->
                                <p class="mt-3">
                                    <a wire:click.prevent="addFeeSubNote" class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500" href="#">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
                                        Add fee sub note option
                                    </a>
                                </p>
                            @endif
                        @endforeach

                    </div>
                    <!-- End Fee sub notes -->

                    <!-- Format Description -->
                    <div class="space-y-2 col-span-12   ">

                        <label for="status" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                            Format Description
                        </label> 

                        @foreach ($format_descriptions as $index => $format_description)
                            <input
                                wire:model.live="format_descriptions.{{ $index }}"
                                id="format_descriptions_{{ $index }}"
                                type="text"
                                class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                placeholder="Enter format description">

                            @if($index === count($format_descriptions) - 1) <!-- Only show "Add phone" on the last input -->
                                <p class="mt-3">
                                    <a wire:click.prevent="addFormat" class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500" href="#">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
                                        Add format description
                                    </a>
                                </p>
                            @endif
                        @endforeach

                    </div>
                    <!-- End Format Description -->

                    <!-- Rule Description -->
                    <div class="space-y-2 col-span-12   ">

                        <label for="status" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                            Rule Description
                        </label> 

                        @foreach ($rule_descriptions as $index => $fule_description)
                            <input
                                wire:model.live="rule_descriptions.{{ $index }}"
                                id="rule_descriptions_{{ $index }}"
                                type="text"
                                class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                placeholder="Enter format description">

                            @if($index === count($rule_descriptions) - 1) <!-- Only show "Add phone" on the last input -->
                                <p class="mt-3">
                                    <a wire:click.prevent="addRule" class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500" href="#">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
                                        Add rule description
                                    </a>
                                </p>
                            @endif
                        @endforeach

                    </div>
                    <!-- End Rule Description -->

                    <!-- Waiver Description -->
                    <div class="space-y-2 col-span-12   ">

                        <label for="status" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                            Waiver Description
                        </label> 

                        @foreach ($waiver_descriptions as $index => $waiver_description)
                            <input
                                wire:model.live="waiver_descriptions.{{ $index }}"
                                id="waiver_descriptions_{{ $index }}"
                                type="text"
                                class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                placeholder="Enter format description">

                            @if($index === count($waiver_descriptions) - 1) <!-- Only show "Add phone" on the last input -->
                                <p class="mt-3">
                                    <a wire:click.prevent="addWaiver" class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500" href="#">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
                                        Add waiver description
                                    </a>
                                </p>
                            @endif
                        @endforeach

                    </div>
                    <!-- End Waiver Description -->

                    


                </div> 


              


                
                <div class="mt-5 flex justify-center gap-x-2">
                    <a href="{{ route('tournament.index') }}" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">
                        Cancel
                    </a>
                    {{-- <button type="submit" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                    Save
                    </button> --}}

                    @if($status == "inactive")
                        <button type="submit" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        Save
                        </button>

                    @else 
                        <button
                         onclick="confirm('Are you sure, you want to save this record? You had set the tournament has active and it will be considered and as the active tournament ') || event.stopImmediatePropagation()"
                        wire:click.prevent="save"
                        type="submit" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        Save
                        </button>
                    @endif



                </div>
            </div>
        </div>
        <!-- End Card -->
    </form>
 


</div>
<!-- End Card Section -->


@push('scripts')

    <script>
        $(document).ready(function() {
            // Initialize Flatpickr as a date range picker
            flatpickr("#daterange", {
                mode: "range",
                dateFormat: "'M d, Y", // Format as `yyyy-mm-dd`
                onChange: function(selectedDates, dateStr) {
                    if (selectedDates.length === 2) {
                        const [startDate, endDate] = selectedDates.map(date => flatpickr.formatDate(date, "Y-m-d"));
                        // Send the selected range to Livewire
                        @this.set('start_date', startDate);
                        @this.set('end_date', endDate);
                    }
                }
            });
        });
    </script>






  @endpush