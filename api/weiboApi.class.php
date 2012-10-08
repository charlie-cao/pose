<?php

class WeiboApi extends Api {
    /*     * **
     * need since_id max_id count page
     */
    
    /***
     * 获取当前位置的公共广播
     */
    function anywhere() {
        $data = array();
        $res = D('WeiboApi', 'weibo')->public_timeline($this->since_id, $this->max_id, $this->count, $this->page);

        if (!$res) {
            $res = array();
        }

        $data['result'] = $res;
        $data['numfound'] = count($res);
        $data['lastrow'] = $this->page;
        return $data;
    }
    
    //获取我附近的微博
    function nearby(){
        
    }
    
    

    public function one() {
        $data = array();
        $id = intval($this->data['id']);
        $res = D("Weibo", "weibo")->getOneApi($id);
        if (!$res) {
            $res = array();
        }
        $data['result'] = $res;
        $data['numfound'] = 1;
        $data['lastrow'] = 0;
        return $data;
        //echo json_encode($res);
    }

    public function all() {
        $data = array();
        $id = intval($this->data['id']);
        $res = D("Weibo", "weibo")->getOneApi(3);
        $data['result'] = $res;
        $data['numfound'] = 1;
        $data['lastrow'] = 0;
        return $data;
        //echo json_encode($res);
    }

    public function comment() {
        $data = array();
        $id = intval($this->data['id']);
        $page = intval($this->data['lastRow']);

        $res = D("Comment", "weibo")->getComment($id, $page * 10);
        $rs = $res['data'];
        if (!$rs) {
            $rs = array();
        }

        $data['result'] = $rs;
        $data['numfound'] = intval($res['totalRows']);
        $data['lastrow'] = $page + 1;
        return $data;
    }

    public function favorite() {
        $data = array();
        $id = intval($this->data['id']);
        $page = intval($this->data['lastRow']);
        $res = D("Favorite", "weibo")->getList(1, 0, 10);
        //$res = D("Comment", "weibo")->getComment($id, $page * 10);

        if (!$res) {
            $res = array();
        }

        $data['result'] = $res;
        $data['numfound'] = intval($res['totalRows']);
        $data['lastrow'] = $page + 1;
        return $data;
    }
    
    public function taginfo(){
        
    }

}
