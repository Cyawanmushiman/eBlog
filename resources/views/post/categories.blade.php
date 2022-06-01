@extends('layouts.component')
@section('content')
{{Breadcrumbs::render('category',$category)}}
<main class="home">
  <div class="titleWrapper">
    <h1 class="home__title">{{$category->name}}</h1>
    <h2 class="home__title--japanese">{{$category->name}}の記事</h2>
  </div>

  <div class="home__blogWrapper">
    @if(count($posts) == 0)
      <p>まだ投稿がありません</p>
    @endif
    @foreach($posts as $post)
    <a href="{{route('post.show',$post)}}" class="BlogCard">
      <span class="BlogCard__category">{{ $post->category->name }}</span>
      <div class="BlogCard__image"><img src="{{asset('storage/eyeCatchImage/'.$post->eyeCatchImage)}}"
          alt="eyeCatchImage"></div>
      <h3 class="BlogCard__title">{{Str::limit($post->title,20,'...')}}</h3>
    </a>
    @endforeach
  </div>
</main>

<section class="profile">
  <div class="titleWrapper">
    <h1 class="profile__title">Profile</h1>
    <h2 class="profile__title--japanese">プロフィール</h2>
  </div>

  <div class="profile__avatar"><img src="{{asset('img/avatar.png')}}" alt="アバター"></div>

  <div class="profile__text">
    <h3 class="profile__name">えーじ</h3>
    <p class="profile__body">
      1997年生まれ。元放射線技師→現在エンジニア転職活動中。 HTML・CSS・jQuery・WordPressを学んで現在はLaravel学習中。あれこれ手を出しては悩んでを繰り返しながら、ちょびっとずつ前進しております。
    </p>
    <a href="{{route('contact.create')}}" class="profile__contactLink">contact</a>
    <a href="" class="profile__aboutMe">About Me</a>
  </div>
</section>

<section class="categories">
  <div class="titleWrapper">
    <h1 class="categories__title">Category</h1>
    <h2 class="categories__title--japanese">カテゴリー</h2>
  </div>

  <ul class="categories__menu">
    @foreach($categories as $category)
    <li class="categories__menuItem"><a href="{{route('post.categories',$category)}}">{{$category->name}}</a></li>
    @endforeach
  </ul>
</section>
@endsection