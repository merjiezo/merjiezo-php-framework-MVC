<?php
class modelTest extends login {

	public function __construct() {
		$this->tableName = __CLASS__;
	}

	public function handlelogin($user, $pass) {
		$this->getLoginData($user, $pass, 'username', 'password');
		$result = $this->loginFact();
		if (is_array($result)) {
			if ($result[0] == 'failed') {
				return $result[1];
			}
		} else {
			return 'success';
		}
	}

	//model demo
	public function findUsername($id) {
		return $this->findOnlyOne('username', 'id', $id);
	}

}