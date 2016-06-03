<?php
/**
 * the DB command is all in here
 */

class Command extends Object {

	//this save sql word
	private $sql;

	//pdo connect
	private $pdo;

	//the pdo statement
	private $pdoStmt;

	//the last db select is in here
	private $lastCommandDb;

	private $dataType = PDO::FETCH_ASSOC;

	//To test sql word
	public function getSql() {
		return $this->sql;
	}

	//Connection.php to new a command
	public function __construct($arr) {
		$this->sql = $arr['sql']?$arr['sql']:'';
		$this->pdo = $arr['db'];
	}

	public function queryAll($fetchMode = null) {
		return $this->queryInit('fetchAll', $fetchMode);
	}

	public function queryOne($fetchMode = null) {
		return $this->queryInit('fetch', $fetchMode);
	}

	//insert into database
	public function insert($table, $arr) {
		$this->sql = Merj::sql()->insert($table)->value($arr)->sqlVal();
		return $this->transction();
	}

	//insert serval database
	public function insertSomeVal($table, array $key, array $arr) {
		$this->sql = Merj::sql()->insert($table)->servalValue($key, $arr)->sqlVal();
		return $this->transction();
	}

	//update the database
	public function update($table, $arr, $where) {
		$this->sql = Merj::sql()->update($table)->set($arr)->where($where)->sqlVal();
		return $this->transction();
	}

	public function updateTrans(array $sqlArr = array()) {
		return $this->transctions($sqlArr);
	}

	//delete one record
	public function delete($table, $whereArr) {
		$this->sql = Merj::sql()->delete($table)->where($whereArr)->sqlVal();
		return $this->transction();
	}

	private function queryInit($method, $fetchMode = null) {
		if ($fetchMode) {
			$this->dataType = $fetchMode;
		}
		if ($this->sql && $this->pdo) {
			$this->prepare();
			$result = $this->execute($method);
			return $result?$result:'';
		} else {
			$err = 'Sql or PDO is empty; The sql is '.$this->sql;
			LogWrite::getinstance()->IntoWhere('errordb')->Info($this->sql)->execute();
			throw new PDOException($err);
			return false;
		}
	}

	//Must handle
	private function prepare() {
		//if there have stmt
		if ($this->pdoStmt) {
			$this->lastCommandDb = $this->pdoStmt;
		}
		$this->pdoStmt = $this->pdo->prepare($this->sql);
	}

	//execute it and return
	private function execute($method) {
		if ($this->pdoStmt) {
			$pdoStmt = $this->pdoStmt;
			$pdoStmt->execute();
			$res = $pdoStmt->$method($this->dataType);
			if (!$res) {
				$msg = 'The result is empty, The sql word is :: '.$this->sql;
				LogWrite::getinstance()->IntoWhere('errordb')->Info($msg)->execute();
				return false;
			}
			return $res;
		} else {
			throw new PDOException('PDO is Fail to use execute before prepare!');
		}
	}

	//transction handle
	private function transction() {
		try {
			$this->pdo->beginTransaction();
			$res = $this->pdo->exec($this->sql);
			if ($this->pdo->errorInfo()[0] != '00000') {
				throw new PDOException('DB Error::Fail to change the database!!  The sql is: '.$this->sql.' The Error is :: '.$this->pdo->errorInfo()[2]);
			}
			$this->pdo->commit();
			return true;
		} catch (PDOException $e) {
			$this->pdo->rollback();
			LogWrite::getinstance()->IntoWhere('errordb')->Info($e)->execute();
			return false;
		}
	}

	//change it lately
	private function transctions(array $sqlArr = array()) {
		try {
			$this->pdo->beginTransaction();
			foreach ($sqlArr as $value) {
				$res = $this->pdo->exec($value);
				print_r($this->pdo->errorInfo());
				if ($this->pdo->errorInfo()[0] != '00000') {
					throw new PDOException('DB Error::Fail to change the database!!  The sql is: '.$value.' The Error is :: '.$this->pdo->errorInfo()[2]);
				}
			}
			$this->pdo->commit();
			return true;
		} catch (PDOException $e) {
			$this->pdo->rollback();
			LogWrite::getinstance()->IntoWhere('errordb')->Info($e)->execute();
			return false;
		}
	}
}