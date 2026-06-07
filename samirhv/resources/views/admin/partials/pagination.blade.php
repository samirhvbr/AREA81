@if ($paginator->hasPages())
    <div class="pagination">
        {{-- Anterior --}}
        @if ($paginator->onFirstPage())
            <span style="opacity:0.4; cursor:not-allowed;">&#8592; Anterior</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">&#8592; Anterior</a>
        @endif

        {{-- Páginas --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span>{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Próxima --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">Próxima &#8594;</a>
        @else
            <span style="opacity:0.4; cursor:not-allowed;">Próxima &#8594;</span>
        @endif
    </div>
@endif
