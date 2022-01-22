<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('products', "ProductController@index");
Route::get('status/{id}/{status}', "ProductController@status");
Route::get('index','ProductController@index')->name('products.index');
Route::post('store','ProductController@store')->name('products.store');
Route::get('create','ProductController@create')->name('products.create');

Route::post('destroy/{id}','ProductController@destroy')->name('products.destroy');


Route::get('show/{id}','ProductController@show')->name('products.show');

Route::get('edit/{id}','ProductController@edit')->name('products.edit');




Route::get('challenges.index','ChallengeController@index')->name('challenges.index');

Route::get('challenges.create','ChallengeController@create')->name('challenges.create');

Route::post('challenges.store','ChallengeController@store')->name('challenges.store');

Route::post('challenges.update/{id}','ChallengeController@update')->name('challenges.update');

Route::get('challenges.delete/{id}/{status}', "ChallengeController@status");

Route::get('challenges.edit/{id}', "ChallengeController@edit");




Route::get('leaderboards.index','LeaderboardController@index')->name('leaderboards.index');
Route::get('leaderboards.create','LeaderboardController@create')->name('leaderboards.create');
Route::post('leaderboards.store','LeaderboardController@store')->name('leaderboards.store');
Route::get('leaderboards.status/{id}/{status}', "LeaderboardController@status");




Route::get('reset_password/{token}', ['as' => 'password.reset', function($token)
{
    // implement your reset password route here!
}]);

Route::get('/', function () {
    return view('welcome');
});
