<?php  
class ControllerCommonContentHeader extends Controller {
	public function index() {
		$this->getColumn($this->request->get, 'content_header');
	}
}
?>