<?php
class AdminController extends MController {

	public function RouterUser() {
		return $this->router('user');
	}

	public function RouterGoods() {
		return $this->router('goods');
	}

	public function RouterInstock() {
		return $this->router('instock');
	}

	public function RouterOutstock() {
		return $this->router('outstock');
	}

	public function RouterBarcode() {
		return $this->router('barcode');
	}

}