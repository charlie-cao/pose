<?php

class hudongApi extends Api {

    /**
     * 发布一条针对某一个“微博”或“评论”的评论
     * @return int 
     */
    function comment() {
        $post['reply_comment_id'] = intval($this->data['reply_comment_id']);  //回复 评论的ID
        $post['weibo_id'] = intval($this->data['weibo_id']);          //回复 微博的ID
        $post['content'] = $this->data['comment_content'];          //回复内容
        $post['transpond'] = intval($this->data['transpond']);           //是否同是发布一条微博
        $post['from'] = intval($this->data['from']);             //来自哪里
        $id = D('Comment', 'weibo')->doaddcomment($this->mid, $post, true);
        return (int) $id;
    }
    
    
    /**
     * 获取某一个微博的全部评论
     * @return array
     */
    function getcommentlist() {
        $commentlist = array();
        $post['weibo_id'] = intval($this->data['weibo_id']);          //回复 微博的ID
        $post['page'] = intval($this->data['page']);//当前分页ID
        $post['num'] = intval($this->data['num']);//每次获取多少条记录
        $commentlist = D('Comment','weibo')->getComment($post['weibo_id'],$post['page']);
        return $commonetlist;
    }
    
    public function getWeibo() {
        return $res = D("WeiboApi", "weibo")->public_timeline(0, 5);
        //echo json_encode($res);
    }

}