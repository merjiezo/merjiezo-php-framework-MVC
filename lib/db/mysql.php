<?php
/**
 * mysql Connection
 */

class mysql extends Object {

	protected $connection;
	/**
	 *搜索工厂模式
	 *@param sql
	 *@return array   返回列表数组
	 **/
	public function Search($sql) {
		$query  = $this->query($sql);
		$result = $this->findAll($query);
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
	 *@param sql语句
	 *@return source $query sql
	 **/
	public function query($sql) {
		if (!isset($this->connection) || empty($this->connection)) {
			$this->DatabaseConnection();
		}
		$this->dbSqlProtected($sql);
		if (!($query = mysqli_query($this->connection, $sql))) {//使用mysql_query函数执行sql语句
			$this->err($sql."<br>".mysqli_error($this->connection));//mysql_error 报错
		} else {
			return $query;
		}
	}
	/**
	 * 返回表内所有表名
	 * @param string $schema the schema of the tables. Defaults to empty string, meaning the current or default schema.
	 * @return array all table names in the database. The names have NO schema name prefix.
	 */
	protected function findTableNames($schema = '') {
		$sql = 'SHOW TABLES';
		if ($schema !== '') {
			$sql .= ' FROM '.$this->quoteSimpleTableName($schema);
		}

		return $this->db->createCommand($sql)->queryColumn();
	}

	public function quoteSimpleTableName($name) {
		return strpos($name, "`") !== false?$name:"`".$name."`";
	}

	/**
	 *@param source $query sql语句通过mysql_query 执行出来的资源
	 *@return array   返回列表数组
	 **/
	private function findAll($query) {
		while ($rs = mysqli_fetch_array($query, MYSQL_ASSOC)) {//mysql_fetch_array函数把资源转换为数组，一次转换出一行出来
			$list[] = $rs;
		}
		return isset($list)?$list:"";
	}

	/**
	 *sql注入防范(基本)，传入想要校验的数据
	 *@param  处理前的sql
	 *@return 处理后的value
	 **/
	private function dbSqlProtected($value) {
		if (!isset($this->connection) || empty($this->connection)) {
			$this->DatabaseConnection();
		}
		$value = mysqli_real_escape_string($this->connection, $value);
		return $value;
	}
	/**
	 *连接数据库
	 *@return 连接资源
	 **/
	private function DatabaseConnection() {
		$db               = require (dirname(__FILE__).'/../../config/db.php');
		$this->connection = mysqli_connect($db['host'], $db['user'], $db['password'], $db['dbName']);
		if (!mysqli_query($this->connection, 'set names '.$db['charset'])) {
			mysqli_error($this->connection);
		}
		if (mysqli_connect_error($this->connection)) {
			$this->err("Failed to connect to database: ".mysqli_connect_error());
		}
	}

	private function err($error) {
		die("对不起，您的操作有误，错误原因为：".$error);
	}

}