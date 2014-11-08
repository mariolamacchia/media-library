<?php

class IndexController extends BaseController
{
	public function index()
	{
    // If admin does not exist starts installation
    $admin = User::where('admin', true)->first();
    if (!$admin) {
      return View::make('install')->with('error', Session::get('error'));
    } elseif (Auth::check()) {
      return View::make('index');
    } else {
      return View::make('login')->with('error', Session::get('error'));
    }
	}

}
