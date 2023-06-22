<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group_Synopsis;
use App\Models\Synopsis;
use App\Models\Group;
use Illuminate\Support\Facades\Validator;

class Group_SynopsisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gro_syn = Group_Synopsis::all()->where('deleted', false);
        return response()->json($gro_syn);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gro_syn = new Group_Synopsis();
        $validator = Validator::make($request->all(),[
            'id_group' => 'required|int',
            'id_sinopsis' => 'required|int',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => "Ha ocurrido algun error con sus entradas, porfavor reviselas",
            ], 422);
        }
        $group = Group::find($request->id_group);
        $synopsis = Synopsis::find($request->id_sinopsis);
        if($group->deleted == false && $synopsis->deleted == false){
            $gro_syn->id_group = $request->id_group;
            $gro_syn->id_sinopsis = $request->id_sinopsis;
            $gro_syn->deleted = false;
            $gro_syn->save();
            return response()->json([
                "message" => "Se ha creado una nueva relacion entre lista y video (se ha añadido un video a la lista).",
                "id" => $gro_syn->id,
                "id_lista" => $gro_syn->id_group
            ], 202);
        }
        return "no se puede agregar ya que uno de los elementos se encuentra eliminado";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gro_syn = Group_Synopsis::find($id);
        if ($gro_syn != NULL) {
            if($gro_syn->deleted == false){
                return response()->json($gro_syn);
            }
        }
        return "No existe una relacion de lista con sinopsis con esa ID.";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $gro_syn = Group_Synopsis::find($id);
        if ($gro_syn != NULL) {
            if ($request->id_group != NULL) {
                if (is_int($request->id_group)){
                    $group = Group::find($request->id_group);
                    if($group->deleted == false){
                        $gro_syn->id_group = $request->id_group;
                    }
                    else{
                        return "No se puede agregar una lista que no existe";
                    }
                }
            }
            if ($request->id_sinopsis != NULL) {
                if (is_int($request->id_sinopsis)){
                    $synopsis = Synopsis::find($request->id_sinopsis);
                    if($synopsis->deleted == false){
                        $gro_syn->id_sinopsis = $request->id_sinopsis;
                    }
                    else{
                        return "No se puede agregar una sinopsis que no existe";
                    }
                }
            }
            $gro_syn->save();
            return response()->json($gro_syn);
        }
        return "No existe una relacion de lista con sinopsis con esa ID.";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gro_syn = Group_Synopsis::find($id);
        if ($gro_syn != NULL) {
            $gro_syn->delete();
            return response()->json([
                "message" => "Se ha borrado la relacion entre lista y sinopsis",
                "id" => $id
            ]);
        }
        return "No existe una relacion de lista con sinopsis con esa ID.";
    }

    public function softDelete($id)
    {
        $gro_syn = Group_Synopsis::find($id);

        if($gro_syn != NULL){
            $gro_syn->deleted = 'true';
            $gro_syn->save();
            return response()->json([
                "message" => "Se ha borrado la relacion entre lista y sinopsis",
                "id" => $id
            ], 201);

        }
        return "No existe una relacion de lista con sinopsis con esa ID.";
    }

    public function restore($id)
    {
        $gro_syn = Group_Synopsis::find($id);

        if ($gro_syn != NULL) {
            $gro_syn->deleted = 'false';
            $gro_syn->save();
            return response()->json([
                "message" => "Se ha restaurado la relacion entre lista y sinopsis",
                "id" => $id
            ]);
        }
        return "No existe una relacion de lista con sinopsis con esa ID.";
    }
}
