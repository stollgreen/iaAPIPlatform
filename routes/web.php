<?php

// api mode only


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/api/documentation');
});