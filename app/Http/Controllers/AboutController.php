<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class AboutController extends Controller
{
  public function index(){
    $posts = Post::whereHas('category',function($q) {
      $q->where('name','実績');
    })->get();
    return view('about.index',[
      'posts' => $posts,
    ]);
  }
}
