<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8" />
  <title></title>
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- resetCSS< -->
  <link rel="stylesheet" href="{{asset('css/reset.css')}}">
  <!-- FontAwesome -->
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" />
  <!-- CSSの読み込み -->
  <link href="{{asset('css/app.css')}}" rel="stylesheet" />
  <!-- ファビこん -->
  <link rel="icon" type="image/png" href="" />
</head>

<body>
  <div class="bodyWrapper">
    <header class="header">
      <div class="header__search">
        <a href="" class="js_modal_open" data-target="modal01"><img src="{{asset('img/search.svg')}}"
            alt="search-Icon" /></a>
        <!--data-target属性を追加する。この値をモーダルウィンドウのID属性とリンクさせることで、どのモーダルウィンドウを開くかわかるようにする。-->
      </div>
      <a href="index.html" class="header__title">
        eBlog
      </a>

      <!-- ハンバーガーメニュー -->
      <div id="navArea">
        <nav class="humburgerNav">
          <div class="inner">
            <a href="index.html" class="humburgerNav__title">eBlog</a>
            <ul class="menu">
              <li class="menu-item {{url()->current()==route('post.index') ? 'active' : ''}}"><a
                  href="{{route('post.index')}}">Home</a></li>
              <li class="menu-item {{url()->current()==route('post.create') ? 'active' : ''}}"><a
                  href="{{route('post.create')}}">New Post</a></li>
              <li class="menu-item {{url()->current()==route('contact.create') ? 'active' : ''}}"><a
                  href="{{route('contact.create')}}">Contact</a></li>
              <li class="menu-item"><a href="">About</a></li>
            </ul>
          </div>
        </nav>

        <div class="toggle_btn" id="btn17">
          <span></span>
          <span></span>
          <span></span>
        </div>

        <div id="mask"></div>
      </div>
      <!-- ハンバーガーメニュー -->
    </header>

    {{-- モーダル --}}
    <div id="modal01" class="modal js_modal">
      <!--data-target属性と同じ値のID属性をつける。-->
      <div class="modal__bg js_modal_close"></div>
      <div class="modal__content">
        <form action="{{route('post.index')}}" method="get">
          <input class="searchInput" type="text" name="keyword" value="{{$keyword ?? ''}}" placeholder="記事検索">
          <input type="submit" value="検索" class="searchSubmit">
        </form>
        <a href="" class="js_modal_close">閉じる</a>
      </div>
    </div>
    {{-- モーダル --}}

    @if($errors->any())
    <!-- もし、セッションの中にエラーメッセージがあれば -->
    <div class="errorMessage">
      <ul>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
        @if(empty($errors->first('image')))
        <!-- もし画像ファイル以外でエラーがあれば -->
        <li>画像ファイルがあれば、再度、選択してください。</li>
        @endif
      </ul>
    </div>
    @endif

    @if(session('message'))
    <div class="sessionMessage">{{session('message')}}</div>
    @endif

    @yield('content')
    @include('layouts.sidebar')
    <footer class="footer">
      <a href="index.html" class="footer__title">
        eBlog
      </a>
      <p class="copyRight">©︎ 2022 eBlog</p>
    </footer>
  </div>

  <!--jQueryドキュメント-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
  </script>
  <script src="{{asset('js/script.js')}}"></script>
  <script>
    let winScrollTop;
    $('.js_modal_open').each(function(){//.js_modal_openが複数あるので、どのjs_modal_openがクリックされたかわかるようにする。
      $(this).on("click",function(){
        winScrollTop = $(window).scrollTop();//winScrollTop = スクロール位置の値
        let target = $(this).data('target');//dataメソッドで、クリックした「js＿modal＿open」の「data-target」属性を取得し、変数「target」に代入している。つまり target = modal01 or modal02になる。
        let modal = document.getElementById(target);//指定したIDにマッチする要素を取得できる。
        //modal = 表示したいもの
        $(modal).fadeIn(50);
        return false;//clickイベントを中断する
      });
    });
    $('.js_modal_close').on("click",function(){//js_modal_closeがクリックされたら
      $('.js_modal').fadeOut(50);//js_modalをフェードアウトして消す。
      $('body,html').stop().animate({scrollTop:winScrollTop},100);//winScrollTopの位置まで、アニメーションさせながら、0.1秒かけて移動する。
      return false;
    });
  </script>
</body>

</html>