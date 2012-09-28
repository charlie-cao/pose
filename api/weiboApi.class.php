<?php

class weiboApi extends Api {

    public function getWeiboDetail() {
        $id = intval($this->data['id']);
        return $res = D("Weibo", "weibo")->getOneApi(3);
        //echo json_encode($res);
    }

    public function getCommentList() {
        $id = intval($this->data['id']);
        $page = intval($this->data['lastRow']);

        $res = D("Comment", "weibo")->getComment($id, $page * 10);
        return $res;
    }
    
    public function getFavoriteList(){
        return $res = D("Favorite", "weibo")->getList(1,0,10);
    }

    ///////////
   

}
