<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use DB;

class CountryController extends Controller
{
    
    public function index()
    {
        $pais = Country::all()->where('deleted', false);
        return response()->json($pais);
    }

    

    public function store(Request $request)
    {
        $pais = new Country;
        $request->validate([
            'nombre_pais' => 'required|max:220'
        ]);

        $pais->nombre_pais = $request->nombre_pais;
        $pais->deleted = 'false';

        $nombre = DB::table('countries')
                ->where('nombre_pais', $request->nombre_pais)
                ->get()->first();

        if ($nombre === null) {
            $pais->save();
            return response()->json([
                "message" => "Se ha creado un nuevo pais.",
                "id" => $pais->id
            ], 202);
         }else{
            return "Este pais ya existe.";
        }
    }

    

    public function show($id)
    {
        $pais = Country::find($id);
        if($pais != NULL){
            if($pais->deleted == false){
                return response()->json($pais);
            }
        }
        return "No existe un pais con esa ID.";
    }

    

    public function update(Request $request, $id)
    {
        $pais = Country::find($id);
        if($pais != NULL){
            if($pais->delete == false){
                if($request->nombre_pais != NULL){
                    if($pais->nombre_pais == $request->nombre_pais){
                        return "Nombre de pais no cambia.";
                    }else{
                        $nombre = DB::table('countries')
                            ->where('nombre_pais', $request->nombre_pais)
                            ->get()->first();
                        if ($nombre != null) {
                            return "Este pais ya existe.";
                        }else{
                            $pais->nombre_pais = $request->nombre_pais;
                        }
                    }
                }
            }
            $pais->save();
            return response()->json([
                "message" => "Se ha modificado el pais.",
                "id" => $id
            ], 201);
        }
        return "No existe un pais con esa ID.";
    }

    

    public function destroy($id)
    {
        $pais = Country::find($id);
        if($pais != NULL){
            $pais->delete();
            return response()->json([
                "message" => "Se ha eliminado el pais permanentemente.",
                "id" => $id
            ], 201);
        }
        return "No existe un pais con esa ID.";
    }


    public function softDelete($id)
    {
        $pais = Country::find($id);
        if($pais != NULL){
            $pais->deleted = 'true';
            $pais->save();
            return response()->json([
                "message" => "Se ha eliminado temporalmente el pais.",
                "id" => $id
            ], 201);
        }
        return "No existe un pais con esa ID.";
    }



    public function restore($id){
        $pais = Country::find($id);
        if($pais != NULL){
            $pais->deleted = 'false';
            $pais->save();
            return response()->json([
                "message" => "Se ha restaurado el pais.",
                "id" => $id
            ], 200);
        }
        return "No existe un pais con esa ID.";
    }
}
