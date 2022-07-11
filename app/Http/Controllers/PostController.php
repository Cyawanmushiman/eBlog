<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use App\Http\Requests\PostRequest;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
  private $post;
  private $category;
  public function __construct(Post $post, Category $category)
  {
    $this->post = $post;
    $this->category = $category;
  }


  /**
   * 記事一覧の表示。ホーム画面。
   * @param Request $request
   * @var mixed $keyword 「検索」で入力された値
   * @return void
   */
  public function postList(Request $request)
  {
    //キーワード受け取り
    $keyword = $request->input('keyword');

    return view('post.postList', [
      'posts' => $this->post->getPaginateSearchPosts($keyword),
      'keyword' => $keyword,
    ]);
  }

  /**
   * 新規投稿の表示
   * @return void
   */
  public function newPost()
  {
    return view('post.newPost', [
      'categories' => $this->category->getAllCategories(),
    ]);
  }

  /**
   * 新規投稿からのpostデータをデータベースに登録
   * @param PostRequest $request フォームリクエスト
   * @return void
   */
  public function postKeep(PostRequest $request)
  {
    $inputs = $request->all();
    $newCategoryName = $inputs['newCategoryName'];

    //カテゴリー未選択の場合
    if (empty($inputs['category_id'])) {
      $inputs['category_id'] = 1;
    }

    try {
      DB::beginTransaction();
      //「新しいカテゴリー」を指定している場合
      if (isset($newCategoryName)) {
        $newCategory = $this->category->createCategory($newCategoryName);
        $inputs['category_id'] = $newCategory->id;
      }

      //eyeCatchImage
      if (isset($inputs['eyeCatchImage'])) {
        $name = ImageService::upload($inputs['eyeCatchImage'], 'eyeCatchImage');
        $inputs['eyeCatchImage'] = $name;
      }

      $this->post->createPost($inputs);
      DB::commit();
    } catch (Exception $e) {
      DB::rollBack();
      return back()->with([
        'message' => '新規投稿に失敗しました',
        'status' => 'alert',
      ]);
    }

    return back()->with([
      'message' => '新規投稿を作成しました',
      'status' => 'info',
    ]);
  }

  /**
   * 投稿記事の個別ページ
   * @var object $category_posts  詳細ページと同じカテゴリーidを持つ投稿データ達
   * @var object $markdown
   */
  public function postShow(int $postId)
  {
    $onePost = $this->post->getOnePost($postId);
    return view('post.postShow', [
      'post' => $onePost,
      'relatedPosts' => $onePost->getRelatedPosts($postId, $onePost->category_id, 2),
      'markdown' => Markdown::parse($onePost->body),
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
  public function postEdit(int $postId)
  {
    $onePost = $this->post->getOnePost($postId);
    return view('post.postEdit', [
      'post' => $onePost,
      'categories' => $this->category->getAllCategories(),
    ]);
  }

  /**
   *  更新
   *
   * @param PostRequest $request
   * @param Post $post
   *
   * @return void
   */
  public function postUpdate(PostRequest $request, int $postId)
  {
    $onePost = $this->post->getOnePost($postId);
    $inputs = $request->all();
    $newCategoryName = $inputs['newCategory_name'];

    //カテゴリー
    if ($inputs['category_id'] === "") {
      $inputs['category_id'] = 1;
    }

    try {
      DB::beginTransaction();

      //新しいカテゴリーが入っていたら
      if (isset($newCategoryName)) {
        $newCategory = $this->category->createCategory($newCategoryName);
        $inputs['category_id'] = $newCategory->id;
      }

      //eyeCatchImage
      if (isset($inputs['eyeCatchImage'])) {
        if ($onePost->eyeCatchImage !== 'noImage.png') {
          Storage::disk('public')->delete('eyeCatchImage/' . $onePost->eyeCatchImage);
        }
        $name = ImageService::upload($inputs['eyeCatchImage'], 'eyeCatchImage');
        $inputs['eyeCatchImage'] = $name;
      }

      $onePost->update($inputs);
      DB::commit();
    } catch (Exception $e) {
      DB::rollBack();
      return back()->with([
        'message' => '投稿の更新に失敗しました',
        'status' => 'alert',
      ]);
    }

    return back()->with([
      'message' => '投稿を更新しました',
      'status' => 'info',
    ]);
  }

  /**
   * 投稿削除
   *
   * @param Post $post
   *
   * @return void
   */
  public function postDelete(int $postId)
  {
    $onePost = $this->post->getOnePost($postId);
    if ($onePost->eyeCatchImage !== 'noImage.png') {
      Storage::disk('public')->delete('eyeCatchImage/' . $onePost->eyeCatchImage);
    }
    $onePost->delete();
    return redirect()->route('post.postList')->with([
      'message' => '一つの投稿を削除しました。',
      'status' => 'alert',
    ]);
  }
}
