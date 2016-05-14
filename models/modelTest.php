<?php
class modelTest extends Login {

	public function __construct() {
		$this->tableName = __CLASS__;
		$this->primKey   = 'id';
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
		return $this->findBySql('SELECT * FROM modelTest WHERE id = \'1\'');
	}

	public function changeName() {
		$sqlArr = [
			'UPDATE modelTest SET username=\'la\' WHERE id=\'2\'',
			'UPDATE modelTest SET username=\'lalala\' WHERE id=\'3\'',
		];
		return $this->updateTrans($sqlArr);
	}

}