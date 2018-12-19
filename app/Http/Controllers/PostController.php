<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\AnswerUpvote;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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
            if(empty($post['question'] = $request->input('query'))){
                die('error');
            }
            $uploadedImageFile = $request->file('uploadImage');
            $uploadedCodeFile = $request->file('uploadCode');
            if($uploadedImageFile) {
                $storedFilePath = $uploadedImageFile->store('testuploads', ['disk' => 'public']);
                $post['image'] = $storedFilePath;
            }
            $languageSelection = $request->input('language');
            if($languageSelection && $languageSelection !== 'none'){
                $post['language'] = $request->input('language');
                if($uploadedCodeFile){
                    $post['code_snippet'] = file_get_contents($uploadedCodeFile);
                }
                else if($code = $request->input('code')){
                    $post['code_snippet'] = $code;
                }
            }
            $post['user'] = Auth::id();
            $post->save();
            return Redirect::to('/');
        }
        else {
            return Redirect::to('/login');
        }
    }

    public static function getAllPosts() {
        $posts = Post::with('user')->withCount('answers')->orderBy('created_at', 'desc')->get()->toArray();
        return $posts;
    }

    public static function listAllWithTag($tag) {
        $posts = Post::with('user')
            ->withCount('answers')
            ->where('queries.language', '=', $tag)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
        return view('tag')->with('posts', $posts)->with('tag', $tag);
    }

    public static function getAllPostsByUser($userId) {
        $posts = Post::where('user', $userId)->with('user')->withCount('answers')->orderBy('created_at', 'desc')->get()->toArray();
        return $posts;
    }


    ///// AJAX functions /////
    public function getAllAnswers($postId) {
        $answers = Answer::join('users', 'users.id', '=', 'answers.user')
            ->orderBy('answers.upvotes', 'desc')
            ->orderBy('answers.created_at', 'desc')
            ->where('answers.question', '=', $postId)
            ->get(['answers.id', 'answers.answer', 'answers.upvotes', 'users.name']);
        foreach ($answers as &$answer){
            $prevUpvote = AnswerUpvote::where('answer_id', $answer['id'])->where('user_id', Auth::id())->first();
            if($prevUpvote){
                $answer['hasUpvoted'] = 1;
            }
            else{
                $answer['hasUpvoted'] = 0;
            }
        }
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

    public function upvoteAnswer(Request $request){
        if($request->ajax()) {
            if (Auth::check()) {
                $postData['answer_id'] = $request->post('answer_id');
                $postData['user_id'] = Auth::id();
                $prevUpvote = AnswerUpvote::where('answer_id', $postData['answer_id'])->where('user_id', Auth::id())->first();
                if($prevUpvote){
                    AnswerUpvote::destroy($prevUpvote['id']);
                    Answer::find($postData['answer_id'])->decrement('upvotes');
                    $result = -1;
                }
                else {
                    AnswerUpvote::create($postData);
                    Answer::find($postData['answer_id'])->increment('upvotes');
                    $result = 1;
                }
                echo json_encode(['result' => $result]);

            }
        }
    }
}
