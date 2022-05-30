<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;



class PostController extends Controller
{
  public function index(Request $request)
  {
    $keyword = $request->input('keyword');
    $query = Post::query();
    if(!empty($keyword)) {
      $query->where('title','like','%'.$keyword.'%');
    }
    $posts = $query->orderBy('created_at', 'desc')->paginate(10);
    $categories = Category::all();
    return view('post.index', compact('posts','categories'));
  }

  public function create()
  {
    $categories = Category::all();
    return view('post.create',compact('categories'));
  }

  public function store(Request $request)
  {
    $inputs = $request->validate([
      'title' => 'required|max:255',
      'body' => 'required|max:5000',
      'eyeCatchImage' => 'image|max:5120',
      'newCategory_name' => ['name' => 'unique:Categories,name'],
    ]);

    //カテゴリー
    if($request->category_id == ""){
      $request->category_id = 1;
    }
    if($request->has('newCategory_name')){
      $newCategory_name = $request->newCategory_name;
      $newCategory = Category::create(['name' => $newCategory_name]);
      $request->category_id = $newCategory->id;
    }
    $inputs['category_id'] = $request->category_id;

    //eyeCatchImage
    if ($request->file('eyeCatchImage')) {
      $original = $request->file('eyeCatchImage')->getClientOriginalName();
      $name = date('Ymd_His') . '_' . $original;
      $request->file('eyeCatchImage')->move('storage/eyeCatchImage/', $name);

      $inputs['eyeCatchImage'] = $name;
    }
    Post::create($inputs);
    return back()->with('message', '新規投稿を作成しました');
  }

  public function show(Post $post)
  {
    $category_posts = Post::where('category_id',$post->category->id)
      ->limit(2)
      ->get();
    return view('post.show', compact('post','category_posts'));
  }

  public function edit(Post $post)
  {
    $categories = Category::all();
    return view('post.edit', compact('post','categories'));
  }

  public function update(Request $request, Post $post)
  {
    $inputs = $request->validate([
      'title' => 'required|max:255',
      'body' => 'required|max:5000',
      'eyeCatchImage' => 'image|max:5120',
      'newCategory_name' => ['name' => 'unique:Categories,name'],
    ]);

    //カテゴリー
    // dd($request->has('newCategory_name'));
    // dd(isset($request->newCategory_name));

    if($request->category_id == ""){
      $request->category_id = 1;
    }
    if(isset($request->newCategory_name)){
      $newCategory_name = $request->newCategory_name;
      $newCategory = Category::create(['name' => $newCategory_name]);
      $request->category_id = $newCategory->id;
    }
    $inputs['category_id'] = $request->category_id;

    //eyeCatchImage
    if ($request->file('eyeCatchImage')) {
      if ($post->eyeCatchImage !== 'noImage.png') {
        Storage::disk('public')->delete('eyeCatchImage/' . $post->eyeCatchImage);
      }
      $original = $request->file('eyeCatchImage')->getClientOriginalName();
      $name = date('Ymd_His') . '_' . $original;
      $request->file('eyeCatchImage')->move('storage/eyeCatchImage/', $name);

      $inputs['eyeCatchImage'] = $name;
    }

    $post->update($inputs);
    return back()->with('message', '投稿を更新しました');
  }

  public function delete(Request $request,Post $post){
    if($post->eyeCatchImage !== 'noImage.png'){
      Storage::disk('public')->delete('eyeCatchImage/'.$post->eyeCatchImage);
    }
    $post->delete();
    return redirect()->route('post.index')->with('message','一つの投稿を削除しました');
  }

  public function categories(Category $category){
    $posts = $category->posts()->get();
    $categories = Category::all();
    return view('post.categories',compact('posts','categories','category'));
    //$categoryはルートパラメータで渡してます。
  }
}
