<?php

use Illuminate\Support\Facades\Route;

Route::post('{favoritable_type}/{favoritable_id}/favorites', 'Rir\Favorites\Controllers\FavoriteController@toggle');
