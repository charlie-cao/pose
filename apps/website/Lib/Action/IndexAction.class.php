<?php

class IndexAction extends Action {

    public function index() {


        $data = array();
        $this->assign($data);
        $this->display();
    }
    
    public function findpassword(){
    	$data = array();
    	$this->assign($data);
    	$this->display();
    }

   

}

