<?php
/**
 * All class Extend this class,
 * this is the base class for the framework!
 */
class Object {
	//获取类名
	public function getClassName() {
		return get_called_class();
	}
	//有此方法
	public function hasMethod($name) {
		return method_exists($this, $name);
	}

	public function __call($name, $params) {
		die('Calling unknown method: '.get_class($this)."::$name()");
	}
	//是否有此属性
	public function hasProperty($name, $checkVars = true) {
		return $this->canGetProperty($name, $checkVars) || $this->canSetProperty($name, false);
	}
	//是否可读
	public function canGetProperty($name, $checkVars = true) {
		return method_exists($this, 'get'.$name) || $checkVars && property_exists($this, $name);
	}
	//是否可写
	public function canSetProperty($name, $checkVars = true) {
		return method_exists($this, 'set'.$name) || $checkVars && property_exists($this, $name);
	}
}