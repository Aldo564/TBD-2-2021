<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PayMethod;
use App\Models\TypeOfPayment;
use App\Models\Bank;


class PayMethodController extends Controller
{
    // Muestra todas las tuplas de un modelo
    public function index()
    {
        $paymethod = PayMethod::all()->where('deleted', false);;
        return response()-> json($paymethod);
    }

    public function store(Request $request)
    {
      $paymethod = new PayMethod();
      $request->validate([
        'numero_tarjeta' => 'required',
        'nombre_cliente' => 'required|max:40',
        'apellido_cliente' => 'required|max:40',
        'mes_expiracion' => 'required',
        'anio_expiracion' => 'required',
        'tipo_metodo' => 'required',
        'id_banco' => 'required',
      ]);

      $paymethod -> numero_tarjeta = $request->numero_tarjeta;
      $paymethod -> nombre_cliente = $request->nombre_cliente;
      $paymethod -> apellido_cliente = $request->apellido_cliente;
      $paymethod -> mes_expiracion = $request->mes_expiracion;
      $paymethod -> anio_expiracion = $request->anio_expiracion;
      $paymethod -> tipo_metodo = $request->tipo_metodo;
      $paymethod -> id_banco = $request->id_banco;
      $paymethod -> deleted = false;
      $paymethod -> save();
      return response()->json([
        "message" => "Se ha creado un nuevo metodo de pago",
        "id" => $paymethod -> id,
        "nombre_cliente" => $paymethod -> nombre_cliente,
        "apellido_cliente" => $paymethod -> apellido_cliente
      ], 202);
    }

    public function show($id)
    {
      $paymethod = PayMethod::find($id);
      if ($paymethod != NULL) {
          if($paymethod->deleted == false){
              return response()->json($paymethod);
          }
      }
      return "No existe un metodo de pago con ese ID.";
    }

    public function update(Request $request, $id)
    {
      $paymethod = PayMethod::find($id);
      if ($paymethod != NULL) {
          if($paymethod->deleted == false){
              $request->validate([
                'numero_tarjeta' => 'required',
                'nombre_cliente' => 'required|max:40',
                'apellido_cliente' => 'required|max:40',
                'mes_expiracion' => 'required',
                'anio_expiracion' => 'required',
                'tipo_metodo' => 'required',
                'id_banco' => 'required',
              ]);

              $paymethod -> numero_tarjeta = $request->numero_tarjeta;
              $paymethod -> nombre_cliente = $request->nombre_cliente;
              $paymethod -> apellido_cliente = $request->apellido_cliente;
              $paymethod -> mes_expiracion = $request->mes_expiracion;
              $paymethod -> anio_expiracion = $request->anio_expiracion;
              $paymethod -> tipo_metodo = $request->tipo_metodo;
              $paymethod -> id_banco = $request->id_banco;
              $paymethod -> save();
              return response()->json([
                "message" => "Se ha modificado un metodo de pago",
                "id" => $paymethod -> id,
                "nombre_cliente" => $paymethod -> nombre_cliente,
                "apellido_cliente" => $paymethod -> apellido_cliente
              ], 201);
          }
      }
      return "No existe un metodo de pago con ese ID.";
    }

    // Borrar una tupla fuertemente de la BD
    public function destroy($id)
    {
      $paymethod = PayMethod::find($id);
      if ($paymethod != NULL) {

        $paymethod -> delete();

        return response() -> json([
          "message" => "Se a borrado un metodo de pago",
          "id" => $paymethod -> id
        ]);
      }
      return "No existe un metodo de pago con ese ID.";
    }

    // Borrar una tupla suavemente de la BD
    public function softDelete($id)
    {
      $paymethod = PayMethod::find($id);
      if ($paymethod != NULL) {
          $paymethod -> deleted = 'true';
          $paymethod -> save();

          return response() -> json([
            "message" => "Se a borrado un metodo de pago",
            "id" => $paymethod -> id
          ]);
      }
      return "No existe un metodo de pago con ese ID.";
    }

    // restaura una tupla borrada suavemente de la BD
    public function restore($id)
    {
      $paymethod = PayMethod::find($id);
      if ($paymethod != NULL) {
          $paymethod -> deleted = 'false';
          $paymethod -> save();

          return response() -> json([
            "message" => "Se a restaurado un metodo de pago",
            "id" => $paymethod -> id
          ]);
      }
      return "No existe un metodo de pago con ese ID.";
    }
}
