@extends('layouts.component')
@section('content')
{{Breadcrumbs::render('newPost')}}
<div class="create">
  <div class="titleWrapper">
    <h1 class="create__title">New Post</h1>
    <h2 class="create__title--japanese">新規投稿</h2>
  </div>

  <form class="create__form" action="{{route('post.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <label for="category">category</label>
    <select name="category_id" type="text"  id="category">
        <option value="">選択してください</option>
        @foreach($categories as $category)
        <option value="{{$category->id}}" {{old('category_id') == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
        @endforeach
    </select>
    <input type="text" id="category" name="newCategory_name" placeholder="新しいカテゴリー" value="{{ old('newCategory_name') }}">

    <label for="title">title</label>
    <input type="text" id="title" name="title" value="{{old('title')}}">

    <label for="body">body</label>
    <textarea name="body" id="body">{{old('body')}}</textarea>

    <label for="eyeCatchImage">eyeCatchImage(画像サイズ:1024kBまで)</label>
    <input type="file" id="eyeCatchImage" name="eyeCatchImage">

    <button class="create__btn" type="submit">create!</button>
  </form>
</div>
@endsection
