<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showProfile($username) {
        $user = User::where('username', $username)->first();
        $posts = PostController::getAllPostsByUser($user['id']);
        $user['self'] = false;
        if(Auth::check()){
            $user['self'] = ($username === Auth::user()->username);
        }
        $postCount = User::where('username', $username)->withCount('posts')->get()->toArray();
        $answerCount = User::where('username', $username)->withCount('answers')->get()->toArray();
        $stats = [
            'posts_count' => $postCount[0]['posts_count'],
            'answers_count' => $answerCount[0]['answers_count']
        ];
        return view('profile', ['user' => $user, 'posts' => $posts, 'stats' => $stats]);
    }

    public static function findUserByEmail($email){
        $user = User::where('email', $email)->first();
        return $user;
    }

    public static function findUserByUsername($username){
        $user = User::where('username', $username)->first();
        return $user;
    }

    public static function findUserByEmailOrUsername($emailOrUsername){
        $user = User::where('email', $emailOrUsername)->orWhere('username', $emailOrUsername)->first();
        return $user;
    }

    public static function userExists($emailOrUsername){
        $user = User::where('email', $emailOrUsername)->orWhere('username', $emailOrUsername)->first();
        if($user)
            return true;
        return false;
    }


}
