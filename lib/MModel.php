<?php
$mysqlPath = dirname(__FILE__).'/mysql.php';
include ($mysqlPath);
class MModel extends mysql {

	private $mysql;
	protected $tableName = '';

	public function findOnlyOne($target, $idName, $idVal) {
		$sql  = 'SELECT '.$target.' FROM '.$this->tableName.' WHERE '.$idName.'=\''.$idVal.'\'';
		$rows = $this->mysql->Search($sql);
		if ($rows) {
			return $rows[0][$target];
		} else {
			return false;
		}
	}

	public function __construct() {
		$this->mysql = new mysql();
	}
	/**
	 *加密代码
	 *@param  明文
	 *@return 返回密文
	 **/
	public function encrypt($value) {
		if ($value == '') {
			return false;
		} else {
			$ciphertext = substr($value, 0, -1);
			$value      = $ciphertext.''.$ciphertext;
			return sha1(md5(str).'merjiezo');
		}
	}
	/**
	 *搜索工厂模式
	 *@param 是否成功
	 *@param 待处理的数组
	 *@return json数组，带有是否成功的标记
	 **/
	protected function jsonGet($success, $arr = []) {
		if ($success) {
			$json = json_encode($arr);
			return '{"success":true,'.substr($json, 1, -1).'}';
		} else {
			return '{"success":false}';
		}
	}

}
// $Mmodel            = new MModel();
// $Mmodel->tableName = 'exitem';
// echo $Mmodel->findOnlyOne('st_classmark', 'shuqian', '123');