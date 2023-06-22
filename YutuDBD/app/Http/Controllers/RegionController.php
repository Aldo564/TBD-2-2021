<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Country;
use DB;

class RegionController extends Controller
{
    
    public function index()
    {
        $region = Region::all()->where('deleted', false);
        return response()->json($region);
    }

    

    public function store(Request $request)
    {
        $region = new Region();
        $request->validate([
            'nombre_region' => 'required|max:220',
            'id_pais' => 'required'
        ]);
        
        $region->nombre_region = $request->nombre_region;
        $region->id_pais = $request->id_pais;
        $region->deleted = 'false';

        $nombre = DB::table('regions')
                ->where('nombre_region', $request->nombre_region)
                ->get()->first();

        if ($nombre != null) {
            return "Esta region ya existe.";
        }

        $pais = Country::find($request->id_pais);
        if($pais != NULL){
            if($pais->deleted == true){
                return "No existe un pais con esa ID.";
            }else{
                $region->save();
                return response()->json([
                    "message" => "Se ha creado una nueva region.",
                    "id" => $region->id,
                ], 202);
            }
        }else{
            return "No existe un pais con esa ID.";
        }
    }

    

    public function show($id)
    {
        $region = Region::find($id);
        if($region != NULL){
            if($region->deleted == false){
                return response()->json($region);
            }
        }
        return "No existe una region con esa ID.";
    }

    

    public function update(Request $request, $id)
    {
        $region = Region::find($id);
        if($region != NULL){
            if($region->deleted == false){
                if($request->nombre_region != NULL){
                    if($region->nombre_region == $request->nombre_region){
                        return "Nombre de region no cambia.";
                    }else{
                        $nombre = DB::table('regions')
                            ->where('nombre_region', $request->nombre_region)
                            ->get()->first();

                        if ($nombre != null) {
                            return "Esta region ya existe.";
                        }else{
                            $region->nombre_region = $request->nombre_region;
                        }
                    }
                }

                if($request->id_pais != NULL){
                    if($region->id_pais == $request->id_pais){
                        return "La ID de pais no cambia.";
                    }else{
                        $pais = Country::find($request->id_pais);
                        if($pais == NULL){
                            return "No existe un pais con esa ID.";
                        }else{
                            if($pais->deleted == false){
                                $region->id_pais = $request->id_pais;
                            }else{
                                return "No existe un pais con esa ID.";
                            }
                        }
                    }
                }
            }
            $region->save();
            return response()->json([
                "message" => "Se ha modificado la region.",
                "id" => $id
            ], 201);
        }
        return "No existe una region con esa ID.";
    }

    

    public function destroy($id)
    {
        $region = Region::find($id);
        if($region != NULL){
            $region->delete();
            return response()->json([
                "message" => "Se ha eliminado la region permanentemente.",
                "id" => $id
            ], 201);
        }
        return "No existe una region con esa ID.";
    }



    public function softDelete($id)
    {
        $region = Region::find($id);
        if($region != NULL){
            $region->deleted = 'true';
            $region->save();
            return response()->json([
                "message" => "Se ha eliminado temporalmente la region.",
                "id" => $id
            ], 201);
        }
        return "No existe una region con esa ID.";
    }



    public function restore($id){
        $region = Region::find($id);
        if($region != NULL){
            $region->deleted = 'false';
            $region->save();
            return response()->json([
                "message" => "Se ha restaurado la region.",
                "id" => $id
            ], 200);
        }
        return "No existe una region con esa ID.";
    }

}
