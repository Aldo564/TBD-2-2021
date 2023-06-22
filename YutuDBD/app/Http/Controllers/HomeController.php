<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Synopsis;
use App\Models\Admin_User_Synopsis;
use DB;

class HomeController extends Controller
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
    public function inicio()
    {
        $category = Category::all()->where('deleted', false);
        $user = User::all()->where('deleted', false);
        $synopse = Synopsis::all()->where('deleted', false);

        $mensaje = HomeController::mensajeAlt();

        if (!empty($category) && !(empty($user) && !empty($synopse))) {
            return view('home', compact('category', 'user', 'synopse', 'mensaje'));
        }
        return "No existe una categoria con esa ID.";
    }


    public function sortByCategory(Request $request)
    {
        $filtro_cate = DB::table('categories')
                ->where('id', $request->id_categoria)
                ->get()->first();


        $filtro_user = null;
        $user = User::all()->where('deleted', false);

        $category = Category::all()->where('deleted', false);

        $synopse = DB::table('synopses')
                ->join('category__synopses', 'category__synopses.id_sinopsis', '=', 'synopses.id')
                ->join('categories', 'categories.id', '=', 'category__synopses.id_categoria')
                ->where('categories.id', $request->id_categoria)
                ->select('synopses.id', 'synopses.titulo_video', 'synopses.descripcion', 'synopses.link_imagen', 'synopses.fecha_creacion')
                ->get();

        $mensaje = HomeController::mensajeAlt();
        return view('home', compact('synopse', 'filtro_cate', 'category', 'filtro_user', 'user','mensaje'));
    }

    public function sortByUser(Request $request)
    {
        $filtro_user = DB::table('users')
                ->where('nickname', $request->nickname)
                ->get()->first();

        $filtro_cate = null;

        $admin_user_synopsis = Admin_User_Synopsis::all()->where('deleted', false);
        $category = Category::all()->where('deleted', false);
        $user = User::all()->where('deleted', false);

        $synopse = DB::table('synopses')
                ->join('admin__user__synopses', 'admin__user__synopses.id_sinopsis', '=', 'synopses.id')
                ->join('users', 'users.id', '=', 'admin__user__synopses.id_usuario')
                ->where('users.nickname', $request->nickname)
                ->where('admin__user__synopses.es_propietario', true)
                ->select('synopses.id', 'synopses.titulo_video', 'synopses.descripcion', 'synopses.link_imagen', 'synopses.fecha_creacion')
                ->get();

        $mensaje = HomeController::mensajeAlt();
        return view('home', compact('synopse', 'filtro_cate', 'category', 'filtro_user', 'user','mensaje'));
    }

    public function sortByViews(Request $request)
    {
        $category = Category::all()->where('deleted', false);
        $user = User::all()->where('deleted', false);
        $orden = $request->order;
        if($orden == "asc"){
            $synopse = DB::select("select synopses.*, count(historial__user__synopses.id_sinopsis) as a
                                    from historial__user__synopses 
                                    inner join synopses on synopses.id = historial__user__synopses.id_sinopsis
                                    group by synopses.id
                                    order by a asc");
        }
        else{
            $synopse = DB::select("select synopses.*, count(historial__user__synopses.id_sinopsis) as a
                                    from historial__user__synopses 
                                    inner join synopses on synopses.id = historial__user__synopses.id_sinopsis
                                    group by synopses.id
                                    order by a desc");
        }
        
        $mensaje = HomeController::mensajeAlt();
        return view('home', compact('synopse','mensaje','category','user'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
