<?php  
class ControllerCommonContentTop extends Controller {
	protected function index() {
		$this->getColumn($this->request->get, 'content_top');
	}
}
?>