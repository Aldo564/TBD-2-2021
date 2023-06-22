<?php

namespace App\Http\Controllers;

use \DateTime;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Synopsis;

use App\Models\Historial_User_Synopsis;

class Historial_User_SynopsisController extends Controller
{
    // Muestra todas las tuplas de un modelo
    public function index()
    {
        $hist_user_syn = Historial_User_Synopsis::all()->where('deleted', false);;
        return response()-> json($hist_user_syn);
    }

    // No funciona
    public function store(Request $request)
    {
      $hist_user_syn = new Historial_User_Synopsis();
      $request->validate([
        'id_usuario' => 'required',
        'id_sinopsis' => 'required'
      ]);


      $format = "d-M-y";
      $formathour = "H:i:s";
      $date = new DateTime();
      $timestamp = $date -> getTimestamp();
      $fecha = date($format, $timestamp);
      $hora = date($formathour, $timestamp);

      $hist_user_syn -> fecha = $fecha;
      $hist_user_syn -> hora = $hora;
      $hist_user_syn -> id_usuario = $request->id_usuario;
      $hist_user_syn -> id_sinopsis = $request->id_sinopsis;
      $hist_user_syn -> deleted = false;
      $hist_user_syn -> save();
      return response()->json([
        "message" => "Se ha creado una nueva relacion entre usuario y sinopsis (Historial)",
        "fecha" => $hist_user_syn -> fecha,
        "hora" => $hist_user_syn -> hora,
        "id_usuario" => $hist_user_syn -> id_usuario,
        "id_sinopsis" => $hist_user_syn -> id_sinopsis
      ], 202);
    }

    // Muestra la tupla especifica con el id de entrada
    public function show($id)
    {
      $hist_user_syn = Historial_User_Synopsis::find($id);
      if ($hist_user_syn != NULL) {
          if($hist_user_syn->deleted == false){
              return response()->json($hist_user_syn);
          }
      }
      return "No existe una relacion entre usuario y sinopsis (Historial) con ese ID.";
    }

    public function update(Request $request, $id)
    {
      $hist_user_syn = Historial_User_Synopsis::find($id);
      if ($hist_user_syn != NULL) {
          if($hist_user_syn->deleted == false){
              $request->validate([
                #'fecha' => 'nullable|date',
                #'hora' => 'nullable',
                'id_usuario' => 'required',
                'id_sinopsis' => 'required'
              ]);


              $format = "d-M-y";
              $formathour = "H:i:s";
              $timestamp = $hist_user_syn->timestamps;
              $fecha = date($format, $timestamp);
              $hora = date($formathour, $timestamp);

              $hist_user_syn -> fecha = $fecha;
              $hist_user_syn -> hora = $hora;
              $hist_user_syn -> id_usuario = $request->id_usuario;
              $hist_user_syn -> id_sinopsis = $request->id_sinopsis;
              $hist_user_syn -> save();
              return response()->json([
                "message" => "Se ha modificado una relacion entre usuario y sinopsis (Historial)",
                "fecha" => $hist_user_syn -> fecha,
                "hora" => $hist_user_syn -> hora,
                "id_usuario" => $hist_user_syn -> id_usuario,
                "id_sinopsis" => $hist_user_syn -> id_sinopsis
              ], 201);
          }
      }
      return "No existe una relacion entre usuario y sinopsis (Historial) con ese ID.";
    }

    // Borrar una tupla fuertemente de la BD
    public function destroy($id)
    {
      $hist_user_syn = Historial_User_Synopsis::find($id);
      if ($hist_user_syn != NULL) {

        $hist_user_syn -> delete();

        return response() -> json([
          "message" => "se ha borrado una relacion entre usuario y sinopsis (Historial)",
          "id" => $hist_user_syn -> id
        ]);
      }
      return "No existe una relacion entre usuario y sinopsis (Historial) con ese ID.";
    }

    // Borrar una tupla suavemente de la BD
    public function softDelete($id)
    {
      $hist_user_syn = Historial_User_Synopsis::find($id);
      if ($hist_user_syn != NULL) {
          $hist_user_syn -> deleted = 'true';
          $hist_user_syn -> save();

          return response() -> json([
            "message" => "se ha borrado una relacion entre usuario y sinopsis (Historial)",
            "id" => $hist_user_syn -> id
          ]);
      }
      return "No existe una relacion entre usuario y sinopsis (Historial) con ese ID.";
    }

    // restaura una tupla borrada suavemente de la BD
    public function restore($id)
    {
      $hist_user_syn = Historial_User_Synopsis::find($id);
      if ($hist_user_syn != NULL) {
          $hist_user_syn -> deleted = 'false';
          $hist_user_syn -> save();

          return response() -> json([
            "message" => "se ha restaurado una relacion entre usuario y sinopsis (Historial)",
            "id" => $hist_user_syn -> id
          ]);
      }
      return "No existe una relacion entre usuario y sinopsis (Historial) con ese ID.";
    }
}
