<?php
/**
 *
 */
class Query {

	private $queryWord;

	public $select = '';

	public $from = '';

	public $where = '';

	public $groupby = '';

	public $having = '';

	public $between = '';

	public $orderby = '';

	public $join = '';

	public $limit = '';

	public function select($select = '*') {
		if (!is_array($select)) {
			$select = preg_split('/\s*,\s*/', trim($select), -1, PREG_SPLIT_NO_EMPTY);
		}
		$this->select = 'SELECT '.$select;
		return $this;
	}

	public function from($table) {
		if (!is_array($table)) {
			$table = preg_split('/\s*,\s*/', trim($table), -1, PREG_SPLIT_NO_EMPTY);
		}
		$this->from = ' FROM '.$table;
		return $this;
	}

	public function where($group) {
		$where = '';
		if (is_array($group)) {
			foreach ($group as $key => $value) {
				$where .= 'AND '.$key.'=\''.$value.'\'';
			}
			$where       = substr($where, 4);
			$where       = ' WHERE '.$where;
			$this->where = addslashes($where);
		}
		if (is_string($group)) {
			$this->where = addslashes($group);
		}
		return $this;
	}

	public function groupby() {

	}

	public function between() {

	}

	public function orderby($keyArr) {
		$orderby = ' ORDER BY ';
	}

	public function join() {

	}

	public function limit($page, $count) {
		$limit = ' LIMIT ';
		$num   = $page*$count-$count;
		$this->limit .= $num.', '.$count;
	}

	public function sum() {
		return $this;
	}

	public function num() {
		return $this;
	}

	public function min() {
		return $this;
	}

	public function max() {
		return $this;
	}

	public function count() {
		return $this;
	}

}