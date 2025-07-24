<!DOCTYPE html>
<html lang="en">
@include('components.head.head')

<body class="bg-gray-50 text-gray-800">
    @include('components.navbar.navbar')
    @include('components.preloader.preloader')

    <main class="max-w-2xl mx-auto px-4 py-10">
        <h2 class="text-2xl md:text-3xl font-bold mb-6 text-center text-gray-800">
            Checkout
        </h2>

        @if (isset($checkoutData['expires_at']))
            <p class="text-center text-sm text-gray-600 mb-6">
                Sesi ini akan kadaluarsa pada
                <span class="font-medium text-red-500">
                    {{ \Carbon\Carbon::parse($checkoutData['expires_at'])->translatedFormat('l, d F Y H:i') }} WIB
                </span>
            </p>
        @endif

        <form action="{{ route('checkout.submit') }}" method="POST" class="bg-white rounded-xl shadow-md p-6 space-y-6">
            @csrf
            <input type="hidden" name="dataCheckout" value="{{ json_encode($checkoutData) }}">

            {{-- Buyer Info --}}
            <div>
                <label class="block text-sm font-medium mb-1">Nama <span class="text-red-500">*</span></label>
                <input type="text" name="name" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            {{-- Attendees --}}
            @if ($ticketCount > 0)
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-indigo-700">
                            Data Attendees ({{ $ticketCount }})
                        </h3>

                        @if ($ticketCount > 1)
                            <button type="button" id="copy-attendee-btn"
                                class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition duration-200">
                                <i class="fas fa-copy mr-1"></i>Copy ke Semua
                            </button>
                        @endif
                    </div>

                    <div class="space-y-6" id="attendee-list">
                        @for ($i = 0; $i < $ticketCount; $i++)
                            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 attendee-item">
                                <h4 class="font-medium mb-2 text-sm text-gray-700">Attendee {{ $i + 1 }}</h4>

                                <div class="mb-2">
                                    <label class="block text-sm font-medium mb-1">Nama</label>
                                    <input type="text" name="attendees[{{ $i }}][name]"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none attendee-name"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-1">Email</label>
                                    <input type="email" name="attendees[{{ $i }}][email]"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none attendee-email"
                                        required>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            @endif

            {{-- Submit --}}
            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 shadow-sm">
                    <i class="fas fa-paper-plane mr-2"></i>Submit Checkout
                </button>
            </div>
        </form>

        @if ($errors->any())
            <div class="fixed bottom-6 right-6 z-50 animate-[slideIn_0.5s_ease-out_forwards]">
                <div class="mb-4 p-4 rounded-xl bg-red-50 text-red-700 border border-red-300 shadow-lg">
                    <div class="flex items-center gap-2">
                        <i class="ri-error-warning-line text-xl"></i>
                        <strong>Oops! Ada masalah dengan input kamu:</strong>
                    </div>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </main>
    <script src="{{ asset('js/customer.js') }}"></script>
</body>

</html>
