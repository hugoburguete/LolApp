<?php

use Illuminate\Http\Request;

Route::group([], function () {
    Route::get('/summoner/{summoner}', 'SummonerController@get');
});
