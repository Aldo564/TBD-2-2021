<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_Role;
use App\Models\User_PayMethod;
use App\Models\Follow;
use App\Models\Donate;
use App\Models\Admin_User_Synopsis;
use App\Models\Admin_user_group;
use App\Models\View_user_group;
use App\Models\Like_User_Synopsis;
use App\Models\Comment;
use App\Models\Historial_User_Synopsis;
use App\Models\Commune;
use App\Models\Synopsis;
use App\Models\Category;
use App\Models\Video;
use DB;
use Carbon\Carbon;

class UserController extends Controller
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

    // Muestra todas las tuplas de un modelo
    public function index()
    {
        $user = User::all()->where('deleted', false);
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $user = new User();
        $request->validate([
            'nickname' => 'required|max:200',
            'contrasenia' => 'required|max:400',
            'email' => 'required|email',
            'fecha_nacimiento' => 'required|date',
            'id_comuna' => 'required',
        ]);

        $edad = Carbon::parse($request->fecha_nacimiento)->diff(Carbon::now())->y;

        $user->nickname = $request->nickname;
        $user->contrasenia = $request->contrasenia;
        $user->edad = $edad;
        $user->email = $request->email;
        $user->saldo = 0;
        $user->fecha_nacimiento = $request->fecha_nacimiento;
        $user->deleted = 'false';
        $user->id_comuna = $request->id_comuna;


        $nombre = DB::table('users')
                ->where('nickname', $request->nickname)
                ->get()->first();

        if ($nombre != null) {
            echo "<script>
            alert('The user already exist.');window.location='/s'</script>";
        }


        $email = DB::table('users')
                ->where('email', $request->email)
                ->get()->first();

        if ($email != null) {
            echo "<script>
            alert('The email has been already used.');window.location='/s'</script>";
        }


        $user->save();
        echo "<script>
            alert('The user has been created sucessfully.');window.location='/'</script>";

    }

    // Muestra una tupla segun el id ingresado por parametro
    public function show($id)
    {
        $user = User::find($id);
        if($user != NULL){
            if($user->deleted == false){
                return response()->json($user);
            }
        }
        return "No existe un usuario con esa ID.";
    }

    /*
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if($user != NULL){
            if($user->deleted == false){
                if($request->nickname != NULL){
                    if($user->nickname == $request->nickname){
                        return "Nombre de usuario no cambia.";
                    }else{
                        $nombre = DB::table('users')
                            ->where('nickname', $request->nickname)
                            ->get()->first();
                        if ($nombre != null) {
                            return "Este usuario ya existe.";
                        }else{
                            $user->nickname = $request->nickname;
                        }
                    }
                }

                if($request->contrasenia != NULL){
                    if($request->contrasenia == $user->contrasenia){
                        return "Contraseña no cambia.";
                    }else{
                        $user->contrasenia = $request->contrasenia;
                    }
                }

                if($request->email != NULL){
                    if($user->email == $request->email){
                        return "Email no cambia.";
                    }else{
                        $email = DB::table('users')
                        ->where('email', $request->email)
                        ->get()->first();

                        if ($email != null) {
                            return "Este email ya existe.";
                        }else{
                            $user->email = $request->email;
                        }
                    }
                }

                if($request->fecha_nacimiento != NULL){
                    if($user->fecha_nacimiento == $request->fecha_nacimiento){
                        return "Fecha de nacimiento no cambia.";
                    }else{
                        $user->fecha_nacimiento = $request->fecha_nacimiento;
                        $edad = Carbon::parse($request->fecha_nacimiento)->diff(Carbon::now())->y;
                        $user->edad = $edad;
                    }
                }

                if($request->id_comuna != NULL){
                    if($user->id_comuna == $request->id_comuna){
                        return "ID de comuna no cambia.";
                    }else{
                        $comuna = Commune::find($request->id_comuna);
                        if($comuna == NULL){
                            return "No existe una comuna con esa ID.";
                        }else{
                            if($comuna->deleted == false){
                                $user->id_comuna = $request->id_comuna;
                            }else{
                                return "No existe una comuna con esa ID.";
                            }
                        }
                    }
                }
            }
            $user->save();
            return response()->json([
                "message" => "Se ha modificado el usuario.",
                "id" => $id
            ], 201);
        }
        return "No existe un usuario con esa ID.";
    }
    */

    public function update(Request $request)
    {

        $user = User::find(session('user')->id);

        $nombre = null;
        $email = null;
        $ver = 0;

        if ($user -> contrasenia == $request -> confirmacion_contrasenia)
        {
          $request->session()->flush();
          $ver = 1;
          if (!empty($request -> nickname))
          {
            $nombre = DB::table('users')
                ->where('nickname', $request->nickname)
                ->get()->first();
            if ($nombre != null)
            {
              return view('updateerror', compact('user', 'nombre', 'email', 'ver'));
            }
            else
            {
              $user -> nickname = $request -> nickname;
            }
          }

          if (!empty($request -> contrasenia_nueva))
          {
            $user -> contrasenia = $request -> contrasenia_nueva;
          }

          if (!empty($request -> email))
          {
            $email = DB::table('users')
                ->where('email', $request -> email)
                ->get()->first();
            if ($email != null)
            {
              return view('updateerror', compact('user', 'nombre', 'email', 'ver'));
            }
            else
            {
              $user -> email = $request -> email;
            }
          }

          $user->save();

          $request->session()->put('user', $user);

          return view('updatesuccess', compact('user'));
        }
        else
        {
          return view('updateerror', compact('user', 'nombre', 'email', 'ver'));
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if($user != NULL){
            User_Role::where('id_usuario', $id)->delete();
            User_PayMethod::where('id_usuario', $id)->delete();
            Follow::where('id_usuario_Origen', $id)->delete();
            Follow::where('id_usuario_Destino', $id)->delete();
            Donate::where('id_usuario_Origen', $id)->delete();
            Donate::where('id_usuario_Destino', $id)->delete();
            Admin_User_Synopsis::where('id_usuario', $id)->delete();
            Admin_user_group::where('id_usuario', $id)->delete();
            View_user_group::where('id_usuario', $id)->delete();
            Like_User_Synopsis::where('id_usuario', $id)->delete();
            Comment::where('id_usuario', $id)->delete();
            Historial_User_Synopsis::where('id_usuario', $id)->delete();

            $user->delete();
            return response()->json([
                "message" => "Se ha eliminado el usuario permanentemente.",
                "id" => $id
            ], 201);
        }
        return "No existe un usuario con esa ID.";
    }

    public function softDelete($id)
    {
        $user = User::find($id);
        if($user != NULL){
            $user->deleted = 'true';
            $user->save();
            return response()->json([
                "message" => "Se ha eliminado temporalmente el usuario.",
                "id" => $id
            ], 201);
        }
        return "No existe un usuario con esa ID.";
    }

    public function restore($id)
    {
        $user = User::find($id);
        if($user != NULL){
            $user->deleted = 'false';
            $user->save();
            return response()->json([
                "message" => "Se ha restaurado el usuario.",
                "id" => $id
            ], 200);
        }
        return "No existe un usuario con esa ID.";
    }

    public function login(Request $request)
    {
        $category = Category::all()->where('deleted', false);
        $user = User::all()->where('deleted', false);
        $synopse = Synopsis::all()->where('deleted', false);

        $nameIn = $request->nickname;
        $passIn = $request->contrasenia;

        $veriUser = DB::table('users')
                    ->where('nickname', $nameIn)
                    ->get()->first();

        if($veriUser != null){
            $data = json_decode(json_encode($veriUser),false);
            if($data->contrasenia == $passIn && $data->deleted == false){
                $request->session()->put('user',$veriUser);
                $mensaje = UserController::mensajeAlt();
                return view('home', compact('veriUser', 'category', 'user', 'synopse','mensaje'));
            }
            else{
                echo '<script language="javascript">alert("Password doesn\'t match");</script>';
                return view('login');
            }
        }
        else{
            echo '<script language="javascript">alert("Nickname or Password is incorrect");</script>';
            return view('login');
        }
    }

    public function logout(Request $request)
    {
        
        $category = Category::all()->where('deleted', false);
        $user = User::all()->where('deleted', false);
        $synopse = Synopsis::all()->where('deleted', false);

        $request->session()->flush();

        if (!empty($category) && !(empty($user) && !empty($synopse))) {
            $mensaje = UserController::mensajeAlt();
            return view('home', compact('category', 'user', 'synopse','mensaje'));
        }
    }

    public function notMyProfile($id)
    {

        $follow = DB::table('follows')
                ->where('follows.id_usuario_Origen', session('user')->id)
                ->where('follows.id_usuario_Destino', $id)
                ->get()
                ->first();

        $user = DB::table('users')
                ->where('deleted', false)
                ->where('users.id', $id)
                ->get()
                ->first();

      return view('notmyprofile', compact('user', 'follow'));
    }


    public function getChannels($id)
    {
        $users = DB::table('users')
                ->join('follows', 'users.id','=', 'follows.id_usuario_Destino')
                ->where('follows.id_usuario_Origen', $id)
                ->select('users.*')
                ->get();
        
        return view('follow', compact('users'));
    }

    
    public function followUser(Request $request)
    {
        $follow = new Follow();
        $follow->id_usuario_Origen = session('user')->id;
        $follow->id_usuario_Destino = $request->id;
        $follow->deleted = false;

        $following = DB::table('follows')
                ->where('follows.id_usuario_Origen', session('user')->id)
                ->where('follows.id_usuario_Destino', $request->id)
                ->where('deleted', false)
                ->get()
                ->first();

        if(empty($following)){
            $follow->save();
        }

        $user = User::find($request->id);

        return view('notmyprofile', compact('follow', 'user'));
    }

    
    public function unFollowUser(Request $request)
    {
        $follow = DB::table('follows')
                ->where('follows.id_usuario_Origen', session('user')->id)
                ->where('follows.id_usuario_Destino', $request->id)
                ->delete();

        $user = User::find($request->id);

        return view('profile', compact('follow', 'user'));
    }




    public function like($id)
    {
        $user_like = DB::table('like__user__synopses')
                    ->where('deleted', false)
                    ->where('id_usuario', session('user')->id)
                    ->where('id_sinopsis', $id)
                    ->update(['estado' => 0]);

        $synopsis = Synopsis::all()->find($id);


        $likes = DB::table('like__user__synopses')
                    ->where('id_sinopsis', $id)
                    ->where('estado', 0)
                    ->count();

        $dislikes = DB::table('like__user__synopses')
                    ->where('id_sinopsis', $id)
                    ->where('estado', 1)
                    ->count();

        $video = Video::all()
                    ->where('id',$synopsis->id_video)
                    ->first();

        $category = DB::table('category__synopses')
                    ->join('categories', 'category__synopses.id_categoria', '=', 'categories.id')
                    ->where('category__synopses.id_sinopsis', $id)
                    ->select('categories.*')
                    ->get();

        $views = DB::table('historial__user__synopses')
                    ->where('id_sinopsis', $synopsis->id)
                    ->where('deleted', false)
                    ->count();

        $like = new Like_User_Synopsis();
        $like -> estado = 0;
        $like -> id_usuario = session('user')->id;
        $like -> id_sinopsis = $id;
        $like -> deleted = false;

        $id_usuario = session('user')->id;             
        $lists = DB::select("select groups.*
        from ((groups
        inner join admin_user_groups on groups.id = admin_user_groups.id_lista)
        inner join users on admin_user_groups.id_usuario = users.id)
        where users.id = '$id_usuario' and groups.deleted = false and admin_user_groups.es_propietario = true");

        if(empty($user_like)){
            $like -> save();
            $likes = $likes + 1;
        }

        return view('movie', compact('likes', 'synopsis', 'dislikes', 'video', 'category', 'views','lists'));
    }



    public function dislike($id)
    {
        $user_dislike = DB::table('like__user__synopses')
                    ->where('deleted', false)
                    ->where('id_usuario', session('user')->id)
                    ->where('id_sinopsis', $id)
                    ->update(['estado' => 1]);

        $synopsis = Synopsis::all()->find($id);

        $likes = DB::table('like__user__synopses')
                    ->where('id_sinopsis', $id)
                    ->where('estado', 0)
                    ->count();

        $dislikes = DB::table('like__user__synopses')
                    ->where('id_sinopsis', $id)
                    ->where('estado', 1)
                    ->count();

        $video = Video::all()
                    ->where('id',$synopsis->id_video)
                    ->first();

        $category = DB::table('category__synopses')
                    ->join('categories', 'category__synopses.id_categoria', '=', 'categories.id')
                    ->where('category__synopses.id_sinopsis', $id)
                    ->select('categories.*')
                    ->get();

        $views = DB::table('historial__user__synopses')
                    ->where('id_sinopsis', $synopsis->id)
                    ->where('deleted', false)
                    ->count();
        
        $id_usuario = session('user')->id;             
        $lists = DB::select("select groups.*
        from ((groups
        inner join admin_user_groups on groups.id = admin_user_groups.id_lista)
        inner join users on admin_user_groups.id_usuario = users.id)
        where users.id = '$id_usuario' and groups.deleted = false and admin_user_groups.es_propietario = true");

        $dislike = new Like_User_Synopsis();
        $dislike -> estado = 1;
        $dislike -> id_usuario = session('user')->id;
        $dislike -> id_sinopsis = $id;
        $dislike -> deleted = false;

        if(empty($user_dislike)){
            $dislike -> save();
            $dislikes = $dislikes + 1;
        }

        return view('movie', compact('likes', 'synopsis', 'dislikes', 'video', 'category', 'views','lists'));
    }
}
