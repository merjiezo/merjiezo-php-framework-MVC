<?php
class Users extends Login {

	public function __construct() {
		$this->tableName = __CLASS__;
		$this->primKey   = 'user_id';
	}

	public function handlelogin($user, $pass) {
		$this->getLoginData($user, $pass, 'name', 'userpass');
		$result = $this->loginFact();
		if (is_array($result)) {
			if ($result[0] == 'failed') {
				return $result[1];
			}
		} else {
			return 'success';
		}
	}

}
