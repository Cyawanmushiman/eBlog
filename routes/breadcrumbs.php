<?php 
// Home
Breadcrumbs::for('home', function ($trail) {
  $trail->push('Home',route('post.index'));
});

//Home > Contact
Breadcrumbs::for('contact',function ($trail) {
  $trail->parent('home');
  $trail->push('Contact',route('contact.create'));
});

//Home > Contact > confirm
Breadcrumbs::for('confirm', function ($trail) {
  $trail->parent('contact');
  $trail->push('入力内容確認',route('contact.confirm'));
});

//Home > New Post
Breadcrumbs::for('newPost',function($trail) {
  $trail->parent('home');
  $trail->push('New Post',route('post.create'));
});

//Home > Category
Breadcrumbs::for('category',function ($trail,$category) {
  $trail->parent('home');
  $trail->push($category->name, route('post.categories',['category'=>$category]));
});

//Home > show
Breadcrumbs::for('show', function ($trail,$post) {
  $trail->parent('home');
  $trail->push($post->title, route('post.show',['post'=>$post]));
});

//Home > show > edit
Breadcrumbs::for('edit', function ($trail,$post) {
  $trail->parent('show',$post);
  $trail->push('編集',route('post.edit',['post' => $post]));
});

//Home > about
Breadcrumbs::for('about',function ($trail) {
  $trail->parent('home');
  $trail->push('About',route('about.index'));
});

