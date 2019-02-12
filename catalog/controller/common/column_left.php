<?php  
class ControllerCommonColumnLeft extends Controller {
	public function index() {
		$this->getColumn($this->request->get, 'column_left');
	}
}
?>