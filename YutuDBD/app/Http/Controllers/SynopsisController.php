<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use DateTime;
use DB;

class SynopsisController extends Controller
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
    
    public function index()
    {
        $synopsis = Synopsis::all()->where('deleted', false);
        $mensaje = SynopsisController::mensajeAlt();
        return view('home', compact('synopsis'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $synopsis = new Synopsis();
        $validator = Validator::make($request->all(),[
            'titulo_video' => 'required|max:100',
            'descripcion' => 'required|string',
            'fecha_creacion' => 'required|date'
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => "Ha ocurrido algun error con sus entradas, porfavor reviselas",
            ], 422);
        }
        if($request->link_imagen == NULL){
            $synopsis->link_imagen = "https://cdn.businessinsider.es/sites/navi.axelspringer.es/public/styles/bi_876/public/media/image/2021/02/bi-2238511.jpg?itok=zIr1fDtD";
        }
        else{
            $synopsis->link_imagen = $request->link_imagen;
        }
        if($request->restriccion_edad == NULL){
            $synopsis->restriccion_edad = 0;
        }
        else{
            $synopsis->restriccion_edad = $request->restriccion_edad;
        }
        $synopsis->titulo_video = $request->titulo_video;
        $synopsis->descripcion = $request->descripcion;
        $synopsis->fecha_creacion = $request->fecha_creacion;
        $synopsis->deleted = false;
        $synopsis->save();
        return response()->json([
            "message" => "Se ha creado una nueva sinopsis.",
            "id" => $synopsis->id
        ], 202);
    }

    public function show($id)
    {
        $synopsis = Synopsis::find($id);

        $categorias = Category::all()->where('deleted',false);

        $video = Video::all()->where('id',$synopsis->id_video)->where('deleted',false);
        $categ_sinop = Category_Synopsis::all()->where('id_sinopsis',$id)->where('deleted',false);
        if ($synopsis != NULL) {
            if($synopsis->deleted == false){
                return view('editVideo',compact('synopsis','video','categorias','categ_sinop'));
              }
        }
        return "No existe una sinopsis con esa ID.";
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha_creacion' => 'date'
        ]);

        $synopsis = Synopsis::find($id);
    

        if ($synopsis != NULL) {
            if($synopsis->deleted == false){
                if ($request->titulo_video != NULL) {
                    if (is_string($request->titulo_video)){
                        $synopsis->titulo_video = $request->titulo_video;
                    }
                }
                if ($request->descripcion != NULL) {
                    if (is_string($request->descripcion)){
                        $synopsis->descripcion = $request->descripcion;
                    }
                }
                if ($request->restriccion_edad != NULL) {
                    if (is_string($request->restriccion_edad)){
                        $synopsis->restriccion_edad = $request->restriccion_edad;
                    }
                }
                if ($request->link_imagen != NULL) {
                    if (is_string($request->link_imagen)){
                            $synopsis->link_imagen = $request->link_imagen;
                        
                    }
                }
                if ($request->fecha_creacion != NULL) {
                    $synopsis->fecha_creacion = $request->fecha_creacion;
                }
                $synopsis->save();



                if($request->link_video != NULL){
                    
                    $video = Video::find($synopsis->link_video);
                    if (!empty($video)){
                        if (is_string($request->link_video)){
                            if (strpos($request->link_video,"https://www.youtube.com/embed/",0) !== false){
                                $video->link_video = $request->link_video;
                            }
                            else{
                                if(strpos($request->link_video,"https://www.youtube.com/",0) !== false){ //https://www.youtube.com/watch?v=64CsCJtOKt4
                                    $partes = explode("watch?v=",$request->link_video);
                                    $link = "{$partes[0]}embed/{$partes[1]}";
                                    $video->link_video = $link;
                                }
                            }
                        }
                        $video->titulo = $synopsis->titulo_video;
                        $video->link_video = $request->link_video;
                        $video->save();
                    }else{
                        $newVideo = new Video();
                        if (is_string($request->link_video)){
                            if (strpos($request->link_video,"https://www.youtube.com/embed/",0) !== false){
                                $newVideo->link_video = $request->link_video;
                            }
                            else{
                                if(strpos($request->link_video,"https://www.youtube.com/",0) !== false){ //https://www.youtube.com/watch?v=64CsCJtOKt4
                                    $partes = explode("watch?v=",$request->link_video);
                                    $link = "{$partes[0]}embed/{$partes[1]}";
                                    $newVideo->link_video = $link;
                                }
                            }
                        }
                        $newVideo->titulo = $synopsis->titulo_video;
                        $newVideo->deleted = false;
                        $newVideo->save();
                        $synopsis->id_video = $newVideo->id;
                        $synopsis->save();
                    }
                    
                    
        
                }

                if($request->id_categoria != NULL){
                    
                    $cat = DB::table('category__synopses')->where('id_sinopsis', $id)->get()->first();
                    
                    if(!empty($cat)){
                        $cat_syp = Category_Synopsis::find($cat->id);
                        $cat_syp->id_categoria = $request->id_categoria;
                        $cat_syp->save();
                    }else{
                        $cat_syn = new Category_Synopsis();
                        $cat_syn->id_sinopsis = $id;
                        $cat_syn->id_categoria = $request->id_categoria;
                        $cat_syn->deleted = false;
                        $cat_syn->save();
                    }
                    
                }
                
                
                echo "<script> alert('The video has benn edited.');window.location='/'</script>";
            }
        }
    }







    public function destroy($id)
    {
        $synopsis = Synopsis::find($id);
        if ($synopsis != NULL) {
            Group_Synopsis::where('id_sinopsis',$id)->delete();
            Comment::where('id_sinopsis',$id)->delete();
            $synopsis->delete();
            return response()->json([
                "message" => "Se ha borrado la sinopsis",
                "id" => $id
            ]);
        }
        return "No existe un video con esa ID.";
    }

    public function softDelete($id)
    {
        $synopsis = Synopsis::find($id);

        if($synopsis != NULL){
            $synopsis->deleted = 'true';
            $synopsis->save();
            return response()->json([
                "message" => "Se ha eliminado suavemente la sinopsis",
                "id" => $id
            ], 201);

        }
        return "No existe una sinopsis con esa ID.";
    }

    public function restore($id)
    {
        $synopsis = Synopsis::find($id);

        if ($synopsis != NULL) {
            $synopsis->deleted = 'false';
            $synopsis->save();
            return response()->json([
                "message" => "Se a restaurado la sinopsis",
                "id" => $id
            ]);
        }
        return "No existe una sinopsis con esa ID.";
    }

    public function sortByUser(Request $request)
    {
        $synopses = DB::table('synopses')
                ->join('admin_user_synopses', 'synopses.id', '=', 'admin_user_synopses.id_sinopsis')
                ->join('users', 'users.id', '=', 'admin_user_synopses.id_sinopsis')
                ->where('users.id', $request->id)
                ->where('admin_user_synopses.es_propietario', true)
                ->select('sinopses.id', 'sinopses.titulo_video', 'synopses.descripcion', 'synopses.link_imagen');
        $mensaje = SynopsisController::mensajeAlt();

        return view('home', compact('synopses','mensaje'));
    }

    public function uploadVideo()
    {

        $category = Category::all()->where('deleted', false);

        if(!empty($category)){
            return view('upload', compact('category'));
        } else{
            return "No existen categorías.";
        }
    }

    public function createVideo(Request $request)
    {

        $synopsis = new Synopsis();
        $now = \Carbon\Carbon::now();
        $usera = User::all()->where('id', session('user')->id);

        $validator = Validator::make($request->all(),[
            'titulo_video' => 'required|max:100',
            'descripcion' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => "Ha ocurrido algun error con sus entradas, porfavor reviselas 1",
            ], 422);
        }

        if($request->link_imagen == NULL){
            $synopsis->link_imagen = "https://cdn.businessinsider.es/sites/navi.axelspringer.es/public/styles/bi_876/public/media/image/2021/02/bi-2238511.jpg?itok=zIr1fDtD";
        }
        else{
            $synopsis->link_imagen = $request->link_imagen;
        }
        if($request->restriccion_edad == NULL){
            $synopsis->restriccion_edad = 0;
        }
        else{
            $synopsis->restriccion_edad = $request->restriccion_edad;
        }
        $synopsis->titulo_video = $request->titulo_video;
        $synopsis->descripcion = $request->descripcion;
        $synopsis->fecha_creacion = $now;
        $synopsis->deleted = false;

        $video = new Video();

        $validator = Validator::make($request->all(),[
            'link_video' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => "Ha ocurrido algun error con sus entradas, porfavor reviselas 2",
            ], 422);
        }

        if (is_string($request->link_video)){
            if (strpos($request->link_video,"https://www.youtube.com/embed/",0) !== false){
                $video->link_video = $request->link_video;
            }
            else{
                if(strpos($request->link_video,"https://www.youtube.com/",0) !== false){ //https://www.youtube.com/watch?v=64CsCJtOKt4
                    $partes = explode("watch?v=",$request->link_video);
                    $link = "{$partes[0]}embed/{$partes[1]}";
                    $video->link_video = $link;
                }
            }
        }

        $video->deleted = false;
        $video->titulo = $synopsis->titulo_video;
        $video->save();

        $synopsis->id_video = $video->id;
        $synopsis->save();

        $admin = new Admin_User_Synopsis();
        $admin->id_usuario = session('user')->id;
        $admin->id_sinopsis = $synopsis->id;
        $admin->es_propietario = true;
        $admin->es_colab = false;
        $admin->deleted = false;
        $admin->save();

        $cate_synopsis = new Category_Synopsis();
        $cate_synopsis->id_categoria = $request->id_categoria;
        $cate_synopsis->id_sinopsis = $synopsis->id;
        $cate_synopsis->deleted = false;
        $cate_synopsis->save();

        $comment = NULL;
        $userc = NULL;

        $category = DB::table('category__synopses')
                    ->join('categories', 'category__synopses.id_categoria', '=', 'categories.id')
                    ->where('category__synopses.id_sinopsis', $synopsis->id)
                    ->select('categories.*')
                    ->get();

        $id_usuario = session('user')->id;             
        $lists = DB::select("select groups.*
        from ((groups
        inner join admin_user_groups on groups.id = admin_user_groups.id_lista)
        inner join users on admin_user_groups.id_usuario = users.id)
        where users.id = '$id_usuario' and groups.deleted = false and admin_user_groups.es_propietario = true");

        $likes = 0;
        $dislikes = 0;
        $views = 0;

        return view('movie', compact('synopsis', 'video', 'admin', 'cate_synopsis', 'usera', 'comment', 'userc','category', 'likes', 'dislikes', 'views','lists'));
    }

    public function showMovie($id)
    {

        $synopsis = Synopsis::all()
                            ->where('id', $id)
                            ->first();
        
        $usuarios = User::all()->where('deleted',false);

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
                $id_usuario = session('user')->id;             
                    $lists = DB::select("select groups.*
                    from ((groups
                    inner join admin_user_groups on groups.id = admin_user_groups.id_lista)
                    inner join users on admin_user_groups.id_usuario = users.id)
                    where users.id = '$id_usuario' and groups.deleted = false and admin_user_groups.es_propietario = true");
                return view('movie', compact('synopsis','video','category','usera', 'comment', 'userc', 'likes', 'dislikes', 'views','usuarios','lists'));
                
            }
        }
        
    }




    public function getHistory($id)
    {

        $synopsis = DB::table('historial__user__synopses')
                    ->where('historial__user__synopses.id_usuario', $id)
                    ->join('synopses', 'synopses.id', '=', 'historial__user__synopses.id_sinopsis')
                    ->orderBy('historial__user__synopses.updated_at', 'desc')
                    ->select('synopses.*')
                    ->get();
        
        return view('history', compact('synopsis'));
        
    }

    public function getMoviesInv($id){

        $synopsis = Synopsis::all()
        ->where('id', $id)
        ->first();

        

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

                if (!empty(session('user')->id)){
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

                
                if(empty($hist)){
                    $hist_user_syn -> save();
                    
                }else{
                    $hist_user_syn->updated_at = $fecha->toDateTimeString();
                }
                $id_usuario = session('user')->id;             
                $lists = DB::select("select groups.*
                        from ((groups
                        inner join admin_user_groups on groups.id = admin_user_groups.id_lista)
                        inner join users on admin_user_groups.id_usuario = users.id)
                        where users.id = '$id_usuario' and groups.deleted = false and admin_user_groups.es_propietario = true");
                
                return view('moviesInvitados', compact('synopsis','video','category','usera', 'comment', 'userc', 'hist_user_syn','lists'));
                }

                return view('moviesInvitados', compact('synopsis','video','category','usera', 'comment', 'userc'));
                }
                }
                else
                {
                echo "<script> alert('La pelicula seleccionada no esta disponible.');window.location='/'</script>";
                }

    }



}


