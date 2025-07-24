<div class="min-h-screen bg-white p-6">
    {{-- Animated Header --}}
    <div
        class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-50 to-purple-50 p-8 mb-8 shadow-lg transition-all duration-500 hover:shadow-xl">
        <div class="flex items-center gap-6 z-10 relative">
            <div
                class="p-4 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 text-white shadow-lg animate-[pulse_3s_ease-in-out_infinite]">
                <i class="ri-calendar-event-line text-3xl"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Event Settings</h1>
                <p class="text-indigo-600/80 text-lg mt-2">Customize your event experience</p>
            </div>
        </div>
        <div class="absolute -right-10 -top-10 text-purple-100/40 text-9xl z-0">
            <i class="ri-settings-5-fill"></i>
        </div>
    </div>

    {{-- Dynamic Grid Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Side - Form --}}
        <div class="lg:col-span-2">
            <form id="update-event-form" action="{{ route('event.update', $event->id) }}" method="POST"
                enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Organization Select --}}
                <div class="relative group">
                    <select name="organizer_id" id="organizer_id"
                        class="appearance-none w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer">
                        <option value="">Select Organizer</option>
                        @foreach ($organizers as $organizer)
                            <option value="{{ $organizer->id }}"
                                {{ old('organizer_id', $event->organizer_id) == $organizer->id ? 'selected' : '' }}>
                                {{ $organizer->name }}
                            </option>
                        @endforeach
                    </select>
                    <div
                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 group-focus-within:text-primary-500 transition-colors duration-300">
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <label for="organizer_id"
                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                        Event Organization
                    </label>
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                        <i class="ri-community-line text-2xl animate-[bounce_4s_ease-in-out_infinite]"></i>
                    </div>
                </div>

                {{-- Event Title --}}
                <div class="relative group">
                    <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}"
                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                        placeholder=" ">
                    <label for="title"
                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                        Event Title
                    </label>
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                        <i class="ri-edit-box-line text-2xl animate-[bounce_4s_ease-in-out_infinite]"></i>
                    </div>
                </div>

                {{-- Event Image Upload --}}
                <div id="upload-container"
                    class="relative group border-2 border-dashed border-gray-300 rounded-xl p-4 transition-all duration-300 hover:border-purple-400 bg-white cursor-pointer">

                    {{-- Hidden File Input --}}
                    <input type="file" id="file-upload" name="event_image" accept="image/*"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />

                    {{-- Default State --}}
                    <div id="default-state" class="flex items-center gap-4">
                        <div class="flex items-center gap-2 text-gray-500">
                            <i
                                class="ri-upload-cloud-2-line text-3xl text-purple-500 animate-[bounce_4s_ease-in-out_infinite]"></i>
                            <span class="text-lg">Upload Event Image</span>
                        </div>

                        @if ($event->event_image)
                            <div class="w-20 h-20 rounded-lg overflow-hidden border border-gray-200">
                                <img src="{{ asset($event->event_image) }}" alt="Current Event Image"
                                    class="w-full h-full object-cover" />
                            </div>
                        @endif
                    </div>

                    {{-- Preview State --}}
                    <div id="preview-state" class="hidden flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-20 h-20 rounded-lg overflow-hidden border border-gray-200">
                                <img id="preview-image" src="" alt="Preview Image"
                                    class="w-full h-full object-cover" />
                            </div>
                            <span class="text-sm text-gray-600">Selected image preview</span>
                        </div>
                        <button type="button" id="change-image"
                            class="text-sm text-red-600 hover:underline hover:text-red-800 transition-all duration-200">
                            Remove
                        </button>
                    </div>
                </div>


                {{-- Date Range --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="relative group">
                        <input type="datetime-local" id="start_date" name="start_date"
                            value="{{ old('start_date', \Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i')) }}"
                            class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                            placeholder=" ">
                        <label for="start_date"
                            class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                            Start Date
                        </label>
                        <div
                            class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                            <i class="ri-calendar-2-line text-2xl animate-[bounce_4s_ease-in-out_infinite]"></i>
                        </div>
                    </div>
                    <div class="relative group">
                        <input type="datetime-local" id="end_date" name="end_date"
                            value="{{ old('end_date', $event->end_date ? \Carbon\Carbon::parse($event->end_date)->format('Y-m-d\TH:i') : '') }}"
                            class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                            placeholder=" ">
                        <label for="end_date"
                            class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                            End Date
                        </label>
                        <div
                            class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                            <i class="ri-calendar-check-line text-2xl animate-[bounce_4s_ease-in-out_infinite]"></i>
                        </div>
                    </div>
                </div>

                {{-- Timezone --}}
                <div class="relative group">
                    <select id="timezone" name="timezone"
                        class="w-full px-5 py-4 pl-14 pr-12 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 appearance-none peer">
                        @foreach (timezone_identifiers_list() as $tz)
                            <option value="{{ $tz }}"
                                {{ old('timezone', $event->timezone) === $tz ? 'selected' : '' }}>
                                {{ $tz }}
                            </option>
                        @endforeach
                    </select>
                    <label for="timezone"
                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                        Timezone
                    </label>
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                        <i class="ri-time-line text-2xl animate-[bounce_4s_ease-in-out_infinite]"></i>
                    </div>
                    <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-gray-400">
                        <i class="ri-arrow-down-s-line text-xl"></i>
                    </div>
                </div>

                {{-- Status Select --}}
                <div class="relative group">
                    <select id="status" name="status"
                        class="w-full px-5 py-4 pl-14 pr-12 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 appearance-none peer">
                        <option value="draft" {{ old('status', $event->status) === 'draft' ? 'selected' : '' }}>Draft
                        </option>
                        <option value="published"
                            {{ old('status', $event->status) === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    <label for="status"
                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                        Status
                    </label>
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                        <i class="ri-toggle-line text-2xl animate-[bounce_4s_ease-in-out_infinite]"></i>
                    </div>
                    <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-gray-400">
                        <i class="ri-arrow-down-s-line text-xl"></i>
                    </div>
                </div>

                {{-- Bank Information Section --}}

                <h3 class="text-lg font-semibold text-purple-800 mb-4 flex items-center gap-2">
                    <i class="ri-bank-card-line"></i>
                    Bank Information
                </h3>

                <div class="space-y-4">
                    {{-- Bank Name --}}
                    <div class="relative group">
                        <input type="text" id="bank_name" name="bank_name"
                            value="{{ old('bank_name', $event->bank_name) }}"
                            class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                            placeholder="BCA,BNI,BRI ">
                        <label for="bank_name"
                            class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                            Bank Name
                        </label>
                        <div
                            class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                            <i class="ri-bank-line text-2xl animate-[bounce_4s_ease-in-out_infinite]"></i>
                        </div>
                    </div>

                    {{-- Bank Account Number --}}
                    <div class="relative group">
                        <input type="number" id="bank_account_number" name="bank_account_number"
                            value="{{ old('bank_account_number', $event->bank_account_number) }}"
                            class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                            placeholder="1234567890">
                        <label for="bank_account_number"
                            class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                            Account Number
                        </label>
                        <div
                            class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                            <i class="ri-bank-card-line text-2xl animate-[bounce_4s_ease-in-out_infinite]"></i>
                        </div>
                    </div>

                    {{-- Bank Account Name --}}
                    <div class="relative group">
                        <input type="text" id="bank_account_name" name="bank_account_name"
                            value="{{ old('bank_account_name', $event->bank_account_name) }}"
                            class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 peer"
                            placeholder="John Doe">
                        <label for="bank_account_name"
                            class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                            Account Name
                        </label>
                        <div
                            class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-purple-500">
                            <i class="ri-user-line text-2xl animate-[bounce_4s_ease-in-out_infinite]"></i>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div class="relative group">
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-5 py-4 pl-14 text-lg rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-0 bg-white text-gray-800 transition-all duration-300 shadow-sm group-hover:border-purple-300 resize-y min-h-[120px] hover:min-h-[140px] focus:min-h-[140px] peer"
                        placeholder="Description">{{ old('description', $event->description) }}</textarea>
                    <label for="description"
                        class="absolute left-14 top-4 px-2 text-gray-500 text-lg transition-all duration-300 transform -translate-y-9 scale-90 bg-white rounded peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-9 peer-focus:scale-90 peer-focus:text-purple-600">
                        Description
                    </label>
                    <div
                        class="absolute inset-y-0 left-0 pl-5 flex items-start pt-4 pointer-events-none text-purple-500">
                        <i class="ri-align-left text-2xl animate-[bounce_4s_ease-in-out_infinite]"></i>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-4 px-6 text-lg font-semibold bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 rounded-xl shadow-lg text-white transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl active:scale-95 group">
                        <div class="flex items-center justify-center gap-3">
                            <i
                                class="ri-save-2-line text-2xl transition-transform group-hover:scale-125 group-hover:rotate-12"></i>
                            <p class="relative overflow-hidden h-7">
                                <span
                                    class="block transition-transform duration-500 group-hover:-translate-y-[120%]">Save
                                    Changes</span>
                                <span
                                    class="left-0 top-full w-full text-center transition-transform duration-500 group-hover:-translate-y-full flex items-center justify-center gap-2">
                                    Update Now! <i
                                        class="ri-arrow-right-line animate-[slideRight_1s_ease-in-out_infinite]"></i>
                                </span>
                            </p>
                        </div>
                    </button>
                </div>
            </form>
        </div>

        {{-- Right Side - Preview Card --}}
        <div class="lg:col-span-1">
            <div class="sticky top-6">
                <div
                    class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-6 shadow-lg border border-purple-100 transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                    <div class="text-center mb-6">
                        <div
                            class="inline-flex p-3 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg mb-4">
                            <i class="ri-eye-line text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Live Preview</h3>
                        <p class="text-purple-600/80">See how your event will appear</p>
                    </div>

                    <div class="bg-white rounded-xl p-5 shadow-inner border border-gray-200 mb-6">
                        @if ($event->event_image)
                            <img src="{{ asset($event->event_image) }}" alt="Event Image"
                                class="w-full h-48 object-cover rounded-lg mb-4">
                        @else
                            <div
                                class="h-48 bg-gradient-to-r from-purple-100 to-indigo-100 rounded-lg mb-4 flex items-center justify-center">
                                <i class="ri-image-line text-4xl text-purple-300"></i>
                            </div>
                        @endif
                        <h4 class="font-bold text-gray-800 text-lg mb-1 truncate">
                            {{ $event->title ?: 'Your Event Name' }}</h4>
                        <div class="flex items-center gap-2 text-purple-600 mb-3">
                            <i class="ri-calendar-line"></i>
                            <span class="text-sm">
                                {{ $event->start_date ? \Carbon\Carbon::parse($event->start_date)->format('M d, Y') : 'Start date' }}
                                @if ($event->end_date)
                                    - {{ \Carbon\Carbon::parse($event->end_date)->format('M d, Y') }}
                                @endif
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm line-clamp-2">
                            {{ $event->description ?: 'Event description will appear here...' }}
                        </p>
                    </div>

                    <div class="flex justify-center">
                        <button
                            class="px-6 py-2.5 bg-white text-purple-600 rounded-lg border border-purple-200 font-medium hover:bg-purple-50 transition-all flex items-center gap-2">
                            <i class="ri-share-line"></i> Share Preview
                        </button>
                    </div>
                </div>

                {{-- Tips Card --}}
                <div
                    class="mt-6 bg-gradient-to-br from-indigo-50 to-blue-50 rounded-2xl p-6 shadow-lg border border-indigo-100">
                    <h4 class="font-bold text-gray-800 text-lg mb-3 flex items-center gap-2">
                        <i class="ri-lightbulb-flash-line text-indigo-500"></i>
                        Pro Tips
                    </h4>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-start gap-2">
                            <i class="ri-checkbox-circle-fill text-indigo-400 mt-1"></i>
                            <span>Use clear, descriptive event names</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="ri-checkbox-circle-fill text-indigo-400 mt-1"></i>
                            <span>Add high-quality images for better engagement</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="ri-checkbox-circle-fill text-indigo-400 mt-1"></i>
                            <span>Set reminders for important deadlines</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById("update-event-form").addEventListener("submit", function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const submitBtn = form.querySelector("button[type='submit']");

        submitBtn.disabled = true;
        submitBtn.classList.add("opacity-75", "cursor-not-allowed");
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';

        fetch(form.action, {
                method: "POST",
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async (res) => {
                const data = await res.json();

                if (res.ok && data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#6366F1'
                    });
                } else {
                    Swal.fire({
                        title: 'Oops!',
                        html: (data.errors || ['Something went wrong']).join("<br>"),
                        icon: 'error',
                        confirmButtonColor: '#EF4444'
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Something went wrong (network or server error)',
                    icon: 'error',
                    confirmButtonColor: '#EF4444'
                });
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.classList.remove("opacity-75", "cursor-not-allowed");
                submitBtn.innerHTML = 'Update Now!';
            });
    });
</script>
