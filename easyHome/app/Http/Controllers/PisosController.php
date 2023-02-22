<?php

namespace App\Http\Controllers;

use App\Models\Pisos;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
    public function store(Request $request)
    {
        $pisos = new Pisos();
    

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('images/featureds', 'public');
            $pisos->image_path  = $path;
        } else {
            $pisos->image_path  = 'noFoto';
        }
        $pisos->title = $request->title;
        $pisos->link = $request->link;
        $pisos->save($request->validated());
    
        return $pisos;
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
