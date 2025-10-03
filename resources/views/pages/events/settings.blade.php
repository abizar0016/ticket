<div class="min-h-screen bg-gray-50 p-3 sm:p-4 md:p-6">
    {{-- Dynamic Grid Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- Animated Header --}}
        <div
            class="lg:col-span-12 relative overflow-hidden rounded-xl sm:rounded-2xl bg-gradient-to-r from-indigo-50 to-indigo-100 p-6 sm:p-8 mb-6 shadow-lg sm:shadow-2xl transition-all duration-500 hover:shadow-xl sm:hover:shadow-3xl group">
            <div class="relative z-10 flex items-center gap-4 sm:gap-6">
                <div
                    class="p-3 sm:p-4 rounded-lg sm:rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 text-white shadow-md sm:shadow-lg">
                    <i class="ri-calendar-event-line text-2xl sm:text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-3xl font-bold text-gray-800 tracking-tight">Event Settings</h1>
                    <p class="text-indigo-600/80 text-sm sm:text-lg mt-1 sm:mt-2">Customize your event experience</p>
                </div>
            </div>
            <div class="absolute right-4 sm:right-10 top-0 text-black/10 text-6xl sm:text-9xl z-0">
                <i class="ri-settings-5-line"></i>
            </div>
        </div>

        {{-- Left Side - Form (8/12 width) --}}
        <div class="lg:col-span-8">
            <form action="{{ route('events.update', $events->id) }}"
                method="POST"
                class="ajax-form"
                data-success="Event updated successfully."
                enctype="multipart/form-data" class="space-y-6 sm:space-y-8">
                @csrf
                @method('PUT')

                {{-- Event Details Card --}}
                <div class="bg-white shadow-lg sm:shadow-2xl rounded-xl sm:rounded-2xl p-4 sm:p-6">
                    <h3
                        class="text-base sm:text-lg font-semibold text-indigo-600 mb-4 sm:mb-6 flex items-center gap-2 pb-2 sm:pb-3 border-b border-gray-100">
                        <i class="ri-file-list-3-line"></i>
                        Event Details
                    </h3>

                    {{-- Organization (Readonly) --}}
                    <div class="relative group mb-4 sm:mb-6">
                        <div
                            class="absolute inset-y-0 left-0 pl-4 sm:pl-5 flex items-center pointer-events-none text-indigo-600">
                            <i class="ri-community-line text-xl sm:text-2xl"></i>
                        </div>
                        <input type="text" id="organization_name_display"
                            value="{{ $events->organization->name ?? '' }}" readonly
                            class="w-full px-4 sm:px-5 py-3 sm:py-4 pl-12 sm:pl-14 pr-4 text-base sm:text-lg rounded-lg sm:rounded-xl border-2 border-gray-200 bg-gray-100 text-gray-800 focus:border-indigo-500 focus:ring-0 transition-all duration-300 shadow-sm peer cursor-not-allowed"
                            placeholder=" ">
                        <label for="organization_name_display"
                            class="absolute left-12 sm:left-14 top-3 sm:top-4 px-2 text-gray-500 text-sm sm:text-base transition-all duration-300 transform -translate-y-7 sm:-translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-7 sm:peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600">
                            Event Organization
                        </label>
                    </div>

                    {{-- Event Title --}}
                    <div class="relative group mb-4 sm:mb-6">
                        <input type="text" id="title" name="title" value="{{ old('title', $events->title) }}"
                            class="w-full px-4 sm:px-5 py-3 sm:py-4 pl-12 sm:pl-14 text-base sm:text-lg rounded-lg sm:rounded-xl border-2 border-gray-200 focus:border-indigo-500 outline-none focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                            placeholder=" ">
                        <label for="title"
                            class="absolute left-12 sm:left-14 top-3 sm:top-4 px-2 text-gray-500 text-sm sm:text-base transition-all duration-300 transform -translate-y-7 sm:-translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-7 sm:peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600">
                            Event Title
                        </label>
                        <div
                            class="absolute inset-y-0 left-0 pl-4 sm:pl-5 flex items-center pointer-events-none text-indigo-600">
                            <i class="ri-edit-box-line text-xl sm:text-2xl"></i>
                        </div>
                    </div>

                    {{-- Event Image Upload --}}
                    <div id="upload-container"
                        class="relative group border-2 border-dashed border-gray-300 rounded-lg sm:rounded-xl p-4 sm:p-6 transition-all duration-300 hover:border-indigo-400 bg-white cursor-pointer mb-4 sm:mb-6">
                        {{-- Hidden File Input --}}
                        <input type="file" id="file-upload" name="event_image" accept="image/*"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />

                        {{-- Default State --}}
                        <div id="default-state" class="flex items-center gap-3 sm:gap-4">
                            <div class="flex items-center gap-2 text-gray-500">
                                <i class="ri-upload-cloud-2-line text-2xl sm:text-3xl text-indigo-600"></i>
                                <div>
                                    <p class="text-sm sm:text-base font-medium">Upload Event Image</p>
                                    <p class="text-xs sm:text-sm text-gray-400">Recommended size: 1200x630px</p>
                                </div>
                            </div>

                            @if ($events->event_image)
                                <div
                                    class="w-16 h-16 sm:w-20 sm:h-20 rounded-lg overflow-hidden border border-gray-200 ml-auto">
                                    <img src="{{ asset($events->event_image) }}" alt="Current Event Image"
                                        class="w-full h-full object-cover" />
                                </div>
                            @endif
                        </div>

                        {{-- Preview State --}}
                        <div id="preview-state" class="hidden flex items-center justify-between gap-3 sm:gap-4">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <div
                                    class="w-16 h-16 sm:w-20 sm:h-20 rounded-lg overflow-hidden border border-gray-200">
                                    <img id="preview-image" src="" alt="Preview Image"
                                        class="w-full h-full object-cover" />
                                </div>
                                <div>
                                    <p class="text-xs sm:text-sm font-medium text-gray-800">Image selected</p>
                                    <p class="text-xs text-gray-500">Click to change</p>
                                </div>
                            </div>
                            <button type="button" id="change-image"
                                class="text-xs sm:text-sm text-red-600 hover:underline hover:text-red-800 transition-all duration-200">
                                Remove
                            </button>
                        </div>
                    </div>

                    {{-- Date Range --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-4 sm:mb-6">
                        <div class="relative group">
                            <input type="datetime-local" id="start_date" name="start_date"
                                value="{{ old('start_date', \Carbon\Carbon::parse($events->start_date)->format('Y-m-d H:i')) }}"
                                class="w-full px-4 sm:px-5 py-3 sm:py-4 pl-12 sm:pl-14 text-base sm:text-lg rounded-lg sm:rounded-xl border-2 border-gray-200 focus:border-indigo-500 outline-none focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                placeholder=" ">
                            <label for="start_date"
                                class="absolute left-12 sm:left-14 top-3 sm:top-4 px-2 text-gray-500 text-sm sm:text-base transition-all duration-300 transform -translate-y-7 sm:-translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-7 sm:peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600">
                                Start Date
                            </label>
                            <div
                                class="absolute inset-y-0 left-0 pl-4 sm:pl-5 flex items-center pointer-events-none text-indigo-600">
                                <i class="ri-calendar-2-line text-xl sm:text-2xl"></i>
                            </div>
                        </div>
                        <div class="relative group">
                            <input type="datetime-local" id="end_date" name="end_date"
                                value="{{ old('end_date', $events->end_date ? \Carbon\Carbon::parse($events->end_date)->format('Y-m-d\TH:i') : '') }}"
                                class="w-full px-4 sm:px-5 py-3 sm:py-4 pl-12 sm:pl-14 text-base sm:text-lg rounded-lg sm:rounded-xl border-2 border-gray-200 focus:border-indigo-500 outline-none focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                placeholder=" ">
                            <label for="end_date"
                                class="absolute left-12 sm:left-14 top-3 sm:top-4 px-2 text-gray-500 text-sm sm:text-base transition-all duration-300 transform -translate-y-7 sm:-translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-7 sm:peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600">
                                End Date
                            </label>
                            <div
                                class="absolute inset-y-0 left-0 pl-4 sm:pl-5 flex items-center pointer-events-none text-indigo-600">
                                <i class="ri-calendar-check-line text-xl sm:text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Event Location Card --}}
                <div class="bg-white shadow-lg sm:shadow-2xl rounded-xl sm:rounded-2xl p-4 sm:p-6">
                    <h3
                        class="text-base sm:text-lg font-semibold text-indigo-600 mb-4 sm:mb-6 flex items-center gap-2 pb-2 sm:pb-3 border-b border-gray-100">
                        <i class="ri-map-pin-line"></i>
                        Event Location
                    </h3>

                    <div class="space-y-4 sm:space-y-6">
                        {{-- Venue Name --}}
                        <div class="relative group">
                            <input type="text" id="venue_name" name="venue_name"
                                value="{{ old('venue_name', $events->venue_name ?? '') }}"
                                class="w-full px-4 sm:px-5 py-3 sm:py-4 pl-12 sm:pl-14 text-base sm:text-lg rounded-lg sm:rounded-xl border-2 border-gray-200 focus:border-indigo-500 outline-none focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                placeholder=" ">
                            <label for="venue_name"
                                class="absolute left-12 sm:left-14 top-3 sm:top-4 px-2 text-gray-500 text-sm sm:text-base transition-all duration-300 transform -translate-y-7 sm:-translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-7 sm:peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600">
                                Venue Name
                            </label>
                            <div
                                class="absolute inset-y-0 left-0 pl-4 sm:pl-5 flex items-center pointer-events-none text-indigo-600">
                                <i class="ri-building-line text-xl sm:text-2xl"></i>
                            </div>
                        </div>

                        {{-- Address Line --}}
                        <div class="relative group">
                            <input type="text" id="address_line" name="address_line"
                                value="{{ old('address_line', $events->address_line ?? '') }}"
                                class="w-full px-4 sm:px-5 py-3 sm:py-4 pl-12 sm:pl-14 text-base sm:text-lg rounded-lg sm:rounded-xl border-2 border-gray-200 focus:border-indigo-500 outline-none focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                placeholder=" ">
                            <label for="address_line"
                                class="absolute left-12 sm:left-14 top-3 sm:top-4 px-2 text-gray-500 text-sm sm:text-base transition-all duration-300 transform -translate-y-7 sm:-translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-7 sm:peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600">
                                Street Address
                            </label>
                            <div
                                class="absolute inset-y-0 left-0 pl-4 sm:pl-5 flex items-center pointer-events-none text-indigo-600">
                                <i class="ri-road-map-line text-xl sm:text-2xl"></i>
                            </div>
                        </div>

                        {{-- City and State --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            {{-- City --}}
                            <div class="relative group">
                                <input type="text" id="city" name="city"
                                    value="{{ old('city', $events->city ?? '') }}"
                                    class="w-full px-4 sm:px-5 py-3 sm:py-4 pl-12 sm:pl-14 text-base sm:text-lg rounded-lg sm:rounded-xl border-2 border-gray-200 focus:border-indigo-500 outline-none focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                    placeholder=" ">
                                <label for="city"
                                    class="absolute left-12 sm:left-14 top-3 sm:top-4 px-2 text-gray-500 text-sm sm:text-base transition-all duration-300 transform -translate-y-7 sm:-translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-7 sm:peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600">
                                    City
                                </label>
                                <div
                                    class="absolute inset-y-0 left-0 pl-4 sm:pl-5 flex items-center pointer-events-none text-indigo-600">
                                    <i class="ri-community-line text-xl sm:text-2xl"></i>
                                </div>
                            </div>

                            {{-- State --}}
                            <div class="relative group">
                                <input type="text" id="state" name="state"
                                    value="{{ old('state', $events->state ?? '') }}"
                                    class="w-full px-4 sm:px-5 py-3 sm:py-4 pl-12 sm:pl-14 text-base sm:text-lg rounded-lg sm:rounded-xl border-2 border-gray-200 focus:border-indigo-500 outline-none focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                    placeholder=" ">
                                <label for="state"
                                    class="absolute left-12 sm:left-14 top-3 sm:top-4 px-2 text-gray-500 text-sm sm:text-base transition-all duration-300 transform -translate-y-7 sm:-translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-7 sm:peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600">
                                    State/Province
                                </label>
                                <div
                                    class="absolute inset-y-0 left-0 pl-4 sm:pl-5 flex items-center pointer-events-none text-indigo-600">
                                    <i class="ri-government-line text-xl sm:text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Custom Maps URL --}}
                        <div class="relative group">
                            <input type="url" id="custom_maps_url" name="custom_maps_url"
                                value="{{ old('custom_maps_url', $events->custom_maps_url ?? '') }}"
                                class="w-full px-4 sm:px-5 py-3 sm:py-4 pl-12 sm:pl-14 text-base sm:text-lg rounded-lg sm:rounded-xl border-2 border-gray-200 focus:border-indigo-500 outline-none focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                placeholder="Map Embed Link">
                            <label for="custom_maps_url"
                                class="absolute left-12 sm:left-14 top-3 sm:top-4 px-2 text-gray-500 text-sm sm:text-base transition-all duration-300 transform -translate-y-7 sm:-translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-7 sm:peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600">
                                Custom Maps URL
                            </label>
                            <div
                                class="absolute inset-y-0 left-0 pl-4 sm:pl-5 flex items-center pointer-events-none text-indigo-600">
                                <i class="ri-map-pin-line text-xl sm:text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bank Information Card --}}
                <div class="bg-white shadow-lg sm:shadow-2xl rounded-xl sm:rounded-2xl p-4 sm:p-6">
                    <h3
                        class="text-base sm:text-lg font-semibold text-indigo-600 mb-4 sm:mb-6 flex items-center gap-2 pb-2 sm:pb-3 border-b border-gray-100">
                        <i class="ri-bank-card-line"></i>
                        Bank Information
                    </h3>

                    <div class="space-y-4 sm:space-y-6">
                        {{-- Bank Name --}}
                        <div class="relative group">
                            <input type="text" id="bank_name" name="bank_name"
                                value="{{ old('bank_name', $events->bank_name) }}"
                                class="w-full px-4 sm:px-5 py-3 sm:py-4 pl-12 sm:pl-14 text-base sm:text-lg rounded-lg sm:rounded-xl border-2 border-gray-200 focus:border-indigo-500 outline-none focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                placeholder="BCA,BNI,BRI ">
                            <label for="bank_name"
                                class="absolute left-12 sm:left-14 top-3 sm:top-4 px-2 text-gray-500 text-sm sm:text-base transition-all duration-300 transform -translate-y-7 sm:-translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-7 sm:peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600">
                                Bank Name
                            </label>
                            <div
                                class="absolute inset-y-0 left-0 pl-4 sm:pl-5 flex items-center pointer-events-none text-indigo-600">
                                <i class="ri-bank-line text-xl sm:text-2xl"></i>
                            </div>
                        </div>

                        {{-- Bank Account Number --}}
                        <div class="relative group">
                            <input type="number" id="bank_account_number" name="bank_account_number"
                                value="{{ old('bank_account_number', $events->bank_account_number) }}"
                                class="w-full px-4 sm:px-5 py-3 sm:py-4 pl-12 sm:pl-14 text-base sm:text-lg rounded-lg sm:rounded-xl border-2 border-gray-200 focus:border-indigo-500 outline-none focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                placeholder="1234567890">
                            <label for="bank_account_number"
                                class="absolute left-12 sm:left-14 top-3 sm:top-4 px-2 text-gray-500 text-sm sm:text-base transition-all duration-300 transform -translate-y-7 sm:-translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-7 sm:peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600">
                                Account Number
                            </label>
                            <div
                                class="absolute inset-y-0 left-0 pl-4 sm:pl-5 flex items-center pointer-events-none text-indigo-600">
                                <i class="ri-bank-card-line text-xl sm:text-2xl"></i>
                            </div>
                        </div>

                        {{-- Bank Account Name --}}
                        <div class="relative group">
                            <input type="text" id="bank_account_name" name="bank_account_name"
                                value="{{ old('bank_account_name', $events->bank_account_name) }}"
                                class="w-full px-4 sm:px-5 py-3 sm:py-4 pl-12 sm:pl-14 text-base sm:text-lg rounded-lg sm:rounded-xl border-2 border-gray-200 focus:border-indigo-500 outline-none focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 peer"
                                placeholder="John Doe">
                            <label for="bank_account_name"
                                class="absolute left-12 sm:left-14 top-3 sm:top-4 px-2 text-gray-500 text-sm sm:text-base transition-all duration-300 transform -translate-y-7 sm:-translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-7 sm:peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600">
                                Account Name
                            </label>
                            <div
                                class="absolute inset-y-0 left-0 pl-4 sm:pl-5 flex items-center pointer-events-none text-indigo-600">
                                <i class="ri-user-line text-xl sm:text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description Card --}}
                <div class="bg-white shadow-lg sm:shadow-2xl rounded-xl sm:rounded-2xl p-4 sm:p-6">
                    <div class="relative group">
                        <textarea id="description" name="description" rows="4"
                            class="w-full px-4 sm:px-5 py-3 sm:py-4 pl-12 sm:pl-14 text-base sm:text-lg rounded-lg sm:rounded-xl border-2 border-gray-200 focus:border-indigo-500 outline-none focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-indigo-300 resize-y min-h-[100px] sm:min-h-[120px] hover:min-h-[120px] sm:hover:min-h-[140px] focus:min-h-[120px] sm:focus:min-h-[140px] peer"
                            placeholder="Description">{{ old('description', $events->description) }}</textarea>
                        <label for="description"
                            class="absolute left-12 sm:left-14 top-3 sm:top-4 px-2 text-gray-500 text-sm sm:text-base transition-all duration-300 transform -translate-y-7 sm:-translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-7 sm:peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-indigo-600">
                            Description
                        </label>
                        <div
                            class="absolute inset-y-0 left-0 pl-4 sm:pl-5 flex items-start pt-3 sm:pt-4 pointer-events-none text-indigo-600">
                            <i class="ri-align-left text-xl sm:text-2xl"></i>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="pt-3 sm:pt-4">
                    <button type="submit"
                        class="w-full py-3 sm:py-4 px-4 sm:px-6 text-base sm:text-lg font-semibold bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 rounded-lg sm:rounded-xl shadow-lg sm:shadow-2xl text-white transition-all duration-300 transform hover:-translate-y-0.5 sm:hover:-translate-y-1 hover:shadow-md sm:hover:shadow-xl active:scale-95 group">
                        <div class="flex items-center justify-center gap-2 sm:gap-3">
                            <i
                                class="ri-save-2-line text-xl sm:text-2xl transition-transform group-hover:scale-110 sm:group-hover:scale-125 group-hover:rotate-6 sm:group-hover:rotate-12"></i>
                            <p class="relative overflow-hidden h-6 sm:h-7">
                                <span
                                    class="block transition-transform duration-500 group-hover:-translate-y-[120%]">Save
                                    Changes</span>
                                <span
                                    class="left-0 top-full w-full text-center transition-transform duration-500 group-hover:-translate-y-full flex items-center justify-center gap-1 sm:gap-2">
                                    Update Now! <i
                                        class="ri-arrow-right-line animate-[slideRight_1s_ease-in-out_infinite]"></i>
                                </span>
                            </p>
                        </div>
                    </button>
                </div>
            </form>
        </div>

        {{-- Right Side - Preview Card (4/12 width) --}}
        <div class="lg:col-span-4">
            <div class="sticky top-4 sm:top-6 space-y-4 sm:space-y-6">
                {{-- Preview Card --}}
                <div
                    class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg sm:shadow-2xl transition-all duration-500 hover:shadow-md sm:hover:shadow-xl hover:-translate-y-0.5 sm:hover:-translate-y-1">
                    <div class="text-center mb-4 sm:mb-6">
                        <div
                            class="inline-flex p-2 sm:p-3 rounded-lg sm:rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-md sm:shadow-lg mb-3 sm:mb-4">
                            <i class="ri-eye-line text-xl sm:text-2xl"></i>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Live Preview</h3>
                        <p class="text-indigo-600/80 text-xs sm:text-sm">See how your event will appear</p>
                    </div>

                    <div
                        class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-5 shadow-inner border border-gray-200 mb-4 sm:mb-6">
                        @if ($events->event_image)
                            <img src="{{ asset($events->event_image) }}" alt="Event Image"
                                class="w-full h-40 sm:h-48 object-cover rounded-lg mb-3 sm:mb-4">
                        @else
                            <div
                                class="h-40 sm:h-48 bg-gradient-to-r from-indigo-100 to-indigo-100 rounded-lg mb-3 sm:mb-4 flex items-center justify-center">
                                <i class="ri-image-line text-3xl sm:text-4xl text-indigo-300"></i>
                            </div>
                        @endif
                        <h4 class="font-bold text-gray-800 text-base sm:text-lg mb-1 truncate">
                            {{ $events->title ?: 'Your Event Name' }}</h4>
                        <div class="flex items-center gap-1 sm:gap-2 text-indigo-600 mb-2 sm:mb-3">
                            <i class="ri-calendar-line text-sm sm:text-base"></i>
                            <span class="text-xs sm:text-sm">
                                {{ $events->start_date ? \Carbon\Carbon::parse($events->start_date)->format('M d, Y') : 'Start date' }}
                                @if ($events->end_date)
                                    - {{ \Carbon\Carbon::parse($events->end_date)->format('M d, Y') }}
                                @endif
                            </span>
                        </div>
                        <p class="text-gray-600 text-xs sm:text-sm line-clamp-2">
                            {{ $events->description ?: 'Event description will appear here...' }}
                        </p>
                    </div>
                </div>

                {{-- Tips Card --}}
                <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg sm:shadow-2xl">
                    <h4 class="font-bold text-gray-800 text-base sm:text-lg mb-2 sm:mb-3 flex items-center gap-2">
                        <i class="ri-lightbulb-flash-line text-indigo-500"></i>
                        Pro Tips
                    </h4>
                    <ul class="space-y-2 sm:space-y-3 text-gray-700 text-xs sm:text-sm">
                        <li class="flex items-start gap-2">
                            <i class="ri-checkbox-circle-fill text-indigo-400 mt-0.5 sm:mt-1"></i>
                            <span>Use clear, descriptive event names</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="ri-checkbox-circle-fill text-indigo-400 mt-0.5 sm:mt-1"></i>
                            <span>Add high-quality images for better engagement</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="ri-checkbox-circle-fill text-indigo-400 mt-0.5 sm:mt-1"></i>
                            <span>Set reminders for important deadlines</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>