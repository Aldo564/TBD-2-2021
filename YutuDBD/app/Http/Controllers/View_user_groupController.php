<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\View_user_group;
use App\Models\User;
use App\Models\Group;


class View_user_groupController extends Controller
{

    public function index()
    {
        $view_user_group = View_user_group::all()->where('deleted', false);
        return response()->json($view_user_group);  
    }






    public function store(Request $request)
    {
        $view_user_group = new View_user_group();
        $request->validate([

          'id_lista' => 'required',
          'id_usuario' => 'required',
        ]);

            $user = User::find($request->id_usuario);
            $group = Group::find($request->id_group);

            if($user != NULL && $group != NULL){
                $role -> id_lista = $request->id_lista;
                $role -> id_usuario = $request->id_usuario;
                $role -> deleted = false;
                $role -> save();
            
                return response()->json([
                    "message" => "Se ha añadido una nueva vista a la lista.",
                    "id_lista" => $role -> id_lista,
                    "id" => $role -> id,
                    "id_usuario" => $role -> id_usuario
                    ], 202);
            }else{
                return "No existe alguno de los elementos.";
            }
            
        }






    public function show($id)
    {
        $view_user_group = View_user_group::find($id);
        if ($view_user_group != NULL) {
            if($view_user_group->deleted == false){
                return response()->json($view_user_group);
            }
        }
        return "No existe una visualización con ese ID.";
    }





//Elimina permanentemente
    public function destroy($id)
    {
    $view_user_group = View_user_group::find($id);
    if ($view_user_group != NULL) {

        $view_user_group -> delete();

        return response() -> json([
            "message" => "Se ha borrado permanentemente una visualización del usuario a la lista.",
            "id" => $view_user_group -> id
        ]);
    }
    return "El ID no corresponde a una visualización del usuario.";
    }






//Elimina temporalmente   
    public function softDelete($id)
    {
        $view_user_group = View_user_group::find($id);

        if($view_user_group != NULL){
            $view_user_group->deleted = 'true';
            $view_user_group->save();
            return response()->json([
                "message" => "Se ha borrado temporalmente la la visualizacion del usuario a la lista.",
                "id" => $id
            ], 201);

        }
        return "El ID no corresponde a una visualización del usuario.";
    }






//Restaura un softdelete
    public function restore($id)
    {
      $view_user_group = view_user_group::find($id);
      if ($view_user_group != NULL) {
          $view_user_group -> deleted = 'false';
          $view_user_group -> save();

          return response() -> json([
            "message" => "Se ha restaurado una relacion entre el usuario y la lista.",
            "id" => $view_user_group -> id
          ]);
      }
      return "El usuario no está asociado a la lista.";
    }



public function update(Request $request, $id){

    $view = View_user_group::find($id);
    if ($view != NULL){
      if($view -> deleted == false){
        if($request -> id_lista != NULL){
          $view -> id_lista = $request -> id_lista;
        }if ($request -> id_usuario != NULL){
          $view -> id_usuario = $request -> id_usuario;
        }
        $view->save();
        return response()->json([
            "message" => "Se ha modificado la relación.",
            "id" => $id
        ], 201);
      }else{
        return "No existe la relación vista-grupo con el ID ingresado.";
      }
      

    }else{
      return "No existe la relación vista-grupo con el ID ingresado.";
    }


  }
  
}
