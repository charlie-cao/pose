<?php
class BrandAction extends Action {
	/*
	 * 附近品牌
	 * */
    public function index() {
        $data = array();
        $this->assign($data);
        $this->display();
    }

    public function map() {
    	$data = array();
    	$this->assign($data);
    	$this->display();
    }
    
    /**
     * 晒物详情
     **/
    public function detail() {
    	$data = array();
    	$this->assign($data);
    	$this->display();
    }
    
    /**
     * 品牌详情
     **/
    public function branddetail() {
    	$data = array();
    	$this->assign($data);
    	$this->display();
    }
    
    /**
     * 门店地址
     **/
    public function stores() {
    	$data = array();
    	$this->assign($data);
    	$this->display();
    }
    
    public function comment() {

    	$data = array();
    	$this->assign($data);
    	$this->display();
    }

    public function like(){
    	$data = array();
    	$this->assign($data);
    	$this->display();
    
    }
    
    //拍照
    public function photograph(){
    	$data = array();
    	$this->assign($data);
    	$this->display();
    }

    //打标签
    public function addtag(){
    	$data = array();
    	$this->assign($data);
    	$this->display();
    }
    
    //完善信息 发布
    public function publish(){
    	$data = array();
    	$this->assign($data);
    	$this->display();
    }
    //门店地址
    public function locations(){
    	$data = array();
    	$this->assign($data);
    	$this->display();
    }
    
    
    
}

