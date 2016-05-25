<?php
/**
 *
 */
class View extends Object {

	public function render($path, array $model = array()) {
		if (file_exists($path)) {
			extract($model);
			ob_end_clean();
			ob_start();
			require ($path);
			$content = ob_get_contents();
			ob_end_clean();
			ob_start();
			return $content;
		} else {
			throw new Exception("FILE DON'T EXSISTS, the path of the FILE is :: $path You must change the router you defined");
		}
	}

}