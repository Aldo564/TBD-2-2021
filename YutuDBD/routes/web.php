<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@inicio');
Route::put('/profile', 'UserController@update');
Route::get('/s', 'SignUpController@index');
Route::get('/mv', 'MyVideosController@videosUsuario');
Route::get('/mGuest/{id}','SynopsisController@getMoviesInv');

Route::get('/volver', function ()
{
    return view('profile');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/signup', function () {
    return view('signup');
});

Route::get('/formList', function () {
    return view('formList');
});

Route::get('/movie', function () {
    return view('movie');
});

Route::get('/logout', function () {
    return view('logout');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/upload', function () {
    return view('upload');
});

//VideoController
Route::get('/video','VideoController@index');
Route::get('/video/{id}','VideoController@show');
Route::post('/video/create','VideoController@store');
Route::put('/video/update/{id}','VideoController@update');
Route::put('/video/restore/{id}','VideoController@restore');
Route::delete('/video/delete/{id}','VideoController@destroy');
Route::delete('/video/softDelete/{id}','VideoController@softDelete');

//SynopsisController
Route::get('/synopsis','SynopsisController@index');
Route::get('/synopsis/{id}','SynopsisController@show');
Route::post('/synopsis/create','SynopsisController@store');
Route::put('/synopsis/update/{id}','SynopsisController@update');
Route::put('/synopsis/restore/{id}','SynopsisController@restore');
Route::delete('/synopsis/delete/{id}','SynopsisController@destroy');
Route::delete('/synopsis/softDelete/{id}','SynopsisController@softDelete');

//GroupController
Route::get('/group','GroupController@index');
Route::get('/group/{id}','GroupController@show');
Route::post('/group/create','GroupController@store');
Route::put('/group/update/{id}','GroupController@update');
Route::put('/group/restore/{id}','GroupController@restore');
Route::delete('/group/delete/{id}','GroupController@destroy');
Route::delete('/group/softDelete/{id}','GroupController@softDelete');

//Group_SynopsisController
Route::get('/group_synopsis','Group_SynopsisController@index');
Route::get('/group_synopsis/{id}','Group_SynopsisController@show');
Route::post('/group_synopsis/create','Group_SynopsisController@store');
Route::put('/group_synopsis/update/{id}','Group_SynopsisController@update');
Route::put('/group_synopsis/restore/{id}','Group_SynopsisController@restore');
Route::delete('/group_synopsis/delete/{id}','Group_SynopsisController@destroy');
Route::delete('/group_synopsis/softDelete/{id}','Group_SynopsisController@softDelete');

//CategoryController
Route::get('/category','CategoryController@index');
Route::get('/category/{id}','CategoryController@show');
Route::post('/category/create','CategoryController@store');
Route::put('/category/update/{id}','CategoryController@update');
Route::put('/category/restore/{id}','CategoryController@restore');
Route::delete('/category/delete/{id}','CategoryController@destroy');
Route::delete('/category/softDelete/{id}','CategoryController@softDelete');

//Category_SynopsisController
Route::get('/category_synopsis','Category_SynopsisController@index');
Route::get('/category_synopsis/{id}','Category_SynopsisController@show');
Route::post('/category_synopsis/create','Category_SynopsisController@store');
Route::put('/category_synopsis/update/{id}','Category_SynopsisController@update');
Route::put('/category_synopsis/restore/{id}','Category_SynopsisController@restore');
Route::delete('/category_synopsis/delete/{id}','Category_SynopsisController@destroy');
Route::delete('/category_synopsis/softDelete/{id}','Category_SynopsisController@softDelete');

