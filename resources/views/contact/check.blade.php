@extends('layouts.component')
@section('content')
<div class="contact">
  <h1 class="contact__title">Check</h1>
  <h2 class="contact__title--japanese">内容確認</h2>

  <form class="contact__form" action="{{route('form.send')}}" method="post">
    @csrf
    <label for="title">件名：</label>
    <p class="contact__text">{{$input['title']}}</p>
    <input type="hidden" id="title" name="title" value="{{$input['title']}}">

    <label for="body">お問い合わせ内容：</label>
    <p class="contact__text">{{$input['body']}}</p>
    <input type="hidden" id="body" name="body" value="{{$input['body']}}">

    <label for="email">メールアドレス：</label>
    <p class="contact__text">{{$input['email']}}</p>
    <input type="hidden" id="email" name="email" value="{{$input['email']}}">

    <button class="contact__btn" type="submit">確認</button>
  </form>
</div>
@endsection