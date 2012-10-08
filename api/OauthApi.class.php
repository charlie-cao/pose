<?php

class OauthApi extends Api {

    function access_token() {
        if ($_REQUEST['userId'] && $_REQUEST['passwd']) {
            $username = desdecrypt($_POST['userId'], '12345678');
            if (is_numeric($username)) {
                $map['uid'] = $username;
            } elseif (is_string($username)) {
                $map['email'] = h($username);
            } else {
                return;
            }
            $map['password'] = md5(desdecrypt(h($_REQUEST['passwd']), '12345678'));
            $user = M('user')->where($map)->field('uid')->find();
            $this->mid = $user['uid'];
        }
    }

    function request_key() {
        return array($this->getRequestKey());
    }

    private function getRequestKey() {
        return "thinksns";
    }

    public function isValidEmail($email) {
        if (UC_SYNC) {
            $res = uc_user_checkemail($email);
            if ($res == -4) {
                return false;
            } else {
                return true;
            }
        } else {
            return preg_match("/[_a-zA-Z\d\-\.]+@[_a-zA-Z\d\-]+(\.[_a-zA-Z\d\-]+)+$/i", $email) !== 0;
        }
    }

    //原来的方法
    function authorize() {
        
    }

    //用户注册
    function register() {


        $uid = intval($_POST['invite_uid']);
// 		// 验证码
// 		$verify_option = $this->_isVerifyOn('register');
// 				if ($verify_option && (md5(strtoupper($_POST['verify'])) != $_SESSION['verify'])){
// 				$this->error(L('error_security_code'));
// 				exit;
// 				}
// 				Addons::hook('public_before_doregister', $_POST);
// 				// 邀请码
// 				$invite_code = h($_REQUEST['invite_code']);
// 				$invite_info = null;
// 				// 是否允许注册
// 				$register_option = model('Xdata')->get('register:register_type');
// 				if ($register_option === 'closed') { // 关闭注册
// 					$this->error(L('reg_close'));
// 				} else if ($register_option === 'invite') { //邀请注册
// 					// 邀请方式
// 					$invite_option = model('Invite')->getSet();
// 					if ($invite_option['invite_set'] == 'close') { // 关闭邀请
// 						$this->error(L('reg_invite_close'));
// 					} else { // 普通邀请 OR 使用邀请码
// 						if (!$invite_code)
// 							$this->error(L('reg_invite_warming'));
// 						else if (!($invite_info = $this->__getInviteInfo($invite_code))){
// 							$this->error(L('reg_invite_code_error'));
// 						}
// 					}
// 				} else { // 公开注册
// 					if (!($invite_info = $this->__getInviteInfo($invite_code)))
// 						unset($invite_code, $invite_info);
// 				}
// 				var_dump($_REQUEST);
// 				exit;
//  		// 参数合法性检查
// 				$required_field = array(
// 						'email'		=> 'Email',
// 						'nickname'  => L('username'),
// 						'password'	=> L('password'),
// 						'repassword'=> L('retype_password'),
// 				);
// 				foreach ($required_field as $k => $v)
// 					if (empty($_POST[$k]))
// 					$this->error($v . L('not_null'));
// 				if (!$this->isValidEmail($_POST['email']))
// 					$this->error(L('email_format_error_retype'));
// 				if (!$this->isValidNickName($_POST['nickname']))
// 					$this->error(L('username_format_error'));
// 				if (strlen($_POST['password']) < 6 || strlen($_POST['password']) > 16 || $_POST['password'] != $_POST['repassword'])
// 					$this->error(L('password_rule'));
// 				if (!$this->isEmailAvailable($_POST['email']))
// 					$this->error(L('email_used_retype'));
// 				var_dump($_REQUEST);
// 				// 是否需要Email激活
// 				$need_email_activate = intval(model('Xdata')->get('register:register_email_activate'));
// 				var_dump($_REQUEST);
// 				exit;
        //$_POST = $_GET;
        // 注册
        $data['email'] = $_POST['email'];
        $data['password'] = md5($_POST['password']);
        $data['uname'] = t($_POST['nickname']);
        $data['ctime'] = time();
        //$data['is_active'] = $need_email_activate ? 0 : 1;
        $data['is_active'] = 1;
        $data['register_ip'] = get_client_ip();
        $data['login_ip'] = get_client_ip();
        if (!($uid = D('User', 'home')->add($data))) {
//					return 1;
            $msg = false;
        } else {
//					return 0;
            $msg = true;
        }
// 					$this->error(L('reg_filed_retry'));
//				Addons::hook('public_after_doregister',$uid);
// 				if($_POST['invite_code']){
// 					unset($data);
// 					$data['uid'] = intval($_POST['invite_uid']);
// 					$data['fid'] = $uid;
// 					$data['type'] = 0;
// 					M('weibo_follow')->add($data);
// 					$data1['uid'] = $uid;
// 					$data1['fid'] = intval($_POST['invite_uid']);
// 					$data1['type'] = 0;
// 					M('weibo_follow')->add($data1);
// 				}
        // 将用户添加到myop_userlog，以使漫游应用能获取到用户信息
        $user_log = array(
            'uid' => $uid,
            'action' => 'add',
            'type' => '0',
            'dateline' => time(),
        );
        M('myop_userlog')->add($user_log);
        return $msg;

        // 将邀请码设置已用
// 				model('Invite')->setInviteCodeUsed($invite_code);
// 				model('InviteRecord')->addRecord($invite_info['uid'],$uid);
        // 同步至UCenter
// 				if (UC_SYNC) {
// 					$uc_uid = uc_user_register($_POST['nickname'],$_POST['password'],$_POST['email']);
// 					//echo uc_user_synlogin($uc_uid);
// 					if ($uc_uid > 0)
// 						$data['uname']	   = t($_POST['nickname']);
// 					ts_add_ucenter_user_ref($uid,$uc_uid,$data['uname']);
// 				}
// 				if ($need_email_activate == 1) { // 邮件激活
// 					$this->activate($uid, $_POST['email'], $invite_code);
// 				} else {
// 					// 置为已登录, 供完善个人资料时使用
// 					service('Passport')->loginLocal($uid);
// 					//if (!is_numeric(stripos($_POST['HTTP_REFERER'], dirname('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']))) && $register_option != 'invite') {
// 					//注册完毕，跳回注册页之前
// 					//    redirect($_POST['HTTP_REFERER']);
// 					//} else {
// 					//注册完毕，跳转至帐号修改页
// 					redirect(U('home/Public/userinfo',array('uid'=>$uid)));
// 					//}
// 				}
    }

