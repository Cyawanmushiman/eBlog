@extends('layouts.component')
@section('content')
<main class="single">
  <h1 class="single__title">{{$post->title}}</h1>
  <div class="single__image"><img src="{{asset('storage/eyeCatchImage/'.$post->eyeCatchImage)}}" alt="eyeCatchImage"></div>
  <div class="single__body">
    <p class="single__text">
      {{$post->body}}
    </p>
  </div>

</main>
@endsection