<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favoritos = auth()->user()->favorites;    
        return response()->json([
            'success' => true,
            'data'    => $favoritos
        ], 200);
    }

    public function favorite($id)
    {
            if (Favorite::where('user_id',auth()->user()->id)->where('id_peliserie', $id )->first()){
                return response()->json([
                    'success'  => false,
                    'message' => "ERROR you can't put in favourite the same movie/serie two times"
                ], 500);
            }else{
                $favorite = Favorite::create([
                    'user_id' => auth()->user()->id,
                    'id_peliserie' => $id,
                ]);
                return response()->json([
                    'success' => true,
                    'data'    => "Favourited successfully"
                ], 200);
            }


    }
    public function unfavorite($id)
    {
        if (Favorite::where('user_id',auth()->user()->id)->where('id_peliserie', $id )->first()){
            Favorite::where('user_id',auth()->user()->id)
                    ->where('id_peliserie', $id )->delete();
            return response()->json([
                'success' => true,
                'data'    => "Unfavorited successfully"
            ], 200);
        }else{
            return response()->json([
                'success'  => false,
                'message' => "ERROR you don't put in favorite this movie/serie yet"
            ], 500);
        };
    }
}
