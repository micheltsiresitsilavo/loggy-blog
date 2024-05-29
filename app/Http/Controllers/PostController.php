<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
     $posts  = Post::with([

        'media'
     ])->latest()->get();
    //  dd($posts);
    return view('posts.index', ['posts' => $posts]);
    }

    public function show(Post $id) {
     $post  = Post::with(['category', 'media'])->get()->find($id);
    //  dd($post);
    return view('posts.show', ['post' => $post]);
    }
}
