@inject('categories', 'App\Http\Controllers\PostController')
<section class="profile">
  <div class="titleWrapper">
    <h1 class="profile__title">Profile</h1>
    <h2 class="profile__title--japanese">プロフィール</h2>
  </div>

  <div class="profile__avatar"><img src="{{asset('img/avatar.png')}}" alt="アバター"></div>

  <div class="profile__text">
    <h3 class="profile__name">Jippy</h3>
    <p class="profile__body">
      1997年生まれ。元放射線技師→現在エンジニア転職活動中。
      HTML・CSS・jQuery・WordPressを学んで現在はLaravel学習中。あれこれ手を出しては悩んでを繰り返しながら、ちょびっとずつ前進しております。
    </p>
    <a href="{{route('contact.create')}}" class="profile__contactLink">contact</a>
    <a href="{{route('about.index')}}" class="profile__aboutMe">About Me</a>
  </div>
</section>

<section class="categories">
  <div class="titleWrapper">
    <h1 class="categories__title">Category</h1>
    <h2 class="categories__title--japanese">カテゴリー</h2>
  </div>

  <ul class="categories__menu">
    @foreach($categories->getCategories() as $category)
    <li class="categories__menuItem"><a href="{{route('post.categories',$category)}}">{{$category->name}}</a></li>
    @endforeach
  </ul>
</section>