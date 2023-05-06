<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/** установить город если он есть в конфиге */
Route::get('setcity/{city}', function ($city) {
    if (in_array($city, Config::get('app.cities'))) {
        Session::flush();
        Session::put('current_city', $city);
    }
    return redirect()->route("index");
})->name("setcity");

/** показать список если нет в сессии города, либо перенаправить на страницу города */
Route::get('/index', function () {
    return view("welcome");
})->name("index");
Route::fallback(function (){
    if (in_array(Session::get("current_city"), Config::get('app.cities'), true)) {
        return redirect()->route("main", Session::get("current_city"));
    }
    return redirect()->route('index');
});
/** основаная группа роутов */
Route::group([
    'prefix' => '{city}',
    'where' => ['city', '[a-zA-Z]{2,20}']
], function () {
    /** показать страницу города */
    Route::get('/', [HomeController::class, 'main'])->name('main');
});

