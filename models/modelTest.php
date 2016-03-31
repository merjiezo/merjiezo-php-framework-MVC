<?php
class modelTest extends MModel {

	public function __construct() {
		$this->tableName = __CLASS__;
	}

	public function findUsername($id) {
		return $this->findOnlyOne('username', 'id', $id);
	}

}