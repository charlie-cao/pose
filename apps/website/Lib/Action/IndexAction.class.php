<?php

class IndexAction extends Action {

    public function index() {


        $data = array();
        $this->assign($data);
        $this->display();
    }

    public function getWeibo() {
        $res = D("WeiboApi", "weibo")->public_timeline(0, 5);
        echo json_encode($res);
    }

}

