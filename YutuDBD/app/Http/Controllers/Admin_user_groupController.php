<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Group;
use App\Models\Admin_user_group;
use App\Models\View_user_group;
use App\Models\Group_Synopsis;

class Admin_user_groupController extends Controller
{
    public function index()
    {
        $admin_user_group = Admin_user_group::all()->where('deleted', false);
        return response()->json($admin_user_group);  
    }






    public function store(Request $request)
    {
        $admin_user_group = new Admin_user_group();
        $request->validate([

          'id_lista' => 'required',
          'id_usuario' => 'required',
          'es_colab' => 'required',
          'es_propietario' => 'required'
        ]);


        if ($request -> es_propietario == true){
            $listas = Admin_User_Group::all()
                    ->where('es_propietario',true)
                    ->where('id_lista',$request->id_lista);
            if(count($listas) >= 1){
                return "La lista le pertenece a otro usuario.";
            }
            
        }

        $user = User::find($request->id_usuario);
        $group = Group::find($request->id_group);

        if ($user != NULL && $group != NULL){
            
            if($user->deleted == false && $group->deleted == false){
                if ($request -> es_propietario == true){
    
                    $admin_user_group->es_colab = true;
                    $admin_user_group->id_usuario = $request->id_usuario;
                    $admin_user_group->id_lista = $request->id_lista;
                    $admin_user_group->es_propietario = $request->es_propietario;
                    $admin_user_group->deleted = false;
                    $admin_user_group->save();
                    return response()->json([
                        "message" => "Se ha creado una nueva relación usuario-lista.",
                        "id" => $admin_user_group->id,
                        "id_lista" => $admin_user_group->id_lista,
                    ], 202);
                }else{
                    $admin_user_group->id_usuario = $request->id_usuario;
                    $admin_user_group->id_lista = $request->id_lista;
                    $admin_user_group->es_colab = $request->es_colab;
                    $admin_user_group->es_propietario = $request->es_propietario;
                    $admin_user_group->deleted = false;
                    $admin_user_group->save();
                    return response()->json([
                        "message" => "Se ha creado una nueva relación usuario-lista.",
                        "id" => $admin_user_group->id,
                        "id_lista" => $admin_user_group->id_lista,
                    ], 202);
                }
                
            }

        }
        
        return "No se puede crear la relación porque uno de los elementos no existe.";
    
    }









    public function show($id)
    {
        $admin_user_group = Admin_user_group::find($id);
        if ($admin_user_group != NULL) {
            if($admin_user_group->deleted == false){
                return response()->json($admin_user_group);
            }
        }
        return "No existe una relación entre usuario-lista.";
    }











//Elimina permanentemente
    public function destroy($id)
    {
        $admin_user_group = Admin_user_group::find($id);
        if ($admin_user_group != NULL) {
            if ($admin_user_group->es_propietario == true){

                Group_Synopsis::where('id_group', $admin_user_group->id_lista)->delete();
                View_user_group::where('id_lista', $admin_user_group->id_lista)->delete();
                Group::where('id', $admin_user_group->id_lista)->delete();
                $admin_user_group->delete();

            }
            else{
                $admin_user_group->delete();
            }
            return response()->json([
                "message" => "Se ha borrado permanentemente la relación entre el usuario y lista.",
                "id" => $id
            ], 201);
        }
        return "No exista la relación entre usuario-lista con ese ID.";
    }






//Elimina temporalmente   
    public function softDelete($id)
    {
        $admin_user_group = Admin_user_group::find($id);

        if($admin_user_group != NULL){
            $admin_user_group->deleted = 'true';
            $admin_user_group->save();
            return response()->json([
                "message" => "Se ha borrado temporalmente la relacion entre el usuario y la lista.",
                "id" => $id
            ], 201);

        }
        return "El usuario no está asociado a la lista.";
    }






//Restaura un softdelete
    public function restore($id)
    {
      $admin_user_group = Admin_user_group::find($id);
      if($admin_user_group != NULL){
        if ($admin_user_group -> deleted == true) {
            $admin_user_group -> deleted = false;
            $admin_user_group -> save();
  
            return response() -> json([
              "message" => "Se ha restaurado una relacion entre el usuario y la lista.",
              "id" => $admin_user_group -> id
            ], 200);
        }else{
            return "La relación no ha sido eliminada.";
        }
      }

      return "El usuario no está asociado a la lista.";
    }






public function update(Request $request, $id){

    $admin = Admin_user_group::find($id);
    if ($admin != NULL){
      if($admin -> deleted == false){
        if($request->id_lista != NULL){
          $admin -> id_lista = $request -> id_lista;
        }if ($request -> id_usuario != NULL){
          $admin -> id_usuario = $request -> id_usuario;
        }if ($request -> es_colab != NULL){
            $admin -> es_colab = $request -> es_colab;
        }if ($request -> es_propietario != NULL){
            $admin -> es_propietario = $request -> es_propietario;
        }

        $admin->save();
        return response()->json([
            "message" => "Se ha modificado la relación.",
            "id" => $id
        ], 201);
      }else{
        return "No existe la relación con el ID ingresado.";
      }
      

    }else{
      return "No existe la relación con el ID ingresado.";
    }


  }
}