<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function favorite($id)
    {
            $favorite = Favorite::create([
                'category_id'=>$id,
                'user_id'=>auth()->user()->id,
                

            ]);
            return redirect()->back();

    }
    public function unfavorite($id)
    {
        DB::table('favorites')->where(['id_user'=>Auth::id(),'id_place'=>$place->id])->delete();
        return redirect()->back();
    }
}
