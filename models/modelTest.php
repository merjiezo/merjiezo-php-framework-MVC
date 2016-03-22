<?php
include ('../lib/MModel.php');
class modelTest extends MModel {

	public function __construct() {
		$this->tableName = __CLASS__;
	}
}