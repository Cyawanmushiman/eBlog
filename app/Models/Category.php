<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    //DB操作
    /**
     * 指定したidに一致するカテゴリーデータを返す
     *
     * @param integer $id
     * @return object
     */
    public function getOneCategory(int $id): object
    {
        return $this->where('id',$id)->first();
    }

    /**
     * DBに新しいカテゴリーを追加する
     *
     * @param string $newCategoryName
     * @return object
     */
    public function createCategory(string $newCategoryName): object
    {
        return $this->create(['name' => $newCategoryName]);
    }

    /**
     * 全てのカテゴリーを取得する
     *
     * @return object
     */
    public function getAllCategories(): object
    {
        return $categories = $this->all();
    }

    /**
     * カテゴリーに紐づいた投稿を全て取得する
     *
     * @return object
     */
    public function getCategoryPosts(): object
    {
        $posts = $this->posts()->get();
        return $posts;
    }

    /**
     * カテゴリーを削除する
     *
     * @return void
     */
    public function categoryDelete()
    {
        return $this->delete();
    }
}
