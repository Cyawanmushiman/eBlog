<?php

declare(strict_types=1);

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

  public function category()
  {
    return $this->belongsTo('App\Models\Category');
  }


  //DB操作
  /**
   * 指定したidと一致する投稿データを取得する
   *
   * @param integer $id
   * @return object
   */
  public function getOnePost(int $id): object
  {
    return $this->where('id', $id)->first();
  }

  /**
   * 検索されたワードに一致する投稿データを取得する(ページネーションも兼ねる)
   *
   * @param mixed $keyword
   * @return object
   */
  public function getPaginateSearchPosts(mixed $keyword): object
  {
    $query = $this->query();
    if (isset($keyword)) {
      $query = $query->where('title', 'like', '%' . $keyword . '%');
    }

    $posts = $query->orderBy('created_at', 'desc')
      ->paginate(10);

    return $posts;
  }

  /**
   * DBに指定した配列を保存する
   *
   * @param array $inputs
   * @return object
   */
  public function createPost(array $inputs): object
  {
    return $this->create($inputs);
  }


  /**
   * 指定したカテゴリーのカラム名、カラムの値に紐ずく投稿データを全て取得する
   *
   * @param string $columnName
   * @param string $columnValue
   * @return object
   */
  public function getRelationPosts(string $columnName, string $columnValue): object
  {
    $relationPosts = $this->whereHas('category', function ($q) use ($columnName, $columnValue) {
      $q->where($columnName, $columnValue);
    })->get();

    return $relationPosts;
  }

  /**
   * 関連記事取得(除く記事のid,関連カテゴリーのid、取得する記事の上限を指定)
   *
   * @param integer $id
   * @param integer $postCategoryId
   * @param integer $value
   * @return object
   */
  public function getRelatedPosts(int $id, int $postCategoryId, int $value): object
  {
    $relatedPosts = $this->where('id', '!=', $id)
      ->where('category_id', $postCategoryId)
      ->limit($value)
      ->get();

    return $relatedPosts;
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
}
