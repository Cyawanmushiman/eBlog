<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    private $category;
    public function __construct(Category $category)
    {
        $this->category = $category;
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
  public function categoryPosts(int $categoryId)
  {
    $oneCategory = $this->category->getOneCategory($categoryId);
    return view('category.categoryPosts', [
      'posts' => $oneCategory->getCategoryPosts(),
      'category' => $oneCategory,
    ]);
  }

  /**
   * カテゴリー削除（紐づく投稿はその他に分類）
   *
   * @param Category $category sidebarのルートパラメータから取得
   *
   * @var object $posts カテゴリーに紐づく投稿データ達
   *
   * @return void
   */
  public function categoryDelete(int $categoryId){
    $oneCategory = $this->category->getOneCategory($categoryId);
    $posts = $oneCategory->getCategoryPosts();
    foreach($posts as $post){
      $post->update(['category_id' => 1]);
    }

    $oneCategory->categoryDelete();
    return redirect()->route('post.postList')->with([
        'message' => 'カテゴリーを削除しました。（紐ずく投稿のカテゴリーはその他に変更しました。）',
        'status' => 'alert',
    ]);
  }
}
