<?php

Route::get('/', function()
{
  if (Auth::check()) {
    return View::make('index');
  } else {
    return View::make('login');
  }
});
