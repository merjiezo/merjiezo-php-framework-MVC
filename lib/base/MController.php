<?php
class MController extends Object {

	protected $defineIndex = 'index';
	private $staticHTML    = 'view';
	public $thisClass      = '';

	//传入路径，打印出页面
	protected function router($path) {
		if (!isset($path) || empty($path)) {
			return $this->readFile($this->defineIndex);
		} else {
			return $this->readFile($path);
		}
	}
	//暂时拼接html，应该有控制，html、PHP皆可
	private function readFile($path) {
		if ($path == 'error') {
			return file_get_contents('view/layout/error.html');
		}
		if ($path == 'error500') {
			return file_get_contents('view/layout/500.html');
		}
		$path = $this->staticHTML.'/'.$this->thisClass.'/'.$path.'.html';
		if (file_exists($path)) {
			//读取文件、打印
			return file_get_contents($path);
		} else {
			return file_get_contents('view/layout/error.html');
		}
	}

	protected function notFound($error) {
		switch ($error) {
			case '404':
				return $this->readFile('error');
				break;
			case '500':
				return $this->readFile('error500');
				break;
			default:
				return $this->readFile('error500');
				break;
		}
	}
}