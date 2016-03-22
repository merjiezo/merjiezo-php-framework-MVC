<?php
$MModel = dirname(__FILE__).'MModel.php';
include ($MModel);
class login extends MModel {

	private $username = '';
	private $password = '';
	private $tableName;
	private $error = '';
	private $MModel;
	//登录业务工厂类
	public function __construct($username, $password, $userId, $passId) {
		$this->username = $username;
		$this->password = $password;
		$this->MModel   = new MModel();
		$this->EmptyOrNot();
		$this->getDataFromSql();

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
		$MModel   = new MModel();
		$password = $MModel->findOnlyOne('XH_PW', 'user_tb', 'XH_ID', $this->username);
		return $password;
	}

	private function getDataFromSql($userId, $passId) {
		$sql    = 'SELECT * FROM '.$this->tableName.' WHERE '.$userId.'=\''.$this->username.'\' AND '.$passId.'=\''.$this->password.'\'';
		$MModel = new MModel();
		$result = $MModel->Search($sql);
		if ($result) {

		} else {
			$this->error = '未找到此用户或者密码错误';
		}
	}
}