//Admin_User_SynopsisController
Route::get('/admin_user_synopsis','Admin_User_SynopsisController@index');
Route::get('/admin_user_synopsis/{id}','Admin_User_SynopsisController@show');
Route::post('/admin_user_synopsis/create','Admin_User_SynopsisController@store');
Route::put('/admin_user_synopsis/update/{id}','Admin_User_SynopsisController@update');
Route::put('/admin_user_synopsis/restore/{id}','Admin_User_SynopsisController@restore');
Route::delete('/admin_user_synopsis/delete/{id}','Admin_User_SynopsisController@destroy');
Route::delete('/admin_user_synopsis/softDelete/{id}','Admin_User_SynopsisController@softDelete');


// Controlador Usuario
Route::get('/users','UserController@index');
Route::get('/users/{id}','UserController@show');
Route::post('/users/create','UserController@store');
Route::put('/users/update','UserController@update');
Route::put('/users/restore/{id}','UserController@restore');
Route::delete('/users/delete/{id}','UserController@destroy');
Route::delete('/users/softDelete/{id}','UserController@softDelete');


// Controlador Comuna
Route::get('/communes','CommuneController@index');
Route::get('/communes/{id}','CommuneController@show');
Route::post('/communes/create','CommuneController@store');
Route::put('/communes/update/{id}','CommuneController@update');
Route::put('/communes/restore/{id}','CommuneController@restore');
Route::delete('/communes/delete/{id}','CommuneController@destroy');
Route::delete('/communes/softDelete/{id}','CommuneController@softDelete');


// Controlador Region
Route::get('/regions','RegionController@index');
Route::get('/regions/{id}','RegionController@show');
Route::post('/regions/create','RegionController@store');
Route::put('/regions/update/{id}','RegionController@update');
Route::put('/regions/restore/{id}','RegionController@restore');
Route::delete('/regions/delete/{id}','RegionController@destroy');
Route::delete('/regions/softDelete/{id}','RegionController@softDelete');


// Controlador Pais
Route::get('/countries','CountryController@index');
Route::get('/countries/{id}','CountryController@show');
Route::post('/countries/create','CountryController@store');
Route::put('/countries/update/{id}','CountryController@update');
Route::put('/countries/restore/{id}','CountryController@restore');
Route::delete('/countries/delete/{id}','CountryController@destroy');
Route::delete('/countries/softDelete/{id}','CountryController@softDelete');


// Controlador Donacion
Route::get('/donates','DonateController@index');
Route::get('/donates/{id}','DonateController@show');
Route::post('/donates/create','DonateController@store');
Route::put('/donates/update/{id}','DonateController@update');
Route::put('/donates/restore/{id}','DonateController@restore');
Route::delete('/donates/delete/{id}','DonateController@destroy');
Route::delete('/donates/softDelete/{id}','DonateController@softDelete');


// Controlador Seguir
Route::get('/follows','FollowController@index');
Route::get('/follows/{id}','FollowController@show');
Route::post('/follows/create','FollowController@store');
Route::put('/follows/update/{id}','FollowController@update');
Route::put('/follows/restore/{id}','FollowController@restore');
Route::delete('/follows/delete/{id}','FollowController@destroy');
Route::delete('/follows/softDelete/{id}','FollowController@softDelete');


// Controlador Usuario Metodo de Pago
Route::get('/user_paymethods','User_PayMethodController@index');
Route::post('/user_paymethods/create','User_PayMethodController@store');
Route::get('/user_paymethods/{id}','User_PayMethodController@show');
Route::put('/user_paymethods/update/{id}','User_PayMethodController@update');
Route::put('/user_paymethods/restore/{id}','User_PayMethodController@restore');
Route::delete('/user_paymethods/delete/{id}','User_PayMethodController@destroy');
Route::delete('/user_paymethods/softDelete/{id}','User_PayMethodController@softDelete');


// Controlador Banco
Route::get('/bank','BankController@index');
Route::get('/bank/{id}','BankController@show');
Route::post('/bank/create','BankController@store');
Route::put('/bank/update/{id}','BankController@update');
Route::put('/bank/restore/{id}','BankController@restore');
Route::delete('/bank/delete/{id}','BankController@destroy');
Route::delete('/bank/softDelete/{id}','BankController@softDelete');

