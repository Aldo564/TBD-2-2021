<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commune;

class SignUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commune = Commune::all()->where('deleted', false);
        return view('signup',compact('commune'));  
    }

}
