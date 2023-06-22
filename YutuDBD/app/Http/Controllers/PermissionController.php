<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\Models\Permission;
use App\Models\Role_permission;
use DB;


class PermissionController extends Controller
{

    public function index()
    {
        $permission = Permission::all()->where('deleted', false);
        return response()->json($permission);
    }


    public function store(Request $request)
    {
        $permission = new Permission();
        $request->validate([
          'nombre' => 'required|max:140',
          'descripcion' => 'required|max:140',
        ]);


        $permission -> nombre = $request->nombre;
        $permission -> descripcion = $request->descripcion;
        $permission -> deleted = false;


        $nombre_permiso = DB::table('permissions')
                ->where('nombre', $request->nombre)
                ->get()->first();



        if ($nombre_permiso != null) {
            return "Este permiso ya existe.";
        }

        $permission -> save();

        return response()->json([
          "message" => "Se ha creado un nuevo permiso.",
          "id" => $permission -> id,
          "nombre" => $permission -> nombre,
          "descripcion" => $permission -> descripcion,
        ], 202);

    }


    public function show($id)
    {
        $permission = Permission::find($id);
        if ($permission != NULL) {
            if($permission->deleted == false){
                return response()->json($permission);
            }
        }
        return "No existe una permiso con ese ID.";
    }

    public function destroy($id)
    {
      $permission = Permission::find($id);
      if ($permission != NULL) {
          $permission -> delete();
          Role_permission::where('id_rol', $id)->delete();

          return response() -> json([
            "message" => "Se ha borrado un permiso de manera definitiva.",
            "id" => id
          ],201);
      }
      return "No existe un permiso con ese ID.";
    }

    public function softDelete($id)
    {
      $permission = Permission::find($id);
      if ($permission != NULL) {
          $permission -> deleted = 'true';
          $permission -> save();

          return response() -> json([
            "message" => "Se ha borrado un permiso momentaneamente.",
            "id" => $permission -> id,
          ]);
      }
      return "No existe un permiso con ese ID.";
    }

    // restaura una tupla borrada suavemente de la BD
    public function restore($id)
    {
      $permission = Permission::find($id);

      if ($permission != NULL) {
          $permission -> deleted = 'false';
          $permission -> save();

          return response() -> json([
            "message" => "Se ha restaurado el permiso.",
            "id" => $permission -> id
          ],200);
      }
      return "No existe un permiso con ese ID.";
    }

    /*
    public function update($id){

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
    */

    public function update(Request $request, $id){

      $permission = Permission::find($id);
      if ($permission != NULL){
        if($permission -> deleted == false){
          if($request -> nombre != NULL){
            $permission -> nombre = $request -> nombre;
          }if ($request -> descripcion != NULL){
            $permission -> descripcion = $request -> descripcion;
          }
          $permission->save();
          return response()->json([
              "message" => "Se ha modificado el permiso.",
              "id" => $id
          ], 201);
        }else{
          return "No existe un permiso con ese ID ingresado.";
        }


      }else{
        return "No existe un permiso con el ID ingresado.";
      }


    }
}
