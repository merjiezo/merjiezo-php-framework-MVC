<?php

/**
 * session options
 */
class Session {

	//打开session
	public function open() {
		if ($this->getIsActive()) {
			return;
		}

		@session_start();

		if ($this->getIsActive()) {
			return;
		} else {
			return 'session failed to start';
		}
	}

	//暂停session的写入
	public function close() {
		if ($this->getIsActive()) {
			@session_write_close();
		}
	}

	//＊＊强行销毁所有session（不建议使用）
	public function destory() {
		if ($this->getIsActive()) {
			@session_unset();
			@session_destroy();
		}
	}
	//获取session
	public function get($key, $defultValue) {
		$this->open();
		return isset($_SESSION[$key])?$_SESSION[$key]:$defultValue;
	}
	//设置session
	public function set($key, $value) {
		$this->open();
		$_SESSION[$key] = $value;
	}
	//移除session
	public function remove($key) {
		$this->open();
		if (isset($_SESSION[$key])) {
			$value = $_SESSION[$key];
			return $value;
		} else {
			return null;
		}
	}

	//session是否处于活跃状态
	public function getIsActive() {
		return session_status() === PHP_SESSION_ACTIVE;
	}
	//session唯一id
	public function getId() {
		return session_id();
	}
	//修改sessionID
	public function setId($value) {
		session_id($value);
	}
	//获取数量
	public function getCount() {
		$this->open();
		return count($_SESSION);
	}

	public function initWebSiteSession($day, $arrSess) {
		session_cache_expire(60*24*$day);
		foreach ($arrSess as $key => $value) {
			(!isset($key) && empty($key) && !isset($value) && empty($value))?
			''
			:$this->set($key, $value);
		}
	}

	public function __destruct() {
		$this->close();
	}

}