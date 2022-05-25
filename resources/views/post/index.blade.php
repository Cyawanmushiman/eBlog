@extends('layouts.component')
@section('content')
<main class="home">
  <h1 class="home__title">Posts</h1>
  <h2 class="home__title--japanese">記事一覧</h2>

  <div class="home__blogWrapper">
    @foreach($posts as $post)
    <a href="{{route('post.show',$post)}}" class="BlogCard">
      <div class="BlogCard__image"><img src="{{asset('storage/eyeCatchImage/'.$post->eyeCatchImage)}}"
          alt="eyeCatchImage"></div>
      <h3 class="BlogCard__title">{{Str::limit($post->title,20,'...')}}</h3>
    </a>
    @endforeach
  </div>

  {{$posts->links('vendor.pagination.custom-2')}}
</main>

<section class="profile">
  <h1 class="profile__title">Profile</h1>
  <h2 class="profile__title--japanese">プロフィール</h2>

  <div class="profile__avatar"><img src="{{asset('img/avatar.png')}}" alt="アバター"></div>

  <div class="profile__text">
    <h3 class="profile__name">えーじ</h3>
    <p class="profile__body">
      1997年生まれ。元放射線技師→現在エンジニア転職活動中。 HTML・CSS・jQuery・WordPressを学んで現在はLaravel学習中。あれこれ手を出しては悩んでを繰り返しながら、ちょびっとずつ前進しております。
    </p>
    <a href="{{route('form.show')}}" class="profile__contactLink">contact</a>
    <a href="" class="profile__aboutMe">About Me</a>
  </div>
</section>
@endsection