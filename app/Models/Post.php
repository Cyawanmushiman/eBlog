<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use cebe\markdown\Markdown as Markdown;


class Post extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // public function comments(){
    //   return $this->hasMany('App\Models\Comment');
    // }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    //markdown
    public function parse()
    {
        //newでインスタンスを作る
        $parser = new Markdown();
        //bodyをパースする
        return $parser->parse($this->body);
    }
    public function getMarkBodyAttribute()
    {
        return $this->parse();
    }

    //ページネーションと検索機能付きの投稿データ取得
    public function getPaginateSearchPosts($keyword)
    {
        $query = $this->query();
        if (isset($keyword)) {
            $query = $query->where('title', 'like', '%' . $keyword . '%');
        }

        $posts = $query->orderBy('created_at', 'desc')
                        ->paginate(10);

        return $posts;
    }

    // public function getPaginatePosts($sortColumn, $sortOrder, $value)
    // {
    //     $query = $this->query();
    // }

    //postsテーブルに保存
    public function createPost($inputs)
    {
        return $this->create($inputs);
    }

    //カテゴリー「実績」に紐ずく投稿データを取得
    public function getRelationPosts($relation, $columnName, $columnValue)
    {
        $relationPosts = $this->whereHas($relation, function ($q) use ($columnName, $columnValue) {
            $q->where($columnName, $columnValue);
        })->get();

        return $relationPosts;
    }

    //関連記事取得(除く記事のid,関連カテゴリーのid、取得する記事の上限を指定)
    public function getRelatedPosts($id,$postCategoryId,$value)
    {
        $relatedPosts = $this->where('id', '!=', $id)
                ->where('category_id', $postCategoryId)
                ->limit($value)
                ->get();

        return $relatedPosts;
    }

}
