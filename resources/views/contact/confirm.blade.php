@extends('layouts.component')
@section('content')
<div class="contact">
  <h1 class="contact__title">Check</h1>
  <h2 class="contact__title--japanese">内容確認</h2>

  <form class="contact__form" action="" method="post">
    @csrf
    <label for="title">件名：</label>
    <p class="contact__text">{{$inputs['title']}}</p>

    <label for="body">お問い合わせ内容：</label>
    <p class="contact__text">{{$inputs['body']}}</p>

    <label for="email">メールアドレス：</label>
    <p class="contact__text">{{$inputs['email']}}</p>
    
    <button name="back" class="contact__btn" type="submit">戻る</button>
    <button class="contact__btn" type="submit">送信</button>
  </form>
</div>
@endsection