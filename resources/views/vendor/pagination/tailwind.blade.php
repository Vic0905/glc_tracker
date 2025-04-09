@if ($paginator->hasPages())
    <div class="overflow-x-auto">
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center space-x-2 mt-4">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 text-sm text-gray-400 bg-gray-200 rounded-lg cursor-not-allowed">← Previous</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" 
                   class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-blue-500 hover:text-white transition">
                    ← Previous
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-4 py-2 text-sm text-gray-500 bg-white border border-gray-300 rounded-lg">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-4 py-2 text-sm text-white bg-blue-600 border border-blue-600 rounded-lg font-bold shadow-md">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" 
                               class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-blue-500 hover:text-white transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" 
                   class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-blue-500 hover:text-white transition">
                    Next →
                </a>
            @else
                <span class="px-4 py-2 text-sm text-gray-400 bg-gray-200 rounded-lg cursor-not-allowed">Next →</span>
            @endif
        </nav>
    </div>
@endif
