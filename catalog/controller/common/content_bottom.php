<?php  
class ControllerCommonContentBottom extends Controller {
	protected function index() {
		$this->getColumn($this->request->get, 'content_bottom');
	}
}
?>