<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

if (app()->environment('testing')) {
    Route::view('/_foundation/smoke', 'foundation-smoke');
}
