<?php
/**
 * PDO connection
 */
class Connection extends Object {

	//PDO to data connection STATIC$
	public $connect;

	//PDO FIRST in
	private $dsn;
	//SECOND
	private $user;
	//THIRD
	private $pass;

	private $charset;

	public function getConnect() {
		$this->getInfo();
		if ($this->isActive()) {
			return $this->connect;
		} else {
			$this->nowConnect();
			return $this->connect;
		}
	}

	public function createCommand($sql = null) {
		//first connect the db
		$command = new Command([
				'db'  => $this->getConnect(),
				'sql' => $sql,
			]);
		return $command;
	}

	//if there is active
	public function isActive() {
		return $this->connect;
	}

	//close connection
	public function close() {
		if ($this->isActive()) {
			$this->connect = null;
		}
	}

	private function err($err) {
		die('errInfo: '+$err);
	}

	//get infomation from config
	private function getInfo() {
		$db = require (dirname(__FILE__).'/../../config/db.php');
		if ($db['dsn'] && $db['user'] && $db['password']) {
			$this->dsn     = $db['dsn'];
			$this->user    = $db['user'];
			$this->pass    = $db['password'];
			$this->charset = $db['charset']?$db['charset']:'utf8';
		} else {
			$this->err('One of the PDO::DB Parameter is empty!');
		}
	}

	private function nowConnect() {
		try {
			$this->connect = new PDO($this->dsn, $this->user, $this->pass);
		} catch (PDOException $e) {
			$this->err($e->getMessage());
		}
		if (!$this->connect) {
			$this->err('PDO connect error');
		}
		$this->connect->exec('SET NAMES '.$this->charset);
		$this->connect->getAttribute(constant("PDO::ATTR_SERVER_VERSION"));
	}

	public function __destruct() {
		$this->close();
	}

}