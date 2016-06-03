<?php
class LogWrite {

	private $msg;

	private $path;

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
	/*
	 * Choose Log file that write into
	 * error/app/session
	 */
	public function IntoWhere($path) {
		$this->path = APP_BASEURL.'/runtime/'.$path.'.log';
		return $this;
	}

	public function Info($msg) {
		$msg       = date('Y-m-d H:i:s')." ::  $msg \r\n";
		$this->msg = $msg;
		return $this;
	}

	public function execute() {
		return error_log($this->msg, 3, $this->path);
	}
}