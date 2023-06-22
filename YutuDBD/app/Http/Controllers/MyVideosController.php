<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Synopsis;
use App\Models\Admin_User_Synopsis;
use App\Models\User;



class MyVideosController extends Controller
{

    public function videosUsuario()
    {
       

        $sinopsis = Synopsis::all()->where('deleted',false);
        $admin = Admin_User_Synopsis::all()->where('deleted',false);
        
        return view('myVideos',compact('sinopsis','admin'));
        
    
    }





}
