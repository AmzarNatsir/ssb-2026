@if ($paginator->hasPages())
<ul>
    <li class="mr-3">
       <a class="font-size-14" href="#" id="navbarDropdown" data-toggle="dropdown">
       {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
       </a>
    </li>
    @if (!$paginator->onFirstPage())
        <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Previous">
            <a href="{{ $paginator->previousPageUrl() }}"><i class="ri-arrow-left-s-line"></i></a>
        </li>
    @endif
    @if ($paginator->hasMorePages())
        <li data-toggle="tooltip" data-placement="top" title="" data-original-title="Next">
            <a href="{{ $paginator->nextPageUrl() }}"><i class="ri-arrow-right-s-line"></i></a>
        </li>
    @endif
 </ul>
 @endif