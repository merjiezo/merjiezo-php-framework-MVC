<?php
/**
 * PDO logic level
 */
class PDOClass extends Object {

	protected $connection;
	/**
	 *Search Factory
	 *@param sql
	 *@return array   返回列表数组
	 **/
	public function Search($sql) {
		$query  = $this->query($sql);
		$result = $this->AllRow($query);
		return $result;
	}
	/**
	 *插入数据
	 *@param  tablename
	 * @param 插入的数组
	 *@return 是否成功
	 **/
	public function InsertInto($table, $arr) {
		foreach ($arr as $key => $value) {
			$keyArr[]   = '`'.$key.'`';
			$keyValue[] = '\''.$value.'\'';
		}
		$keys   = implode(',', $keyArr);
		$values = implode(',', $keyValue);
		$sql    = 'insert into '.$table.'('.$keys.') values('.$values.')';
		return $this->query($sql);
	}
	/**
	 *更新数据
	 *@param  tablename
	 * @param update的数据
	 * @param KeyName表的主键名
	 * @param ID主键号
	 *@return 是否成功
	 **/
	public function UpdateData($table, $KeyName, $id, $arrUpdate) {
		foreach ($arrUpdate as $key => $value) {
			$keyAndvalueArr[] = "`".$key."`='".$value."'";
		}
		$keyAndValue = implode(',', $keyAndvalueArr);
		$sql         = 'update '.$table.' set '.$keyAndValue.' where '.$KeyName.' = \''.$id.'\'';
		$query       = $this->query($sql);
		return $query;
	}
	public function deleteOneRecord($tables, $theKey, $findId) {
		$sql   = 'DELETE FROM '.$tables.' WHERE '.$theKey.' = \''.$findId.'\'';
		$query = $this->query($sql);
		return $query;
	}
	/**
	 *do query
	 *@param  sql
	 *@return query object
	 **/
	public function query($sql) {
		if (!isset($this->connection) || empty($this->connection)) {
			$this->connect();
		}
		return $this->connection->query($sql);
	}

	//clear Property connection
	public function close() {
		unset($this->connection);
	}
	/**
	 *query result to Array
	 *@param  query result
	 *@return array from database
	 **/
	private function AllRow($query) {
		foreach ($query as $row) {
			$list[] = $row;
		}
		return isset($list)?$list:'';
	}
	/**
	 *connect database
	 * get Property connect a PDO connection
	 **/
	private function connect() {
		try {
			$db               = require (dirname(__FILE__).'/../../config/db.php');
			$this->connection = new PDO($db['dsn'], $db['user'], $db['password']);
			$this->connection->exec('set names '.$db['charset']);
		} catch (PDOException $e) {
			$this->err($e->Message());
		}
	}

	private function err($err) {
		$this->close();
		die('PDO database Error, the reason is : '.$err);
	}

}