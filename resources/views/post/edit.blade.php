@extends('layouts.component')
@section('content')
{{Breadcrumbs::render('edit',$post)}}
<div class="create">
  <div class="titleWrapper">
    <h1 class="create__title">Post edit</h1>
    <h2 class="create__title--japanese">投稿編集</h2>
  </div>

  <form class="create__form" action="{{route('post.update',$post)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    <label for="category">category</label>
    <select name="category_id" type="text"  id="category">
        <option value="">選択してください</option>
      @foreach($categories as $category)
        <option value="{{$category->id}}" 
          @if($post->category_id == $category->id)
            selected
          @endif
        >{{$category->name}}</option>
      @endforeach
    </select>
    <input type="text" id="category" name="newCategory_name" placeholder="新しいカテゴリー">

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