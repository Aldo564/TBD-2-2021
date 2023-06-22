<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_PayMethod;
use App\Models\User;
use App\Models\PayMethod;
use DB;

class User_PayMethodController extends Controller
{
    
    public function index()
    {
        $metodo = User_PayMethod::all()->where('deleted', false);
        return response()->json($metodo);
    }

    

    public function store(Request $request)
    {
        $metodo = new User_PayMethod();
        $request->validate([
            'id_usuario' => 'required',
            'id_metodoPago' => 'required'
        ]);

        $metodo->id_usuario = $request->id_usuario;
        $metodo->id_metodoPago = $request->id_metodoPago;
        $metodo->deleted = 'false';

        $user = User::find($request->id_usuario);
        $pago = PayMethod::find($request->id_metodoPago);

        if($user == NULL){
            return "No existe un usuario con esa ID.";
        }

        if($pago == NULL){
            return "No existe un metodo de pago con esa ID.";
        }

        else{
            if($user->deleted == false){
                if($pago->deleted == false){
                    $user_paymethods = DB::table('user__pay_methods')
                        ->where('id_usuario', $request->id_usuario) 
                        ->where('id_metodoPago', $request->id_metodoPago)
                        ->get()->first();
                    if($user_paymethods != NULL){
                        return "Error, el usuario ya tiene el metodo de pago";
                    }else{
                        $metodo->save();
                        return response()->json([
                            "message" => "Se ha agregado el metodo de pago.",
                            "id" => $metodo->id,
                            "id usuario" => $metodo->id_usuario,
                            "id metodo de pago" => $metodo->id_metodoPago
                        ], 202);
                    }
                }else{
                    return "No existe el metodo de pago.";
                }
            }else{
                return "No existe el usuario.";
            }
        }
    }

    

    public function show($id)
    {
        $metodo = User_PayMethod::find($id);
        if($metodo != NULL){
            if($metodo->deleted == false){
                return response()->json($metodo);
            }
        }
        return "No existe una ID de metodo de pago asociada a un usuario.";
    }

    

    public function update(Request $request, $id)
    {
        $metodo = User_PayMethod::find($id);
        if($metodo != NULL){
            if($request->id_usuario != NULL){
                if($metodo->id_usuario == $request->id_usuario){
                    return "La ID de usuario no cambia.";
                }else{
                    $user = User::find($request->id_usuario);
                    if($user == NULL){
                        return "No existe un usuario con esa ID.";
                    }else{
                        if($metodo->deleted == false){
                            $relacion = DB::table('user__pay_methods')
                                    ->where('id_usuario', $request->id_usuario) 
                                    ->where('id_metodoPago', $request->id_metodoPago)
                                    ->get()->first();
                            if($relacion != NULL){
                                return "Error, el usuario ya tiene el metodo de pago";
                            }else{
                                $metodo->id_usuario = $request->id_usuario;
                            }
                        }else{
                            return "No existe un usuario con esa ID.";
                        }
                    }
                }
            }


            if($request->id_metodoPago != NULL){
                if($metodo->id_metodoPago == $request->id_metodoPago){
                    return "La ID del metodo de pago no cambia.";
                }else{
                    $pago = PayMethod::find($request->id_metodoPago);
                    if($pago == NULL){
                        return "No existe un metodo de pago con esa ID.";
                    }else{
                        if($metodo->deleted == false){
                            $relacion = DB::table('user__pay_methods')
                                    ->where('id_usuario', $request->id_usuario) 
                                    ->where('id_metodoPago', $request->id_metodoPago)
                                    ->get()->first();
                            if($relacion != NULL){
                                return "Error, el usuario ya tiene el metodo de pago";
                            }else{
                                $metodo->id_metodoPago = $request->id_metodoPago;
                            }
                        }else{
                            return "No existe un metodo de pago con esa ID.";
                        }
                    }
                }
            }

            $metodo->save();
            return response()->json($metodo);
        }else{
            return "No existe una ID de metodo de pago asociada a un usuario.";
        }
    }

    

    public function destroy($id)
    {
        $metodo = User_PayMethod::find($id);
        if($metodo != NULL){
            $metodo->delete();
            return response()->json([
                "message" => "Se ha eliminado la relacion metodo de pago y usuario.",
                "id" => $id
            ], 201);
        }else{
            return "No existe una ID de metodo de pago asociada a un usuario.";
        }
    }



    public function softDelete($id)
    {
        $metodo = User_PayMethod::find($id);
        if($metodo != NULL){
            $metodo->deleted = 'true';
            $metodo->save();
            return response()->json([
                "message" => "Se ha eliminado temporalmente la relacion metodo de pago y usuario.",
                "id" => $id
            ], 201);
        }
        return "No existe una ID de metodo de pago asociada a un usuario.";
    }



    public function restore($id){
        $metodo = User_PayMethod::find($id);
        if($metodo != NULL){
            $metodo->deleted = 'false';
            $metodo->save();
            return response()->json([
                "message" => "Se ha restaurado la relacion metodo de pago y usuario.",
                "id" => $id
            ], 200);
        }
        return "No existe una ID de metodo de pago asociada a un usuario.";
    }
}
