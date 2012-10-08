<?php

class UserAction extends Action {
    public function index() {
        $data = array();
        $this->assign($data);
        $this->display();
    }

    public function findpassword() {
    	$data = array();
    	$this->assign($data);
    	$this->display();
    }
    
    public function register() {
    	$data = array();
    	$this->assign($data);
    	$this->display();
    }
    
    public function registerinfo() {

    	$data = array();
    	$this->assign($data);
    	$this->display();
    }

    public function getinvcode(){
    	$data = array();
    	$this->assign($data);
    	$this->display();
    
    }

    public function thankyou(){
    	$data = array();
    	$this->assign($data);
    	$this->display();
    
    }
	//我发布的
    public function mybrand(){
    	$data = array();
    	$this->assign($data);
    	$this->display();
    
    }
	// 我喜欢的
    public function ilikebrand(){
    	$data = array();
    	$this->assign($data);
    	$this->display();
    }
    
    // 我的成就
    public function brandlist(){
    	$data = array();
    	$this->assign($data);
    	$this->display();
    }
    
    // 我的好友
    public function friend(){
    	$data = array();
    	$this->assign($data);
    	$this->display();
    }
    
    // 我的话题
    public function topic(){
    	$data = array();
    	$this->assign($data);
    	$this->display();
    }
    
    
    
    
}

