<?php
/**
 * The factory of the database
 */
class DbFactory {

	private $connection;

	private $sql;

	public function __construct() {
		$connect          = new mysqliConnection();
		$this->connection = $connect->isConnect();
		$this->sql        = new Query();
	}

	public function createCommend() {

	}

	public function createOneRecord() {

	}
}