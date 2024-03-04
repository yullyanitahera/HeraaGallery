<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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


Route::middleware(['guest'])->group(function () {
    //Home Luar
    Route::get('/', function (){
        return view('rumah');
    });
    //Login 
    Route::get('/login', function () {
        return view('login');
    })->name('login');
    //Register
    Route::get('/register', function () {
        return view('register');
    });
    //proses register
    Route::post('/registered', [UserController::class, 'register']);
    //proses log in
    Route::post('/ceklogin', [UserController::class, 'ceklogin']);
});

//middleware user
Route::middleware(['user'])->group(function () {
    //data Explore
    Route::get('/getDataExplore',[UserController::class, 'getdata']);
    //likefoto
    Route::post('/likefoto' ,[UserController::class,'likesfoto']);
    //Home explore
    Route::get('/explore',[UserController::class, 'explore']);
    //Home explore-detail
    Route::get('/explore-detail/{id}',[UserController::class, 'explore_detail']);
    //datadetailexplore
    Route::get('/explore-detail/{id}/getdatadetail', [UserController::class, 'getdatadetail']);
    //Menampilakan Komentar
    Route::get('/explore-detail/getkomen/{id}', [UserController::class, 'ambildatakomentar']);
    //kirimkomentar
    Route::post('/explore-detail/kirimkomentar', [UserController::class, 'kirimkomentar']);
    //follow
    Route::post('/explore-detail/ikuti', [UserController::class, 'ikuti']);
    //upload
    Route::get('/upload',[UserController::class, 'upload']);
    //tambahalbum
    Route::post('/tambah_album',[UserController::class, 'tambahalbum']);
    //upload foto
    Route::post('/upload',[UserController::class, 'upload_foto']);
    //album
    Route::get('/album',[UserController::class, 'album']);
    //datapostinan
    Route::get('/getDataPostingan',[UserController::class, 'getdatapostingan']);
    //dataAlbum
    Route::get('/getDataAlbum',[UserController::class, 'getdataalbum']);
    //profil
    Route::get('/profile',[UserController::class, 'profil']);
    //updatedata
    Route::post('/updateprofile',[UserController::class, 'updatedataprofile']);
    //updatefotoprofile
    Route::post('/ubahprofil',[UserController::class, 'fotoprofil']);
    //about
    Route::get('/about',[UserController::class, 'about']);
    //changepassword
    Route::get('/password&username ',[UserController::class, 'edit_password_username']);
    //ubahpassword
    Route::post('/change-password', [UserController::class, 'update']);
    //profil public
    Route::get('/profil_public/{id}', [UserController::class, 'profil_public']);
    //fotopublic
    Route::get('/getDataPublic/{id}', [UserController::class, 'getdatapublic']);
     //log out
    Route::get('/logout ',[UserController::class, 'logout']);
    //delete
    Route::delete('/deletefoto/{id}', [UserController::class, 'deletefoto']);
});
//middleware Admin
Route::middleware(['admin'])->group(function () {
    //dasbor
    
});
Route::get('/loginadmin', function () {
    return view('admin.signin');
});
Route::get('/dashboard', function () {
    return view('admin.dasbor');
});