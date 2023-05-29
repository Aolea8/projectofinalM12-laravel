<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;


class CommentController extends Controller
{

    public function comments($id)
    {
        $comments = Comment::where('id_peliserie', $id)->with('user')->get();
        return response()->json([
            'success' => true,
            'data'    => $comments
        ], 200);
    }

    public function comment($id, Request $request){
        $validatedData = $request->validate([
            'comment'  => 'required|string',
        ]);
        if (Comment::where('user_id',auth()->user()->id)->where('id_peliserie', $id )->first()){
            return response()->json([
                'success'  => false,
                'message' => "ERROR you can't comment the same post two timest"
            ], 500);
        }else{
            $comment = Comment::create([
                'user_id' => auth()->user()->id,
                'id_peliserie' => $id,
                'comment' =>$request->input('comment'),
            ]);
            return response()->json([
                'success' => true,
                'data'    => $comment,
            ], 201);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function uncomment($id){
        $comment = Comment::find($id);
        if ($comment){
            if ( $comment->user_id == auth()->user()->id ){
                $comment->delete();
                return response()->json([
                    'success' => true,
                    'data'    => "Comment deleted successfully"
                ], 200);
            }else{
                return response()->json([
                    'success'  => false,
                    'message' => "ERROR, you can not delete a comment that is not yours"
                ], 500);
            }
        }else{
            return response()->json([
                'success'  => false,
                'message' => "Comment not found"
            ], 404);
        }
    }
}