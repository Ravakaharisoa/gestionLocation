<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Utilisateurs;
use App\Http\Livewire\TypeArticleComp;
use App\Http\Controllers\HomeController;
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


/*Route::get('/articles', function () {
    return Article::with("type")->paginate(5);
});*/

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

//Route::get('/habilitations/utilisateurs',[UserController::class,'index'])->name('utilisateurs')->middleware("auth.admin");

Route::group([
	"middleware" =>["auth","auth.admin"],
	"as" => "admin."
],function()
{
	Route::group([
		"prefix" =>"habilitations",
		"as" =>"habilitations."
	],function()
	{
		Route::get("/utilisateurs",Utilisateurs::class)->name('users.index');
	});

	Route::group([
		"prefix" =>"gestarticles",
		"as" =>"gestarticles."
	],function()
	{
		Route::get("/typearticles",TypeArticleComp::class)->name('typearticles');
	});
});