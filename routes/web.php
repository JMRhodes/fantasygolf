<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/fantasy-golf/leaderboard');
});

Route::get('/fantasy-golf', function () {
    return redirect('/fantasy-golf/leaderboard');
});
