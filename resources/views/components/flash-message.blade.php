@props(['status' => 'info'])

@php
    if(session('status') === 'info'){
        $textColor = 'textGreen';
    }
    if(session('status') === 'alert'){
        $textColor = 'textRed';
    }
@endphp

@if($errors->any())
<!-- もし、セッションの中にエラーメッセージがあれば -->
<div class="textRed">
  <ul>
    @foreach($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
    @if(empty($errors->first('image')))
    <!-- もし画像ファイル以外でエラーがあれば -->
    <li>画像ファイルがあれば、再度、選択してください。</li>
    @endif
  </ul>
</div>
@endif

@if(session('message'))
<div class="{{ $textColor }}">{{session('message')}}</div>
@endif
