<?php

class Cookie {
	//cookie name
	public $name = '';
	//defult value
	public $value = '';
	//time strtotime style
	public $time = 0;

	public function __construct($name = '', $value = '', $time) {
		$this->name  = $name;
		$this->value = (String) $value;
		$this->time  = $time;
	}

	/**
	 *setCookie
	 *@param  object
	 *@return array
	 **/
	public function setCookie() {
		setcookie($this->name, $this->value, @strtotime('+ '.$this->time));
	}

	//distory cookie if exsist
	public static function distory($name) {
		if ($_COOKIE[$name]) {
			setcookie($name, 'distory', 1);
		}
		return true;
	}

	//get number of cookie
	public function getCount() {
		return count($_COOKIE);
	}

	//jiami
	public function base64_encode($data) {
		$data = $data >> 3;
		return base64_encode($data);
	}

	//jiemi
	public function base64_decode($data) {
		$data = base64_decode($data);
		return $data << 3;
	}
}