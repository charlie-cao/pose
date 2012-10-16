<?php

class UserApi extends Api {

    public function setAvatar() {
        $faceurl = $_REQUEST['faceurl'];
        if ($faceurl) {
            $a = D("Avatar", "home")->saveAvatar($this->mid, $faceurl);
        } else {
            $a = FALSE;
        }
        $res['result'] = array("status" => $a);
        $res['numfound'] = 1;
        $res['lastrow'] = 1;
        return $res;
    }

    //按用户UID或昵称返回用户资料，同时也将返回用户的最新发布的微博
    function show() {

        $data = getUserInfo($this->user_id, urldecode($this->user_name), $this->mid, true);
        $res['result'] = $data;
        $res['numfound'] = 1;
        $res['lastrow'] = 1;

        return $res;
    }

    //用户关注列表
    function following() {
        $result =  D('WeiboApi', 'weibo')->following($this->user_id, $this->user_name, $this->since_id, $this->max_id, $this->count, $this->page);
        $res['result'] = $result;
        $res['numfound'] = 1;
        $res['lastrow'] = 1;

        return $res;
    }

    //用户粉丝列表
    function followers() {
        $result = D('WeiboApi', 'weibo')->followers($this->user_id, $this->user_name, $this->since_id, $this->max_id, $this->count, $this->page);
        $res['result'] = $result;
        $res['numfound'] = 1;
        $res['lastrow'] = 1;

        return $res;
    }

    function addfollowing() {
        $result = D('Follow', 'weibo')->dofollow($this->mid, $this->user_id);
        if ($result == '00' || $result == '10') {
            $result = array('is_followed' => 'unfollow');
        } else if ($result == '13') {
            $result = array('is_followed' => 'eachfollow');
        } else {
            $result = array('is_followed' => 'havefollow');
        }
        $res['result'] = $result;
        $res['numfound'] = 1;
        $res['lastrow'] = 1;

        return $res;
    }

    //取消关注
    function delfollowing() {
        $result = D('Follow', 'weibo')->unfollow($this->mid, $this->user_id);
        $result = array('is_followed' => $result ? 'unfollow' : 'havefollow');
        $res['result'] = $result;
        $res['numfound'] = 1;
        $res['lastrow'] = 1;
        return $res;
    }

    public function notificationCount() {
        if (empty($this->user_id) && isset($this->mid)) {
            return service('Notify')->getCount($this->mid);
        } else {
            return service('Notify')->getCount($this->user_id);
        }
    }

    public function unsetNotificationCount() {
        if (empty($this->user_id) && isset($this->mid)) {
            switch ($this->data['type']) { // 暂仅允许message/weibo_commnet/atMe
                case 'message':
                    return (int) model('Message')->setAllIsRead($this->mid);
                case 'weibo_comment':
                    return (int) model('UserCount')->setZero($this->mid, 'comment');
                case 'atMe':
                    return (int) model('UserCount')->setZero($this->mid, 'atme');
                default:
                    return 0;
            }
        } else {
            switch ($this->data['type']) { // 暂仅允许message/weibo_commnet/atMe
                case 'message':
                    return (int) model('Message')->setAllIsRead($this->user_id);
                case 'weibo_comment':
                    return (int) model('UserCount')->setZero($this->user_id, 'comment');
                case 'atMe':
                    return (int) model('UserCount')->setZero($this->user_id, 'atme');
                default:
                    return 0;
            }
        }
    }

    public function getNotificationList() {
        $this->data['type'] = $this->data['type'] ? $this->data['type'] : array(1, 2);
        $this->data['order'] = $this->data['order'] == 'ASC' ? '`mb`.`list_id` ASC' : '`mb`.`list_id` DESC';
        if (empty($this->user_id) && isset($this->mid)) {
            return service('Notify')->getNotifityCount($this->mid, $this->data['type'], $this->since_id, $this->max_id, $this->count, $this->page);
        } else {
            return service('Notify')->getNotifityCount($this->user_id, $this->data['type'], $this->since_id, $this->max_id, $this->count, $this->page);
        }
    }

    public function setMessageIsRead() {
        if (empty($this->user_id) && isset($this->mid)) {
            return (int) model('Message')->setMessageIsRead($this->id, $this->mid);
        } else {
            return (int) model('Message')->setMessageIsRead($this->id, $this->user_id);
        }
    }

}