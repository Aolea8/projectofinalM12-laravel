<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pelis;
use Illuminate\Support\Facades\Storage;


class PelisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pelis= Pelis::all(); 
        return response()->json([
            'success' => true,
            'data'    => $pelis
        ], 200);
    }
    
    public function show($id)
    {
        $pelis = Pelis::where('id_peliserie', $id)->first();
        return response()->json([
            'success' => true,
            'data'    => $pelis
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
            'file' => 'required|mimes:mp4', 
        ]);
        
        $peliExist = Pelis::where('id_peliserie', $request->input('id_peliserie'))->first();
        if ($peliExist) {
            return response()->json([
                'success' => false,
                'message' => 'La peli ya tiene un video asignado'
            ], 400);
        }
        
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        
        $file->storeAs('public', $fileName); 
        
        $peli = Pelis::create([
            'id_peliserie' => $request->input('id_peliserie'),
            'url' => asset('storage/' . $fileName),
        ]);
        $peli->save();
        return response()->json([
            'success' => true,
            'data' => $peli
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

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
                'data'    => $reserva,
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
            Pelis::destroy($peli->id);
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

    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }
}
