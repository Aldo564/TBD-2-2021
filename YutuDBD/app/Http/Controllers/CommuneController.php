<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commune;
use App\Models\Region;
use DB;

class CommuneController extends Controller
{
    public function index()
    {
        $commune = Commune::all()->where('deleted', false);
        return response()->json($commune);
    }

    

    public function store(Request $request)
    {
        $commune = new Commune();
        $request->validate([
            'nombre_comuna' => 'required|max:200',
            'id_region' => 'required'
        ]);

        $commune->nombre_comuna = $request->nombre_comuna;
        $commune->id_region = $request->id_region;
        $commune->deleted = 'false';

        $nombre = DB::table('communes')
                ->where('nombre_comuna', $request->nombre_comuna)
                ->get()->first();

        if ($nombre != null) {
            return "Esta comuna ya existe.";
        }

        $region = Region::find($request->id_region);
        if($region == null){
            return "No existe una region con esa ID.";
        }else{
            if($region->deleted == true){
                return "No existe una region con esa ID.";
            }else{
                $commune->save();
                return response()->json([
                    "message" => "Se ha creado una nueva comuna.", 
                    "id" => $commune->id,
                    "nombre" => $commune->nombre_comuna,
                    "id region" => $commune->id_region
                ], 202);
            }
        }
    }

    

    public function show($id)
    {
        $commune = Commune::find($id);
        if($commune != NULL){
            if($commune->deleted == false){
                return response()->json($commune);
            }
        }
        return "No existe una comuna con esa ID.";
    }

    

    public function update(Request $request, $id)
    {
        $commune = Commune::find($id);
        if($commune != NULL){
            if($commune->deleted == false){
                if($request->nombre_comuna != NULL){
                    if($commune->nombre_comuna == $request->nombre_comuna){
                        return "Nombre de comuna no cambia.";
                    }else{
                        $nombre = DB::table('communes')
                        ->where('nombre_comuna', $request->nombre_comuna)
                        ->get()->first();

                        if ($nombre != null) {
                            return "Esta comuna ya existe.";
                        }else{
                            $commune->nombre_comuna = $request->nombre_comuna;
                        }
                    }
                }

                if($request->id_region != NULL){
                    if($commune->id_region == $request->id_region){
                        return "La ID de region no cambia.";
                    }else{
                        $region = Region::find($request->id_region);
                        if($region == null){
                            return "No existe una region con esa ID.";
                        }else{
                            if($region->deleted == false){
                                $commune->id_region = $request->id_region;
                            }else{
                                return "No existe una region con esa ID.";
                            }
                        }
                    }
                }
            }
            $commune->save();
            return response()->json([
                "message" => "Se ha modificado la comuna.",
                "id" => $id
            ], 201);
        }
        return "No existe una comuna con esa ID.";
    }

    

    public function destroy($id)
    {
        $commune = Commune::find($id);
        if($commune != NULL){
            $commune->delete();
            return response()->json([
                "message" => "Se ha borrado la comuna.",
                "id" => $id
            ], 201);
        }
        return "No existe una comuna con esa ID.";
    }



    public function softDelete($id)
    {
        $commune = Commune::find($id);
        if($commune != NULL){
            $commune->deleted = 'true';
            $commune->save();
            return response()->json([
                "message" => "Se ha eliminado temporalmente la comuna.",
                "id" => $id
            ], 201);
        }
        return "No existe una comuna con esa ID.";
    }



    public function restore($id)
    {
        $commune = Commune::find($id);
        if($commune != NULL){
            $commune->deleted = 'false';
            $commune->save();
            return response()->json([
                "message" => "Se ha restaurado la comuna.",
                "id" => $id
            ], 200);
        }
        return "No existe una comuna con esa ID.";
    }
}
