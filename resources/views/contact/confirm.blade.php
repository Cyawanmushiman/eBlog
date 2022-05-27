@extends('layouts.component')
@section('content')
<div class="contact">
  <h1 class="contact__title">Check</h1>
  <h2 class="contact__title--japanese">内容確認</h2>

  <form class="contact__form" action="{{route('contact.send')}}" method="POST">
    @csrf
    <label for="title">件名：</label>
    <p class="contact__text">{{$inputs['title']}}</p>
    <input type="hidden" name="title" value="{{$inputs['title']}}">

    <label for="body">お問い合わせ内容：</label>
    <p class="contact__text">{{$inputs['body']}}</p>
    <input type="hidden" name="body" value="{{$inputs['body']}}">

    <label for="email">メールアドレス：</label>
    <p class="contact__text">{{$inputs['email']}}</p>
    <input type="hidden" name="email" value="{{$inputs['email']}}">

    <button name="back" class="contact__btn" type="submit">戻る</button>
    <button class="contact__btn" type="submit">送信</button>
  </form>
</div>
@endsection