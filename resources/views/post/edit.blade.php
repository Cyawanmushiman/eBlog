@extends('layouts.component')
@section('content')
<div class="create">
  <h1 class="create__title">Post edit</h1>
  <h2 class="create__title--japanese">投稿編集</h2>

  <form class="create__form" action="{{route('post.update',$post)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <label for="title">title</label>
    <input type="text" id="title" name="title" value="{{old('title',$post->title)}}">

    <label for="body">body</label>
    <textarea name="body" id="body">{{old('body',$post->body)}}</textarea>


    <label for="eyeCatchImage">eyeCatchImage</label>
    <div class="create__image"><img src="{{asset("storage/eyeCatchImage/".$post->eyeCatchImage)}}" alt="eyeCatchImage"></div>
    <input type="file" id="eyeCatchImage" name="eyeCatchImage">

    <button class="create__btn" type="submit">update!</button>
  </form>
</div>
@endsection