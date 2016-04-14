<?php
/**
 *
 */
class mysqliConnection {

	public $connection;

	private $user;

	private $password;

	private $table;

	private $host;

	private $charset;

	private $error;

	public function isConnect() {
		if ($connection !== null) {
			return $connection;
		} else {
			$this->getMySqlInfo();
			$this->open();
		}
	}

	public function disConnect() {
		if ($this->connection) {
			$this->connection = null;
			return true;
		}
	}

	private function getMySqlInfo() {
		$db             = require (dirname(__FILE__).'/../../config/db.php');
		$this->user     = $db['user'];
		$this->password = $db['password'];
		$this->table    = $db['dbName'];
		$this->host     = $db['host'];
		$this->charset  = $db['charset'];
	}

	private function open() {
		$this->connection = mysqli_connect($this->host, $this->user, $this->password, $this->table);
		if (!$this->checkConnect() && !$this->checkCharset()) {
			die($this->error);
		}
	}

	private function checkCharset() {
		if (!mysqli_query($this->connection, 'set names '.$this->charset)) {
			$this->error = mysqli_error($this->connection);
			return false;
		}
		return true;
	}

	private function checkConnect() {
		if (mysqli_connect_error($this->connection)) {
			$this->error = "Failed to connect to database: ".mysqli_connect_error();
			return false;
		}
		return true;
	}

	public function __destruct() {
		$this->connection = null;
		if ($this->connection) {
			die('close database failed, place try again later');
		}
	}
}