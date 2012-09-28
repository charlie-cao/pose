<?php
class IndexAction extends Action {
	public function index() {
		$data = array ();
		$this->assign ( $data );
		$this->display ();
	}
	public function login($param) {
		$data = array ();
		$this->assign ( $data );
		$this->display ();
	}
}

