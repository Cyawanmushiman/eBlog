@extends('layouts.component')
@section('content')
{{Breadcrumbs::render('show',$post)}}
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <main class="single">
      
        @can('admin')
        <div class="single__touch">
          <a href="{{route('post.edit',$post)}}" class="singleEdit">edit</a>
          <form method="post" action="{{route('post.delete',$post)}}">
            @csrf
            @method('delete')
            <button type="submit" class="singleDelete" onclick="return confirm('この投稿を削除してよろしいですか？')">delete</button>
          </form>
        </div>
        @endcan
      
        <h1 class="single__title">{{$post->title}}</h1>
        <p class="single__category">{{$post->category->name}}</p>
        <div class="single__image"><img src="{{asset('storage/eyeCatchImage/'.$post->eyeCatchImage)}}" alt="eyeCatchImage"></div>
        <div class="single__body">
          <div class="single__texts">
            {!! nl2br($markdown) !!}
          </div>
        </div>
      
      </main>
      
      <section class="Related">
        <div class="titleWrapper">
          <h1 class="Related__title">Related Posts</h1>
          <h2 class="Related__title--japanese">関連記事</h2>
        </div>
      
        <div class="Related__blogWrapper">
          @foreach($category_posts as $category_post)
          <a href="{{route('post.show',$category_post)}}" class="BlogCard">
            <span class="BlogCard__category">
              {{ $category_post->category->name }}
            </span>
            <div class="BlogCard__image">
              <img src="{{asset('storage/eyeCatchImage/'.$category_post->eyeCatchImage)}}"
                alt="eyeCatchImage">
            </div>
            <h3 class="BlogCard__title">
              {{Str::limit($category_post->title,20,'...')}}
            </h3>
          </a>
          @endforeach
        </div>
      </section>
    </div>
    @include('layouts.sidebar')
  </div>
</div>
@endsection