<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;

class ContactController extends Controller
{
  public function create(){
    return view('contact.create');
  }

  public function post(Request $request){
    $inputs = $request->validate([
      'title' => 'required|max:255',
      'body' => 'required|max:10000',
      'email' => 'required|email|max:100',
    ]);

    $request->session()->put('form_input',$inputs);
    // return redirect()->route('contact.confirmget',$inputs);
    // return view('contact.confirm')->with($inputs);
    // return redirect()->action('ContactController@confirm',$inputs);
    // return redirect()->route('contact.confirm');
    // return redirect()->route('contact.confirm',$inputs);
    // return redirect()->route('contact.confirm')->withInput($inputs);
    return redirect()->action('ContactController@confirm');
  }

  public function confirm(Request $request){
    $inputs = $request->session()->get('form_input');
    // $inputs = $request->inputs;
    // dd($request);
    // $inputs = $request->old();
    return view('contact.confirm',compact('inputs'));
  }

  public function send(Request $request){
    // dd($request);
    $inputs = $request->session()->get('form_input');
    // $inputs = $request->all();
    // $inputs = $request->inputs;

    if($request->has('back')){
      return redirect()->route('contact.create')->withInput($inputs);
    }
    $request->session()->forget('form_input');

    Contact::create($inputs);

    Mail::to(config('mail.admin'))->send(new ContactForm($inputs));
//config/mail.phpの中のadmin宛にメールを送信する。フォームの送信内容をContactForm.phpに送る。
    Mail::to($inputs['email'])->send(new ContactForm($inputs));
    //フォームの中のemail宛にメールを送信する
    return redirect()->route('post.index')->with('message','お問い合わせを送信しました');
  }
}
