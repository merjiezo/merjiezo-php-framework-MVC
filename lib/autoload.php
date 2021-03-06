<?php
/**
 * this is an autoload that if one class has been new, but this class does not
 * exsist in this file, it can be autoload through a method call autoLoad,
 * through a mapped table, and all framework file's classpath is in the { $classPath }
 */
class Merj {

	public static $classPath = [];

	public static $alreadyReq = [];

	// public static $app = Connection::getinstance();

	public static function autoLoad($className) {
		$file = self::$classPath[$className];
		if (!isset(self::$classPath[$className])) {
			//if there is model or controller
			if (strpos($className, 'Controller')) {
				self::auto(APP_BASEURL.'/Controller/'.$className.'.php');
				return;
			} else {
				self::auto(APP_BASEURL.'/models/'.$className.'.php');
				return;
			}
		}
		self::auto($file);
	}

	public static function session($key) {
		$session = new Session();
		return $session->get($key, '');
	}

	public static function auto($file) {
		if (!is_file($file)) {
			die('This is not a file or this is not Exist'.$file);
		}
		require ($file);
	}

	public static function db() {
		$con = Connection::getinstance();
		return $con;
	}

	public static function sql() {
		return new QueryBuilder();
	}

	public static function widget() {
		return new Widgets();
	}
}

spl_autoload_register(['Merj', 'autoLoad'], true, true);
Merj::$classPath = require (__DIR__ .'/composer/loadArray.php');
