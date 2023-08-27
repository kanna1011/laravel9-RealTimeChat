<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ChatController extends Controller
{
    /**
     * @return View
     */
    public function index() : View
    {
        $posts = Post::all();
        return view('chat.index',[
            "posts" => $posts
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request) : JsonResponse
    {
        $post = new Post($request->all());
        $post->save();
        event(new MessageSent($post));

        return response()->json(['message' => '投稿しました。']);
    }
}
