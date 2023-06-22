<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\Permission;
use App\Models\Role_permission;

class Role_permissionController extends Controller
{
    public function index()
    {
        $role_permission = Role_permission::all()->where('deleted', false);
        return response()->json($role_permission);  
    }






    public function store(Request $request)
    {
        $role_permission = new Role_permission();
        $request->validate([

          'id_permiso' => 'required',
          'id_rol' => 'required'
        ]);
  
        $timestamp = $role_permission->timestamps;
        
  
        $role_permission -> id_permiso = $request->id_permiso;
        $role_permission -> id_rol = $request->id_rol;
        $role_permission -> deleted = false;



        $rol = Role::find($request->id_rol);
        $permiso = Permission::find($request->id_permiso);



        if($rol == NULL){
          return "No existe el rol.";
        }
        
        if($permiso == NULL){
          return "No existe el permiso.";
        }

        if($rol -> deleted == true){
            return "No existe el rol.";
        }

        if($rol -> deleted == true){
          return "No existe el permiso.";
        }



        $role_permission -> save();
        
        return response()->json([
          "message" => "Se ha creado una nueva relación rol-permiso.",
          "id_permiso" => $role_permission -> id_permiso,
          "id_rol" => $role_permission -> id_rol,
          "id" => $role_permission->id
        ], 202);
    }













    public function show($id)
    {
        $role_permission = Role_permission::find($id);
        if ($role_permission != NULL) {
            if($role_permission->deleted == false){
                return response()->json($role_permission);
            }
        }
        return "No existe una relacion rol-permiso con esa ID.";
    }

















    public function destroy($id)
    {
      $role_permission = Role_permission::find($id);
      if ($role_permission != NULL) {

          $role_permission -> delete();

          return response() -> json([
            "message" => "Se ha borrado definitivamente la relación rol-permiso.",
            "id" => $role_permission -> id
          ]);
      }
      return "No existe un rol con ese ID.";
    }











    
    public function softDelete($id)
    {
      $role_permission = Role_permission::find($id);
      if ($role_permission != NULL) {
          $role_permission -> deleted = 'true';
          $role_permission -> save();

          return response() -> json([
            "message" => "Se ha borrado momentaneamente la relación rol-permiso.",
            "id_rol" => $role_permission -> id_rol,
            "id_permiso" => $role_permission -> id_permiso
          ]);
      }
      return "No existe una relacion rol-permiso con ese ID.";
    }












    // restaura una tupla borrada suavemente de la BD
    public function restore($id)
    {
      $role_permission = Role_permission::find($id);
      if ($role_permission != NULL) {
        if($role_permission -> deleted == true){
          $role_permission -> deleted = false;
          $role_permission -> save();

          return response() -> json([
            "message" => "Se ha restaurado la relación rol-permiso.",
            "id" => $role_permission -> id
          ],200);
        }else{
          return "La relación no ha sido eliminada.";
        }

      }
      return "No existe una relación rol-permiso con ese ID.";
    }





    public function update(Request $request, $id){

      $role = Role_permission::find($id);
      if ($role != NULL){
        if($role -> deleted == false){
          if($request -> id_permiso != NULL){
            $role -> id_permiso = $request -> id_permiso;
          }if ($request -> id_rol != NULL){
            $role -> id_rol = $request -> id_rol;
          }
          $role->save();
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
