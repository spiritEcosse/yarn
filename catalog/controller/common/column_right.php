<?php  
class ControllerCommonColumnRight extends Controller {
	public function index() {
		$this->getColumn($this->request->get, 'column_right');
	}
}
?>