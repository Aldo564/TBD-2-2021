<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\User;
use App\Models\User_role;
use DB;

class User_RoleController extends Controller
{
    public function index()
    {
        $user_role = User_role::all()->where('deleted', false);
        return response()->json($user_role);  
    }









    public function store(Request $request)
    {
        $user_role = new User_role();
        $request->validate([
          'id_usuario' => 'required',
          'id_rol' => 'required',
        ]);
  
        $timestamp = $user_role->timestamps;
        
  
        $user_role -> id_usuario = $request->id_usuario;
        $user_role -> id_rol = $request->id_rol;
        $user_role -> deleted = false;

        $rol = Role::find($request->id_rol);
        $usuario = User::find($request->id_usuario);



        if($rol == NULL){
          return "No existe el rol.";
        }
        
        if($usuario == NULL){
          return "No existe el usuario.";
        }
        if($rol -> deleted == true){
            return "No existe el rol.";
        }

        if($rol -> deleted == true){
          return "No existe el usuario.";
        }


  
        $user_role -> save();
        
        return response()->json([
          "message" => "Se ha creado una nueva relacion usuario-rol.",
          "id_usuario" => $user_role -> id_usuario,
          "id" => $user_role -> id,
          "id_rol" => $user_role -> id_rol
        ],202);

    }









    public function show($id)
    {
        $user_role = User_role::find($id);
        if ($user_role != NULL) {
            if($user_role->deleted == false){
                return response()->json($user_role);
            }
        }
        return "No existe una relacion usuario-rol con ese ID.";
    }











//Elimina permanentemente
    public function destroy($id)
    {
      $user_role = User_role::find($id);
      if ($user_role != NULL) { 
          $user_role -> delete();

          return response() -> json([
            "message" => "Se ha borrado una relación usuario-rol.",
            "id" => $user_role -> id
          ]);
      }
      return "No existe una relacion usuario-rol con ese ID.";
    }






//Elimina temporalmente   
    public function softDelete($id)
    {
      $user_role = User_role::find($id);
      if ($user_role != NULL) {
          $user_role -> deleted = 'true';
          $user_role -> save();

          return response() -> json([
            "message" => "Se ha borrado temporalmente una relacion usuario-rol.",
            "id" => $user_role -> id
          ]);
      }
      return "No existe una relación usuario-rol con ese ID.";
    }






//Restaura un softdelete
    public function restore($id)
    {
      $user_role = User_role::find($id);
      if ($user_role != NULL) {
        if($user_role -> deleted == 'true'){
          $user_role -> deleted = 'false';
          $user_role -> save();

          return response() -> json([
            "message" => "Se ha restaurado una relacion usuario-rol.",
            "id" => $user_role -> id
          ],200);
        }else{
          return "La relación no ha sido eliminada";
        }

      }
      return "No existe una relacion usuario-rol con ese ID.";
    }





public function update(Request $request, $id){

  $user_role = User_role::find($id);
  if ($user_role != NULL){
    if($user_role -> deleted == false){
      if($request -> id_permiso != NULL){
        $user_role -> id_permiso = $request -> id_permiso;
      }if ($request -> id_rol != NULL){
        $user_role -> id_rol = $request -> id_rol;
      }
      $user_role->save();
      return response()->json([
          "message" => "Se ha modificado la relación.",
          "id" => $id
      ], 201);
    }else{
      return "No existe la relación con ese ID ingresado.";
    }
    

  }else{
    return "No existe la relación con el ID ingresado.";
  }


}
}

