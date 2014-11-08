<?php

class IndexController extends BaseController
{
	public function index()
	{
    if (!$this->getAdmin()) {
      return $this->getInstallPage();
    } elseif ($this->isLogged()) {
      return $this->getLoggedPage();
    } else {
      return $this->getLoginPage();
    }
	}

  private function getAdmin()
  {
    return User::where('admin', true)->first();
  }

  private function isLogged()
  {
    return Auth::check();
  }

  private function getLoginPage()
  {
    return View::make('login')->with('error', Session::get('error'));
  }

  private function getInstallPage()
  {
    return View::make('install')->with('error', Session::get('error'));
  }

  private function getLoggedPage()
  {
    $this->setDownloadType(Input::get('download'));
    return View::make('index', array(
      'downloadType' => Session::get('downloadType'),
      'user' => Auth::user(),
      'files' => $this->getFiles()
    ));
  }

  private function setDownloadType($type)
  {
    if (!Session::get('download')) Session::put('downloadType', 'm3u');
    if ($type) Session::put('downloadType', $type);
  }

  private function getFiles()
  {
    $out = [];
    $video_extension = ['avi', 'mp4'];
    $user = Auth::user();
    $files = glob($user->folder);
    foreach ($files as $file) {
      $film = '';
      // If file is video
      if (!is_dir($file) and in_array($ext, $video_extension)) {
        $ext = pathinfo($file)['extension'];
        $out[] = array(
          'name' => pathinfo($file, $ext)['basename'],
          'image' => '',
          'link' => '#'
        );
      } else if (is_dir($file)) {
        $out[] = array(
          'name' => $film,
          'image' => '',
          'link' => '#'
        );
      }
    }
    return $out;
  }
}
