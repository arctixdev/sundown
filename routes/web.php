<?php

use Illuminate\Support\Facades\Route;
use Location\Coordinate;
use Illuminate\Support\Facades\Artisan;

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


Route::get('/', function () {
    Artisan::call('app:find-closest-landing-spot');
    $closest_landing_spot = Artisan::output();
    return View('front', ["landpoint" => $closest_landing_spot["name"], "distance" => $closest_landing_spot["distance"]]);
});
