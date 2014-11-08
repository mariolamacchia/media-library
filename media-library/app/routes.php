<?php

Route::get('/', function()
{
  if (Auth::check()) {
    return View::make('index');
  } else {
    return View::make('login')->with('error', Session::get('error'));
  }
});

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
