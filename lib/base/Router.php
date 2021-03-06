<?php
class Router extends Object {

	public $catchAll;

	private static $_instance;

	private function __construct() {}
	private function __clone() {}
	//单例
	public static function getinstance() {
		if (!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	//获取URL内容
	private function getUrl() {
		if (!isset($_GET['r']) || empty($_GET['r'])) {
			return ['site', 'index'];
		} else {
			if (strpos($_GET['r'], '/')) {
				if (substr($_GET['r'], -1) == '/') {
					return [substr($str, 0, -1), 'index'];
				} else {
					return explode("/", $_GET['r']);
				}
			} else {
				return [$_GET['r'], 'index'];
			}
		}
	}
	//路由工厂模式
	public function getControllerFactory() {
		$arrURL = $this->getURL();
		if ($this->catchAll()) {
			$arrURL = $this->catchAll();
		}
		$className   = ucwords($arrURL[0]).'Controller';
		$includePath = 'controller/'.ucwords($arrURL[0]).'Controller.php';
		if (file_exists($includePath)) {
			$ClassController            = new $className;
			$ClassController->thisClass = $arrURL[0];
			$arr                        = $ClassController->behaviors();
			if (!$arr) {
				$classMethod = 'Router'.ucwords($arrURL[1]);
				if ($ClassController->hasMethod($classMethod)) {
					return $ClassController->$classMethod();
				} else {
					return $ClassController->notFound('404');
				}
			}
			foreach ($arr['rules'] as $value) {
				if ($value['matchAuthority'] == 1 && $this->inRouteArr($value['actions'], $arrURL[1])) {
					$classMethod = 'Router'.ucwords($arrURL[1]);
					if ($ClassController->hasMethod($classMethod)) {
						return $ClassController->$classMethod();
					} else {
						return $ClassController->notFound('404');
					}
				}
			}
			header("HTTP/2.0 403 Not Found");
			echo "<script>alert('Error 403, No authority!')</script>";
			exit;
		} else {
			$controller = new MController();
			return $controller->notFound('404');
		}
	}

	public function catchAll() {
		$base = require ('config/base.php');
		if ($base['catchAll']) {
			return explode("/", $base['catchAll']);
		}
	}

	private function inRouteArr($action, $control) {
		$classMethod = 'Router'.ucwords($control);
		foreach ($action as $value) {
			if ($value == $classMethod) {
				return false;
			}
		}
		return true;
	}

}