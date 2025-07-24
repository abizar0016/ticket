@if ($paginator->hasPages())
    <nav class="flex items-center justify-center py-6">
        <ul class="inline-flex items-center gap-[2px] bg-white rounded-xl shadow-xl px-2 py-1 animate-[fadeIn_0.6s_ease-out]">
            {{-- Previous Page --}}
            @if ($paginator->onFirstPage())
                <li class="animate-[fadeIn_0.4s_ease-out]">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 text-gray-400 rounded-l-xl border border-gray-200 cursor-not-allowed transition-all">
                        <i class="ri-arrow-left-s-line text-lg"></i>
                    </span>
                </li>
            @else
                <li class="animate-[fadeIn_0.4s_ease-out]">
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="flex items-center justify-center w-10 h-10 bg-white text-gray-600 border border-gray-200 rounded-l-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 group hover:shadow-md hover:-translate-x-0.5">
                        <i class="ri-arrow-left-s-line text-lg group-hover:scale-125 transition-transform"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Dots --}}
                @if (is_string($element))
                    <li class="animate-[fadeIn_0.4s_ease-out]">
                        <span class="w-10 h-10 flex items-center justify-center text-gray-400">{{ $element }}</span>
                    </li>
                @endif

                {{-- Page Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="animate-[pop_0.4s_ease-out]">
                                <span
                                    class="w-10 h-10 flex items-center justify-center rounded-full text-white font-semibold bg-gradient-to-br from-purple-500 to-indigo-600 shadow-md scale-110 ring-2 ring-purple-300 transition-all duration-300">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li class="animate-[fadeIn_0.4s_ease-out]">
                                <a href="{{ $url }}"
                                    class="w-10 h-10 flex items-center justify-center rounded-full text-gray-600 hover:text-blue-600 hover:border-blue-300 hover:bg-blue-50 border border-gray-200 transition-all duration-300 hover:scale-105 hover:shadow-sm">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page --}}
            @if ($paginator->hasMorePages())
                <li class="animate-[fadeIn_0.4s_ease-out]">
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="flex items-center justify-center w-10 h-10 bg-white text-gray-600 border border-gray-200 rounded-r-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 group hover:shadow-md hover:translate-x-0.5">
                        <i class="ri-arrow-right-s-line text-lg group-hover:scale-125 transition-transform"></i>
                    </a>
                </li>
            @else
                <li class="animate-[fadeIn_0.4s_ease-out]">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 text-gray-400 border border-gray-200 rounded-r-xl cursor-not-allowed transition-all">
                        <i class="ri-arrow-right-s-line text-lg"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
