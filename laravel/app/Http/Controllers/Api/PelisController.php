<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelis;

class PelisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pelis = Pelis::all();
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
            'id_peliserie' => 'required',
            'url'      => 'required'
        ]);

        $Peli = Pelis::create([
            'id_peliserie' =>$request->input('id_peliserie'),
            'url' =>$request->input('url')
        ]);

        return response()->json([
            'success' => true,
            'data'    => $Peli
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pelis = Pelis::where('id_peliserie', $id)->first();
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
        $peli = Pelis::find($id);
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
        $peli = Pelis::find($id);
        if ($peli){
            Pelis::destroy($id);
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
