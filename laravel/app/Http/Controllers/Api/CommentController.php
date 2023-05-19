<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function comment(Request $request, Post $post){
        $validatedData = $request->validate([
            'pcomment'  => 'required',
        ]);
        $repetido = Comment::where('user_id',auth()->user()->id)->where('id_peliserie', $post->id )->where('comment',$request->input('pcomment'))->first();
        if ($repetido){
            return redirect()->route('details', $post)
            ->with('error', __('fpp.post-comment-error'));
        }else{
            $comment = Comment::create([
                'user_id' => auth()->user()->id,
                'id_peliserie' => $post->id,
                'comment' =>$request->input('pcomment'),
            ]);
            return redirect()->back()
            ->with('success', __('fpp.post-comment'));
        }
    }

    public function uncomment(Post $post, Comment $comment){
        if ($post->user_id == auth()->user()->id || auth()->user()->hasRole(['admin']) || $comment->user_id == auth()->user()->id ){
            $comment->delete();
            return redirect()->route('posts.show', $post)
                ->with('success', __('fpp.post-uncomment'));
        }else{
            return redirect()->route('posts.show', $post)
            ->with('error', __('fpp.post-uncomment-error'));
        }
    }
}
