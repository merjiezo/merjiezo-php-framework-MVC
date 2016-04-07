<?php
class login extends MModel {

	private $username = '';
	private $password = '';
	private $tableName;
	private $error = '';
	//登录业务工厂类
	public function __construct($username, $password, $userId, $passId) {
		$this->username = $username;
		$this->password = $password;
		$this->EmptyOrNot();
		$this->getDataFromSql($userId, $passId);

	}

	public function getTableName($tableName) {
		$this->tableName = $tableName;
	}

	private function EmptyOrNot() {
		if ($this->username == '' || $this->password == '') {
			$this->error = 'Empty';
		} else {
			return true;
		}
	}
	private function getpassword() {
		$password = $this->findOnlyOne('XH_PW', 'user_tb', 'XH_ID', $this->username);
		return $password;
	}

	private function getDataFromSql($userId, $passId) {
		$sql    = 'SELECT * FROM '.$this->tableName.' WHERE '.$userId.'=\''.$this->username.'\' AND '.$passId.'=\''.$this->password.'\'';
		$result = $this->Search($sql);
		if ($result) {
			return true;
		} else {
			$this->error = '未找到此用户或者密码错误';
		}
	}
}