<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \DateTime;
use App\Models\Synopsis;
use App\Models\Group_Synopsis;
use App\Models\Category;
use App\Models\Category_Synopsis;
use App\Models\Comment;
use App\Models\Video;
use App\Models\User;
use App\Models\Admin_User_Synopsis;
use App\Models\Historial_User_Synopsis;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DB;

class CommentController extends Controller
{
    // Muestra todas las tuplas de un modelo
    public function index()
    {
        $comment = Comment::all()->where('deleted', false);
        return response()-> json($comment);
    }





    public function store(Request $request)
    {
      $comment = new Comment();
      $request->validate([
        'texto' => 'required|max:140',
        'id_sinopsis' => 'required'
      ]);

      $format = "d-M-y";
      $date = new DateTime();
      $timestamp = $date->getTimestamp();
      $fecha = date($format, $timestamp);

      $comment -> fecha = $fecha;
      $comment -> texto = $request->texto;
      $comment -> id_usuario = session('user')->id;
      $comment -> id_sinopsis = $request->id_sinopsis;
      $comment -> deleted = false;

      $comment -> save();



      


      $synopsis = Synopsis::all()
      ->where('id', $request->id_sinopsis)
      ->first();


      $usuarios = User::all()->where('deleted',false);
      $id = $request->id_sinopsis;
      if(!empty($synopsis)){
            $video = Video::all()
                            ->where('id',$synopsis->id_video)
                            ->first();

            if(!empty($video)){
                $usera = DB::table('admin__user__synopses')
                            ->join('users', 'admin__user__synopses.id_usuario', '=', 'users.id')
                            ->where('admin__user__synopses.id_sinopsis', $id)
                            ->where('admin__user__synopses.es_propietario', true)
                            ->select('users.*')
                            ->get()
                            ->first();

                $category = DB::table('category__synopses')
                            ->join('categories', 'category__synopses.id_categoria', '=', 'categories.id')
                            ->where('category__synopses.id_sinopsis', $id)
                            ->select('categories.*')
                            ->get();

                $comment = DB::table('comments')
                            ->join('synopses','synopses.id', '=', 'comments.id_sinopsis')
                            ->where('synopses.id', $id)
                            ->select('comments.*')
                            ->get();

                $userc = DB::table('users')
                            ->join('comments', 'comments.id_usuario', '=', 'users.id')
                            ->get();


                $likes = DB::table('like__user__synopses')
                            ->where('id_sinopsis', $id)
                            ->where('estado', 0)
                            ->count();

                $dislikes = DB::table('like__user__synopses')
                            ->where('id_sinopsis', $id)
                            ->where('estado', 1)
                            ->count();

                $views = DB::table('historial__user__synopses')
                            ->where('id_sinopsis', $synopsis->id)
                            ->where('deleted', false)
                            ->count();
                            
                
                if (!empty(session('user')->id) && session('user')->edad >= $synopsis->restriccion_edad){
                    $hist_user_syn = new Historial_User_Synopsis();
                    $fecha = Carbon::now();

                    $format = "d-M-y";
                    $formathour = "H:i:s";
                    $date = new DateTime();
                    $timestamp = $date -> getTimestamp();
                    $fecha2 = date($format, $timestamp);
                    $hora = date($formathour, $timestamp);

                    $hist_user_syn -> fecha = $fecha2;
                    $hist_user_syn -> hora = $hora;
                    $hist_user_syn->created_at = $fecha->toDateTimeString();
                    $hist_user_syn->updated_at = $fecha->toDateTimeString();
                    $hist_user_syn -> id_usuario = session('user')->id;
                    $hist_user_syn -> id_sinopsis = $synopsis->id;
                    $hist_user_syn -> deleted = false;

                    $hist = DB::table('historial__user__synopses')
                                ->where('id_usuario',session('user')->id)
                                ->where('id_sinopsis', $synopsis->id)
                                ->where('deleted', false)
                                ->get()
                                ->first();

                    $id_usuario = session('user')->id;             
                    $lists = DB::select("select groups.*
                    from ((groups
                    inner join admin_user_groups on groups.id = admin_user_groups.id_lista)
                    inner join users on admin_user_groups.id_usuario = users.id)
                    where users.id = '$id_usuario' and groups.deleted = false and admin_user_groups.es_propietario = true");
                    
                    if(empty($hist)){
                        $hist_user_syn -> save();
                        $views = $views + 1;
                        
                    }else{
                        $hist_user_syn->updated_at = $fecha->toDateTimeString();
                    }

                    return view('movie', compact('synopsis','video','category','usera', 'comment', 'userc', 'hist_user_syn', 'likes', 'dislikes', 'views','usuarios','lists'));
                
                }

                return view('movie', compact('synopsis','video','category','usera', 'comment', 'userc', 'likes', 'dislikes', 'views','usuarios'));
                
            }
        }
      
      
      
    }






    
    // Muestra la tupla especifica con el id de entrada
    public function show($id)
    {
      $comment = Comment::find($id);
      if ($comment != NULL) {
          if($comment->deleted == false){
              return response()->json($comment);
          }
      }
      return "No existe un comentario con ese ID.";
    }

    public function update(Request $request, $id)
    {
      $comment = Comment::find($id);
      if ($comment != NULL) {
          if($comment->deleted == false){
              $request->validate([
                'texto' => 'required|max:140',
                'id_usuario' => 'required',
                'id_sinopsis' => 'required'
              ]);

              $format = "d-M-y";
              $timestamp = $comment->timestamps;
              $fecha = date($format, $timestamp);

              $comment -> fecha = $fecha;
              $comment -> texto = $request->texto;
              $comment -> id_usuario = $request->id_usuario;
              $comment -> id_sinopsis = $request->id_sinopsis;
              $comment -> save();
              return response()->json([
                "message" => "Se ha modificado un comentario",
                "fecha" => $comment -> fecha,
                "id" => $comment -> id,
                "contenido" => $comment -> texto
              ], 201);
          }
      }
      return "No existe un comentario con ese ID.";
    }

    // Borrar una tupla fuertemente de la BD
    public function destroy($id)
    {
      $comment = Comment::find($id);
      if ($comment != NULL) {

          $comment -> delete();

          return response() -> json([
            "message" => "Se a borrado un comentario",
            "id" => $comment -> id
          ]);
      }
      return "No existe un comentario con ese ID.";
    }

    // Borrar una tupla suavemente de la BD
    public function softDelete($id)
    {
      $comment = Comment::find($id);
      if ($comment != NULL) {
          $comment -> deleted = 'true';
          $comment -> save();

          return response() -> json([
            "message" => "Se a borrado un comentario",
            "nombre" => $comment -> nombre,
            "id" => $comment -> id
          ]);
      }
      return "No existe un comentario con ese ID.";
    }

    // restaura una tupla borrada suavemente de la BD
    public function restore($id)
    {
      $comment = Comment::find($id);
      if ($comment != NULL) {
          $comment -> deleted = 'false';
          $comment -> save();

          return response() -> json([
            "message" => "Se a restaurado un comentario",
            "id" => $comment -> id
          ]);
      }
      return "No existe un comentario con ese ID.";
    }
}
