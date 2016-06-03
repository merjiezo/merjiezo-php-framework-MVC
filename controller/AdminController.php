<?php
class AdminController extends MController {

	//rules is the function that cannot into this website page
	//Guest is can show method
	public function behaviors() {
		return [
			'rules' => [
				[
					'actions'        => ['RouterUser', 'RouterGoods', 'RouterInstock', 'RouterOutstock', 'RouterBarcode'],
					'matchAuthority' => $this->getSession('status', 1),
				],
				[
					'actions'        => [],
					'matchAuthority' => $this->getSession('status', 2),
				],
				[
					'actions'        => ['RouterUser', 'RouterGoods', 'RouterInstock', 'RouterOutstock', 'RouterBarcode'],
					'matchAuthority' => $this->getSession('status', 0),
				],
			],
		];
	}

	public function RouterUser() {
		$user  = new Users();
		$model = $user->LimitInfo(1, 10);
		return $this->router('user', $model);
	}

	public function RouterGoods() {
		$shelvies = new Shelvies();
		$model    = $shelvies->findAllSl();
		return $this->router('goods', $model);
	}

	public function RouterInstock() {
		$inquiry = new Inquiry();
		$model   = $inquiry->LimitInfo(1, 10);
		return $this->router('instock', $model);
	}

	public function RouterOutstock() {
		return $this->router('outstock');
	}

	public function RouterBarcode() {
		return $this->router('barcode');
	}

	public function RouterShowgoods() {
		$stock   = explode('/', $_GET['r'])[2];
		$inquiry = new Inquiry();
		$model   = $inquiry->findOneRec($stock);
		if ($model) {
			return $this->router('showgoods', $model);
		} else {
			header("HTTP/2.0 404 Not Found");
			return $this->html('404');
		}
	}

	//store/index.php?r=admin/codedraw&text=123456
	public function RouterCodedraw() {
		$codebar = 'BCGcode128';
		$text    = $_GET['text'];
		require (APP_BASEURL.'/vender/barcodegen/BCGFontFile.php');
		require (APP_BASEURL.'/vender/barcodegen/BCGDrawing.php');
		require (APP_BASEURL.'/vender/barcodegen/'.$codebar.'.barcode.php');

		$font       = new BCGFontFile(APP_BASEURL.'/vender/barcodegen/font/Arial.ttf', 18);
		$colorFront = new BCGColor(0, 0, 0);
		$colorBack  = new BCGColor(255, 255, 255);

		$drawException = null;
		try {
			// Barcode Part
			$code = new $codebar();
			$code->setScale(2);
			$code->setThickness(30);
			$code->setForegroundColor($colorFront);
			$code->setBackgroundColor($colorBack);
			$code->setFont($font);
			$code->setStart(NULL);
			$code->setTilde(true);
			$code->parse($text);
		} catch (Exception $exception) {
			$drawException = $exception;
		}

		// Drawing Part
		$drawing = new BCGDrawing('', $colorBack);
		if ($drawException) {
			$drawing->drawException($drawException);
		} else {
			$drawing->setBarcode($code);
			$drawing->draw();
		}

		header('Content-Type: image/png');
		$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
	}

}