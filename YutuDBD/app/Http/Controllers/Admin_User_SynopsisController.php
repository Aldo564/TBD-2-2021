<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin_User_Synopsis;
use App\Models\Category_Synopsis;
use App\Models\Group_Synopsis;
use App\Models\Synopsis;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class Admin_User_SynopsisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adm_user_syn = Admin_User_Synopsis::all()->where('deleted', false);
        return response()->json($adm_user_syn);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $adm_user_syn = new Admin_User_Synopsis();
        $validator = Validator::make($request->all(),[
            'id_usuario' => 'required|int',
            'id_sinopsis' => 'required|int',
            'es_colab' => 'required|bool',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => "Ha ocurrido algun error con sus entradas, porfavor reviselas",
            ], 422);
        }
        if($request->es_propietario != true){
            $adm_user_syn->es_propietario = false;
        }
        else{
            $rows = Admin_User_Synopsis::all()->where('es_propietario',true)->where('id_sinopsis',$request->id_sinopsis);
            if(count($rows) >= 1){
                return "Ya existe una persona que es propietaria de esa sinopsis";
            }
        }
        $user = User::find($request->id_usuario);
        $synopsis = Synopsis::find($request->id_sinopsis);
        if($user->deleted == false && $synopsis->deleted == false){
            $adm_user_syn->id_usuario = $request->id_usuario;
            $adm_user_syn->id_sinopsis = $request->id_sinopsis;
            $adm_user_syn->es_colab = $request->es_colab;
            $adm_user_syn->deleted = false;
            $adm_user_syn->save();
            return response()->json([
                "message" => "Se ha creado una nueva relacion entre usuario y categoria (se ha añadido un colaborador o se ha creado una categoria).",
                "id" => $adm_user_syn->id,
                "id_sinopsis" => $adm_user_syn->id_sinopsis
            ], 202);
        }
        return "no se puede agregar ya que uno de los elementos se encuentra eliminado";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $adm_user_syn = Admin_User_Synopsis::find($id);
        if ($adm_user_syn != NULL) {
            if($adm_user_syn->deleted == false){
                return response()->json($adm_user_syn);
            }
        }
        return "No existe una relacion de usuario con sinopsis con esa ID.";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $adm_user_syn = Admin_User_Synopsis::find($id);
        if ($adm_user_syn != NULL) {
            if($adm_user_syn->deleted == false){
                if ($request->id_usuario != NULL) {
                    if(is_int($request->id_usuario)){
                        $user = User::find($request->id_usuario);
                        if ($user->deleted == false){
                            $adm_user_syn->id_usuario = $request->id_usuario;
                        }
                        else{
                            return "no se puede agregar un usuario que no existe";
                        }
                    }
                }
                if ($request->id_sinopsis != NULL) {
                    if(is_int($request->id_sinopsis)){
                        $synopsis = Synopsis::find($request->id_sinopsis);
                        if ($synopsis->deleted == false){
                            $adm_user_syn->id_sinopsis = $request->id_sinopsis;
                        }
                        else{
                            return "no se puede agregar una sinopsis que no existe";
                        }
                    }
                }
                if ($request->es_colab != NULL) {
                    if(is_bool($request->es_colab)){
                        $adm_user_syn->es_colab = $request->es_colab;
                    }
                }
                if ($request->es_propietario != NULL) {
                    if(is_bool($request->es_colab)){
                        if($request->es_propietario != true){
                            $adm_user_syn->es_propietario = false;
                            Category_Synopsis::where('id_sinopsis', $adm_user_syn->id_sinopsis)->delete();
                            Group_Synopsis::where('id_sinopsis', $adm_user_syn->id_sinopsis)->delete();
                            Synopsis::find($adm_user_syn->id_sinopsis)->delete();
                            $adm_user_syn->delete();
                        }
                        else{
                            $rows = Admin_User_Synopsis::all()->where('es_propietario',true)->where('id_sinopsis',$adm_user_syn->id_sinopsis);
                            print($rows);
                            if(count($rows) >= 1){
                                return "Ya existe una persona que es propietaria de esa sinopsis";
                            }
                            else{
                                $adm_user_syn->es_propietario = true;
                            }
                        }
                    }
                }
                $adm_user_syn->save();
                return response()->json($adm_user_syn);
            }
        }
        return "No existe una relacion de usuario con sinopsis con esa ID.";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adm_user_syn = Admin_User_Synopsis::find($id);
        if ($adm_user_syn != NULL) {
            if ($adm_user_syn->es_propietario == true){
                Category_Synopsis::where('id_sinopsis', $adm_user_syn->id_sinopsis)->delete();
                Group_Synopsis::where('id_sinopsis', $adm_user_syn->id_sinopsis)->delete();
                Admin_User_Synopsis::where('id_sinopsis', $adm_user_syn->id_sinopsis)->delete();
                Synopsis::find($adm_user_syn->id_sinopsis)->delete();
            }
            else{
                $adm_user_syn->delete();
            }
            return response()->json([
                "message" => "Se ha borrado la relacion entre usuario y sinopsis (se ha eliminado la participacion de un usuario en la sinopsis)",
                "id" => $id
            ]);
        }
        return "No existe una relacion de usuario con sinopsis con esa ID.";
    }

    public function softDelete($id)
    {
        $adm_user_syn = Admin_User_Synopsis::find($id);

        if($adm_user_syn != NULL){
            $adm_user_syn->deleted = 'true';
            $adm_user_syn->save();
            return response()->json([
                "message" => "Se ha borrado la relacion entre usuario y sinopsis (se ha eliminado la participacion de un usuario en la sinopsis)",
                "id" => $id
            ], 201);

        }
        return "No existe una relacion de usuario con sinopsis con esa ID.";
    }

    public function restore($id)
    {
        $adm_user_syn = Admin_User_Synopsis::find($id);

        if ($adm_user_syn != NULL) {
            $adm_user_syn->deleted = 'false';
            $adm_user_syn->save();
            return response()->json([
                "message" => "Se a restaurado la relacion entre usuario y sinopsis (se ha restaurado la participacion de un usuario en la sinopsis)",
                "id" => $id
            ]);
        }
        return "No existe una relacion de usuario con sinopsis con esa ID.";
    }
}
