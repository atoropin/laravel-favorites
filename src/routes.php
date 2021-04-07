<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'api', 'middleware'=> ['auth:api'] ], function () {
    Route::post('{favoritable_type}/{favoritable_id}/favorites', 'FavoriteController@toggle');
});
