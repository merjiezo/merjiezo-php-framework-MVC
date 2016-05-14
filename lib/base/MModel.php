<?php

class MModel {

	protected $tableName = '';
	protected $primKey   = 'id';

	//defult is id
	public function setPrimKey($id) {
		$this->primKey = $id;
	}
	/**
	 * 返回一条纪录内的一个值
	 * @param  想要取出的值
	 * @param  主键对应的值
	 * @return 返回一个值
	 **/
	public function findOnlyOne($target, $idVal) {
		$sql = Merj::sql()->select($target)->from($this->tableName)->where([
				$this->primKey => $idVal,
			])->sqlVal();
		$rows = Merj::db()->createCommand($sql)->queryOne();
		if ($rows) {
			return $rows[$target];
		} else {
			return false;
		}
	}

	/**
	 * 返回一条纪录
	 * @param  主键属性
	 * @param  主键对应的值
	 * @return 返回这条纪录
	 **/
	public function findOneRecord($userIdVal) {
		$sql = Merj::sql()->select()->from($this->tableName)->where([
				$this->primKey => $userIdVal,
			])->sqlVal();
		$rows = Merj::db()->createCommand($sql)->queryOne();
		if ($rows) {
			return $rows;
		} else {
			return false;
		}
	}
	/**
	 * 通过sql语句查找
	 * @param  sql words
	 * @return results
	 **/
	public function findBySql($sql) {
		return Merj::db()->createCommand($sql)->queryAll();
	}
	/**
	 * @param  Insert info
	 * @return success or not
	 **/
	public function insertOne($arr) {
		return Merj::db()->createCommand()->insert($this->tableName, $arr);
	}
	/**
	 * @param  Insert infos
	 * @return success or not
	 **/
	public function insertNum() {

	}
	/**
	 * @param
	 * @param
	 * @return success or not
	 **/
	public function updateOneRec($arrUpDate, $idVal) {
		return Merj::db()->createCommand()->update($this->tableName, $arrUpDate, [
				$this->primKey => $idVal,
			]);
	}

	public function updateTrans($sqlArr) {
		return Merj::db()->createCommand()->updateTrans($sqlArr);
	}
	/**
	 * 通过sql语句查找
	 * @param  sql words
	 * @return success or not
	 **/
	public function deleteOne($arr) {
		return Merj::db()->createCommand()->delete($this->tableName, $arr);
	}
	/**
	 * 加密代码
	 * @param  明文
	 * @return 返回密文
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
	 * 转换成json格式，并且返回成功与否
	 * @param 是否成功
	 * @param 待处理的数组
	 * @return json数组，带有是否成功的标记
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
	 * object to array
	 * @param  object
	 * @return array
	 **/
	public function obj_arr($obj) {
		if (is_object($obj)) {
			$array = (array) $obj;
		}if (is_array($obj)) {
			foreach ($obj as $key => $value) {
				$array[$key] = $this->obj_arr($value);
			}
		}
		return $array;
	}
}