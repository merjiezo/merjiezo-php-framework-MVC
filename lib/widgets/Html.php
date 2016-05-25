<?php
require ('HtmlWidget.php');
/**
 * This is html label
 */
class Html implements HtmlWidget {

	public $htmlType = '';

	protected $attr = [
		'class' => '',
		'id'    => '',
		'data'  => '',
		'attr'  => '',
	];

	public $SingleAttr = [
		'src'   => '',
		'href'  => '',
		'type'  => '',
		'value' => '',
		'name'  => '',
		'min'   => '',
		'max'   => '',
	];

	protected $contents;

	public function getClass($className = null) {
		$res = '';
		if (is_array($className)) {
			$res                 = implode(' ', $className);
			$this->attr['class'] = 'class="'.$res.'"';
		} else {
			$res                 = $className;
			$this->attr['class'] = 'class="'.$res.'"';
		}

		return $this;
	}

	public function getId($idName = null) {
		if ($idName) {
			$this->attr['id'] = 'id="'.$idName.'"';
		}
		return $this;
	}

	public function getData($dataName = null) {
		$res = [];
		if (!$dataName) {
			return $this;
		}
		foreach ($dataName as $key => $value) {
			$res[] = 'data-'.$key.'="'.$value.'"';
		}
		$this->attr['data'] = implode(' ', $res);
		return $this;
	}

	public function uniqueAttr($AttrName = null) {
		$res = [];
		if (!$AttrName) {
			return $this;
		}
		foreach ($AttrName as $key => $value) {
			$res[] = $key.'="'.$value.'"';
		}
		$this->attr['attr'] = implode(' ', $res);
		return $this;
	}

	public function getContents($contents = '') {
		$this->contents = $contents;
		return $this;
	}

	public function getVal($type = 0) {
		$style = $this->beanAttr();
		$style .= ' '.$this->beanSingle();
		$html = '<'.$this->htmlType.' '.$style.'>';
		if ($type == 1) {
			$html .= $this->contents;
			$html .= '</'.$this->htmlType.'>';
		}
		return $html;
	}

	protected function beanAttr() {
		$arr = [];
		foreach ($this->attr as $key => $value) {
			if ($value != '') {
				$arr[$key] = $value;
			}
		}
		$arr = array_values($arr);
		return implode(' ', $arr);
	}

	protected function beanSingle() {
		$arr = [];
		foreach ($this->SingleAttr as $key => $value) {
			if ($value != '') {
				$arr[$key] = $value;
			}
		}
	}

}