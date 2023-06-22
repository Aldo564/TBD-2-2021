<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category_Synopsis;
use App\Models\Category;
use App\Models\Synopsis;
use Illuminate\Support\Facades\Validator;

class Category_SynopsisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cat_syn = Category_Synopsis::all()->where('deleted', false);
        return response()->json($cat_syn);
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
        $cat_syn = new Category_Synopsis();
        $validator = Validator::make($request->all(),[
            'id_categoria' => 'required|int',
            'id_sinopsis' => 'required|int',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => "Ha ocurrido algun error con sus entradas, porfavor reviselas",
            ], 422);
        }
        $category = Category::find($request->id_categoria);
        $synopsis = Synopsis::find($request->id_sinopsis);
        if($category->deleted == false && $synopsis->deleted == false){
            $cat_syn->id_categoria = $request->id_categoria;
            $cat_syn->id_sinopsis = $request->id_sinopsis;
            $cat_syn->deleted = false;
            $cat_syn->save();
            return response()->json([
                "message" => "Se ha creado una nueva relacion entre categoria y video (se ha añadido un video a la categoria).",
                "id" => $cat_syn->id,
                "id_lista" => $cat_syn->id_categoria
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
        $cat_syn = Category_Synopsis::find($id);
        if ($cat_syn != NULL) {
            if($cat_syn->deleted == false){
                return response()->json($cat_syn);
            }
        }
        return "No existe una relacion de categoria con sinopsis con esa ID.";
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
        $cat_syn = Category_Synopsis::find($id);

        if ($cat_syn != NULL) {
            if ($request->id_categoria != NULL) {
                if(is_int($request->id_categoria)){
                    $category = Category::find($request->id_categoria);
                    if($category->deleted == false){
                        $cat_syn->id_categoria = $request->id_categoria;
                    }
                    else{
                        return "No se puede agregar una categoria que no existe";
                    }
                }
            }
            if ($request->id_sinopsis != NULL) {
                if(is_int($request->id_sinopsis)){
                    $synopsis = Synopsis::find($request->id_sinopsis);
                    if($synopsis->deleted == false){
                        $cat_syn->id_sinopsis = $request->id_sinopsis;
                    }
                    else{
                        return "No se puede agregar una sinopsis que no existe";
                    }
                }
            }
            $cat_syn->save();
            return response()->json($cat_syn);
        }
        return "No existe una relacion de categoria con sinopsis con esa ID.";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat_syn = Category_Synopsis::find($id);
        if ($cat_syn != NULL) {
            $cat_syn->delete();
            return response()->json([
                "message" => "Se ha borrado la relacion entre categoria y sinopsis (se ha eliminado una sinopsis de la categoria)",
                "id" => $id
            ]);
        }
        return "No existe una relacion de categoria con sinopsis con esa ID.";
    }

    public function softDelete($id)
    {
        $cat_syn = Category_Synopsis::find($id);

        if($cat_syn != NULL){
            $cat_syn->deleted = 'true';
            $cat_syn->save();
            return response()->json([
                "message" => "Se ha borrado la relacion entre categoria y sinopsis (se ha eliminado una sinopsis de la categoria)",
                "id" => $id
            ], 201);

        }
        return "No existe una relacion de categoria con sinopsis con esa ID.";
    }

    public function restore($id)
    {
        $cat_syn = Category_Synopsis::find($id);

        if ($cat_syn != NULL) {
            $cat_syn->deleted = 'false';
            $cat_syn->save();
            return response()->json([
                "message" => "Se a restaurado la relacion entre categoria y sinopsis (se ha eliminado una sinopsis de la categoria)",
                "id" => $id
            ]);
        }
        return "No existe una relacion de categoria con sinopsis con esa ID.";
    }
}
