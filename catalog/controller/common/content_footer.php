<?php  
class ControllerCommonContentFooter extends Controller {
	public function index() {
		$this->getColumn($this->request->get, 'content_footer');
	}
}
?>