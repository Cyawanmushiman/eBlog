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
  public function newContact(){
    return view('contact.newContact');
  }

  /**
   * 内容確認ページ
   *
   * @param Request $request
   * @return void
   */
  public function contactConfirm(ContactRequest $request){
    return view('contact.contactConfirm',[
        'inputs' => $request->all(),
    ]);
  }

  public function contactSend(ContactRequest $request){
    $inputs = $request->all();

    if(isset($inputs['back'])){
      return redirect()->route('contact.newContact')->withInput($inputs);
    }

    Mail::to(config('mail.admin'))->send(new ContactForm($inputs));
    Mail::to($inputs['email'])->send(new ContactForm($inputs));

    //送信ボタン連打攻撃対策
    $request->session()->regenerateToken();

    return redirect()->route('post.postList')->with('message','お問い合わせを送信しました');
  }
}
