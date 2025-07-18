<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

/*
 * NOTE: URLは複数形で記述すること
 * https://qiita.com/mserizawa/items/b833e407d89abd21ee72
 */

Route::get('', 'DashboardController@index')->name('dashboard');

Route::resource('users', 'UserController')->middleware('precognitive');
