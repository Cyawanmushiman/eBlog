@extends('layouts.component')
@section('content')
<main class="single">

  <div class="single__touch">
    <a href="{{route('post.edit',$post)}}" class="singleEdit">edit</a>
    <a href="" class="singleDelete">delete</a>
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