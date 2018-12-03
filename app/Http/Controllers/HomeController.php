<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $posts = PostController::getAllPosts();
        return view('home')->with('posts', $posts);
    }

    public function redirectToHome()
    {
        return redirect('/');
    }
}
