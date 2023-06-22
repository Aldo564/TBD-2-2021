<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $video = Video::all()->where('deleted', false);
        return response()->json($video);
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
        $video = new Video();
        $validator = Validator::make($request->all(),[
            'titulo' => 'required|string|max:100',
            'link_video' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => "Ha ocurrido algun error con sus entradas, porfavor reviselas",
            ], 422);
        }
        
        if (is_string($request->titulo)){
            $video->titulo = $request->titulo;
        }
        else{
            return response()->json([
                "message" => "No ha ingresado un string"
            ]);
        }
        if (is_string($request->link_video)){
            if (strpos($request->link_video,"https://api.cuevana3.io/",0) !== false or strpos($request->link_video,"https://www.youtube.com/embed/",0) !== false){
                $video->link_video = $request->link_video;
            }
            else{
                return response()->json([
                    "message" => "No ha ingresado un link"
                ]);
            }
        }
        $video->deleted = false;
        $video->save();
        return response()->json([
            "message" => "Se ha creado un nuevo video.",
            "id" => $video->id
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
        $video = Video::find($id);
        if ($video != NULL) {
            if($video->deleted == false){
                return response()->json($video);
            }
        }
        return "No existe un video con esa ID.";
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
        $video = Video::find($id);
        if ($video != NULL) {
            if($video->deleted == false){
                if ($request->titulo != NULL) {
                    if (is_string($request->titulo)){
                        $video->titulo = $request->titulo;
                    }
                    else{
                        return response()->json([
                            "message" => "No ha ingresado un string"
                        ]);
                    }
                }
                if ($request->link_video != NULL) {
                    if (is_string($request->link_video)){
                        if (strpos($request->link_video,"https://api.cuevana3.io/") !== false or strpos($request->link_video,"https://www.youtube.com/embed/") !== false){
                            $video->link_video = $request->link_video;
                        }
                        else{
                            return response()->json([
                                "message" => "No ha ingresado un link"
                            ]);
                        }
                    }
                    else{
                        return response()->json([
                            "message" => "No ha ingresado un link"
                        ]);
                    }
                }
                $video->save();
                return response()->json($video);
            }
        }
        return "No existe un videos con esa ID.";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = Video::find($id);
        if ($video != NULL) {
            $video->delete();
            return response()->json([
                "message" => "Se ha borrado el video",
                "id" => $id
            ]);
        }
        return "No existe un video con esa ID.";
    }

    public function softDelete($id)
    {
        $video = Video::find($id);

        if($video != NULL){
            $video->deleted = 'true';
            $video->save();
            return response()->json([
                "message" => "Se ha eliminado suavemente el video",
                "id" => $id
            ], 201);

        }
        return "No existe un video con esa ID.";
    }

    public function restore($id)
    {
        $video = Video::find($id);

        if ($video != NULL) {
            $video->deleted = 'false';
            $video->save();
            return response()->json([
                "message" => "Se a restaurado el video",
                "id" => $id
            ]);
        }
        return "No existe un video con esa ID.";
    }
}
