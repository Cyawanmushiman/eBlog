<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactForm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inputs)
    {
      $this->inputs = $inputs;
      //inputsプロパティにフォームの送信内容をセットして、後から自由に使えるようにする。
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->view('contact.mail')->with(['inputs' => $this->inputs])->subject('お問い合わせを受け付けました');
        //contactフォルダのmail.blade.phpにフォームで送信された内容と、メールの件名を保持させたまま表示。
    }
}
