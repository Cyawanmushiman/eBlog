<?php

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
    public function getOneCategory($id)
    {
        return $this->where('id',$id)->first();
    }
    
    public function createCategory($newCategoryName)
    {
        return $this->create(['name' => $newCategoryName]);
    }

    public function getAllCategories()
    {
        return $categories = $this->all();
    }

    public function getCategoryPosts()
    {
        $posts = $this->posts()->get();
        return $posts;
    }

    public function categoryDelete()
    {
        return $this->delete();
    }
}
