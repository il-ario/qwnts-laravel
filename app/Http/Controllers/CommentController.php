<?php

namespace App\Http\Controllers;

use App\Http\Resources\Comment as CommentResource;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function index(int $id)
    {
        $post = Post::where('id', $id)->first();

        return response(CommentResource::collection($post->comments), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $id)
    {
        $validated = $this->validator($request);

        if (! $validated instanceof MessageBag) {
            $comment = new Comment;

            $comment->text = $validated['text'];
            $comment->post_id = $id;
            $comment->user_id = auth('api')->user();

            $comment->save();
    
            return response(new CommentResource($comment), 200);
        } else {
            return response($validated, 422);
        }
    }

    /**
     * Custom validator.
     * 
     * @param  Request $request
     * @return \Illuminate\Support\Facades\Validator
     */
    public function validator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required'
        ]);
 
        if ($validator->fails()) {
            return $validator->errors();
        }

        return $validator->validated();
    }
}
