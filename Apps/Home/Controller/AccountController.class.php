<?php
/**
 * 微信发送
 */
namespace Home\Controller;

use Home\Org\Html;
use Think\controller;

class AccountController extends RoleController
{
    //账号管理->账号管理
    function accountManage()
    {
        if(!hasAsoRole('AMO'))    error(ERROR_MSG);
        $method = I('method') ? I('method') : 'show';
        $html = new \Home\Org\Html();
        $db = M('system_admin');
        switch ($method) {
            case 'show':
                $tableName = 'system_admin';
                $searchArr = array(
                    '搜索' => array(
                        '用户名' => array('name' => 'uname', 'type' => 'text'),
                    )
                );
                $searchHtml = TableController::createSearch($tableName, $searchArr);
                //分页
                $wh = $this->getWhereConfig($tableName);
                $count = $db->where($wh)->count();
                $pagesize = 50;
                $parameter = TableController::getGlobalWhere($tableName) ? merge($_GET, array('where' => TableController::getGlobalWhere($tableName))) : '';
                $page = new \Home\Org\Page($count, $pagesize, $parameter);
                $data = $db->where($wh)->order('id desc')->limit($page->firstRow, $page->listRows)->select();
                $pager = $page->show();
                $this->pager = '<div class="pager">' . $pager . '</div>';
                foreach ($data as &$v) {
                    $v['id'] = $v['id'];
                    $v['uname'] = $v['uname'];
                    $v['power'] = getPowerString($v['power']);
                    $v['lst_logintime'] = $v['lst_logintime'];
                    $v['caozuo'] = $this->createOperate(array(
                        array('act' => 'edit', 'id' => $v['id']),
                        array('act' => 'del', 'id' => $v['id']),
                    ), "accountManage");
                }
                $this->assign('data', $data);
                $this->nav = array(
                    '账号管理' => array('icon' => 'icon_grid', 'selected' => 1),
                    '添加' => array('link' => '/index.php?m=Home&c=Account&a=accountManage&method=add', 'icon' => 'icon_add'),
                );
                $this->main = $searchHtml . $this->fetch('Account:accountManage');
                $this->_out();
                break;
            case 'add':
                if ($_POST) {
                    $uname = I('post.uname');
                    $power = I('post.power');
                    $upass = I('post.upass');
                    if (empty($uname) || empty($upass)) {
                        error('账号密码不能为空');
                    }
                    $arr['uname'] = $uname;
                    $arr['power'] = arrayToStr($power);
                    $arr['registertime'] = date("Y-m-d H:i:s");
                    if (!empty($upass)) {
                        $arr['upass'] = md5($upass);
                    }
                    $update = $db->add($arr);
                    if ($update) {
                        success('添加成功', U('Account/accountManage'));
                    } else {
                        error('添加失败');
                    }
                }
                $this->assign('uname', $html->createInput('text', 'uname'));
                $this->assign('upass', $html->createInput('text', 'upass'));
                $this->assign('power', getPowerCheckbox("power",null));
                $this->nav = array(
                    '账号管理' => array('link' => '/index.php?m=Home&c=Account&a=accountManage&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('Account:accountManage_add');
                $this->_out();
                break;
            case 'edit':
                if ($_POST) {
                    $power = I('post.power');
                    $upass = I('post.upass');
                    $arr['power'] = arrayToStr($power);
                    if (!empty($upass)) {
                        $arr['upass'] = passwd($upass);
                    }
                    $id = I('post.id');
                    $update = $db->where("id=$id")->save($arr);
                    if ($update) {
                        success('修改成功', U('Account/accountManage'));
                    } else {
                        error('修改失败');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $this->assign('id', $id);
                $this->assign('uname', $data['uname']);
                $this->assign('upass', $html->createInput('text', 'upass'));
                $this->assign('power', getPowerCheckbox("power",$data['power']));
                $this->nav = array(
                    '账号管理' => array('link' => '/index.php?m=Home&c=Account&a=accountManage&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Account&a=accountManage&method=add', 'icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Account:accountManage_edit');
                $this->_out();
                break;
            case 'del':
                $id = I('id');
                $db->where("id=$id")->delete() ? success('删除成功', U('Account/accountManage')) : error('删除失败');
                break;
        }
    }

    function createOperate($array, $control)
    {
        $caozuo = '';
        foreach ($array as $v) {
            if ($v['act'] == 'edit')
                $caozuo .= '<a href="' . U('Account/' . $control, array('method' => 'edit', 'id' => $v['id'])) . '"><span class="icon_edit" title="修改"></span></a> ';
            if ($v['act'] == 'del')
                $caozuo .= '<a href="' . U('Account/' . $control, array('method' => 'del', 'id' => $v['id'])) . '" onclick="javascript:return confirm(\'你确定要删除吗?\')"><span class="icon_delete" title="删除"></span></a>';
            if ($v['act'] == 'copy')
                $caozuo .= '<a href="' . U('Account/' . $control, array('method' => 'copy', 'id' => $v['id'])) . '"><span class="icon_star" title="复制"></span></a> ';
        }
        return $caozuo;
    }

    function getWhereConfig($tableName)
    {
        //解析url里的where
        $url_where = TableController::parseUrlWhere();

        //解析global里的where
        $global_where = TableController::parseUrlWhere(TableController::getGlobalWhere($tableName));
        if ($global_where) //如果是搜索的话 那么删除默认where里的where
        {
            //unset($_GET['p']);
            $url_where = array();
        }

        $wh = implode(' and ', merge($url_where, $global_where));
        $wh = !empty($wh) ? $wh : null;
        return $wh;
    }

    function delcache()
    {
        $path = "Apps/Runtime/";
        delDirAndFile($path);
        exit;
    }

    //批量更新redis
    function updateRedis() {
        $table = $_POST['table'];
        if ($table == "iphone_mst") {
            $result_arr = M('iphone_mst')->where("status != 3")->select();
            foreach ($result_arr as $val) {
                if (!empty($val['deviceid'])) {
                    getRedis()->set("google_api_iphone_info@" . $val['deviceid'], $val);
                }
            }
        } else if ($table == "agreement_mst") {
            $result_arr = M('agreement_mst')->select();
            foreach ($result_arr as $val) {
                if (!empty($val['sid'])) {
                    getRedis()->set("agreement_task_info@" . $val['sid'], $val);
                }
            }
        } else if ($table == "proxy_server_mst") {
            $result_arr = M('proxy_server_mst')->select();
            foreach ($result_arr as $val) {
                getRedis()->set("proxy_server_info@".$val['sid_part']."@".$val['sid_part_start']."@".$val['sid_part_end'], $val);
                getRedis()->set("proxy_server_info@".$val['id'], $val);
            }
            getRedis()->del('proxy_server_ip_list');
            foreach ($result_arr as $val){
                $ip_str = '';
                for ($i=$val['sid_part_start'];$i<=$val['sid_part_end'];$i++) {
                    $ip_str = $val['sid_part'] . $i;
                    getRedis()->hSet('proxy_server_ip_list', $ip_str, $val['id']);
                }
            }
        }
        echo '更新Redis成功';exit;
    }
}