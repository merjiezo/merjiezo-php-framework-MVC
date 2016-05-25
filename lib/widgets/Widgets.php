<?php
/**
 * This is a html widgets
 * All Method have a array
 * this array is the method list, just like this:
 * [
 * 		'class' => '',
 *   	'id' => '',
 *    	'' => '',
 *     	'' => '',
 *      '' => '',
 *
 * ]
 *
 */
class Widgets {

	//This is button logic, and it's must have value
	public function Button($class, $value = 'Button', $arr) {
		$button           = new Html();
		$button->htmlType = 'button';
		echo $button->getClass($class)->getId($arr['id'])->getData($arr['data'])->uniqueAttr($arr['uniqueAttr'])->getContents($value)->getVal(1);
	}

	//This is <a></a>
	public function a($class, $href, $value = 'Href', $arr) {
		$a                     = new Html();
		$a->htmlType           = 'a';
		$a->SingleAttr['href'] = $href;
		echo $a->getClass($class)->getId($arr['id'])->getData($arr['data'])->uniqueAttr($arr['uniqueAttr'])->getContents($value)->getVal(1);
	}

	public function Form($href, $type = 'GET', $contents) {
		$html = '<form method="'.$type.'" action="'.$href.'">';
		$html .= $contents;
		$html .= '</from>';
	}

	public function p() {
		$p                = new Html();
		$button->htmlType = 'p';
	}

	public function Input() {
		$html             = new Html();
		$button->htmlType = 'input';
	}

	public function Div() {
		$html             = new Html();
		$button->htmlType = 'div';
	}

	//The type of the html tag
	public function Html($type) {
		$html             = new Html();
		$button->htmlType = $type;
	}
}