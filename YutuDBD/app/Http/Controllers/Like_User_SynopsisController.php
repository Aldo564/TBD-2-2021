<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Like_User_Synopsis;
use App\Models\User;
use App\Models\Synopsis;

class Like_User_SynopsisController extends Controller
{
    // Muestra todas las tuplas de un modelo
    public function index()
    {
        $like_user_syn = Like_User_Synopsis::all()->where('deleted', false);;
        return response()-> json($like_user_syn);
    }

    public function store(Request $request)
    {
      $like_user_syn = new Like_User_Synopsis();
      $request->validate([
        'estado' => 'required',
        'id_usuario' => 'required',
        'id_sinopsis' => 'required'
      ]);

      #$date = date('d-m-Y H:i:s', $like_user_syn->timestamps);

      $like_user_syn -> estado = $request->estado;
      $like_user_syn -> id_usuario = $request->id_usuario;
      $like_user_syn -> id_sinopsis = $request->id_sinopsis;
      $like_user_syn -> deleted = false;
      $like_user_syn -> save();
      return response()->json([
        "message" => "Se ha creado una nueva relacion entre usuario y sinopsis (Like)",
        "id_usuario" => $like_user_syn -> id_usuario,
        "id_sinopsis" => $like_user_syn -> id_sinopsis
      ], 202);
    }

    public function show($id)
    {
      $like_user_syn = Like_User_Synopsis::find($id);
      if ($like_user_syn != NULL) {
          if($like_user_syn->deleted == false){
              return response()->json($like_user_syn);
          }
      }
      return "No existe una relacion de usuario y sinopsis (Like) con ese ID.";
    }

    public function update(Request $request, $id)
    {
      $like_user_syn = Like_User_Synopsis::find($id);
      if ($like_user_syn != NULL) {
          if($like_user_syn->deleted == false){
              $request->validate([
                'estado' => 'required',
                'id_usuario' => 'required',
                'id_sinopsis' => 'required'
              ]);

              #$date = date('d-m-Y H:i:s', $like_user_syn->timestamps);

              $like_user_syn -> estado = $request->estado;
              $like_user_syn -> id_usuario = $request->id_usuario;
              $like_user_syn -> id_sinopsis = $request->id_sinopsis;
              $like_user_syn -> save();
              return response()->json([
                "message" => "Se ha creado una nueva relacion entre usuario y sinopsis (Like)",
                "id_usuario" => $like_user_syn -> id_usuario,
                "id_sinopsis" => $like_user_syn -> id_sinopsis
              ], 202);
          }
      }
      return "No existe una relacion entre usuario y sinopsis (Like) con ese ID.";
    }

    // Borrar una tupla fuertemente de la BD
    public function destroy($id)
    {
      $like_user_syn = Like_User_Synopsis::find($id);
      if ($like_user_syn != NULL) {

        $like_user_syn -> delete();

        return response() -> json([
          "message" => "se ha borrado una relacion entre usuario y sinopsis (Like)",
          "id" => $like_user_syn -> id
        ]);
      }
      return "No existe una relacion entre usuario y sinopsis (Like) con ese ID.";
    }

    // Borrar una tupla suavemente de la BD
    public function softDelete($id)
    {
      $like_user_syn = Like_User_Synopsis::find($id);
      if ($like_user_syn != NULL) {
          $like_user_syn -> deleted = 'true';
          $like_user_syn -> save();

          return response() -> json([
            "message" => "se ha borrado una relacion entre usuario y sinopsis (Like)",
            "id" => $like_user_syn -> id
          ]);
      }
      return "No existe una relacion entre usuario y sinopsis (Like) con ese ID.";
    }

    // restaura una tupla borrada suavemente de la BD
    public function restore($id)
    {
      $like_user_syn = Like_User_Synopsis::find($id);
      if ($like_user_syn != NULL) {
          $like_user_syn -> deleted = 'false';
          $like_user_syn -> save();

          return response() -> json([
            "message" => "se ha restaurado una relacion entre usuario y sinopsis (Like)",
            "id" => $like_user_syn -> id
          ]);
      }
      return "No existe una relacion entre usuario y sinopsis (Like) con ese ID.";
    }
}
