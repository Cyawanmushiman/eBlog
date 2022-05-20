@extends('layouts.component')
@section('content')
<main class="single">

  <div class="single__touch">
    <a href="{{route('post.edit',$post)}}" class="singleEdit">edit</a>
    <form method="post" action="{{route('post.delete',$post)}}">
      @csrf
      @method('delete')
      <button type="submit" class="singleDelete" onclick="return confirm('この投稿を削除してよろしいですか？')">delete</button>
    </form>
  </div>

  <h1 class="single__title">{{$post->title}}</h1>
  <div class="single__image"><img src="{{asset('storage/eyeCatchImage/'.$post->eyeCatchImage)}}" alt="eyeCatchImage"></div>
  <div class="single__body">
    <p class="single__text">
      {{$post->body}}
    </p>
  </div>

</main>
@endsection