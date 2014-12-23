<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

Route::get('/', array('as' => 'index', 'uses' => 'HomeController@index'));
Route::get('/{city}', array('as' => 'search', 'uses' => 'HomeController@search'));

