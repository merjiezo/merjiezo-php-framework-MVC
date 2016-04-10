<?php
class SiteController extends MController {

	public function RouterIndex() {
		return $this->router('index');
	}

	public function RouterUpload() {
		$file   = new upload('upfile', 'files');
		$upFile = $file->uploadFile();
		if ($upFile) {
			print_r($upFile);
			echo "<script>alert('success')</script>";
			// return $this->router('index');
		} else {
			echo "<script>alert('failed')</script>";
		}
	}
}