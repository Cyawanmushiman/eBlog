@extends('layouts.component')
@section('content')
<div class="contact">
  <h1 class="contact__title">Contact</h1>
  <h2 class="contact__title--japanese">お問い合わせ</h2>

  <form class="contact__form" action="{{route('contact.post')}}" method="post">
    @csrf
    <label for="title">件名</label>
    <input type="text" id="title" name="title" value="{{old('title')}}">

    <label for="body">お問い合わせ内容</label>
    <textarea name="body" id="body">{{old('body')}}</textarea>

    <label for="email">メールアドレス</label>
    <input type="text" id="email" name="email" value="{{old('email')}}">

    <button class="contact__btn" type="submit">確認</button>
  </form>
</div>
@endsection