<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Category_Synopsis;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function mensajeAlt()
    {
        $mensajes = array(
            'If Only You Knew The Power Of The Dark Side...', 
            'Okaerinasai Master !',
            'It’s showtime!',
            'How Good To See You Again So Soon, Mr. Wick',
            'Say My Name',
            'You shall not Pass',
            'There’s no place like home.',
            'Welcome to the party, pal.'
        );
         
        $todo=(count($mensajes)-1);
        $num=rand(0,$todo);
        $mensaje = $mensajes[$num];

        return $mensaje;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all()->where('deleted', false);
        $mensaje = CategoryController::mensajeAlt();
        return view('home', compact('category'));
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
        $category = new Category();
        $validator = Validator::make($request->all(),[
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => "Ha ocurrido algun error con sus entradas, porfavor reviselas",
            ], 422);
        }
        $category->nombre = $request->nombre;
        $category->descripcion = $request->descripcion;
        $category->deleted = false;
        $category->save();
        return response()->json([
            "message" => "Se ha creado una nueva categoria.",
            "id" => $category->id,
        ], 202);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if (!empty($category)) {
            if($category->deleted == false){
                $mensaje = CategoryController::mensajeAlt();
                return view('home', compact('category'));
            }
        }
        return "No existe una categoria con esa ID.";
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
        $category = Category::find($id);
        if ($category != NULL) {
            if($category->deleted == false){
                if ($request->descripcion != NULL) {
                    if (is_string($request->descripcion)){
                        $category->descripcion = $request->descripcion;
                    }
                }
                if ($request->nombre != NULL) {
                    if (is_string($request->nombre)){
                        $category->nombre = $request->nombre;
                    }
                }
                $category->save();
                return response()->json($category);
            }
        }
        return "No existe una categoria con esa ID.";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category != NULL) {
            Category_Synopsis::where('id_categoria', $id)->delete();
            $category->delete();
            return response()->json([
                "message" => "Se ha borrado la categoria",
                "id" => $id
            ]);
        }
        return "No existe una categoria con esa ID.";
    }

    public function softDelete($id)
    {
        $category = Category::find($id);

        if($category != NULL){
            $category->deleted = 'true';
            $category->save();
            return response()->json([
                "message" => "Se ha borrado la categoria",
                "id" => $id
            ], 201);

        }
        return "No existe una categoria con esa ID.";
    }

    public function restore($id)
    {
        $category = Synopsis::find($id);

        if ($category != NULL) {
            $category->deleted = 'false';
            $category->save();
            return response()->json([
                "message" => "Se a restaurado la categoria",
                "id" => $id
            ]);
        }
        return "No existe una categoria con esa ID.";
    }
}
