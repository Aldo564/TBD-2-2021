<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use App\Models\User;
use DB;

class FollowController extends Controller
{
    
    public function index()
    {
        $seguir = Follow::all()->where('deleted', false);
        return response()->json($seguir);
    }

    

    public function store(Request $request)
    {
        $seguir = new Follow();
        $request->validate([
            'id_usuario_Origen' => 'required',
            'id_usuario_Destino' => 'required'
        ]);
        
        $seguir->id_usuario_Origen = $request->id_usuario_Origen;
        $seguir->id_usuario_Destino = $request->id_usuario_Destino;
        $seguir->deleted = 'false';

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
                    $origen = DB::table('follows')
                            ->where('id_usuario_Origen', $request->id_usuario_Origen) 
                            ->where('id_usuario_Destino', $request->id_usuario_Destino)
                            ->get()->first();

                    if($origen != NULL){
                        return "Error, ya sigue al usuario destino.";
                    }else{
                        $seguir->save();
                        return response()->json([
                            "message" => "Se ha realizado un follow.",
                            "id" => $seguir->id,
                            "id usuario origen" => $seguir->id_usuario_Origen,
                            "id usuario destino" => $seguir->id_usuario_Destino
                        ], 202);
                    }
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
        $seguir = Follow::find($id);
        if($seguir != NULL){
            if($seguir->deleted == false){
                return response()->json($seguir);
            }
        }
        return "No existe un seguimiento con esa ID.";
    }

    

    public function update(Request $request, $id)
    {
        $seguir = Follow::find($id);
        if($seguir != NULL){
            if($request->id_usuario_Origen != NULL){
                if($seguir->id_usuario_Origen == $request->id_usuario_Origen){
                    return "La ID de usuario origen no cambia.";
                }else{
                    $origen = User::find($request->id_usuario_Origen);
                    if($origen == NULL){
                        return "No existe un usuario con esa ID.";
                    }else{
                        if($origen->deleted == false){
                            if($request->id_usuario_Origen != $seguir->id_usuario_Destino){
                                $origen2 = DB::table('follows')
                                    ->where('id_usuario_Origen', $request->id_usuario_Origen) 
                                    ->where('id_usuario_Destino', $request->id_usuario_Destino)
                                    ->get()->first();
                                if($origen2 != NULL){
                                    return "Este seguimiento ya existe.";
                                }else{
                                    $seguir->id_usuario_Origen = $request->id_usuario_Origen;
                                }
                            }else{
                                return "Error, ID's de origen y destino coinciden.";
                            }
                        }else{
                            return "No existe un usuario con esa ID.";
                        }
                    }
                }
            }

            if($request->id_usuario_Destino != NULL){
                if($seguir->id_usuario_Destino == $request->id_usuario_Destino){
                    return "La ID de usuario destino no cambia.";
                }else{
                    $destino = User::find($request->id_usuario_Destino);
                    if($destino == NULL) {
                        return "No existe un usuario con esa ID.";
                    }else{
                        if($destino->deleted == false){
                            if($request->id_usuario_Destino != $seguir->id_usuario_Origen){
                                $destino2 = DB::table('follows')
                                    ->where('id_usuario_Origen', $request->id_usuario_Origen) 
                                    ->where('id_usuario_Destino', $request->id_usuario_Destino)
                                    ->get()->first();
                                if($destino2 != NULL){
                                    return "Este seguimiento ya existe.";
                                }else{
                                    $seguir->id_usuario_Destino = $request->id_usuario_Destino;
                                }
                            }else{
                                return "Error, ID's de origen y destino coinciden.";
                            }
                        }else{
                            return "No existe un usuario con esa ID.";
                        }
                    }
                }
            }
            $seguir->save();
            return response()->json($seguir);
        }else{
            return "No existe un seguimiento con esa ID.";
        }
    }

    

    public function destroy($id)
    {
        $seguir = Follow::find($id);
        if($seguir != NULL){
            $seguir->delete();
            return response()->json([
                "message" => "Se ha eliminado el seguimiento permanentemente.",
                "id" => $id
            ], 201);
        }
        return "No existe un seguimiento con esa ID.";
    }



    public function softDelete($id)
    {
        $seguir = Follow::find($id);
        if($seguir != NULL){
            $seguir->deleted = 'true';
            $seguir->save();
            return response()->json([
                "message" => "Se ha eliminado temporalmente el seguimiento.",
                "id" => $id
            ], 201);
        }
        return "No existe un seguimiento con esa ID.";
    }



    public function restore($id){
        $seguir = Follow::find($id);
        if($seguir != NULL){
            $seguir->deleted = 'false';
            $seguir->save();
            return response()->json([
                "message" => "Se ha restaurado el seguimiento.",
                "id" => $id
            ], 200);
        }
        return "No existe un seguimiento con esa ID.";
    }
}
