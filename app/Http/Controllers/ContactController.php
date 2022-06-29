<?php
//dev
namespace App\Http\Controllers;

use App\Mail\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
  /**
   * お問い合わせページ
   *
   * @return void
   */
  public function create(){
    return view('contact.create');
  }

  /**
   * 内容確認ページ
   *
   * @param Request $request
   * @return void
   */
  public function confirm(ContactRequest $request){
    return view('contact.confirm',[
        'inputs' => $request->all(),
    ]);
  }

  public function send(ContactRequest $request){
    $inputs = $request->all();

    if(isset($inputs['back'])){
      return redirect()->route('contact.create')->withInput($inputs);
    }

    // Contact::create($inputs);
    Mail::to(config('mail.admin'))->send(new ContactForm($inputs));
    // //config/mail.phpの中のadmin宛にメールを送信する。フォームの送信内容をContactForm.phpに送る。
    Mail::to($inputs['email'])->send(new ContactForm($inputs));
    // //フォームの中のemail宛にメールを送信する

    //送信ボタン連打攻撃対策
    $request->session()->regenerateToken();

    return redirect()->route('post.index')->with('message','お問い合わせを送信しました');
  }
}
