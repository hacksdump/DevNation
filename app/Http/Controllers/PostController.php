<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    public function getPost($post_id) {
        $post = Post::with('user')->find($post_id)->toArray();
        if($post)
            return view('post')->with('post', $post);
        abort(404);
    }

    public function showPostCreator() {
        if(Auth::check()) {
            return view('ask');
        }
        else {
            return Redirect::to('/login');
        }
    }

    public function createPost(Request $request) {
        if(Auth::check()) {
            $post = new Post;
            $post['question'] = $request->input('query');
            $post['user'] = Auth::id();
            $post->save();
            return Redirect::to('/');
        }
        else {
            return Redirect::to('/login');
        }
    }

    public static function getAllPosts() {
        $posts = Post::with('user')->orderBy('created_at', 'desc')->get()->toArray();
        return $posts;
    }

    public static function getAllPostsByUser($userId) {
        $posts = Post::where('user', $userId)->with('user')->orderBy('created_at', 'desc')->get()->toArray();
        return $posts;
    }


    ///// AJAX functions /////
    public function getAllAnswers($postId) {
        $answers = Answer::where('question', $postId)->with('user')->orderBy('created_at', 'desc')->get()->pluck('answer')->toArray();
        $answers = Answer::join('users', 'users.id', '=', 'answers.user')
            ->orderBy('answers.created_at', 'desc')
            ->get(['answers.answer', 'users.name']);
        echo json_encode($answers);
    }

    public function postAnswer(Request $request){
        if($request->ajax()) {
            if (Auth::check()) {
                $postData['answer'] = $request->post('answer');
                $postData['user'] = Auth::id();
                $postData['question'] = $request->post('question');
                Answer::create($postData);
                $this->getAllAnswers($postData['question']);
            }
        }
    }
}
