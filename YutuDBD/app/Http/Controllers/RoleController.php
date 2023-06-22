<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\Role_permission;
use App\Models\User_role;
use DB;


class RoleController extends Controller
{

    public function index()
    {
        $role = Role::all()->where('deleted', false);
        return response()->json($role);  
    }




    public function store(Request $request)
    {
        $role = new Role();
        $request->validate([

          'nombre' => 'required|max:200',
          'descripcion' => 'required|max:140'
        ]);
  
        $timestamp = $role->timestamps;
        
        
        $role -> nombre = $request->nombre;
        $role -> descripcion = $request->descripcion;
        $role -> deleted = false;
        
     
        
        $nombre_rol = DB::table('roles')
                ->where('nombre', $request->nombre)
                ->get()->first();


 
        if ($nombre_rol != null) {
            return "Este rol ya existe.";
        }

  
          $role -> save();
          return response()->json([
            "message" => "Se ha creado un nuevo rol",
            "id" => $role -> id,
            "nombre" => $role -> nombre,
            "descripcion" => $role -> descripcion
          ], 202);
  
    }







    public function show($id)
    {
        $role = Role::find($id);
        if ($role != NULL) {
            if($role->deleted == false){
                return response()->json($role);
            }
        }
        return "No existe un rol con ese ID.";
    }



    public function destroy($id)
    {
      $role = Role::find($id);
      if ($role != NULL) {
          User_role::where('id_rol', $id)->delete();
          Role_permission::where('id_rol',$id)->delete(); 
          $role->delete();
          return response() -> json([
            "message" => "Se ha eliminado definitivamente un rol.",
            "id" => $role -> id
          ],201);
      }
      return "No existe un rol con ese ID.";
    }






    
    public function softDelete($id)
    {
      $role = Role::find($id);
      if ($role != NULL) {
          $role -> deleted = 'true';
          $role -> save();

          return response() -> json([
            "message" => "Se ha borrado momentaneamente un rol.",
            "id" => $id -> id
          ]);
      }
      return "No existe un rol con ese ID.";
    }






    // restaura una tupla borrada suavemente de la BD
    public function restore($id)
    {
      $role = Role::find($id);
      if ($role != NULL) {
          $role -> deleted = false;
          $role -> save();

          return response() -> json([
            "message" => "Se ha restaurado un rol.",
            "id" => $role -> id
          ],200);
      }
      return "No existe un rol con ese ID.";
    }




    

public function update(Request $request, $id){

      $role = Role::find($id);
      if ($role != NULL){
        if($role -> deleted == false){
          if($request -> nombre != NULL){
            $role -> nombre = $request -> nombre;
          }if ($request -> descripcion != NULL){
            $role -> descripcion = $request -> descripcion;
          }
          $role->save();
          return response()->json([
              "message" => "Se ha modificado el rol.",
              "id" => $id
          ], 201);
        }else{
          return "No existe el rol con ese ID ingresado.";
        }
        

      }else{
        return "No existe el rol con el ID ingresado.";
      }


    }
    
}



