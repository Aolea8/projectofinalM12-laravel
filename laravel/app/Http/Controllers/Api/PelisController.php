<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peli;

class PelisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pelis = Peli::all();
        return response()->json([
            'success' => true,
            'data'    => $pelis,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_peliserie' => 'required|numeric',
            'url' => 'required',
        ]);
    
        $peliExist = Peli::where('id_peliserie', $request->input('id_peliserie'))->first();

        if ($peliExist) {
            return response()->json([
                'success' => false,
                'message' => 'La peli ya tiene un video asignado'
            ], 400);
        }

        $peli = Peli::create([
            'id_peliserie' => $request->input('id_peliserie'),
            'url' => $request->input('url'),
        ]);
        $peli->save();
        return response()->json([
            'success' => true,
            'data'    => $peli
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pelis = Peli::where('id_peliserie', $id)->first();
        return response()->json([
            'success' => true,
            'data'    => $pelis
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_peliserie'  => 'sometimes|required|numeric',
            'url'           => 'sometimes|required',
        ]);
        $peli = Peli::find($id);
        if ($peli) {
            $peli->fill(array_filter($request->only([
                'id_peliserie',
                'url'
            ])));
            $peli->save();
            return response()->json([
                'success' => true,
                'data'    => $peli,
                'message' => 'Peli actualizada correctamente'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error, peli no encontrada'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $peli = Peli::find($id);
        if ($peli){
            Peli::destroy($id);
            return response()->json([
                'success' => true,
                'message'    => "Peli eliminada correctamente"
            ], 200);
        }else{
            return response()->json([
                'success'  => false,
                'message' => 'Error encontrando peli'
            ], 404);
        }
    }
}
