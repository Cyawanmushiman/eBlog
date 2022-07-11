<div id="modal01" class="modal js_modal">
    <!--data-target属性と同じ値のID属性をつける。-->
    <div class="modal__bg js_modal_close"></div>
    <div class="modal__content">
      <form action="{{route('post.postList')}}" method="get">
        <input class="searchInput" type="search" name="keyword" value="{{$keyword ?? ''}}" placeholder="記事検索">
        <input type="submit" value="検索" class="searchSubmit">
      </form>
      <a href="" class="js_modal_close">閉じる</a>
    </div>
  </div>
