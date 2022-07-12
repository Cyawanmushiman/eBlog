<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;

class AboutController extends Controller
{
    public function aboutShow(Post $post)
    {
        return view('about.aboutShow', [
            'posts' => $post->getRelationPosts('name', '実績'),
        ]);
    }
}