// Controlador Comentarios
Route::get('/comment','CommentController@index');
Route::get('/comment/{id}','CommentController@show');
Route::post('/comment/create','CommentController@store');
Route::put('/comment/update/{id}','CommentController@update');
Route::put('/comment/restore/{id}','CommentController@restore');
Route::delete('/comment/delete/{id}','CommentController@destroy');
Route::delete('/comment/softDelete/{id}','CommentController@softDelete');


// Controlador Historial usuario sinopsis
Route::get('/historial_user_synopsis','Historial_User_SynopsisController@index');
Route::get('/historial_user_synopsis/{id}','Historial_User_SynopsisController@show');
Route::post('/historial_user_synopsis/create','Historial_User_SynopsisController@store');
Route::put('/historial_user_synopsis/update/{id}','Historial_User_SynopsisController@update');
Route::put('/historial_user_synopsis/restore/{id}','Historial_User_SynopsisController@restore');
Route::delete('/historial_user_synopsis/delete/{id}','Historial_User_SynopsisController@destroy');
Route::delete('/historial_user_synopsis/softDelete/{id}','Historial_User_SynopsisController@softDelete');


// Controlador Like usuario sinopsis
Route::get('/like_user_synopsis','Like_User_SynopsisController@index');
Route::get('/like_user_synopsis/{id}','Like_User_SynopsisController@show');
Route::post('/like_user_synopsis/create','Like_User_SynopsisController@store');
Route::put('/like_user_synopsis/update/{id}','Like_User_SynopsisController@update');
Route::put('/like_user_synopsis/restore/{id}','Like_User_SynopsisController@restore');
Route::delete('/like_user_synopsis/delete/{id}','Like_User_SynopsisController@destroy');
Route::delete('/like_user_synopsis/softDelete/{id}','Like_User_SynopsisController@softDelete');


// Controlador Metodo de Pago
Route::get('/paymethod','PayMethodController@index');
Route::get('/paymethod/{id}','PayMethodController@show');
Route::post('/paymethod/create','PayMethodController@store');
Route::put('/paymethod/update/{id}','PayMethodController@update');
Route::put('/paymethod/restore/{id}','PayMethodController@restore');
Route::delete('/paymethod/delete/{id}','PayMethodController@destroy');
Route::delete('/paymethod/softDelete/{id}','PayMethodController@softDelete');


// Controlador Tipo de pago
Route::get('/typeofpayment','TypeOfPaymentController@index');
Route::get('/typeofpayment/{id}','TypeOfPaymentController@show');
Route::post('/typeofpayment/create','TypeOfPaymentController@store');
Route::put('/typeofpayment/update/{id}','TypeOfPaymentController@update');
Route::put('/typeofpayment/restore/{id}','TypeOfPaymentController@restore');
Route::delete('/typeofpayment/delete/{id}','TypeOfPaymentController@destroy');
Route::delete('/typeofpayment/softDelete/{id}','TypeOfPaymentController@softDelete');

// Controlador Rol
Route::get('/role','RoleController@index');
Route::get('/role/{id}','RoleController@show');
Route::post('/role/create','RoleController@store');
Route::put('/role/update/{id}','RoleController@update');
Route::put('/role/restore/{id}','RoleController@restore');
Route::delete('/role/delete/{id}','RoleController@destroy');
Route::delete('/role/softDelete/{id}','RoleController@softDelete');


// Controlador Rol de usuario
Route::get('/user_role','User_roleController@index');
Route::get('/user_role/{id}','User_roleController@show');
Route::post('/user_role/create','User_roleController@store');
Route::post('/user_role/edit/{id}','User_roleController@edit');
Route::put('/user_role/update/{id}','User_roleController@update');
Route::put('/user_role/restore/{id}','User_roleController@restore');
Route::delete('/user_role/delete/{id}','User_roleController@destroy');
Route::delete('/user_role/softDelete/{id}','User_roleController@softDelete');

