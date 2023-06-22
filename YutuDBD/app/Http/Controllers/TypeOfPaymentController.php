<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TypeOfPayment;

class TypeOfPaymentController extends Controller
{

    // Muestra todas las tuplas de un modelo
    public function index()
    {
        $typeofpayment = TypeOfPayment::all()->where('deleted', false);;
        return response()-> json($typeofpayment);
    }

    public function store(Request $request)
    {
      $typeofpayment = new TypeOfPayment();
      $request->validate([
        'descripcion' => 'required|max:20'
      ]);

      $typeofpayment -> descripcion = $request->descripcion;
      $typeofpayment -> deleted = false;
      $typeofpayment -> save();
      return response()->json([
        "message" => "Se ha creado un nuevo tipo de pago",
        "id" => $typeofpayment -> id,
        "descripcion" => $typeofpayment -> descripcion

      ], 202);
    }

    // Muestra la tupla especifica con el id de entrada
    public function show($id)
    {
      $typeofpayment = TypeOfPayment::find($id);
      if ($typeofpayment != NULL) {
          if($typeofpayment->deleted == false){
              return response()->json($typeofpayment);
          }
      }
      return "No existe un tipo de pago con ese ID.";
    }

    // Revisar en postman
    public function update(Request $request, $id)
    {
      $typeofpayment = TypeOfPayment::find($id);
      if ($typeofpayment != NULL) {
          if($typeofpayment->deleted == false){
              $request->validate([
                'descripcion' => 'required|max:20'
              ]);

              $typeofpayment -> descripcion = $request->descripcion;
              $typeofpayment -> save();
              return response()->json([
                "message" => "Se ha modificado un tipo de pago",
                "id" => $typeofpayment -> id,
                "descripcion" => $typeofpayment -> descripcion

              ], 201);
          }
      }
      return "No existe un tipo de pago con ese ID.";
    }

    // Borrar una tupla fuertemente de la BD
    public function destroy($id)
    {
      $typeofpayment = TypeOfPayment::find($id);
      if ($typeofpayment != NULL) {
          $typeofpayment -> delete();

          return response() -> json([
            "message" => "Se a borrado un tipo de pago",
            "id" => $typeofpayment -> id
          ]);
      }
      return "No existe un tipo de pago con ese ID.";
    }

    // Borrar una tupla suavemente de la BD
    public function softDelete($id)
    {
      $typeofpayment = TypeOfPayment::find($id);
      if ($typeofpayment != NULL) {
          $typeofpayment -> deleted = 'true';
          $typeofpayment -> save();

          return response() -> json([
            "message" => "Se a borrado un tipo de pago",
            "id" => $typeofpayment -> id
          ]);
      }
      return "No existe un tipo de pago con ese ID.";
    }

    // restaura una tupla borrada suavemente de la BD
    public function restore($id)
    {
      $typeofpayment = TypeOfPayment::find($id);
      if ($typeofpayment != NULL) {
          $typeofpayment -> deleted = 'false';
          $typeofpayment -> save();

          return response() -> json([
            "message" => "Se a restaurado un tipo de pago",
            "id" => $typeofpayment -> id
          ]);
      }
      return "No existe un tipo de pago con ese ID.";
    }
}
