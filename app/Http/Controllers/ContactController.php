<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;

class ContactController extends Controller
{
  public function create(){
    return view('contact.create');
  }

  public function confirm(Request $request){
    $inputs = $request->validate([
      'title' => 'required|max:255',
      'body' => 'required|max:10000',
      'email' => 'required|email|max:100',
    ]);

    return view('contact.confirm',compact('inputs'));
  }

  public function send(Request $request){
    $inputs = $request->validate([
      'title' => 'required|max:255',
      'body' => 'required|max:10000',
      'email' => 'required|email|max:100',
    ]);

    if($request->has('back')){
      return redirect()->route('contact.create')->withInput($inputs);
    }

    // Contact::create($inputs);
    Mail::to(config('mail.admin'))->send(new ContactForm($inputs));
    // //config/mail.phpの中のadmin宛にメールを送信する。フォームの送信内容をContactForm.phpに送る。
    Mail::to($inputs['email'])->send(new ContactForm($inputs));
    // //フォームの中のemail宛にメールを送信する

    $request->session()->regenerateToken();

    return redirect()->route('post.index')->with('message','お問い合わせを送信しました');
  }
}
