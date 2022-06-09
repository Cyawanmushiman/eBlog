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

    public function user(){
      return $this->belongsTo('App\Models\User');
    }

    // public function comments(){
    //   return $this->hasMany('App\Models\Comment');
    // }

    public function category(){
      return $this->belongsTo('App\Models\Category');
    }

    //markdown
    public function parse() {
      //newでインスタンスを作る
      $parser = new Markdown();
      //bodyをパースする
      return $parser->parse($this->body);
    }
    public function getMarkBodyAttribute(){
      return $this->parse();
    }
}
