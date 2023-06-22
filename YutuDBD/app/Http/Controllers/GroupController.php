<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Group_Synopsis;
use App\Models\View_User_Group;
use App\Models\Admin_User_Group;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\Synopsis;
use App\Models\Category;
use App\Models\Category_Synopsis;
use App\Models\Comment;
use App\Models\Video;
use App\Models\User;
use App\Models\Admin_User_Synopsis;
use App\Models\Historial_User_Synopsis;
use Carbon\Carbon;
use DateTime;


class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $group = Group::all()->where('deleted', false);
        return response()->json($group);
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
        $group = new Group();
        $validator = Validator::make($request->all(),[
            'Nombre' => 'required|string|max:100',
            'Descripcion' => 'string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => "Ha ocurrido algun error con sus entradas, porfavor reviselas",
            ], 422);
        }
        if($request->Descripcion == NULL){
            $group->Descripcion = "Mi nueva lista de reproduccion";
        }
        else{
            $group->Descripcion = $request->Descripcion;
        }
        $group->Nombre = $request->Nombre;
        $group->deleted = false;
        $group->save();
        return response()->json([
            "message" => "Se ha creado una nueva lista.",
            "id" => $group->id
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
        $group = Group::find($id);
        if ($group != NULL) {
            if($gro_syn->deleted == false){
                return response()->json($gro_syn);
            }
        }
        return "No existe una lista con esa ID.";
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
        $group = Group::find($id);
        if ($group != NULL) {
            if($group->deleted == false){
                if ($request->Nombre != NULL) {
                    $group->Nombre = $request->Nombre;
                }
                if ($request->Descripcion != NULL) {
                    $group->Descripcion = $request->Descripcion;
                }
                $group->save();
                return response()->json($group);
            }
        }
        return "No existe una lista con esa ID.";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::find($id);
        if ($group != NULL) {
            Group_Synopsis::where('id_group',$id)->delete();
            View_User_Group::where('id_lista',$id)->delete();
            $group->delete();
            return response()->json([
                "message" => "Se ha borrado la lista",
                "id" => $id
            ]);
        }
        return "No existe una lista con esa ID.";
    }

    public function softDelete($id)
    {
        $group = Group::find($id);

        if($group != NULL){
            $group->deleted = 'true';
            $group->save();
            return response()->json([
                "message" => "Se ha eliminado suavemente la lista",
                "id" => $id
            ], 201);

        }
        return "No existe una lista con esa ID.";
    }

    public function restore($id)
    {
        $group = Group::find($id);

        if ($group != NULL) {
            $group->deleted = 'false';
            $group->save();
            return response()->json([
                "message" => "Se a restaurado la lista",
                "id" => $id
            ]);
        }
        return "No existe una lista con esa ID.";
    }

    public function myLists()
    {
        $id_usuario = session('user')->id;  
        $lists = DB::select("select groups.*
                            from ((groups
                            inner join admin_user_groups on groups.id = admin_user_groups.id_lista)
                            inner join users on admin_user_groups.id_usuario = users.id)
                            where users.id = '$id_usuario' and groups.deleted = false and admin_user_groups.es_propietario = true");
        
        return view('mylists', compact('lists'));
    }

    public function showListCont($id)
    {
        $list = Group::find($id);

        $sinopsis = DB::select("select synopses.*
                            from ((synopses
                            inner join group__synopses on synopses.id = group__synopses.id_sinopsis)
                            inner join groups on group__synopses.id_group = groups.id)
                            where groups.id = '$id'");

        
        return view('list', compact('sinopsis','list'));
    }

    public function createList(Request $request)
    {
        $lista = new Group();
        $lista->Nombre = $request->nombre;
        $lista->Descripcion = $request->descripcion;
        $lista->deleted = false;
        $lista->save();
        

        $adm_grop = new Admin_user_group();
        $adm_grop->id_lista = $lista->id;
        $adm_grop->id_usuario = session('user')->id;
        $adm_grop->es_colab = false;
        $adm_grop->es_propietario = true;
        $adm_grop->deleted = false;
        $adm_grop->save();

        return view('profile');
    }

    public function addToList(Request $request)
    {
        $added = new Group_Synopsis();
        $added->id_group = $request->id_list;
        $added->id_sinopsis = $request->id_sinopsis;
        $added->deleted = false;
        $added->save();

        $id = $request->id_sinopsis;
        

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

                return view('movie', compact('synopsis','video','category','usera', 'comment', 'userc', 'likes', 'dislikes', 'views','usuarios'));
                
            }
        }
    }
}
