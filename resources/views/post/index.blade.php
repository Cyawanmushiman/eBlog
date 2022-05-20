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
</main>
@endsection