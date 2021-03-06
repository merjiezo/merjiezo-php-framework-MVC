<?php
class MController extends Object {

	public $defineIndex = 'index';
	private $staticHTML = 'view';
	public $thisClass   = '';

	//this is the html file
	public function Html($path) {
		if (!isset($path) || empty($path)) {
			return $this->readFile($this->defineIndex.'html');
		} else {
			return $this->readFile($path.'.html');
		}
	}

	//传入路径，打印出页面
	public function router($path, array $model = array()) {
		if (!isset($path) || empty($path)) {
			return $this->readFile($this->defineIndex.'.php');
		} else {
			$view = new View();
			if (strstr($path, '/')) {
				return $view->render(APP_BASEURL."/$this->staticHTML/$path.php", $model);
			} else {
				return $view->render(APP_BASEURL."/$this->staticHTML/$this->thisClass/$path.php", $model);
			}
		}
	}
	//暂时拼接html，应该有控制，html、PHP皆可
	private function readFile($path) {
		if ($path == 'error') {
			return @file_get_contents('view/layout/error.html');
			fclose();
		}
		if ($path == 'error500') {
			return @file_get_contents('view/layout/500.html');
		}
		$path = $this->staticHTML.'/'.$this->thisClass.'/'.$path;
		if (file_exists($path)) {
			//读取文件、打印
			return @file_get_contents($path);
		} else {
			return @file_get_contents('view/layout/error.html');
		}
	}

	public function notFound($error) {
		switch ($error) {
			case '404':
				header("HTTP/2.0 404 Not Found");
				return $this->readFile('error');
				break;
			case '500':
				header("HTTP/2.0 500 Not Found");
				return $this->readFile('error500');
				break;
			default:
				header("HTTP/2.0 500 Not Found");
				return $this->readFile('error500');
				break;
		}
	}

	//xss protected
	public function htmlencode($html, $doubleEncode = true) {
		return htmlspecialchars($html, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8', $doubleEncode);
	}

	public static function htmldecode($str) {
		return htmlspecialchars_decode($str, ENT_QUOTES);
	}

	public function __call($name, $params) {
		if (substr($name, 0, 6) == 'Router') {
			$this->notFound('404');
		} else {
			parent::__call($name, $params);
		}
	}

	protected function getSession($key, $status) {
		$session   = new Session();
		$authority = $session->get($key, '');
		if ($status == 0) {
			if (!$authority) {
				return 1;
			}
			return 0;
		}
		return ((int) $authority == $status)?1:0;
	}

	//the controller's method
	public function behaviors() {
		return [];
	}
}