<?php
/**
 * 投稿機能に関する処理を記述
 * 
 * @version 1.0
 * @author 小川英嗣 <xiaochuanyingsi@gmail.com>
 */

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\Storage;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

class PostController extends Controller
{
  /**
   * 記事一覧の表示。ホーム画面。
   *
   * @param Request $request
   * 
   * @var string $keyword 「検索」で入力された値
   * @var object $query
   * @var object $posts 
   * @return void
   */
  public function index(Request $request)
  {
    //キーワード受け取り
    $keyword = $request->input('keyword');

    //クエリ生成
    $query = Post::query();

    //もしキーワードがあったら
    if (isset($keyword)) {
      $query->where('title', 'like', '%' . $keyword . '%');
    }
    
    $posts = $query->orderBy('created_at', 'desc')
      ->paginate(10);
    
    // dd(gettype($keyword));
    return view('post.index', [
      'posts' => $posts,
      'keyword' => $keyword,
    ]);
  }

  /**
   * Undocumented function
   *
   * @return void
   */
  public function create()
  {
    $categories = Category::all();
    return view('post.create', compact('categories'));
  }

  /**
   * Undocumented function
   *
   * @param Request $request
   * @return void
   */
  public function store(Request $request)
  {
    $inputs = $request->validate([
      'title' => 'required|max:255',
      'body' => 'required|max:5000',
      'eyeCatchImage' => 'image',
      'newCategory_name' => ['name' => 'unique:Categories,name'],
    ]);

    //カテゴリー
    if ($request->category_id === "") {
      $request->category_id = 1;
    }
    if (isset($request->newCategory_name)) {
      $newCategory_name = $request->newCategory_name;
      $newCategory = Category::create(['name' => $newCategory_name]);
      $request->category_id = $newCategory->id;
    }
    $inputs['category_id'] = $request->category_id;

    //eyeCatchImage
    if ($request->file('eyeCatchImage')) {
      $original = $request->file('eyeCatchImage')
        ->getClientOriginalName();
      $name = date('Ymd_His') . '_' . $original;
      $request->file('eyeCatchImage')
        ->move('storage/eyeCatchImage/', $name);
      $inputs['eyeCatchImage'] = $name;
    }
    Post::create($inputs);
    return back()->with('message', '新規投稿を作成しました');
  }

  public function show(Post $post)
  {
    $category_posts = Post::where('category_id', $post->category->id)
      ->limit(2)
      ->get();
    $markdown = Markdown::parse($post->body);
    return view('post.show', [
      'post' => $post,
      'category_posts' => $category_posts,
      'markdown' => $markdown,
    ]);
  }

  /**
   * Undocumented function
   *
   * @param Post $post
   * @return void
   */
  public function edit(Post $post)
  {
    $categories = Category::all();
    return view('post.edit', compact('post', 'categories'));
  }
  /**
   * Undocumented function
   *
   * @param Request $request
   * @param Post $post
   * @return void
   */
  public function update(Request $request, Post $post)
  {
    $inputs = $request->validate([
      'title' => 'required|max:255',
      'body' => 'required|max:5000',
      'eyeCatchImage' => 'image',
      'newCategory_name' => ['name' => 'unique:Categories,name'],
    ]);

    //カテゴリー
    if ($request->category_id === "") {
      $request->category_id = 1;
    }
    if (isset($request->newCategory_name)) {
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

  public function delete(Request $request, Post $post)
  {
    if ($post->eyeCatchImage !== 'noImage.png') {
      Storage::disk('public')->delete('eyeCatchImage/' . $post->eyeCatchImage);
    }
    $post->delete();
    return redirect()->route('post.index')->with('message', '一つの投稿を削除しました');
  }

  public function categories(Category $category)
  {
    $posts = $category->posts()->get();
    $categories = Category::all();
    return view('post.categories', compact('posts', 'categories', 'category'));
    //$categoryはルートパラメータで渡してます。
  }

  public function getCategories()
  {
    return $categories = Category::all();
  }
}
