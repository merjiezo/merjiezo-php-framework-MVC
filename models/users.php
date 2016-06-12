<?php
class Users extends Login {

	private $manager = [
		1=> '普通工人',
		2=> '仓储管理员',
	];

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

	public function LimitInfo($page, $limit) {
		$sql = 'SELECT COUNT(*) FROM users';
		$num = $this->findBySql($sql);
		$num = (int) $num['COUNT(*)']/$limit;
		if ($num == 0) {
			$num = 1;
		}
		$num     = (int) $num;
		$query   = new QueryBuilder();
		$sql     = $query->select()->from('users')->limit($page, $limit)->sqlVal();
		$results = $this->findBySql($sql);
		if ($results) {
			foreach ($results as $key => $value) {
				$results[$key]['status'] = $this->manager[$value['status']];
			}
			$results['pagination'] = $num;
			return $results;
		}
		return false;
	}

	public function InsertUser($arr) {
		$arr['time']     = date('Y-m-d');
		$arr['status']   = 1;
		$arr['userpass'] = sha1('123456');
		if ($this->insertOne($arr)) {
			return true;
		}
		return false;
	}

	public function DeleteUser($id) {
		if ($this->deleteOne([
					'user_id' => $id,
				])) {
			return true;
		}
		return false;
	}

	public function UpUserAuth($status, $id) {
		if ($this->updateOneRec([
					'status' => $status,
				], $id)) {
			return true;
		}
		return false;
	}

	public function ResetUserPass($id) {
		if ($this->updateOneRec([
					'userpass' => sha1('123456'),
				], $id)) {
			return true;
		}
		return false;
	}

}
