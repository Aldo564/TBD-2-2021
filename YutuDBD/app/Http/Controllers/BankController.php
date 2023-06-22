<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bank;
use App\Models\PayMethod;
use App\Models\User_PayMethod;

class BankController extends Controller
{
    // Muestra todas las tuplas de un modelo
    public function index()
    {
        $bank = Bank::all()->where('deleted', false);;
        return response()->json($bank);
    }


    public function store(Request $request)
    {
        $bank = new Bank();
        $request->validate([
          'nombre' => 'required|max:40'
        ]);

        $bank -> nombre = $request->nombre;
        $bank -> deleted = false;
        $bank -> save();
        return response()->json([
          "message" => "Se ha creado un nuevo banco",
          "nombre" => $bank -> nombre,
          "id" => $bank -> id
        ], 202);
    }

    // Muestra la tupla especifica con el id de entrada
    public function show($id)
    {
      $bank = Bank::find($id);
      if ($bank != NULL) {
          if($bank->deleted == false){
              return response()->json($bank);
          }
      }
      return "No existe un banco con ese ID.";
    }

    // Modificar una nueva tupla de la BD
    public function update(Request $request, $id)
    {
        $bank = Bank::find($id);
        if ($bank != NULL) {
            if($bank->deleted == false){
              $request->validate([
                'nombre' => 'required|max:40'
              ]);

              $bank -> nombre = $request -> nombre;
              $bank -> save();

              return response() -> json([
                "message" => "Se modificado un banco",
                "nombre" => $bank -> nombre,
                "id" => $bank -> id
              ], 201);
            }
        }
        return "No existe un banco con ese ID.";

    }

    // Borrar una tupla fuertemente de la BD
    public function destroy($id)
    {
        $bank = Bank::find($id);
        if ($bank != NULL) {
          $bank -> delete();

          return response() -> json([
            "message" => "Se a borrado un banco",
            "nombre" => $bank -> nombre,
            "id" => $bank -> id
          ]);
        }
        return "No existe un banco con ese ID.";

    }

    // Borrar una tupla suavemente de la BD
    public function softDelete($id)
    {
      $bank = Bank::find($id);
      if ($bank != NULL) {
          $bank -> deleted = 'true';
          $bank -> save();

          return response() -> json([
            "message" => "Se a borrado un banco",
            "nombre" => $bank -> nombre,
            "id" => $bank -> id
          ]);
      }
      return "No existe un banco con ese ID.";
    }

    // restaura una tupla borrada suavemente de la BD
    public function restore($id)
    {
      $bank = Bank::find($id);
      if ($bank != NULL) {
          $bank -> deleted = 'false';
          $bank -> save();

          return response() -> json([
            "message" => "Se a restaurado un banco",
            "nombre" => $bank -> nombre,
            "id" => $bank -> id
          ]);
      }
      return "No existe un banco con ese ID.";
    }
}
