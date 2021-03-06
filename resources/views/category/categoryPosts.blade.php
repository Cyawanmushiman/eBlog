<x-app>
{{Breadcrumbs::render('category',$category)}}
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <main class="home">
        <div class="titleWrapper">
          <h1 class="home__title">{{$category->name}}</h1>
          <h2 class="home__title--japanese">{{$category->name}}の記事</h2>
        </div>

        <div class="home__blogWrapper">
          @if(count($posts) === 0)
            <p>まだ投稿がありません</p>
          @endif
          @foreach($posts as $post)
          <a href="{{route('post.postShow',$post)}}" class="BlogCard">
            <span class="BlogCard__category">{{ $post->category->name }}</span>
            <div class="BlogCard__image"><img src="{{asset('storage/public/eyeCatchImage/'.$post->eyeCatchImage)}}"
                alt="eyeCatchImage"></div>
            <h3 class="BlogCard__title">{{Str::limit($post->title,20,'...')}}</h3>
          </a>
          @endforeach
        </div>
      </main>
    </div>
    <x-sidebar />
  </div>
</div>
</x-app>