    /**
     * 帐户登录 返回Token
     * 
     */
    function login() {
        $data = array();
        $res = array();
        if ($_REQUEST['user'] && $_REQUEST['passwd']) {
            // 修改通过用户名和密码获得 Token
            $password = $_REQUEST['passwd'];
            $identifier = $_REQUEST['user'];
            if (empty($identifier))
                return false;
            if ($this->isValidEmail($identifier)) {
                $identifier_type = 'email';
            } elseif (is_numeric($identifier) && is_int($identifier)) {
                $identifier_type = 'uid';
            } else {
                $identifier_type = 'uname';
            }
            $user = D('User', 'home')->getUserByIdentifier($identifier, $identifier_type);

            $map['uid'] = $user['uid'];
            $map['password'] = md5($_REQUEST['passwd']);

            $user = M('user')->where($map)->field('uid')->find();
            if ($user) {
                if ($login = M('login')->where("uid=" . $user['uid'] . " AND type='location'")->find()) {
                    $res['oauth_token'] = $login['oauth_token'];
                    $res['oauth_token_secret'] = $login['oauth_token_secret'];
                    $res['uid'] = $user['uid'];
                } else {
                    $res['oauth_token'] = getOAuthToken($user['uid']);
                    $res['oauth_token_secret'] = getOAuthTokenSecret();
                    $res['uid'] = $user['uid'];
                    $savedata['type'] = 'location';
                    $savedata = array_merge($savedata, $res);
                    M('login')->add($savedata);
                }

                if (!$res) {
                    $res = array();
                }

                $data['result'] = $res;
                $data['numfound'] = 1;
                $data['lastrow'] = 0;
                return $data;
            } else {
                $res['status'] = "failed";
                $res['message'] = "Can not verify login info";
                if (!$res) {
                    $res = array();
                }
                

                $data['result'] = $res;
                $data['numfound'] = 0;
                $data['lastrow'] = 0;

                return $data;
                $this->verifyError();
            }
        } else {
            if (!$res) {
                $res = array();
            }

            $data['result'] = $res;
            $data['numfound'] = 0;
            $data['lastrow'] = 0;

            return $data;
            $this->verifyError();
        }
        if (!$res) {
            $res = array();
        }

        $data['result'] = $res;
        $data['numfound'] = 0;
        $data['lastrow'] = 0;

        return $data;
    }

    /**
     * 帐号注销
     * */
    function logout() {
        $data = array();
        $res = array();
        $user['uid'] = $_REQUEST['uid'];
        $logout = M('login')->where("uid=" . $user['uid'] . " AND type='location'")->delete();
        return $logout;
    }

    /**
     * 找回密码
     * 通过邮件返回用户密码
     */
    function findpassword() {
        $email = intval($_POST['email']);
        
    }
    
    function invite(){
        
    }

}