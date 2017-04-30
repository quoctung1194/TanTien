<div class="row">
    <div class="col-lg-6">
        <ul class="pagination ">
            <li>
            {{
                $paginator->currentPage() . ' / ' . ceil($paginator->total()/$paginator->perPage()) . ' ' . __('index.page')
            }}

            </li>
        </ul>
    </div>
    <div class="col-lg-6">
        <div class="paginator" value={{ $paginator->currentPage() }}>
        @if ($paginator->hasPages())
            <ul class="pagination pull-right">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">@lang('pagination.previous')</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a></li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">@lang('pagination.next')</span></li>
                @endif
            </ul>
        @endif
        </div>
    </div>
</div>

