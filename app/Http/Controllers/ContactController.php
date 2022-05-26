<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

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
    return redirect()->action('ContactController@confirm');
  }

  public function confirm(Request $request){
    $inputs = $request->session()->get('form_input');

    return view('contact.confirm',compact('inputs'));
  }
}
