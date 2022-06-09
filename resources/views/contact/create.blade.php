@extends('layouts.component')
@section('content')
{{Breadcrumbs::render('contact')}}
<div class="contact">
  <div class="titleWrapper">
    <h1 class="contact__title">Contact</h1>
    <h2 class="contact__title--japanese">お問い合わせ</h2>
  </div>
  <form class="contact__form" action="{{route('contact.confirm')}}" method="post">
    @csrf
    <label for="title">件名</label>
    <input type="text" id="title" name="title" value="{{old('title')}}">

    <label for="body">お問い合わせ内容</label>
    <textarea name="body" id="body">{{old('body')}}</textarea>

    <label for="email">メールアドレス</label>
    <input type="text" id="email" name="email" value="{{old('email')}}">

    <button class="contact__btn" type="submit">入力内容確認</button>
  </form>
</div>
@endsection