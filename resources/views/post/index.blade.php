@extends('layouts.component')
@section('content')
{{Breadcrumbs::render('home')}}
<main class="home">
  <div class="titleWrapper">
    <h1 class="home__title">Posts</h1>
    <h2 class="home__title--japanese">記事一覧</h2>
  </div>

  <div class="home__blogWrapper">
    @foreach($posts as $post)
    <a href="{{route('post.show',$post)}}" class="BlogCard">
      <span class="BlogCard__category">{{ $post->category->name }}</span>
      <div class="BlogCard__image"><img src="{{asset('storage/eyeCatchImage/'.$post->eyeCatchImage)}}"
          alt="eyeCatchImage"></div>
      <h3 class="BlogCard__title">{{Str::limit($post->title,20,'...')}}</h3>
    </a>
    @endforeach
  </div>

  {{$posts->links('vendor.pagination.custom-2')}}
</main>
@endsection