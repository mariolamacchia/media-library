<?php

class InstallController extends BaseController
{
	public function index()
	{
    $username = Input::get('username');
    $password = Input::get('password');
    $passconf = Input::get('passconf');
    $folder = Input::get('folder');

    $result = $this->validate($username, $password, $passconf);
    echo var_dump($result);
    if ($result['success']) {
      $this->saveUser($username, $password);
      return Redirect::to('/');
    } else {
      return Redirect::to('/')->with('error', $result['message']);
    }
	}

  private function validate($username, $password, $passconf)
  {
    if ($this->existsAdmin()) {
      $error = '';
    } elseif (!$this->isValidUsername($username)) {
      $error = 'Invalid username';
    } elseif (!$this->isValidPassword($password)) {
      $error = 'Invalid password';
    } elseif (!$this->isConfirmMatching($password, $passconf)) {
      $error = 'Passwords not matching';
    }
    if (isset($error)) return array('success' => false, 'message' => $error);
    return array('success' => true);
  }

  private function isValidUsername($username)
  {
    return preg_match('/^[a-zA-Z0-9\.\-_]{6,25}$/', $username);
  }

  private function isValidPassword($password)
  {
    return preg_match('/^[a-zA-Z0-9\.\-_]{6,25}$/', $password);
  }

  private function isConfirmMatching($password, $passconf)
  {
    return $password === $passconf;
  }

  private function existsAdmin()
  {
    return User::where('admin', true)->first();
  }

  private function saveUser($username, $password, $folder)
  {
    try {
    $admin = new User;
    $admin->admin = true;
    $admin->username = $username;
    $admin->password = Hash::make($password); 
    $admin->folder = $folder;
    $admin->save();
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }
}
