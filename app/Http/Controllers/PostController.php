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
   * @var object $query $keywordに一致する投稿データが入る
   * @var object $posts 最新の日付順に整列させたデータが入る
   * @return array 投稿データ キーワード
   */
  public function index(Request $request)
  {
    //キーワード受け取り
    $keyword = $request->input('keyword');

    //もしキーワードがあったら
    if (isset($keyword)) {
      $query = Post::where('title', 'like', '%' . $keyword . '%');
    }else{
      $query = Post::query();
    }
    
    $posts = $query->orderBy('created_at', 'desc')
      ->paginate(10);
    
    return view('post.index', [
      'posts' => $posts,
      'keyword' => $keyword,
    ]);
  }

  /**
   * 新規投稿の表示
   *
   * @var object $categories カテゴリーテーブルの全データ
   * @return array $categories カテゴリーテーブルの全データ
   */
  public function create()
  {
    $categories = Category::all();
    return view('post.create', [
      'categories' => $categories,
    ]);
  }

  /**
   * 新規投稿からのpostデータをデータベースに登録
   *
   * @param Request $request
   * 
   * @var array $inputs postデータにバリデーションをかけて代入
   * @var string $newCategory_name 新しく追加するカテゴリー名 
   * @var object $newCategory 新しく追加したカテゴリーのデータ
   * @var string $original 画像ファイルの元々のファイル名
   * @var string $name 元々のファイル名に年月日時分秒を追加したファイル名
   * @return void
   */
  public function store(Request $request)
  {
    $inputs = $request->validate([
      'title' => 'required|max:255',
      'body' => 'required|max:5000',
      'eyeCatchImage' => 'image',
      'newCategory_name' => ['name' => 'unique:categories,name'],
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
        ->move('storage/public/eyeCatchImage/', $name);
      $inputs['eyeCatchImage'] = $name;
    }
    Post::create($inputs);
    return back()->with('message', '新規投稿を作成しました');
  }

  /**
   * 投稿記事の個別ページ
   *
   * @param Post $post 一覧画面で選択した投稿のデータ
   * 
   * @var object $category_posts 同じカテゴリーに属する投稿データ
   * @var object $markdown
   * 
   * @return void
   */  
  public function show(Post $post)
  {
    $category_posts = Post::where('id','!=',$post->id)
      ->where('category_id', $post->category->id)
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
   * 投稿編集ページ
   *
   * @param Post $post 一覧画面で選択した投稿データ
   * 
   * @var object $categories カテゴリーテーブルの全データ
   * @return void
   */
  public function edit(Post $post)
  {
    $categories = Category::all();
    return view('post.edit', compact('post', 'categories'));
  }

  /**
   * 
   *
   * @param Request $request
   * @param Post $post
   * 
   * @var array $inputs postデータにバリデーションをかけて代入
   * @var string $newCategory_name 新しく追加するカテゴリー名 
   * @var object $newCategory 新しく追加したカテゴリーのデータ
   * @var string $original 画像ファイルの元々のファイル名
   * @var string $name 元々のファイル名に年月日時分秒を追加したファイル名
   *
   * @return void
   */
  public function update(Request $request, Post $post)
  {
    $inputs = $request->validate([
      'title' => 'required|max:255',
      'body' => 'required|max:5000',
      'eyeCatchImage' => 'image',
      'newCategory_name' => ['name' => 'unique:categories,name'],
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
      $request->file('eyeCatchImage')->move('storage/public/eyeCatchImage/', $name);

      $inputs['eyeCatchImage'] = $name;
    }

    $post->update($inputs);
    return back()->with('message', '投稿を更新しました');
  }

  /**
   * 投稿削除
   *
   * @param Request $request
   * @param Post $post
   * 
   * 
   * @return void
   */
  public function delete(Request $request, Post $post)
  {
    if ($post->eyeCatchImage !== 'noImage.png') {
      Storage::disk('public')->delete('eyeCatchImage/' . $post->eyeCatchImage);
    }
    $post->delete();
    return redirect()->route('post.index')->with('message', '一つの投稿を削除しました');
  }

  /**
   * カテゴリー一覧ページ
   *
   * @param Category $category ルートパラメータから取得
   * 
   * @var object $posts カテゴリーに紐づく投稿データ
   * @var object $category URLパラメータで渡されたカテゴリーのレコード
   * @return void
   */
  public function categories(Category $category)
  {
    $posts = $category->posts()->get();
    return view('post.categories', [
      'posts' => $posts,
      'category' => $category,
    ]);
  }

  /**
   * 全カテゴリーデータを返すメソッド
   * 
   * bladeの@injectで使用する目的
   *
   * @return object $categories
   */
  public function getCategories()
  {
    return $categories = Category::all();
  }
}