// Controlador permisos de administracion de lista
Route::get('/admin_user_group','Admin_user_groupController@index');
Route::get('/admin_user_group/{id}','Admin_user_groupController@show');
Route::post('/admin_user_group/create','Admin_user_groupController@store');
Route::put('/admin_user_group/update/{id}','Admin_user_groupController@update');
Route::put('/admin_user_group/restore/{id}','Admin_user_groupController@restore');
Route::delete('/admin_user_group/delete/{id}','Admin_user_groupController@destroy');
Route::delete('/admin_user_group/softDelete/{id}','Admin_user_groupController@softDelete');

// Controlador visualizaciones de usuario en una lista
Route::get('/view_user_group','View_user_groupController@index');
Route::get('/view_user_group/{id}','View_user_groupController@show');
Route::post('/view_user_group/create','View_user_groupController@store');
Route::put('/view_user_group/update/{id}','View_user_groupController@update');
Route::put('/view_user_group/restore/{id}','View_user_groupController@restore');
Route::delete('/view_user_group/delete/{id}','View_user_groupController@destroy');
Route::delete('/view_user_group/softDelete/{id}','View_user_groupController@softDelete');

// Controlador permisos de rol
Route::get('/role_permission','Role_permissionController@index');
Route::get('/role_permission/{id}','Role_permissionController@show');
Route::post('/role_permission/create','Role_permissionController@store');
Route::put('/role_permission/update/{id}','Role_permissionController@update');
Route::put('/role_permission/restore/{id}','Role_permissionController@restore');
Route::delete('/role_permission/delete/{id}','Role_permissionController@destroy');
Route::delete('/role_permission/softDelete/{id}','Role_permissionController@softDelete');


// Controlador permisos
Route::get('/permission','PermissionController@index');
Route::get('/permission/{id}','PermissionController@show');
Route::post('/permission/create','PermissionController@store');
Route::put('/permission/update/{id}','PermissionController@update');
Route::put('/permission/restore/{id}','PermissionController@restore');
Route::delete('/permission/delete/{id}','PermissionController@destroy');
Route::delete('/permission/softDelete/{id}','PermissionController@softDelete');


//SP Routes
Route::post('/store-video', function (Request $request) {
    $a = $request->titulo;
    $b = $request->link_video;
    print($a);
    $post = DB::select("call store_video('$a', '$b')");
});

Route::post('/store-synopsis', function (Request $request) {
    $a = $request->titulo_video;
    $b = $request->descripcion;
    print($a);
    $post = DB::select("call store_synopsis('$a', '$b')");
});


//Indispensables Route
Route::post('/verificatorLogin','UserController@login')->name('verificatorLogin');
Route::post('/Rlogout','UserController@logout')->name('Rlogout');
Route::post('/createVideo', 'SynopsisController@createVideo')->name('createVideo');
Route::post('/creteList', 'GroupController@createList')->name('createList');
Route::post('/addToList', 'GroupController@addToList')->name('addToList');
Route::get('/like/{id}', 'UserController@like');
Route::get('/dislike/{id}', 'UserController@dislike');
Route::get('/followUser/{id}', 'UserController@followUser');
Route::get('/unFollowUser/{id}', 'UserController@unFollowUser');
Route::get('/showMovie/{id}', 'SynopsisController@showMovie')->name('showMovie');
Route::get('/sortByCategory', 'HomeController@sortByCategory');
Route::get('/sortByUser', 'HomeController@sortByUser');
Route::get('/sortByViews', 'HomeController@sortByViews');
Route::get('/uploadVideo', 'SynopsisController@uploadVideo');
Route::get('/profile/{id}', 'UserController@notMyProfile');
Route::get('/getHistory/{id}', 'SynopsisController@getHistory');
Route::get('/getChannels/{id}', 'UserController@getChannels');
Route::get('/myLists', 'GroupController@myLists');
Route::get('/list/{id}', 'GroupController@showListCont');

