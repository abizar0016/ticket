@if ($paginator->hasPages())
    <nav class="flex items-center justify-center py-6">
        <ul class="inline-flex items-center -space-x-[2px] rounded-xl shadow-lg">
            {{-- Previous Page --}}
            @if ($paginator->onFirstPage())
                <li class="animate-[fadeIn_0.4s_ease-out_forwards]">
                    <span
                        class="flex items-center justify-center w-10 h-10 text-gray-400 bg-white border border-gray-200 rounded-l-xl cursor-not-allowed group">
                        <i class="ri-arrow-left-s-line text-lg group-hover:scale-125 transition-transform"></i>
                    </span>
                </li>
            @else
                <li class="animate-[fadeIn_0.4s_ease-out_forwards]">
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="flex items-center justify-center w-10 h-10 text-gray-600 bg-white border border-gray-200 rounded-l-xl hover:bg-gray-50 hover:text-indigo-600 transition-all duration-300 group hover:shadow-md hover:-translate-x-0.5">
                        <i class="ri-arrow-left-s-line text-lg group-hover:scale-125 transition-transform"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="animate-[fadeIn_0.4s_ease-out_forwards]">
                        <span
                            class="flex items-center justify-center w-10 h-10 text-gray-500 bg-white border border-gray-200 transition-all duration-300">
                            {{ $element }}
                        </span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="animate-[bounceIn_0.6s_cubic-bezier(0.34,1.56,0.64,1)_forwards]">
                                <span
                                    class="flex items-center justify-center w-10 h-10 text-white bg-gradient-to-r from-indigo-500 to-indigo-600 border border-indigo-600 shadow-md scale-110">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li class="animate-[fadeIn_0.4s_ease-out_forwards]">
                                <a href="{{ $url }}"
                                    class="flex items-center justify-center w-10 h-10 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 hover:text-indigo-600 hover:border-indigo-200 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page --}}
            @if ($paginator->hasMorePages())
                <li class="animate-[fadeIn_0.4s_ease-out_forwards]">
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="flex items-center justify-center w-10 h-10 text-gray-600 bg-white border border-gray-200 rounded-r-xl hover:bg-gray-50 hover:text-indigo-600 transition-all duration-300 group hover:shadow-md hover:translate-x-0.5">
                        <i class="ri-arrow-right-s-line text-lg group-hover:scale-125 transition-transform"></i>
                    </a>
                </li>
            @else
                <li class="animate-[fadeIn_0.4s_ease-out_forwards]">
                    <span
                        class="flex items-center justify-center w-10 h-10 text-gray-400 bg-white border border-gray-200 rounded-r-xl cursor-not-allowed group">
                        <i class="ri-arrow-right-s-line text-lg group-hover:scale-125 transition-transform"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
