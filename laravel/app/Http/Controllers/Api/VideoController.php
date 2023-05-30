<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pelis;
use Illuminate\Support\Facades\Storage;


class VideoController extends Controller
{
    public function pelis($id)
    {
        $pelis = Pelis::all();
        return response()->json([
            'success' => true,
            'data'    => $pelis
        ], 200);
    }

    public function pelisByID($id)
    {
        $pelis = Pelis::where('id_peliserie', $id)->first();
        return response()->json([
            'success' => true,
            'data'    => $pelis
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_peliserie' => 'required|numeric',
            'file' => 'required|mimes:mp4',
        ]);
    
        $peliExist = Pelis::where('id_peliserie', $request->input('id_peliserie'))->first();
        if ($peliExist) {
            return response()->json([
                'success' => false,
                'message' => 'La peli ya tiene un video asignado'
            ], 400);
        }
    
        $upload = $request->file('file');
        $fileName = $upload->getClientOriginalName();
        $fileSize = $upload->getSize();
    
        $uploadName = $fileName;
        $filePath = $upload->storeAs(
            'uploads',      // Path
            $uploadName,    // Filename
            'public'        // Disk
        );
    
        if (Storage::disk('public')->exists($filePath)) {
            $fullPath = Storage::disk('public')->path($filePath);
    
            $peli = Pelis::create([
                'id_peliserie' => $request->input('id_peliserie'),
                'url' => $filePath,
            ]);
            $peli->save();
    
            return response()->json([
                'success' => true,
                'message' => "Peli Creada Correctamente",
                'data'    => $peli
            ], 201);
        } else {
            return response()->json([
                'success'  => false,
                'data' => "Error"
            ], 421);
        }
    }

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