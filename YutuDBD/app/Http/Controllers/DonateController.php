<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donate;
use App\Models\User;
use Carbon\Carbon;

class DonateController extends Controller
{
    
    public function index()
    {
        $donar = Donate::all()->where('deleted', false);
        return response()->json($donar);
    }

    

    public function store(Request $request)
    {
        $donar = new Donate();
        $request->validate([
            "monto" => 'required',
            "id_usuario_Origen" => 'required',
            "id_usuario_Destino" => 'required',
        ]);
        
        $donar->monto = $request->monto;
        $donar->id_usuario_Origen = $request->id_usuario_Origen;
        $donar->id_usuario_Destino = $request->id_usuario_Destino;
        $donar->deleted = 'false';

        $fecha = Carbon::now();
        $donar->fecha = $fecha->format('Y-m-d');

        $user1 = User::find($request->id_usuario_Origen);
        $user2 = User::find($request->id_usuario_Destino);

        if($user1 == NULL){
            return "No existe un usuario de origen con esa ID.";
        }
        
        if($user2 == NULL){
            return "No existe un usuario de destino con esa ID.";
        }

        else{
            if($user1->deleted == false && $user2->deleted == false){
                if($user1 != $user2){
                    $donar->save();
                    return response()->json([
                        "message" => "Se ha realizado una donacion.",
                        "id donacion" => $donar->id,
                        "id usuario origen" => $donar->id_usuario_Origen,
                        "id usuario destino" => $donar->id_usuario_Destino,
                        "monto" => $donar->monto,
                        "fecha" => $donar->fecha
                    ], 202);
                }else{
                    return "Error, ID's origen y destino coinciden";
                }
            }else{
                return "No existe un usuario con esa ID.";
            }
        }
    }

    

    public function show($id)
    {
        $donar = Donate::find($id);
        if($donar != NULL){
            if($donar->deleted == false){
                return response()->json($donar);
            }
        }
        return "No existe una donacion con esa ID.";
    }

    

    public function update(Request $request, $id)
    {
        $donar = Donate::find($id);
        if($donar != NULL){
            if($request->monto != NULL){
                if($donar->monto == $request->monto){
                    return "El monto no cambia.";
                }else{
                    $donar->monto = $request->monto;
                }
            }

            if($request->id_usuario_Origen != NULL){
                if($donar->id_usuario_Origen == $request->id_usuario_Origen){
                    return "La ID de usuario origen no cambia.";
                }else{
                    $origen = User::find($request->id_usuario_Origen);
                    if($origen == NULL){
                        return "No existe un usuario con esa ID.";
                    }else{
                        if($origen->deleted == false){
                            if($request->id_usuario_Origen != $donar->id_usuario_Destino){
                                $donar->id_usuario_Origen = $request->id_usuario_Origen;
                            }else{
                                return "Error, ID's origen y destino coinciden.";
                            }
                        }else{
                            return "No existe un usuario con esa ID.";
                        }
                    }
                }
            }

            if($request->id_usuario_Destino != NULL){
                if($donar->id_usuario_Destino == $request->id_usuario_Destino){
                    return "La ID de usuario destino no cambia.";
                }else{
                    $destino = User::find($request->id_usuario_Destino);
                    if($destino == NULL){
                        return "No existe un usuario con esa ID.";
                    }else{
                        if($destino->deleted == false){
                            if($request->id_usuario_Destino != $donar->id_usuario_Origen){
                                $donar->id_usuario_Destino = $request->id_usuario_Destino;
                            }else{
                                return "Error, ID's origen y destino coinciden.";
                            }
                        }else{
                            return "No existe un usuario con esa ID.";
                        }
                    }
                }
            }

            if($request->fecha != NULL){
                if($donar->fecha == $request->fecha){
                    return "La fecha no cambia.";
                }else{
                    $donar->fecha = $request->fecha;
                }
            }

            $donar->save();
            return response()->json($donar);
        }else{
            return "No existe un usuario con esa ID.";
        }
    }

    

    public function destroy($id)
    {
        $donar = Donate::find($id);
        if($donar != NULL){
            $donar->delete();
            return response()->json([
                "message" => "Se ha eliminado la donacion permanentemente.",
                "id" => $id
            ], 201);
        }
        return "No existe una donacion con esa ID.";
    }



    public function softDelete($id)
    {
        $donar = Donate::find($id);
        if($donar != NULL){
            $donar->deleted = 'true';
            $donar->save();
            return response()->json([
                "message" => "Se ha eliminado temporalmente la donacion.",
                "id" => $id
            ], 201);
        }
        return "No existe una donacion con esa ID.";
    }



    public function restore($id){
        $donar = Donate::find($id);
        if($donar != NULL){
            $donar->deleted = 'false';
            $donar->save();
            return response()->json([
                "message" => "Se ha restaurado la donacion.",
                "id" => $id
            ], 200);
        }
        return "No existe una donacion con esa ID.";
    }
}
