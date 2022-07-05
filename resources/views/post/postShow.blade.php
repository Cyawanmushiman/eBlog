@extends('layouts.component')
@section('content')
{{Breadcrumbs::render('show',$post)}}
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <main class="single">

                @can('admin')
                <div class="single__touch">
                    <a href="{{route('post.postEdit',$post)}}" class="singleEdit">edit</a>
                    <form method="post" action="{{route('post.postDelete',$post)}}">
                        @csrf
                        @method('delete')
                        <button type="submit" class="singleDelete"
                            onclick="return confirm('この投稿を削除してよろしいですか？')">delete</button>
                    </form>
                </div>
                @endcan

                <h1 class="single__title">{{$post->title}}</h1>
                <p class="single__category">{{$post->category->name}}</p>
                <div class="single__image"><img src="{{asset('storage/public/eyeCatchImage/'.$post->eyeCatchImage)}}"
                        alt="eyeCatchImage"></div>
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
                    @if(count($categoryPosts) === 0)
                        <p>関連記事がありません</p>
                    @endif
                    @foreach($categoryPosts as $post)
                    <a href="{{route('post.postShow',$post)}}" class="BlogCard">
                        <span class="BlogCard__category">
                            {{ $post->category->name }}
                        </span>
                        <div class="BlogCard__image">
                            <img src="{{asset('storage/public/eyeCatchImage/'.$post->eyeCatchImage)}}"
                                alt="eyeCatchImage">
                        </div>
                        <h3 class="BlogCard__title">
                            {{Str::limit($post->title,60,'...')}}
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
