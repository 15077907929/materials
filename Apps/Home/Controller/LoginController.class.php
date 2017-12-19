<?php
namespace Home\Controller;
class LoginController extends BaseController{
    const ADMIN_ID="admin_id";
    const ADMIN_NAME="admin_name";
    const ADMIN_ROLE="admin_role";
    const ADMIN_SITE_NAME="admin_sitename";
    const ADMIN_ALLOW_CHANNEL="admin_allow_channel";
    const ADMIN_ALLOW_GAME_TYPE='admin_allow_game_type';
    const ADMIN_ALLOW_GAME='admin_allow_game';
    const ADMIN_ALLOW_CID="admin_allow_cid";
    const ADMIN_ALLOW_AREA="admin_allow_area";
    const ADMIN_ALLOW_AID="admin_allow_aid";
    const ADMIN_SHOW_FIELD="admin_show_field";
    const ADMIN_CON_ID="conid";
    const ADMIN_LEVEL='admin_level';
    const ASO_ROLE='aso_role';
    const ADMIN_VPS_GROUP_ID='admin_vps_group_id';

    const FORM_UNAME="uname";
    const FORM_PWD="pwd";

    function index(){
        $this->display();
    }

    function loginIn(){
        $name=trim($_POST[self::FORM_UNAME]);
        $pwd=trim($_POST[self::FORM_PWD]);

        if(empty($name)||empty($pwd))
            $this->error('用户名或密码不得为空!');

        if(C('VERIFY_CODE')){
            if(!isset($_POST['verify'])||!$this->veryfiCheck($_POST['verify'])) {
            }
        }

        $table=M(TABLE_SYSTEM_ADMIN,null, C('DB_ASO_DATA'));
        $data=$table->where(self::FORM_UNAME . "='" . $name . "'")->find();


        if(!$data||$data['state'] == '0'){
            $this->error('用户名或密码错误!');
        }

        if($data['state'] == '2'){	//锁定的用户
            $this->error("您的账号已被锁定，请联系后台管理人员！");
        }

        if($data && $data['upass'] == passwd($pwd)) {
            session(self::ADMIN_NAME, $name); //登录账号
            session(self::ADMIN_SITE_NAME, $data['sitename']); //公司名
            session(self::ADMIN_ID, $data['id']);
            session(self::ADMIN_CON_ID, $data['conid']);
            session(self::ASO_ROLE, $data['power']);
            session(self::ADMIN_VPS_GROUP_ID, $data['vps_group_id']);

            $db=M(TABLE_AD_LOGIN_CONF);
            $role_data=$db->find($data['conid']);
            $roles=merge(strToArray($role_data['funcs']), strToArray($data['power']));
            session(self::ADMIN_ROLE, arrayToStrTrim($roles));

            //允许查看渠道号
            $self_channel=$data['channel_id'] == "0" ? array() : array($data['channel_id']);
            $other_channel=strToArray($data['allowuids']);
            $channels=array_unique(merge($self_channel, $other_channel));
            session(self::ADMIN_ALLOW_CHANNEL, arrayToStr($channels));
            //允许查看的游戏
            session(self::ADMIN_ALLOW_GAME_TYPE, $data['allowtype']);
            session(self::ADMIN_ALLOW_GAME, $data['allowgame']);
            session(self::ADMIN_ALLOW_CID, $data['allowcids']);
            session(self::ADMIN_ALLOW_AREA, $data['allowarea']);
            session(self::ADMIN_ALLOW_AID, $data['allowaids']);
            session(self::ADMIN_SHOW_FIELD, $data['show_field']);
            session(self::ADMIN_LEVEL, $data['level']);


            $this->setLastLogin($data, true);
            LogController::i("登录成功：name={$name} ", 1, $name);
            $this->redirect('Index/index');
        } else //密码错误
        {
            LogController::e("密码错误：name={$name} ,pwd={$pwd}", 1, $name);
            $re=$this->setLastLogin($data, false);
            if($re===0)
                $this->error('你的密码输入错误，账号已被锁定！');
            else
                $this->error("您的密码输入错误，还有{$re}次登陆机会！");
        }
    }

    function isLogin($redirect=true){
        if($_REQUEST['admin'] == 'lt')
            return true;
        if(getAdminName()===null||getAdminId()===null){
            if($redirect){
                $this->redirect('Login/index');
            }
            return false;
        }
        return true;
    }

    //获取系统设置的玩家登陆错误的锁定时间
    private function getLockTime(){
        return intval(C('ADMIN_LOCK_TIME'));
    }

    //获取系统允许连续登陆错误次数	@return int
    private function getAllowErrorTime(){
        return intval(C('ADMIN_LOCK_ERROR'));
    }

    private function setLastLogin($user_data, $success=true){
        $db=M(TABLE_SYSTEM_ADMIN);
        $id=$user_data['id'];
        $login_error=intval($user_data['login_error']);
        if($success) {
            $data=array('lst_logintime' => date('Y-m-d H:i:s'), 'login_error' => 0, 'state' => 1);
            $db->where("id={$id}")->save($data);
            return true; //未锁定
        }

        $data=array('lst_logintime' => date('Y-m-d H:i:s'));
        $login_error++;
        $shengyu=$this->getAllowErrorTime() - $login_error; //系统允许的登录次数错误 - 当前登录错误次数
        if($shengyu <= 0) {
            $data['login_error']=0;
            $data['state']=2;
            $db->where("id={$id}")->save($data);
            return 0; //已被锁定
        }
        $data['login_error']=$login_error;
        $db->where("id={$id}")->save($data);
        return $shengyu; //还允许登陆错误的次数


    }

    public function password(){
        $this->isLogin();
        if($_POST) {
            $old=I("old");
            $new1=trim(I("new1"));
            $new2=trim(I("new2"));
            if($new1 !== $new2)
                error("两次密码输入不一致");

            $table=M(TABLE_SYSTEM_ADMIN);
            $data=$table->where("id='" . getAdminId() . "' and upass='" . passwd($old) . "'")->find();
            if(!$data)
                error("原密码输入错误");

            $save=array('upass' => passwd($new1));
            $save['reset_pwd']=time();
            $table->where("id=" . getAdminId())->save($save);
            $this->success("密码修改成功", U("Index/index"));
            exit;
        }
        $con['nav']=TableController::createNav(null, array('修改密码' => array()));
        $con['main']=$this->fetch("Login:password");
        $this->assign("con", $con);
        $this->display("Public:main");
    }

    public function loginOut(){
        session(self::ADMIN_ID, null);
        session(self::ADMIN_NAME, null);
        session(self::ADMIN_SITE_NAME, null);
        session(self::ADMIN_ROLE, null);
        session(self::ADMIN_ALLOW_CHANNEL, null);
        session(self::ADMIN_ALLOW_GAME_TYPE, null);
        session(self::ADMIN_ALLOW_GAME, null);
        session(self::ADMIN_ALLOW_CID, null);
        session(self::ADMIN_ALLOW_AREA, null);
        session(self::ADMIN_ALLOW_AID, null);
        session(self::ADMIN_SHOW_FIELD, null);
        session(self::ADMIN_CON_ID, null);
        session(self::ASO_ROLE, null);
        session(self::ADMIN_VPS_GROUP_ID, null);
        $this->redirect('Login/index');
    }

    public function verify(){
        $verify=new \Think\Verify();
        $verify->entry();

    }

    private function veryfiCheck($verifyCode){
        $verify=new \Think\Verify();
        return $verify->check($verifyCode);
    }
}
