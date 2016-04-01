<?php
class SiteController extends MController {

	public function RouterIndex() {
		return $this->router('index');
	}
}