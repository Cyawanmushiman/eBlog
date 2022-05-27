<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;

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

  public function create(){
    return view('contact.create');
  }
  
  public function confirm(Request $request){
    $inputs = $request->validate([
      'title' => 'required|max:255',
      'body' => 'required|max:10000',
      'email' => 'required|email|max:255',
    ]);

    return view('contact.confirm',compact('inputs'));
  }
  
  public function send(Request $request){
    $inputs = $request->validate([
      'title' => 'required|max:255',
      'body' => 'required|max:10000',
      'email' => 'required|email|max:255',
    ]);

    if($request->has('back')){
      return redirect()->route('contact.create')->withInput($inputs);
    }

    $request->session()->regenerateToken();

    return redirect()->route('post.index')->with('message','送信しました。');
  }
  
}
