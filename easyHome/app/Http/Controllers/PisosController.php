<?php

namespace App\Http\Controllers;

use App\Models\Pisos;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Storage;

class PisosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pisos = Pisos::all();

        return response()->json($pisos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
     /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
{
    $file = new Pisos();

    $file->fotos = $request->fotos;
    $file->user_id = $request->user_id;
    $file->titulo = $request->titulo;
    $file->ciudad = $request->ciudad;
    $file->zona = $request->zona;
    $file->precio = $request->precio;
    $file->planta = $request->planta;
    $file->extension = $request->extension;
    $file->habitaciones = $request->habitaciones;
    $file->baños = $request->baños;
    $file->descripcion = $request->descripcion;
    $file->isFavorite = $request->isFavorite;
    $file->propietario = $request->propietario;

    $file->save();

    $file->fotos = json_decode($file->fotos); // cast fotos to an array

    return response()->json($file, 201);
}



    /**
     * Display the specified resource.
     *
     * @param Piso $piso
     * @return Response
     */
    public function show(Pisos $piso)
    {
        return response()->json($piso);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Piso $piso
     * @return Response
     */
    public function update(Request $request, Pisos $piso)
    {
        $piso->fill($request->except('fotos'));

        $fotos = $request->file('fotos');

        if ($fotos) {

            $fotosArray = [];

            foreach ($fotos as $foto) {
                $path = $foto->store('public/pisos');
                array_push($fotosArray, $path);
            }

            $piso->fotos = $fotosArray;
        }

        $piso->save();

        return response()->json($piso);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Piso $piso
     * @return Response
     */
    public function destroy(Pisos $piso)
    {
        $piso->delete();

        return response()->json(null, 204);
    }
}