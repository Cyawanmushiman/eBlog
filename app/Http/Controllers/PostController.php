<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
  public function index(){
    $posts = Post::orderBy('created_at','desc')->get();
    return view('post.index',compact('posts'));
  }

  public function create(){
    return view('post.create');
  }

  public function store(Request $request,Post $post){
    $inputs = $request->validate([
      'title' => 'required|max:255',
      'body' => 'required|max:5000',
      'eyeCatchImage' => 'image|max:5120',
    ]);

    if($request->file('eyeCatchImage')){
      $original = $request->file('eyeCatchImage')->getClientOriginalName();
      $name = date('Ymd_His').'_'.$original;
      $request->file('eyeCatchImage')->move('storage/eyeCatchImage/',$name);

      $inputs['eyeCatchImage'] = $name;
    }

    Post::create($inputs);
    return back()->with('message','新規投稿を作成しました');
  }

  public function show(Post $post){
    return view('post.show',compact('post'));
  }

  public function edit(Post $post){
    return view('post.edit',compact('post'));
  }

  public function update(Request $request, Post $post){
    $inputs = $request->validate([
      'title' => 'required|max:255',
      'body' => 'required|max:5000',
      'eyeCatchImage' => 'image|max:5120',
    ]);

    if($request->file('eyeCatchImage')){
      if($post->eyeCatchImage !== 'noImage.jpg'){
        Storage::disk('public')->delete('eyeCatchImage/'.$post->eyeCatchImage);
      }
      $original = $request->file('eyeCatchImage')->getClientOriginalName();
      $name = date('Ymd_His').'_'.$original;
      $request->file('eyeCatchImage')->move('storage/eyeCatchImage/',$name);

      $inputs['eyeCatchImage'] = $name;
    }

    $post->update($inputs);
    return back()->with('message','投稿を更新しました');
  }
}

