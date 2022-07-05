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
    /**
     * 記事一覧の表示。ホーム画面。
     *
     * @param Request $request
     *
     * @var mixed $keyword 「検索」で入力された値
     *
     * @return void
     */
    public function postList(Request $request)
    {
        //キーワード受け取り
        $keyword = $request->input('keyword');
        $query = Post::query();

        //もしキーワードがあったら
        if (isset($keyword)) {
            $query = $query->where('title', 'like', '%' . $keyword . '%');
        }

        return view('post.postList', [
            'posts' => $query->orderBy('created_at', 'desc')
                ->paginate(10),
            'keyword' => $keyword,
        ]);
    }

    /**
     * 新規投稿の表示
     *
     * @return void
     */
    public function newPost()
    {
        return view('post.newPost', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * 新規投稿からのpostデータをデータベースに登録
     *
     * @param PostRequest $request フォームリクエスト
     *
     * @return void
     */
    public function postKeep(PostRequest $request ,Category $category)
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
                $newCategory = $category->createCategory($newCategoryName);
                $inputs['category_id'] = $newCategory->id;
            }

            //eyeCatchImage
            if (isset($inputs['eyeCatchImage'])) {
                $name = ImageService::upload($inputs['eyeCatchImage'],'eyeCatchImage');
                $inputs['eyeCatchImage'] = $name;
            }

            Post::create($inputs);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('message', '新規投稿に失敗しました');
        }

        return back()->with('message', '新規投稿を作成しました');
    }

    /**
     * 投稿記事の個別ページ
     *
     * @param Post $post 一覧画面より、選択した投稿のデータ
     *
     * @var object $category_posts  詳細ページと同じカテゴリーidを持つ投稿データ達
     * @var object $markdown
     *
     * @return void
     */
    public function postShow(Post $post)
    {
        return view('post.postShow', [
            'post' => $post,
            'categoryPosts' => Post::where('id', '!=', $post->id) # Postテーブルの投稿idが一致しないデータ
                ->where('category_id', $post->category->id) # かつ、カテゴリーidが一致するデータ
                ->limit(2) # 2件
                ->get(), #取得
            'markdown' => Markdown::parse($post->body),
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
    public function postEdit(Post $post)
    {
        return view('post.postEdit', [
            'post' => $post,
            'categories' => Category::all(),
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
    public function postUpdate(PostRequest $request, Post $post)
    {
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
                $newCategory = Category::create(['name' => $newCategoryName]);
                $inputs['category_id'] = $newCategory->id;
            }

            //eyeCatchImage
            if (isset($inputs['eyeCatchImage'])) {
                if ($post->eyeCatchImage !== 'noImage.png') {
                    Storage::disk('public')->delete('eyeCatchImage/' . $post->eyeCatchImage);
                }
                $name = ImageService::upload($inputs['eyeCatchImage'],'eyeCatchImage');
                $inputs['eyeCatchImage'] = $name;
            }

            $post->update($inputs);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('message', '投稿の更新に失敗しました');
        }

        return back()->with('message', '投稿を更新しました');
    }

    /**
     * 投稿削除
     *
     * @param Post $post
     *
     * @return void
     */
    public function postDelete(Post $post)
    {
        if ($post->eyeCatchImage !== 'noImage.png') {
            Storage::disk('public')->delete('eyeCatchImage/' . $post->eyeCatchImage);
        }
        $post->delete();
        return redirect()->route('post.postList')->with('message', '一つの投稿を削除しました');
    }
}
