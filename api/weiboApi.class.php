<?php

class weiboApi extends Api {

    public function getWeiboDetail() {
        $data = array();
        $id = intval($this->data['id']);
        $res = D("Weibo", "weibo")->getOneApi(3);
        $data['res'] = $res;
        $data['numfound'] = 1;
        $data['lastrow'] = 0;
        return $data;
        //echo json_encode($res);
    }

    public function getCommentList() {
        $data = array();
        $id = intval($this->data['id']);
        $page = intval($this->data['lastRow']);

        $res = D("Comment", "weibo")->getComment($id, $page * 10);
        $rs = $res['data'];
        if(!$rs){
            $rs = array();
        }
        
        $data['res'] = $rs;
        $data['numfound'] = intval($res['totalRows']);
        $data['lastrow'] = $page +1;
        return $data;
    }

    public function getFavoriteList() {
        $data = array();
        $id = intval($this->data['id']);
        $page = intval($this->data['lastRow']);
        return $res = D("Favorite", "weibo")->getList(1, 0, 10);
    }
}
