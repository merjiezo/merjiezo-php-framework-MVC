<?php

class MModel extends mysql {

	protected $tableName = '';
	/**
	 *返回一条纪录内的一个值
	 *@param  想要取出的值
	 *@param  主键属性
	 *@param  主键对应的值
	 *@return 返回一个值
	 **/
	public function findOnlyOne($target, $idName, $idVal) {
		$sql  = 'SELECT '.$target.' FROM '.$this->tableName.' WHERE '.$idName.'=\''.$idVal.'\'';
		$rows = $this->Search($sql);
		if ($rows) {
			return $rows[0][$target];
		} else {
			return false;
		}
	}

	/**
	 *返回一条纪录
	 *@param  主键属性
	 *@param  主键对应的值
	 *@return 返回这条纪录
	 **/
	public function findOneRecord($userId, $userIdVal) {
		$sql  = 'SELECT * FROM '.$this->tableName.' WHERE '.$userId.'=\''.$userIdVal.'\'';
		$rows = $this->Search($sql);
		if ($rows) {
			return $rows[0];
		} else {
			return false;
		}
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
	 *加密代码
	 *@param  明文
	 *@return 返回密文
	 **/
	public function recordExist($sql) {

	}
	/**
	 *转换成json格式，并且返回成功与否
	 *@param 是否成功
	 *@param 待处理的数组
	 *@return json数组，带有是否成功的标记
	 **/
	protected function jsonGet($success, $arr = []) {
		if ($success) {
			if ($arr) {
				$json = json_encode($arr);
				return '{"success":true,'.substr($json, 1, -1).'}';
			} else {
				return '{"success":false}';
			}
		} else {
			return '{"success":false}';
		}
	}

	/**
	 *object to array
	 *@param  object
	 *@return array
	 **/
	public function obj_arr($obj) {
		if (is_object($obj)) {
			$array = (array) $obj;
		}if (is_array($obj)) {
			foreach ($obj as $key => $value) {
				$array[$key] = obj_arr($value);
			}
		}
		return $array;
	}

}