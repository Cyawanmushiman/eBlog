<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $body = 'この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。';

      for ($i = 1; $i<=13 ; $i++){
        $post = new Post;
        $post->title = "$i 番目の投稿";
        $post->body = $body;
        $post->category_id = 1;
        $post->save();
      }

      $cat1 = new Category;
      $cat1->name = "その他";
      $cat1->save();

      $cat2 = new Category;
      $cat2->name = "Laravel";
      $cat2->save();
    }
}
