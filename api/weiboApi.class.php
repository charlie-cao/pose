<?php

class WeiboApi extends Api {
    /*     * **
     * need since_id max_id count page
     */

    /*     * *
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
    function nearby() {
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

    //发现的默认列表
    function find() {
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

    public function one() {
        $data = array();
        $id = intval($_REQUEST['id']);
        $res = D("Weibo", "weibo")->getOneApi($id,null,$this-> mid);
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
    
    public function my() {
        $data = array();
        $result = array();
        
        $uname = getUserName($this -> mid);
        
        $result =  D('WeiboApi', 'weibo')->user_timeline($this -> mid, $uname, $this->since_id, $this->max_id, $this->count, $this->page);
        //var_dump($result);
        
        $data['result'] = $result;
        $data['numfound'] = $res['totalRows'];
        $data['lastrow'] = $res['nowPage'];
        return $data;
    }

    public function comment() {
        $data = array();
        $id = intval($this->data['id']);
        $page = intval($this->data['page']);
        $count = intval($this->data['count']);


        $res = D('WeiboApi', 'weibo')->comments($this->id, $this->since_id, $this->max_id, $this->count, $this->page);
        
        $rs = $res;
        if (!$rs) {
            $rs = array();
        }

        $data['result'] = $rs;
        $data['numfound'] = D('WeiboApi', 'weibo')->commentscount($this->id, $this->since_id, $this->max_id, $this->count, $this->page);;
        $data['lastrow'] = $this->page;
        return $data;
    }

    public function favorite() {
        $data = array();
        $id = intval($_REQUEST['id']);
        
        $count = intval($this->data['count']);
        $res = D("Favorite", "weibo")->getFavoriteListforWeibo($id, $page * $count);
        
    
        if (!$res) {
            $res = array();
        }

        $data['result'] = $res['data'];
        $data['numfound'] = $res['totalRows'];
        $data['lastrow'] = $res['nowPage'];
        return $data;
    }
    public function addfavorite() {
        $data = array();
        $weibo_id = ($_REQUEST["id"]);
        $res = D("Favorite", "weibo")->favWeibo($weibo_id, $this -> mid);
        
    
        if (!$res) {
            $res = array();
        }

        $data['result'] = array('Status' => TRUE);
        $data['numfound'] = 1;
        $data['lastrow'] = 0;
        return $data;
    }

    public function taginfo() {
        
    }
    
    public function upimg(){
        $data = array();
        if ($_FILES['pic']) {
            //执行上传操作
            $savePath = $this->_getSaveTempPath();
            $originName = $_FILES['pic']['name'];
            $filename = md5(time() . 'teste') . '.' . substr($_FILES['pic']['name'], strrpos($_FILES['pic']['name'], '.') + 1);
            if (@copy($_FILES['pic']['tmp_name'], $savePath . '/' . $filename) || @move_uploaded_file($_FILES['pic']['tmp_name'], $savePath . '/' . $filename)) {
                $result['boolen'] = 1;
                $result['type_data'] = 'temp/' . $filename;
                $result['orgin_name'] = $originName;
                $result['picurl'] = SITE_PATH . '/uploads/temp/' . $filename;
                $result['httpurl'] = (SITE_URL . '/data/uploads/temp/' . $filename);
            } else {
                $result['boolen'] = 0;
                $result['message'] = '上传失败';
            }
        } else {
            $result['boolen'] = 0;
            $result['message'] = '上传失败';
        }
        
        $data['result'] = $result;
        $data['numfound'] = 1;
        $data['lastrow'] = 0;
        return $data;
    }
    
    function uploadpic() {
        if ($_FILES['pic']) {
            //执行上传操作
            $savePath = $this->_getSaveTempPath();
            $filename = md5(time() . 'teste') . '.' . substr($_FILES['pic']['name'], strpos($_FILES['pic']['name'], '.') + 1);
            if (@copy($_FILES['pic']['tmp_name'], $savePath . '/' . $filename) || @move_uploaded_file($_FILES['pic']['tmp_name'], $savePath . '/' . $filename)) {
                $result['boolen'] = 1;
                $result['type_data'] = 'temp/' . $filename;
                $result['picurl'] = SITE_PATH . '/uploads/temp/' . $filename;
            } else {
                $result['boolen'] = 0;
                $result['message'] = '上传失败';
            }
        } else {
            $result['boolen'] = 0;
            $result['message'] = '上传失败';
        }
        return $result;
    }
    
    
    private function _getSaveTempPath() {
        $savePath = SITE_PATH . '/data/uploads/temp';
        if (!file_exists($savePath))
            mk_dir($savePath);
        return $savePath;
    }
    
    //发布一个图片微博
    public function publish() {
        $res = array();
        $uppic = $this->uploadpic();
        $pic = $uppic['boolen'] ? $uppic['type_data'] : h($this->data['pic']);
        $data['content'] = h($this->data['content']);
        $id = D('Weibo', 'weibo')->publish($this->mid, $data, $this->data['from'], 1, $pic, array('sina'));
        if($id){
            $res['result'] = array('weibo_id'=>(int)$id);
        }else{
            $res['result'] = array('weibo_id'=>0);
        }
        $res['numfound'] = 1;
        $res['lastrow'] = 0;
        return $res;
    }
    
    //删除一条微博
    function delone() {
        $res = array();
        $result = D('Operate', 'weibo')->deleteMini($this->id, $this->mid);
        $res['result'] = array('Status' => $result);
        $res['numfound'] = 1;
        $res['lastrow'] = 0;
        return $res;
    }

    //删除一条评论
    function delcomment() {
        $res = array();
        $result = D('Comment', 'weibo')->deleteComments($this->id, $this->mid);
        $res['result'] = array('Status' => $result);
        $res['numfound'] = 1;
        $res['lastrow'] = 0;
        return $res;
    }

    //对一个微博发一条评论
    function addcomment() {
        $res = array();
        $post['reply_comment_id'] = intval($this->data['reply_comment_id']);  //回复 评论的ID
        $post['weibo_id'] = intval($this->data['weibo_id']);          //回复 微博的ID
        $post['content'] = $this->data['comment_content'];          //回复内容
        $post['transpond'] = intval($this->data['transpond']);           //是否同是发布一条微博
        $post['from'] = intval($this->data['from']);             //来自哪里
        $id = D('Comment', 'weibo')->doaddcomment($this->mid, $post, true);
        $res['result'] = array('Status' => $id);
        $res['numfound'] = 1;
        $res['lastrow'] = 0;
        return $res;
    }

}
