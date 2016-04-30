<?php
/**
 * the DB command is all in here
 */
class Command {

	//this save sql word
	private $sql;

	//pdo connect
	private $pdo;

	//the pdo statement
	private $pdoStmt;

	//the sql chain word
	private $queryBuider;

	//the last db select is in here
	private $lastCommandDb;

	private $dataType = PDO::FETCH_ASSOC;

	//To test sql word
	public function getSql() {
		return $this->sql;
	}

	//Connection.php to new a command
	public function __construct($arr) {
		$this->sql         = $arr['sql']?$arr['sql']:'';
		$this->queryBuider = new QueryBuilder();
		$this->pdo         = $arr['db'];
	}

	public function queryAll($fetchMode = null) {
		return $this->queryInit('fetchAll', $fetchMode);
	}

	public function queryOne($fetchMode = null) {
		return $this->queryInit('fetch', $fetchMode);
	}

	//insert into database
	public function insert($table, $arr) {
		$this->sql = $this->queryBuider->insert($table)->value($arr)->sqlVal();
		return $this->transction();
	}

	//update the database
	public function update($table, $arr, $where) {
		$this->sql = $this->queryBuider->update($table)->set($arr)->where($where)->sqlVal();
		return $this->transction();
	}

	//delete one record
	public function delete($table, $whereArr) {
		$this->sql = $this->queryBuider->delete($table)->where($whereArr)->sqlVal();
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
			return 'Sql or PDO is empty; The sql is '.$this->sql;
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
				return 'SQL Error, <br/> SQL is::'.$this->sql;
			}
			return $res;
		} else {
			return 'PDO is Fail to use execute before prepare!';
		}
	}

	//transction handle
	private function transction() {
		try {
			$this->pdo->beginTransaction();
			$res = $this->pdo->exec($this->sql);
			if ($res == 0) {
				throw new PDOException('DB Error::Fail to change the database!!  The sql is: '.$this->sql);
			}
			$this->pdo->commit();
			return $res;
		} catch (PDOException $e) {
			$this->pdo->rollback();
			return $e->getMessage();
		}
	}
}