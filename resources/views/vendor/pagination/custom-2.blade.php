{{-- pagination --}}
@if($paginator->hasPages())
<div class="navLinks">
  @if($paginator->onFirstPage())
  <a href="" class="navLinks__prev" style="display: none;"><img src="{{asset('img/prev.svg')}}" alt="前へ"></a>
  @else
  <a href="{{ $paginator->previousPageUrl() }}" class="navLinks__prev"><img src="{{asset('img/prev.svg')}}"
      alt="前へ"></a>
  @endif

  <!-- ページ番号 -->
  {{-- Array Of Links --}}
  {{-- 定数よりもページ数が多い時 --}}
  @if ($paginator->lastPage() > config('const.PAGINATE.LINK_NUM'))

  {{-- 現在ページが表示するリンクの中心位置よりも左の時 --}}
  @if ($paginator->currentPage() <= floor(config('const.PAGINATE.LINK_NUM') / 2)) 
    <?php $start_page=1; //最初のページ ?>
    <?php $end_page = config('const.PAGINATE.LINK_NUM'); ?>
    {{-- end_pageに5を代入 --}}

    {{-- 現在ページが表示するリンクの中心位置よりも右の時 --}}
    @elseif ($paginator->currentPage() > $paginator->lastPage() - floor(config('const.PAGINATE.LINK_NUM') / 2))
    <?php $start_page = $paginator->lastPage() - (config('const.PAGINATE.LINK_NUM') - 1); ?>
    {{-- start_pageに --}}
    <?php $end_page = $paginator->lastPage(); ?>

    {{-- 現在ページが表示するリンクの中心位置の時 --}}
    @else
    <?php $start_page = $paginator->currentPage() - (floor((config('const.PAGINATE.LINK_NUM') % 2 == 0 ? config('const.PAGINATE.LINK_NUM') - 1 : config('const.PAGINATE.LINK_NUM'))  / 2)); ?>
    <?php $end_page = $paginator->currentPage() + floor(config('const.PAGINATE.LINK_NUM') / 2); ?>
    @endif

    {{-- 定数よりもページ数が少ない時 --}}
    @else
    <?php $start_page = 1; ?>
    <?php $end_page = $paginator->lastPage(); ?>
    @endif

    {{-- 処理部分 --}}
    @for ($i = $start_page; $i <= $end_page; $i++) 
      @if ($i==$paginator->currentPage())
        <span class="navLinks__numbers active">{{ $i }}</span>
      @else
        <a class="navLinks__numbers" href="{{ $paginator->url($i) }}">{{ $i }}</a>
      @endif
    @endfor



  @if($paginator->hasMorePages())
  <a href="{{ $paginator->nextPageUrl() }}" class="navLinks__next"><img src="{{asset('img/next.svg')}}" alt=""></a>
  @else
  <a href="" style="display: none;" class="navLinks__next"><img src="{{asset('img/next.svg')}}" alt=""></a>
  @endif
</div>
@endif