<?php

namespace App\Http\Controllers;

use App\Models\Post;

class AboutController extends Controller
{
    /**
     * 自己紹介ページ
     *
     * @var object $posts categoriesテーブルの「nameカラムの値が[実績]」のデータに紐ずく投稿を取得する
     *
     * @return void
     */
    public function aboutShow()
    {
        return view('about.aboutShow', [
            'posts' => Post::whereHas('category', function ($q) {
                $q->where('name', '実績');
            })->get(),
        ]);
    }
}
