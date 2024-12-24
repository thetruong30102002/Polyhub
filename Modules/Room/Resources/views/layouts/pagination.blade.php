@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination">
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.previous')</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
                    </li>
                @endif

                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.next')</span>
                    </li>
                @endif
            </ul>
        </div>

        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            <div>
                <ul class="pagination">
                    @php
                        $total = $paginator->total();
                        $pages_per_set = 3;
                        $start = floor(($paginator->currentPage() - 1) / $pages_per_set) * $pages_per_set + 1;
                        $end = min($start + $pages_per_set - 1, $total);
                        if($end > $paginator->lastPage()){
                            $end = $paginator->lastPage();
                        }
                    @endphp

                    @if ($end > 3)
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->url($start - 1) }}" aria-label="@lang('pagination.previous')">&laquo;</a>
                        </li>
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        <li class="end-{{$end}}--start-{{$start}}--dem- page-item {{ ($paginator->currentPage() == $i) ? 'active' : '' }}">
                            @if ($paginator->currentPage() == $i)
                                <span class="page-link">{{ $i }}</span>
                            @else
                                <a class="page-link" href="{{ ($paginator->currentPage() != $i) ? $paginator->url($i) : '#' }}">{{ $i }}</a>
                            @endif
                        </li>
                    @endfor

                    @if ($end != $paginator->lastPage())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->url($end + 1) }}" aria-label="@lang('pagination.next')">&raquo;</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif

<script>
    function preventDefault(event) {
        event.preventDefault();
        return false;
    }
</script>
