@extends('layouts.component')
@section('content')
<div class="create">
  <h1 class="create__title">New Post</h1>
  <h2 class="create__title--japanese">新規投稿</h2>

  <form class="create__form" action="{{route('post.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <label for="title">title</label>
    <input type="text" id="title" name="title" value="{{old('title')}}">

    <label for="body">body</label>
    <textarea name="body" id="body">{{old('body')}}</textarea>

    <label for="eyeCatchImage">eyeCatchImage</label>
    <input type="file" id="eyeCatchImage" name="eyeCatchImage">

    <button class="create__btn" type="submit">create!</button>
  </form>
</div>
@endsection