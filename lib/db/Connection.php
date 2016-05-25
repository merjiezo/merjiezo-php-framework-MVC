<?php
/**
 * PDO connection
 */

class Connection extends Object {

	//PDO to data connection STATIC$
	public $connect;

	private $db;

	//PDO FIRST in
	private $dsn;
	//SECOND
	private $user;
	//THIRD
	private $pass;

	private $charset;

	private $PDOSlaves;

	private static $_instance;

	private function __construct() {}
	private function __clone() {}
	//单例
	public static function getinstance() {
		if (!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function getConnect() {
		$this->getInfo();
		if ($this->isActive()) {
			return $this->connect;
		} else {
			$this->connect = $this->nowConnect();
			return $this->connect;
		}
	}

	public function getSlavesConnect($num) {
		$this->setToSlaves($num);
		$key = 'slave'.$num;
		if ($this->PDOSlaves[$key]) {
			return $this->PDOSlaves[$key];
		} else {
			$connect               = $this->nowConnect();
			$this->PDOSlaves[$key] = $connect;
			return $this->PDOSlaves[$key];
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

	public function createSlavesComm($num = 0, $sql = null) {
		$command = new Command([
				'db'  => $this->getSlavesConnect($num),
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

	//Handle if there have Error
	private function err($err) {
		throw new Exception('errInfo: '+$err);
	}

	//Get master database information from config
	private function getInfo() {
		$this->db = require (dirname(__FILE__).'/../../config/db.php');
		if ($this->db['dsn'] && $this->db['user'] && $this->db['password']) {
			$this->dsn        = $this->db['dsn'];
			$this->user       = $this->db['user'];
			$this->pass       = $this->db['password'];
			$this->charset    = $this->db['charset']?$this->db['charset']:'utf8';
			$this->rightNowDb = 'master';
		} else {
			$this->err('One of the PDO::DB Parameter is empty!');
		}
	}

	//new a PDO object through this method
	private function nowConnect() {
		try {
			$connect = new PDO($this->dsn, $this->user, $this->pass);
		} catch (PDOException $e) {
			$this->err($e->getMessage());
		}
		if (!$connect) {
			$this->err('PDO connect error');
		}
		$connect->exec('SET NAMES '.$this->charset);
		$connect->getAttribute(constant("PDO::ATTR_SERVER_VERSION"));
		return $connect;
	}

	//Serval attributes change to slaver DataBase
	public function setToSlaves($num) {
		if ($this->db['slaves'][$num]['dsn'] && $this->db['slaves'][$num]['user'] && $this->db['slaves'][$num]['password']) {
			$this->dsn        = $this->db['slaves'][$num]['dsn'];
			$this->user       = $this->db['slaves'][$num]['user'];
			$this->pass       = $this->db['slaves'][$num]['password'];
			$this->rightNowDb = 'slaves'.$num;
		} else {
			$this->err('slaves '.$num.':: missing info!');
		}
	}

	public function setMaster() {
		$this->getInfo();
		return $this;
	}

	public function getRightNowDb() {
		return $this->rightNowDb;
	}

	public function __destruct() {
		$this->close();
	}

}