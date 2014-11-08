<?php

Route::get('/', 'IndexController@index');

Route::post('install', 'InstallController@index');

Route::post('login', function()
{
  if (Auth::check()) {
    return Redirect::to('/');
  } else {
    if (Auth::attempt(array(
      "username" => Input::get('username'),
      "password" => Input::get('password')
    ))) {
      return Redirect::to('/');
    } else {
      return Redirect::to('/')->with('error', 'Invalid username or password');
    }
  }
});

Route::get('logout', function() {
  Auth::logout();
  return Redirect::to('/');
});
