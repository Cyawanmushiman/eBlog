<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class ContactController extends Controller
{
  // public function create(){
  //   return view('contact.create');
  // }

  // public function check(Request $request){
  //   $inputs = $request->validate([
  //     'title' => 'required|max:255',
  //     'body' => 'required|max:10000',
  //     'email' => 'required|email|max:255',
  //   ]);

  //   return view('contact.check',compact('inputs'));
  // }

  private $formItems = ['title','body','email'];
  private $validator = [
    'title' => 'required|max:255',
    'body' => 'required|max:10000',
    'email' => 'required|email|max:255',
  ];

  public function show(){
    return view('contact.create');
  }

  public function post(Request $request){
    $input = $request->only($this->formItems);
    $validator = Validator::make($input, $this->validator);
    if($validator->fails()){
      return redirect()->action('ContactController@show')
      ->withInput()
      ->withErrors($validator);
    }
    
    //セッションに入力値を登録
    $request->session()->put('form_input',$input);
    return redirect()->action('ContactController@confirm');
  }

  public function confirm(Request $request){
    $input = $request->session()->get('form_input');

    if(!$input){
      return redirect()->action('ContactController@show');
    }
    return view('contact.check',compact('input'));
  }

  public function send(Request $request){
    $input = $request->session()->get('form_input');

    if(!$input){
      return redirect()->action('ContactController@show');
    }

    $request->session()->forget('form_input');
    // return redirect()->route('post.index')->with('message','お問い合わせありがとうございました');
    return redirect()->action('ContactController@complete');
  }

  public function complete(){
    return redirect()->route('post.index')->with('message','お問い合わせを送信しました');
  }
  
}
