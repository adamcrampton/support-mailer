<?php

// Front end routes.
Route::get('/', 'PageController@index');

// Admin routes.
Route::resource('admin', 'AdminController');
