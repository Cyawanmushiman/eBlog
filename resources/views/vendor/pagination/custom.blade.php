{{-- pagination --}}
@if($paginator->hasPages())
<div class="navLinks">
  @if($paginator->onFirstPage())
  <a href="" class="navLinks__prev" style="display: none;"><img src="{{asset('img/prev.svg')}}" alt="前へ"></a>
  @else
  <a href="{{ $paginator->previousPageUrl() }}" class="navLinks__prev"><img
      src="{{asset('img/prev.svg')}}" alt="前へ"></a>
  @endif

  <!-- ページ番号 -->
  @foreach ($elements as $element)
    @if (is_array($element))
    {{-- $elementが配列型であればtrue --}}
      @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        {{-- $elementのキーと現在のページ番号が同じ値あであればtrue --}}
          <span class="navLinks__numbers active">{{ $page }}</span>
        @else
          <a href="{{ $url }}" class="navLinks__numbers">{{ $page }}</a>
        @endif
      @endforeach
    @endif
  @endforeach

  @if($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="navLinks__next"><img src="{{asset('img/next.svg')}}" alt=""></a>
  @else
    <a href="" style="display: none;" class="navLinks__next"><img src="{{asset('img/next.svg')}}" alt=""></a>
  @endif
</div>
@endif