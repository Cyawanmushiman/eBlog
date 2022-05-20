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
        <img src="{{asset('img/search.svg')}}" alt="search-Icon" />
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
              <li class="menu-item"><a href="">Home</a></li>
              <li class="menu-item"><a href="">New Post</a></li>
              <li class="menu-item"><a href="">About</a></li>
              <li class="menu-item"><a href="">Blog</a></li>
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

    @if($errors->any())
    <!-- もし、セッションの中にエラーメッセージがあれば -->
    <ul>
      @foreach($errors->all() as $error)
      <li>{{$error}}</li>
      @endforeach
      @if(empty($errors->first('image')))
      <!-- もし画像ファイル以外でエラーがあれば -->
      <li>画像ファイルがあれば、再度、選択してください。</li>
      @endif
    </ul>
    @endif

    @if(session('message'))
    <div class="">{{session('message')}}</div>
    @endif

    @yield('content')
    
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
</body>

</html>