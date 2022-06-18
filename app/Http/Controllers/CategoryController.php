<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
   * カテゴリー一覧ページ
   *
   * @param Category $category ルートパラメータから取得
   * 
   * @var object $posts カテゴリーに紐づく投稿データ
   * @var object $category URLパラメータで渡されたカテゴリーのレコード
   * @return void
   */
  public function index(Category $category)
  {
    $posts = $category->posts()->get();
    return view('category.index', [
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

  /**
   * カテゴリー削除（紐づく投稿はその他に分類）
   *
   * @param Category $category sidebarのルートパラメータから取得
   * 
   * @var object $posts カテゴリーに紐づく投稿データ
   * 
   * @return void
   */
  public function delete(Category $category){
    $posts = $category->posts()->get();
    dd(gettype($posts));
    foreach($posts as $post){
      $post->update(['category_id' => 1]);
    }

    $category->posts()->delete();
    $category->delete();
    return redirect()->route('post.index')->with('message','カテゴリーを削除しました。（紐ずく投稿のカテゴリーはその他に変更しました。）');
  }
}
