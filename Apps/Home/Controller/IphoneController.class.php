<?php
/**
 * Iphone管理
 */
namespace Home\Controller;

use Home\Org\Html;
use Think\controller;

class IphoneController extends RoleController
{
//    static $filepath = '/opt/data/www/asomanager/Uploads/update/';
    static $filepath = '/data/www/googlemanager/Uploads/update/';


    function googleMobileList(){
        if (!hasAsoRole('PDCL')) error(ERROR_MSG);
        $method = I('get.method') ? I('get.method') : 'show';
        $html = new \Home\Org\Html();
        $db = M('iphone_mst');
        $model_data = M("iphone_model")->select();
        foreach ($model_data as $val) {
            $model_list[$val['name']] = $val['mid'];
        }
        $model_list1 = array_flip($model_list);
        $iphone_tag_list1 = getIphoneTagList(2);
        $version_type = array_flip(C('IPHONEVERSIONTYPE'));

        //TODO 获取动态包分类列表
        $dynamic_class_list = M('dynamic_type_mst')->order('type_score DESC')->getField('type_name,type_key');
        $this->assign('dynamic_class_list', $dynamic_class_list);

        switch ($method) {
            case 'show':
                $iphone_sid_one = "";
                $iphone_sid_list = getIphoneSidList();
                foreach ($iphone_sid_list as $val) {
                    if (!empty($val)) {
                        $iphone_sid_one = $val;
                        break;
                    }
                }
                $search_id = I("post.search_id") ? I("post.search_id") : "";
                $search_systemversion = I("post.search_systemversion") ? I("post.search_systemversion") : "";
                $search_iphone_tag = I("post.search_iphone_tag") ? I("post.search_iphone_tag") : "";

                $search_version = $_POST['search_version'];
                $search_tag = $iphone_sid_one;
                if (isset($_POST['search_tag'])) {
                    if ($_POST['search_tag'] == "") {
                        $search_tag = "";
                        $iphone_sid_one = "";
                    } else {
                        $search_tag = $_POST['search_tag'];
                        $iphone_sid_one = $_POST['search_tag'];
                    }
                }
                $wh = "status != 3";
                if (!empty($search_id)) {
                    $wh .= " and sid like '%{$search_id}%'";
                }
                if (!empty($search_systemversion)) {
                    $wh .= " and systemversion = '{$search_systemversion}'";
                }
                if ($search_version != "") {
                    $wh .= " and lua_version = '{$search_version}'";
                }
                if (!empty($search_tag)) {
                    $wh .= " and sid like '%{$search_tag}%'";
                }
                if (!empty($search_iphone_tag)){
                    $wh .= " AND tag = '{$search_iphone_tag}' ";
                }
                $data = $db->where($wh)->order('id desc')->select();
                $count = $db->where($wh)->count();
                $total_count = array();
                foreach ($data as &$v) {
                    $heartbeat_redis = getRedis()->get("aso_iphone_heartbeat_time@" . $v['deviceid']);
                    if (empty($heartbeat_redis)) {
                        $heartbeat_redis = getRedis()->get("aso_iphone_heartbeat_time@" . $v['sid']);
                    }
                    if (empty($heartbeat_redis)) {
                        $heartbeat_redis = getRedis()->get("aso_iphone_heartbeat_time@" . $v['id']);
                    }
                    $v['exception'] = '';
                    if (!empty($heartbeat_redis)) {
                        if (time() - strtotime($heartbeat_redis) > 600) {
                            $v['exception'] = 'exception';
                            $total_count['heartbeat_over'] += 1;
                            $v['heartbeat'] = $heartbeat_redis;
                        } else {
                            $total_count['heartbeat'] += 1;
                            $v['heartbeat'] = "<span style='color:red'>" . $heartbeat_redis . "</span>";
                        }
                    }
                    if ($v['status'] == 1) {
                        $total_count['iphone_open'] += 1;
                    }
                    $v['net_type'] = $model_list1[$v['net_type']];  //是否启用
                    $v['tag'] = $iphone_tag_list1[$v['tag']];       //tag
                    $v['version_type'] = $version_type[$v['version_type']];  //版本类型
                    $dynamic_class_info = getRedis()->get("google_phone_dynamic@{$v['deviceid']}");
                    if($dynamic_class_info){
                        foreach ($dynamic_class_info as $key => $val){
                            $v[$key] = $val;
                        }
                    }

                }
                $this->assign('data', $data);
                $this->assign('count', $count);
                $this->assign('total_count', $total_count);
                if (!hasAsoRole('IPHONEO')) {
                    $this->nav = array(
                        'Iphone列表' => array('icon' => 'icon_grid', 'selected' => 1),
                    );
                } else {
                    $this->nav = array(
                        'Iphone列表' => array('icon' => 'icon_grid', 'selected' => 1),
                        '添加' => array('link' => '/index.php?m=Home&c=Iphone&a=iphoneList&method=add', 'icon' => 'icon_add'),
                    );
                }
                $this->assign("search_id", $html->createInput("text", "search_id", $search_id));
                $this->assign("search_systemversion", $html->createInput("text", "search_systemversion", $search_systemversion));
                $this->assign('search_iphone_tag', $html->createInput('select', 'search_iphone_tag', $search_iphone_tag, getIphoneTagList()));//批量修改tag
                $this->assign("search_version", $html->createInput("text", "search_version", $search_version));
                $this->assign("search_tag", $html->createInput("select", "search_tag", $iphone_sid_one, getIphoneSidList()));
                $this->assign("url", U('Iphone/googleMobileList', array("method" => "show")));
                $this->main = $this->fetch('Iphone:googleMobileList');
                $this->_out();
                break;
        }
    }

    //Iphone管理->Iphone管理
    function iphoneList()
    {
//        file_put_contents('/data/log/asoapi/iphone.log',"开始".date('Y-m-d H:i:s')."\n\n",FILE_APPEND);
        if (!hasAsoRole('IPHONES,IPHONEO')) error(ERROR_MSG);
        $method = I('get.method') ? I('get.method') : 'show';
        $html = new \Home\Org\Html();
        $db = M('iphone_mst');
        $model_data = M("iphone_model")->select();
        foreach ($model_data as $val) {
            $model_list[$val['name']] = $val['mid'];
        }
        $model_list1 = array_flip($model_list);
        $iphone_tag_list1 = getIphoneTagList(2);
        $version_type = array_flip(C('IPHONEVERSIONTYPE'));
        switch ($method) {
            case 'show':
                $iphone_sid_one = "";
                $iphone_sid_list = getIphoneSidList();
                foreach ($iphone_sid_list as $val) {
                    if (!empty($val)) {
                        $iphone_sid_one = $val;
                        break;
                    }
                }
                $search_id = I("post.search_id") ? I("post.search_id") : "";
                $search_systemversion = I("post.search_systemversion") ? I("post.search_systemversion") : "";
                $search_iphone_tag = I("post.search_iphone_tag") ? I("post.search_iphone_tag") : "";

                $search_version = $_POST['search_version'];
                $search_tag = $iphone_sid_one;
                if (isset($_POST['search_tag'])) {
                    if ($_POST['search_tag'] == "") {
                        $search_tag = "";
                        $iphone_sid_one = "";
                    } else {
                        $search_tag = $_POST['search_tag'];
                        $iphone_sid_one = $_POST['search_tag'];
                    }
                }
                $wh = "status != 3";
                if (!empty($search_id)) {
                    $wh .= " and sid like '%{$search_id}%'";
                }
                if (!empty($search_systemversion)) {
                    $wh .= " and systemversion = '{$search_systemversion}'";
                }
                if ($search_version != "") {
                    $wh .= " and lua_version = '{$search_version}'";
                }
                if (!empty($search_tag)) {
                    $wh .= " and sid like '%{$search_tag}%'";
                }
                if (!empty($search_iphone_tag)){
                    $wh .= " AND tag = '{$search_iphone_tag}' ";
                }
                $data = $db->where($wh)->order('id desc')->select();
                $count = $db->where($wh)->count();
                $total_count = array();
                foreach ($data as &$v) {
                    $v['selectid'] = '<input name="id[]" type="checkbox" value="' . $v['id'] . '"/>';
                    $redis = getRedis()->get("aso_dynamic_sid_map_vpn@" . $v['id']);
                    $heartbeat_redis = getRedis()->get("aso_iphone_heartbeat_time@" . $v['deviceid']);
                    if (empty($heartbeat_redis)) {
                        $heartbeat_redis = getRedis()->get("aso_iphone_heartbeat_time@" . $v['sid']);
                    }
                    if (empty($heartbeat_redis)) {
                        $heartbeat_redis = getRedis()->get("aso_iphone_heartbeat_time@" . $v['id']);
                    }
                    $v['exception'] = '';
                    if (!empty($heartbeat_redis)) {
                        if (time() - strtotime($heartbeat_redis) > 600) {
                            $v['exception'] = 'exception';
                            $total_count['heartbeat_over'] += 1;
                            $v['heartbeat'] = $heartbeat_redis;
                        } else {
                            $total_count['heartbeat'] += 1;
                            $v['heartbeat'] = "<span style='color:red'>" . $heartbeat_redis . "</span>";
                        }
                    }
                    if (!empty($redis)) {
                        $v['vpn_ip'] = $redis['id'] . "/" . $redis['ip'];
                        if ($redis['status'] == 1) {
                            $v['vpn_status'] = "<span style='color:blue'>已分配</span>";
                            $total_count['distribution1'] += 1;
                        } else if ($redis['status'] == 2) {
                            $v['vpn_status'] = "<span style='color:green'>分配成功</span>";
                            $total_count['distribution2'] += 1;
                        } else if ($redis['status'] == 3) {
                            $v['vpn_status'] = "<span style='color:red'>分配失败</span>";
                            $total_count['distribution3'] += 1;
                        } else if ($redis['status'] == 4) {
                            $v['vpn_status'] = "<span style='color:red'>IP切换失败</span>";
                            $total_count['distribution4'] += 1;
                        } else {
                            $v['vpn_status'] = "";
                        }
                        $v['vpn_time'] = $redis['time'];
                    }
                    if ($v['status'] == 1) {
                        $total_count['iphone_open'] += 1;
                    }
                    $v['net_type'] = $model_list1[$v['net_type']];  //是否启用
                    $v['tag'] = $iphone_tag_list1[$v['tag']];  //tag
                    $old_version_type = $v['version_type'];
                    $v['version_type'] = $version_type[$v['version_type']];  //版本类型
                    if (!hasAsoRole('IPHONEO')) {
                        $v['hosts_can_update'] = parseYn($v['hosts_can_update']);  //是否启用
                        $v['lua_can_update'] = parseYn($v['lua_can_update']);  //是否启用
                        $v['apk_can_update'] = parseYn($v['apk_can_update']);  //是否启用
                        $v['down_apk_can_update'] = parseYn($v['down_apk_can_update']);  //是否启用
                        $v['status'] = parseYn($v['status']);  //是否启用
                        $v['is_position'] = parseYn($v['is_position']);  //是否定位
                        $v['is_fast'] = parseYn($v['is_fast']);  //是否快速输入
                        $v['caozuo'] = "";
                    } else {
                        if ($old_version_type == 1) {
                            $new_host_version = getRedis()->get('iphone_hosts_version');
                            $new_lua_version = getRedis()->get('iphone_lua_version');
                            $new_apk_version = getRedis()->get('iphone_apk_version');
                            $new_down_apk_version = getRedis()->get('iphone_down_apk_version');
                        } else if ($old_version_type == 2) {
                            $new_host_version = getRedis()->get('iphone_hosts_version_business');
                            $new_lua_version = getRedis()->get('iphone_lua_version_business');
                            $new_apk_version = getRedis()->get('iphone_apk_version_business');
                            $new_down_apk_version = getRedis()->get('iphone_down_apk_version_business');
                        }
                        if ($new_host_version == $v['hosts_version']) {
                            $v['hosts_can_update'] = parseYn($v['hosts_can_update']);  //是否启用
                        } else {
                            $v['hosts_can_update'] = $this->creatAjaxRadio2("iphone_mst", "hosts_can_update", $v['id'], $v['hosts_can_update']);
                        }
                        if ($new_lua_version == $v['lua_version']) {
                            $v['lua_can_update'] = parseYn($v['lua_can_update']);  //是否启用
                        } else {
                            $v['lua_can_update'] = $this->creatAjaxRadio2("iphone_mst", "lua_can_update", $v['id'], $v['lua_can_update']);
                        }
                        if ($new_apk_version == $v['apk_version']) {
                            $v['apk_can_update'] = parseYn($v['apk_can_update']);  //是否启用
                        } else {
                            $v['apk_can_update'] = $this->creatAjaxRadio2("iphone_mst", "apk_can_update", $v['id'], $v['apk_can_update']);
                        }
                        if ($new_down_apk_version == $v['down_apk_version']) {
                            $v['down_apk_can_update'] = parseYn($v['down_apk_can_update']);  //是否启用
                        } else {
                            $v['down_apk_can_update'] = $this->creatAjaxRadio2("iphone_mst", "down_apk_can_update", $v['id'], $v['down_apk_can_update']);
                        }
                        $v['status'] = $this->creatAjaxRadio2("iphone_mst", "status", $v['id'], $v['status']);
                        $v['is_fast'] = $this->creatAjaxRadio2("iphone_mst", "is_fast", $v['id'], $v['is_fast']);

                        $v['is_position'] = $this->creatAjaxRadio2("iphone_mst", "is_position", $v['id'], $v['is_position']);
                        $v['caozuo'] = $this->createOperate(array(
                            array('act' => 'edit', 'id' => $v['id']),
                            array('act' => 'del', 'id' => $v['id']),
                        ), "iphoneList");
                    }
                }
                $this->assign('data', $data);
                $this->assign('count', $count);
                $this->assign('total_count', $total_count);
                $this->assign('group_tag', $html->createInput('select', 'group_tag',null,getIphoneTagList()));//批量修改tag
                $this->assign('group_version_type', $html->createInput('select', 'group_version_type',null,C('IPHONEVERSIONTYPE')));//批量修改版本类型
                $this->assign('group_port', $html->createInput('text', 'group_port', '不修改'));//批量修改端口
                $this->assign('group_status', $html->createInput('radio', 'group_status', 'keep', array('不修改' => 'keep', '否' => 'no', '是' => 'yes')));//批量修改自更新
                $this->assign('group_is_fast', $html->createInput('radio', 'group_is_fast', 'keep', array('不修改' => 'keep', '否' => 'no', '是' => 'yes')));//批量修改自更新
                $this->assign('group_hosts_can_update', $html->createInput('radio', 'group_hosts_can_update', 'keep', array('不修改' => 'keep', '否' => 'no', '是' => 'yes')));//批量修改自更新
                $this->assign('group_lua_can_update', $html->createInput('radio', 'group_lua_can_update', 'keep', array('不修改' => 'keep', '否' => 'no', '是' => 'yes')));//批量修改自更新
                $this->assign('group_apk_can_update', $html->createInput('radio', 'group_apk_can_update', 'keep', array('不修改' => 'keep', '否' => 'no', '是' => 'yes')));//批量修改自更新
                $this->assign('group_down_apk_can_update', $html->createInput('radio', 'group_down_apk_can_update', 'keep', array('不修改' => 'keep', '否' => 'no', '是' => 'yes')));//批量修改自更新
                $this->assign('group_net_type', $html->createInput('select', 'group_net_type', null, $model_list));//批量修改自更新
                $this->assign('group_del', $html->createInput('radio', 'group_del', 'no', array('是' => 'yes', '否' => 'no')));//批量删除
                if (!hasAsoRole('IPHONEO')) {
                    $this->nav = array(
                        'Iphone列表' => array('icon' => 'icon_grid', 'selected' => 1),
                    );
                } else {
                    $this->nav = array(
                        'Iphone列表' => array('icon' => 'icon_grid', 'selected' => 1),
                        '添加' => array('link' => '/index.php?m=Home&c=Iphone&a=iphoneList&method=add', 'icon' => 'icon_add'),
                    );
                }
                $this->assign("search_id", $html->createInput("text", "search_id", $search_id));
                $this->assign("search_systemversion", $html->createInput("text", "search_systemversion", $search_systemversion));
                $this->assign('search_iphone_tag', $html->createInput('select', 'search_iphone_tag', $search_iphone_tag, getIphoneTagList()));//批量修改tag
                $this->assign("search_version", $html->createInput("text", "search_version", $search_version));
                $this->assign("search_tag", $html->createInput("select", "search_tag", $iphone_sid_one, getIphoneSidList()));
                $this->assign("url", U('Iphone/iphoneList', array("method" => "show")));
                $this->main = $this->fetch('Iphone:iphoneList');
                $this->_out();
                break;
            case 'add':
                if (!hasAsoRole('IPHONEO')) error(ERROR_MSG);
                if ($_POST) {
                    $arr['deviceid'] = trim($_POST['deviceid']);
                    $arr['model'] = trim($_POST['model']);
                    $arr['ip'] = trim($_POST['ip']);
                    $arr['vpnid'] = trim($_POST['vpnid']);
                    $arr['version_type'] = trim($_POST['version_type']);
                    $arr['systemversion'] = trim($_POST['systemversion']);
                    $arr['hosts_version'] = trim($_POST['hosts_version']);
                    $arr['lua_version'] = trim($_POST['lua_version']);
                    $arr['apk_version'] = trim($_POST['apk_version']);
                    $arr['down_apk_version'] = trim($_POST['down_apk_version']);
                    $arr['net_type'] = $_POST['net_type'];
                    $arr['tag'] = trim($_POST['tag']);
                    $arr['remark'] = trim($_POST['remark']);
                    $arr['port'] = trim($_POST['port']);
                    $arr['addtime'] = date('Y-m-d H:i:s');
                    $update = $db->add($arr);
                    if ($update) {
                        $data = $db->where("id=$update")->find();
                        getRedis()->set("google_api_iphone_info@" . $data['deviceid'], $data);
                        success('添加成功', U('Iphone/iphoneList'));
                    } else {
                        error('添加失败');
                    }
                }
                $this->assign('deviceid', $html->createInput('text', 'deviceid'));
                $this->assign('model', $html->createInput('text', 'model'));
                $this->assign('ip', $html->createInput('text', 'ip'));
                $this->assign('vpnid', $html->createInput('text', 'vpnid'));
                $this->assign('systemversion', $html->createInput('text', 'systemversion'));
                $this->assign('hosts_version', $html->createInput('text', 'hosts_version'));
                $this->assign('lua_version', $html->createInput('text', 'lua_version'));
                $this->assign('apk_version', $html->createInput('text', 'apk_version'));
                $this->assign('down_apk_version', $html->createInput('text', 'down_apk_version'));
                $this->assign('net_type', $html->createInput('selected', 'net_type', null, $model_list));
                $this->assign('version_type', $html->createInput('select', 'version_type',null,C('IPHONEVERSIONTYPE')));
                $this->assign('tag', $html->createInput('select', 'tag',null,getIphoneTagList()));
                $this->assign('remark', $html->createInput('textarea', 'remark'));
                $this->assign('port', $html->createInput('text', 'port'));
                $this->nav = array(
                    'Iphone列表' => array('link' => '/index.php?m=Home&c=Iphone&a=iphoneList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('Iphone:iphoneList_add');
                $this->_out();
                break;
            case 'edit':
                if (!hasAsoRole('IPHONEO')) error(ERROR_MSG);
                if ($_POST) {
                    $arr['deviceid'] = trim($_POST['deviceid']);
                    $arr['model'] = trim($_POST['model']);
                    $arr['ip'] = trim($_POST['ip']);
                    $arr['vpnid'] = trim($_POST['vpnid']);
                    $arr['version_type'] = trim($_POST['version_type']);
                    $arr['systemversion'] = trim($_POST['systemversion']);
                    $arr['hosts_version'] = trim($_POST['hosts_version']);
                    $arr['lua_version'] = trim($_POST['lua_version']);
                    $arr['apk_version'] = trim($_POST['apk_version']);
                    $arr['down_apk_version'] = trim($_POST['down_apk_version']);
                    $arr['net_type'] = $_POST['net_type'];
                    $arr['tag'] = trim($_POST['tag']);
                    $arr['remark'] = trim($_POST['remark']);
                    $arr['port'] = trim($_POST['port']);
                    $id = I('post.id');
                    $update = $db->where("id=$id")->save($arr);
                    if ($update) {
                        $data = $db->where("id=$id")->find();
                        getRedis()->set("google_api_iphone_info@" . $data['deviceid'], $data);
                        success('修改成功', U('Iphone/iphoneList'));
                    } else {
                        error('修改失败');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $this->assign('id', $id);
                $this->assign('deviceid', $html->createInput('text', 'deviceid', $data['deviceid']));
                $this->assign('model', $html->createInput('text', 'model', $data['model']));
                $this->assign('ip', $html->createInput('text', 'ip', $data['ip']));
                $this->assign('vpnid', $html->createInput('text', 'vpnid', $data['vpnid']));
                $this->assign('systemversion', $html->createInput('text', 'systemversion', $data['systemversion']));
                $this->assign('hosts_version', $html->createInput('text', 'hosts_version', $data['hosts_version']));
                $this->assign('lua_version', $html->createInput('text', 'lua_version', $data['lua_version']));
                $this->assign('apk_version', $html->createInput('text', 'apk_version', $data['apk_version']));
                $this->assign('down_apk_version', $html->createInput('text', 'down_apk_version', $data['down_apk_version']));
                $this->assign('version_type', $html->createInput('select', 'version_type',$data['version_type'],C('IPHONEVERSIONTYPE')));
                $this->assign('tag', $html->createInput('select', 'tag',$data['tag'],getIphoneTagList()));
                $this->assign('remark', $html->createInput('textarea', 'remark', $data['remark']));
                $this->assign('port', $html->createInput('text', 'port', $data['port']));
                $this->assign('net_type', $html->createInput('selected', 'net_type', $data['net_type'], $model_list));
                $this->nav = array(
                    'Iphone列表' => array('link' => '/index.php?m=Home&c=Iphone&a=iphoneList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Iphone&a=iphoneList&method=add', 'icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Iphone:iphoneList_edit');
                $this->_out();
                break;
            case 'del':
                if (!hasAsoRole('IPHONEO')) error(ERROR_MSG);
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $update = $db->where("id=$id")->delete();
                if ($update) {
                    getRedis()->del("google_api_iphone_info@" . $data['deviceid']);
                    success('删除成功', U('Iphone/iphoneList'));
                } else {
                    error('删除失败');
                }
                break;
            case 'groupDel':
                if (!hasAsoRole('IPHONEO')) error(ERROR_MSG);
                $ids = I('ids');
                $phoneList = $db->where("id IN (" . $ids . ")")->field('id,deviceid')->select();
                $delRs = $db->where("id IN (" . $ids . ")")->delete();
                if($delRs){
                    foreach ($phoneList as $val){
                        getRedis()->del("google_api_iphone_info@" . $val['deviceid']);
                    }
                    echo '删除成功';
                }else{
                    echo '删除失败';
                }
                break;
            case 'group':
                if (!hasAsoRole('IPHONEO')) error(ERROR_MSG);
                //批量操作
                $idArr = $_POST['id'];
                $group_status = $_POST['group_status'];
                $group_is_fast = $_POST['group_is_fast'];
                $group_tag = trim($_POST['group_tag']);
                $group_version_type = trim($_POST['group_version_type']);
                $group_port = trim($_POST['group_port']);
                $group_hosts_can_update = $_POST['group_hosts_can_update'];
                $group_lua_can_update = $_POST['group_lua_can_update'];
                $group_apk_can_update = $_POST['group_apk_can_update'];
                $group_down_apk_can_update = $_POST['group_down_apk_can_update'];
                $group_net_type = $_POST['group_net_type'];
                $group_del = $_POST['group_del'];
                $datas = M('iphone_mst')->query("select * from iphone_mst where id in ({$idArr})");
                if ($group_del == "yes") {
                    M('iphone_mst')->query("delete from iphone_mst where id in ({$idArr})");
                    foreach ($datas as $val) {
                        if (!empty($val['deviceid'])) {
                            getRedis()->del("google_api_iphone_info@" . $val['deviceid']);
                        }
                    }
                    echo '删除成功';
                    exit;
                } else {
                    if ($group_status == 'yes') {
                        $arr['status'] = 1;
                    } else if ($group_status == 'no') {
                        $arr['status'] = 0;
                    }
                    if ($group_is_fast == 'yes') {
                        $arr['is_fast'] = 1;
                    } else if ($group_is_fast == 'no') {
                        $arr['is_fast'] = 0;
                    }
                    if ($group_hosts_can_update == 'yes') {
                        $arr['hosts_can_update'] = 1;
                    } else if ($group_hosts_can_update == 'no') {
                        $arr['hosts_can_update'] = 0;
                    }
                    if ($group_lua_can_update == 'yes') {
                        $arr['lua_can_update'] = 1;
                    } else if ($group_lua_can_update == 'no') {
                        $arr['lua_can_update'] = 0;
                    }
                    if ($group_apk_can_update == 'yes') {
                        $arr['apk_can_update'] = 1;
                    } else if ($group_apk_can_update == 'no') {
                        $arr['apk_can_update'] = 0;
                    }
                    if ($group_down_apk_can_update == 'yes') {
                        $arr['down_apk_can_update'] = 1;
                    } else if ($group_down_apk_can_update == 'no') {
                        $arr['down_apk_can_update'] = 0;
                    }
                    if ($group_net_type != '') {
                        $arr['net_type'] = $group_net_type;
                    }
                    if ($group_tag != "") {
                        $arr['tag'] = $group_tag;
                    }
                    if ($group_version_type != "") {
                        $arr['version_type'] = $group_version_type;
                    }
                    if ($group_port != "不修改") {
                        $arr['port'] = $group_port;
                    }
                    $where_vps['_string'] = 'id in (' . $idArr . ')';
                    $list = M('iphone_mst')->where($where_vps)->save($arr);
                    foreach ($datas as $val) {
                        if ($group_status == 'yes') {
                            $val['status'] = 1;
                        } else if ($group_status == 'no') {
                            $val['status'] = 0;
                        }
                        if ($group_hosts_can_update == 'yes') {
                            $val['hosts_can_update'] = 1;
                        } else if ($group_hosts_can_update == 'no') {
                            $val['hosts_can_update'] = 0;
                        }
                        if ($group_lua_can_update == 'yes') {
                            $val['lua_can_update'] = 1;
                        } else if ($group_lua_can_update == 'no') {
                            $val['lua_can_update'] = 0;
                        }
                        if ($group_apk_can_update == 'yes') {
                            $val['apk_can_update'] = 1;
                        } else if ($group_apk_can_update == 'no') {
                            $val['apk_can_update'] = 0;
                        }
                        if ($group_down_apk_can_update == 'yes') {
                            $val['down_apk_can_update'] = 1;
                        } else if ($group_down_apk_can_update == 'no') {
                            $val['down_apk_can_update'] = 0;
                        }
                        if ($group_net_type != '') {
                            $arr['net_type'] = $group_net_type;
                        }
                        if ($group_tag != "") {
                            $val['tag'] = $group_tag;
                        }
                        if ($group_version_type != "") {
                            $val['version_type'] = $group_version_type;
                        }
                        if ($group_port != "不修改") {
                            $val['port'] = $group_port;
                        }
                        if (!empty($val['deviceid'])) {
                            getRedis()->set("google_api_iphone_info@" . $val['deviceid'], $val);
                        }
                    }
                    if ($list) {
                        echo '修改成功';
                        exit;
                    }
                }
                exit;
        }
    }

    //Iphone管理->手机模式管理
    function iphoneModelList() {
        if (!hasAsoRole('IMO')) error(ERROR_MSG);
        $method = I('method') ? I('method') : 'show';
        $html = new \Home\Org\Html();
        $db = M('iphone_model');
        $redis_key = "google_iphone_model_list";
        switch ($method) {
            case 'show':
                $data = $db->order('mid desc')->select();
                foreach ($data as &$v) {
                    $v['caozuo'] = $this->createOperate(array(
                        array('act' => 'edit', 'id' => $v['id']),
                        array('act' => 'del', 'id' => $v['id']),
                    ), "iphoneModelList");
                }
                $this->assign('data', $data);
                $this->nav = array(
                    '手机模式列表' => array('icon' => 'icon_grid', 'selected' => 1),
                    '添加' => array('link' => '/index.php?m=Home&c=Iphone&a=iphoneModelList&method=add', 'icon' => 'icon_add'),
                );
                $this->main = $this->fetch('Iphone:iphoneModelList');
                $this->_out();
                break;
            case 'add':
                if (!hasAsoRole('IMO')) error(ERROR_MSG);
                if ($_POST) {
                    $arr['mid'] = trim($_POST['mid']);
                    $arr['name'] = trim($_POST['name']);
                    $update = $db->add($arr);
                    if ($update) {
                        $datas = $db->order("mid asc")->select();
                        foreach ($datas as $val) {
                            $model_list[$val['mid']] = $val['name'];
                        }
                        getRedis()->set($redis_key,$model_list);
                        success('添加成功', U('Iphone/iphoneModelList'));
                    } else {
                        error('添加失败');
                    }
                }
                $this->assign('mid', $html->createInput('text', 'mid'));
                $this->assign('name', $html->createInput('text', 'name'));
                $this->nav = array(
                    '手机模式列表' => array('link' => '/index.php?m=Home&c=Iphone&a=iphoneModelList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('Iphone:iphoneModelList_add');
                $this->_out();
                break;
            case 'edit':
                if (!hasAsoRole('IMO')) error(ERROR_MSG);
                if ($_POST) {
                    $arr['mid'] = trim($_POST['mid']);
                    $arr['name'] = trim($_POST['name']);
                    $id = I('post.id');
                    $update = $db->where("id=$id")->save($arr);
                    if ($update) {
                        $datas = $db->order("mid asc")->select();
                        foreach ($datas as $val) {
                            $model_list[$val['mid']] = $val['name'];
                        }
                        getRedis()->set($redis_key,$model_list);
                        success('修改成功', U('Iphone/iphoneModelList'));
                    } else {
                        error('修改失败');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $this->assign('id', $id);
                $this->assign('mid', $html->createInput('text', 'mid', $data['mid']));
                $this->assign('name', $html->createInput('text', 'name', $data['name']));
                $this->nav = array(
                    '手机模式列表' => array('link' => '/index.php?m=Home&c=Iphone&a=iphoneModelList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Iphone&a=iphoneModelList&method=add', 'icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Iphone:iphoneModelList_edit');
                $this->_out();
                break;
            case 'del':
                if (!hasAsoRole('IMO')) error(ERROR_MSG);
                $id = I('id');
                $update = $db->where("id=$id")->delete();
                if ($update) {
                    $datas = $db->order("mid asc")->select();
                    foreach ($datas as $val) {
                        $model_list[$val['mid']] = $val['name'];
                    }
                    getRedis()->set($redis_key,$model_list);
                    if (empty($datas)) {
                        getRedis()->del($redis_key);
                    }
                    success('删除成功', U('Iphone/iphoneModelList'));
                } else {
                    error('删除失败');
                }
                break;
        }
    }

    function createOperate($array, $control)
    {
        $caozuo = '';
        foreach ($array as $v) {
            if ($v['act'] == 'edit')
                $caozuo .= '<a href="' . U('Iphone/' . $control, array('method' => 'edit', 'id' => $v['id'])) . '"><span class="icon_edit" title="修改"></span></a> ';
            if ($v['act'] == 'del')
                $caozuo .= '<a href="' . U('Iphone/' . $control, array('method' => 'del', 'id' => $v['id'])) . '" onclick="javascript:return confirm(\'你确定要删除id为' . $v['id'] . '的数据吗?\')"><span class="icon_delete" title="删除"></span></a>';
            if ($v['act'] == 'copy')
                $caozuo .= '<a href="' . U('Iphone/' . $control, array('method' => 'copy', 'id' => $v['id'])) . '"><span class="icon_star" title="复制"></span></a> ';
        }
        return $caozuo;
    }

    function creatAjaxRadio2($table, $field, $id, $value, $array = array())
    {
        if (!empty($array)) {
            if ($value == current($array)) {
                $class0 = "ajax ajax_sel";
                $class1 = "ajax";
            } else{
                $class0 = "ajax";
                $class1 = "ajax ajax_sel";
            }
            $arr = array_flip($array);
            $n = 1;
            $str = "";
            foreach ($arr as $key => $val) {
                if ($n == 1) {
                    $str .= "<span class=\"{$class0}\" ajax=\"/index.php?m=Home&c=Ajax&a=index&table={$table}&key={$field}&value={$key}&id={$id}\">" . $val . "</span>";
                } else {
                    $str .= "<span class=\"{$class1}\" ajax=\"/index.php?m=Home&c=Ajax&a=index&table={$table}&key={$field}&value={$key}&id={$id}\">" . $val . "</span>";
                }
                $n++;
            }
            $str .= " </td>";
        } else {
            if ($value == 0) {
                $class0 = "ajax ajax_sel";
                $class1 = "ajax";
            } else if ($value == 1) {
                $class0 = "ajax";
                $class1 = "ajax ajax_sel";
            }
            $str = "<span class=\"{$class0}\" ajax=\"/index.php?m=Home&c=Ajax&a=index&table={$table}&key={$field}&value=0&id={$id}\">否</span> <span class=\"{$class1}\" ajax=\"/index.php?m=Home&c=Ajax&a=index&table={$table}&key={$field}&value=1&id={$id}\">是</span> </td>";
        }
        return $str;
    }

    function getWhereConfig($tableName)
    {
        //解析url里的where
        $url_where = TableController::parseUrlWhere();

        //解析global里的where
        $global_where = TableController::parseUrlWhere(TableController::getGlobalWhere1($tableName));
        if ($global_where) //如果是搜索的话 那么删除默认where里的where
        {
            //unset($_GET['p']);
            $url_where = array();
        }

        $wh = implode(' and ', merge($url_where, $global_where));
        $wh = !empty($wh) ? $wh : null;
        return $wh;
    }

    //Iphone管理->开发版相关设置
    function iphoneConfig()
    {
        if (!hasAsoRole('IPHONECO')) error(ERROR_MSG);
        if (isset($_POST['maxversion'])) {
            $types = $_POST['types'];
            $val = trim($_POST['val']);
            if ($types == "hosts_max_version") {
                getRedis()->set('iphone_hosts_version', $val);
                echo '修改成功';
                exit;
            } else if ($types == "lua_max_version") {
                getRedis()->set('iphone_lua_version', $val);
                echo '修改成功';
                exit;
            } else if ($types == "apk_max_version") {
                getRedis()->set('iphone_apk_version', $val);
                echo '修改成功';
                exit;
            } else if ($types == "down_apk_max_version") {
                getRedis()->set('iphone_down_apk_version', $val);
                echo '修改成功';
                exit;
            } else if ($types == "google_iphone_commands") {
                getRedis()->set('google_iphone_commands', $val);
                echo '修改成功';
                exit;
            } else {
                echo '修改失败';
                exit;
            }
        }
        if ($_FILES) {
            //上传文件
            if (isset($_FILES['hosts_file'])) {
                if (isset($_POST['hosts_file_password'])) {
                    $password = trim($_POST['hosts_file_password']);
                    getRedis()->set('iphone_hosts_version_password', $password);
                }
                $file = $_FILES['hosts_file'];
                if ($file['error'] === 0) {
                    getRedis()->set('iphone_hosts_zip_name', "hosts");
                    $path = self::$filepath;
                    if (file_exists($path . "hosts")) {
                        $time = date("YmdHis");
                        rename($path . "hosts", $path . $time . "hosts");
                        move_uploaded_file($file['tmp_name'], $path . "hosts");
                        getRedis()->set('iphone_hosts_version_time', date("Y-m-d H;i:s"));
                        success('操作成功', U('Iphone/iphoneConfig'));
                    } else {
                        move_uploaded_file($file['tmp_name'], $path . "hosts");
                        getRedis()->set('iphone_hosts_version_time', date("Y-m-d H;i:s"));
                        success('操作成功', U('Iphone/iphoneConfig'));
                    }
                } else {
                    error('文件上传失败，请重新上传！');
                }
            } else if (isset($_FILES['lua_file'])) {
                if (isset($_POST['lua_file_password'])) {
                    $password = trim($_POST['lua_file_password']);
                    getRedis()->set('iphone_lua_version_password', $password);
                }
                $file = $_FILES['lua_file'];
                if ($file['error'] === 0) {
                    getRedis()->set('iphone_lua_zip_name', "lua.zip");
                    $path = self::$filepath;
                    if (file_exists($path . "lua.zip")) {
                        $time = date("YmdHis");
                        rename($path . "lua.zip", $path . $time . "lua.zip");
                        move_uploaded_file($file['tmp_name'], $path . "lua.zip");
                        getRedis()->set('iphone_lua_version_time', date("Y-m-d H;i:s"));
                        success('操作成功', U('Iphone/iphoneConfig'));
                    } else {
                        move_uploaded_file($file['tmp_name'], $path . "lua.zip");
                        getRedis()->set('iphone_lua_version_time', date("Y-m-d H;i:s"));
                        success('操作成功', U('Iphone/iphoneConfig'));
                    }
                } else {
                    error('文件上传失败，请重新上传！');
                }
            } else if (isset($_FILES['apk_file'])) {
                if (isset($_POST['apk_file_password'])) {
                    $password = trim($_POST['apk_file_password']);
                    getRedis()->set('iphone_apk_version_password', $password);
                }
                $file = $_FILES['apk_file'];
                if ($file['error'] === 0) {
                    getRedis()->set('iphone_apk_zip_name', "google.apk");
                    $path = self::$filepath;
                    if (file_exists($path . "google.apk")) {
                        $time = date("YmdHis");
                        rename($path . "google.apk", $path . $time . "google.apk");
                        move_uploaded_file($file['tmp_name'], $path . "google.apk");
                        getRedis()->set('iphone_apk_version_time', date("Y-m-d H;i:s"));
                        success('操作成功', U('Iphone/iphoneConfig'));
                    } else {
                        move_uploaded_file($file['tmp_name'], $path . "google.apk");
                        getRedis()->set('iphone_apk_version_time', date("Y-m-d H;i:s"));
                        success('操作成功', U('Iphone/iphoneConfig'));
                    }
                } else {
                    error('文件上传失败，请重新上传！');
                }
            } else if (isset($_FILES['down_apk_file'])) {
                if (isset($_POST['down_apk_file_password'])) {
                    $password = trim($_POST['down_apk_file_password']);
                    getRedis()->set('iphone_down_apk_version_password', $password);
                }
                $file = $_FILES['down_apk_file'];
                if ($file['error'] === 0) {
                    getRedis()->set('iphone_down_apk_zip_name', "down.zip");
                    $path = self::$filepath;
                    if (file_exists($path . "down.zip")) {
                        $time = date("YmdHis");
                        rename($path . "down.zip", $path . $time . "down.zip");
                        move_uploaded_file($file['tmp_name'], $path . "down.zip");
                        getRedis()->set('iphone_down_apk_version_time', date("Y-m-d H;i:s"));
                        success('操作成功', U('Iphone/iphoneConfig'));
                    } else {
                        move_uploaded_file($file['tmp_name'], $path . "down.zip");
                        getRedis()->set('iphone_down_apk_version_time', date("Y-m-d H;i:s"));
                        success('操作成功', U('Iphone/iphoneConfig'));
                    }
                } else {
                    error('文件上传失败，请重新上传！');
                }
            }
        }
        $hosts_redis = getRedis()->get('iphone_hosts_version');
        $lua_redis = getRedis()->get('iphone_lua_version');
        $apk_redis = getRedis()->get('iphone_apk_version');
        $down_apk_redis = getRedis()->get('iphone_down_apk_version');
        $google_iphone_commands_redis = getRedis()->get('google_iphone_commands');
        $hosts_lasttime = getRedis()->get('iphone_hosts_version_time');
        $lua_lasttime = getRedis()->get('iphone_lua_version_time');
        $apk_lasttime = getRedis()->get('iphone_apk_version_time');
        $down_apk_lasttime = getRedis()->get('iphone_down_apk_version_time');
        $hosts_max_version = "<button style='font-size: 12px;cursor:pointer;height: 40px;width:110px' class='success_log_field' attr='hosts_max_version'>hosts最新版本号</button> <input name='hosts_max_version' type='text' value='{$hosts_redis}' size='5' />";
        $lua_max_version = "<button style='font-size: 12px;cursor:pointer;height: 40px;width:110px' class='success_log_field' attr='lua_max_version'>lua最新版本号</button> <input name='lua_max_version' type='text' value='{$lua_redis}' size='5' />";
        $apk_max_version = "<button style='font-size: 12px;cursor:pointer;height: 40px;width:110px' class='success_log_field' attr='apk_max_version'>apk最新版本号</button> <input name='apk_max_version' type='text' value='{$apk_redis}' size='5' />";
        $down_apk_max_version = "<button style='font-size: 12px;cursor:pointer;height: 40px;width:110px' class='success_log_field' attr='down_apk_max_version'>down_apk最新版本号</button> <input name='down_apk_max_version' type='text' value='{$down_apk_redis}' size='5' />";
        $google_iphone_commands = "<button style='font-size: 12px;cursor:pointer;height: 40px;width:110px' class='success_log_field' attr='google_iphone_commands'>手机命令</button> <textarea cols='60' rows='10' name='google_iphone_commands'>{$google_iphone_commands_redis}</textarea>";
        $this->assign('hosts_max_version', $hosts_max_version);
        $this->assign('lua_max_version', $lua_max_version);
        $this->assign('apk_max_version', $apk_max_version);
        $this->assign('down_apk_max_version', $down_apk_max_version);
        $this->assign('google_iphone_commands', $google_iphone_commands);
        $this->assign('hosts_lasttime', $hosts_lasttime);
        $this->assign('lua_lasttime', $lua_lasttime);
        $this->assign('apk_lasttime', $apk_lasttime);
        $this->assign('down_apk_lasttime', $down_apk_lasttime);
        $hosts_zip_name = getRedis()->get('iphone_hosts_zip_name');
        $lua_zip_name = getRedis()->get('iphone_lua_zip_name');
        $apk_zip_name = getRedis()->get('iphone_apk_zip_name');
        $down_apk_zip_name = getRedis()->get('iphone_down_apk_zip_name');
        $this->assign('hosts_zip_name', $hosts_zip_name);
        $this->assign('lua_zip_name', $lua_zip_name);
        $this->assign('apk_zip_name', $apk_zip_name);
        $this->assign('down_apk_zip_name', $down_apk_zip_name);
        $html = new Html();
        $this->assign('hosts_file', $html->createInput('file', 'hosts_file'));
        $this->assign('hosts_file_password', $html->createInput('text', 'hosts_file_password'));
        $this->assign('lua_file', $html->createInput('file', 'lua_file'));
        $this->assign('lua_file_password', $html->createInput('text', 'lua_file_password'));
        $this->assign('apk_file', $html->createInput('file', 'apk_file'));
        $this->assign('apk_file_password', $html->createInput('text', 'apk_file_password'));
        $this->assign('down_apk_file', $html->createInput('file', 'down_apk_file'));
        $this->assign('down_apk_file_password', $html->createInput('text', 'down_apk_file_password'));
        $this->nav = array(
            '开发版相关设置' => array('icon' => 'icon_grid', 'selected' => 1),
        );
        $this->main = $this->fetch('Iphone:iphoneConfig');
        $this->_out();
    }

    //Iphone管理->商用版相关设置
    function iphoneConfigBusiness()
    {
        if (!hasAsoRole('IPHONECO')) error(ERROR_MSG);
        if (isset($_POST['maxversion'])) {
            $types = $_POST['types'];
            $val = trim($_POST['val']);
            if ($types == "hosts_max_version") {
                getRedis()->set('iphone_hosts_version_business', $val);
                echo '修改成功';
                exit;
            } else if ($types == "lua_max_version") {
                getRedis()->set('iphone_lua_version_business', $val);
                echo '修改成功';
                exit;
            } else if ($types == "apk_max_version") {
                getRedis()->set('iphone_apk_version_business', $val);
                echo '修改成功';
                exit;
            } else if ($types == "down_apk_max_version") {
                getRedis()->set('iphone_down_apk_version_business', $val);
                echo '修改成功';
                exit;
            } else if ($types == "google_iphone_commands") {
                getRedis()->set('google_iphone_commands_business', $val);
                echo '修改成功';
                exit;
            } else {
                echo '修改失败';
                exit;
            }
        }
        if ($_FILES) {
            //上传文件
            if (isset($_FILES['hosts_file'])) {
                if (isset($_POST['hosts_file_password'])) {
                    $password = trim($_POST['hosts_file_password']);
                    getRedis()->set('iphone_hosts_version_password_business', $password);
                }
                $file = $_FILES['hosts_file'];
                if ($file['error'] === 0) {
                    getRedis()->set('iphone_hosts_zip_name_business', "hosts_business");
                    $path = self::$filepath;
                    if (file_exists($path . "hosts_business")) {
                        $time = date("YmdHis");
                        rename($path . "hosts_business", $path . $time . "hosts_business");
                        move_uploaded_file($file['tmp_name'], $path . "hosts_business");
                        getRedis()->set('iphone_hosts_version_time_business', date("Y-m-d H;i:s"));
                        success('操作成功', U('Iphone/iphoneConfigBusiness'));
                    } else {
                        move_uploaded_file($file['tmp_name'], $path . "hosts_business");
                        getRedis()->set('iphone_hosts_version_time_business', date("Y-m-d H;i:s"));
                        success('操作成功', U('Iphone/iphoneConfigBusiness'));
                    }
                } else {
                    error('文件上传失败，请重新上传！');
                }
            } else if (isset($_FILES['lua_file'])) {
                if (isset($_POST['lua_file_password'])) {
                    $password = trim($_POST['lua_file_password']);
                    getRedis()->set('iphone_lua_version_password_business', $password);
                }
                $file = $_FILES['lua_file'];
                if ($file['error'] === 0) {
                    getRedis()->set('iphone_lua_zip_name_business', "lua_business.zip");
                    $path = self::$filepath;
                    if (file_exists($path . "lua_business.zip")) {
                        $time = date("YmdHis");
                        rename($path . "lua_business.zip", $path . $time . "lua_business.zip");
                        move_uploaded_file($file['tmp_name'], $path . "lua_business.zip");
                        getRedis()->set('iphone_lua_version_time_business', date("Y-m-d H;i:s"));
                        success('操作成功', U('Iphone/iphoneConfigBusiness'));
                    } else {
                        move_uploaded_file($file['tmp_name'], $path . "lua_business.zip");
                        getRedis()->set('iphone_lua_version_time_business', date("Y-m-d H;i:s"));
                        success('操作成功', U('Iphone/iphoneConfigBusiness'));
                    }
                } else {
                    error('文件上传失败，请重新上传！');
                }
            } else if (isset($_FILES['apk_file'])) {
                if (isset($_POST['apk_file_password'])) {
                    $password = trim($_POST['apk_file_password']);
                    getRedis()->set('iphone_apk_version_password_business', $password);
                }
                $file = $_FILES['apk_file'];
                if ($file['error'] === 0) {
                    getRedis()->set('iphone_apk_zip_name_business', "google_business.apk");
                    $path = self::$filepath;
                    if (file_exists($path . "google_business.apk")) {
                        $time = date("YmdHis");
                        rename($path . "google_business.apk", $path . $time . "google_business.apk");
                        move_uploaded_file($file['tmp_name'], $path . "google_business.apk");
                        getRedis()->set('iphone_apk_version_time_business', date("Y-m-d H;i:s"));
                        success('操作成功', U('Iphone/iphoneConfigBusiness'));
                    } else {
                        move_uploaded_file($file['tmp_name'], $path . "google_business.apk");
                        getRedis()->set('iphone_apk_version_time_business', date("Y-m-d H;i:s"));
                        success('操作成功', U('Iphone/iphoneConfigBusiness'));
                    }
                } else {
                    error('文件上传失败，请重新上传！');
                }
            } else if (isset($_FILES['down_apk_file'])) {
                if (isset($_POST['down_apk_file_password'])) {
                    $password = trim($_POST['down_apk_file_password']);
                    getRedis()->set('iphone_down_apk_version_password_business', $password);
                }
                $file = $_FILES['down_apk_file'];
                if ($file['error'] === 0) {
                    getRedis()->set('iphone_down_apk_zip_name_business', "down_business.zip");
                    $path = self::$filepath;
                    if (file_exists($path . "down_business.zip")) {
                        $time = date("YmdHis");
                        rename($path . "down_business.zip", $path . $time . "down_business.zip");
                        move_uploaded_file($file['tmp_name'], $path . "down_business.zip");
                        getRedis()->set('iphone_down_apk_version_time_business', date("Y-m-d H;i:s"));
                        success('操作成功', U('Iphone/iphoneConfigBusiness'));
                    } else {
                        move_uploaded_file($file['tmp_name'], $path . "down_business.zip");
                        getRedis()->set('iphone_down_apk_version_time_business', date("Y-m-d H;i:s"));
                        success('操作成功', U('Iphone/iphoneConfigBusiness'));
                    }
                } else {
                    error('文件上传失败，请重新上传！');
                }
            }
        }
        $hosts_redis = getRedis()->get('iphone_hosts_version_business');
        $lua_redis = getRedis()->get('iphone_lua_version_business');
        $apk_redis = getRedis()->get('iphone_apk_version_business');
        $down_apk_redis = getRedis()->get('iphone_down_apk_version_business');
        $google_iphone_commands_redis = getRedis()->get('google_iphone_commands_business');
        $hosts_lasttime = getRedis()->get('iphone_hosts_version_time_business');
        $lua_lasttime = getRedis()->get('iphone_lua_version_time_business');
        $apk_lasttime = getRedis()->get('iphone_apk_version_time_business');
        $down_apk_lasttime = getRedis()->get('iphone_down_apk_version_time_business');
        $hosts_max_version = "<button style='font-size: 12px;cursor:pointer;height: 40px;width:110px' class='success_log_field' attr='hosts_max_version'>hosts最新版本号</button> <input name='hosts_max_version' type='text' value='{$hosts_redis}' size='5' />";
        $lua_max_version = "<button style='font-size: 12px;cursor:pointer;height: 40px;width:110px' class='success_log_field' attr='lua_max_version'>lua最新版本号</button> <input name='lua_max_version' type='text' value='{$lua_redis}' size='5' />";
        $apk_max_version = "<button style='font-size: 12px;cursor:pointer;height: 40px;width:110px' class='success_log_field' attr='apk_max_version'>apk最新版本号</button> <input name='apk_max_version' type='text' value='{$apk_redis}' size='5' />";
        $down_apk_max_version = "<button style='font-size: 12px;cursor:pointer;height: 40px;width:110px' class='success_log_field' attr='down_apk_max_version'>down_apk最新版本号</button> <input name='down_apk_max_version' type='text' value='{$down_apk_redis}' size='5' />";
        $google_iphone_commands = "<button style='font-size: 12px;cursor:pointer;height: 40px;width:110px' class='success_log_field' attr='google_iphone_commands'>手机命令</button> <textarea cols='60' rows='10' name='google_iphone_commands'>{$google_iphone_commands_redis}</textarea>";
        $this->assign('hosts_max_version', $hosts_max_version);
        $this->assign('lua_max_version', $lua_max_version);
        $this->assign('apk_max_version', $apk_max_version);
        $this->assign('down_apk_max_version', $down_apk_max_version);
        $this->assign('google_iphone_commands', $google_iphone_commands);
        $this->assign('hosts_lasttime', $hosts_lasttime);
        $this->assign('lua_lasttime', $lua_lasttime);
        $this->assign('apk_lasttime', $apk_lasttime);
        $this->assign('down_apk_lasttime', $down_apk_lasttime);
        $hosts_zip_name = getRedis()->get('iphone_hosts_zip_name_business');
        $lua_zip_name = getRedis()->get('iphone_lua_zip_name_business');
        $apk_zip_name = getRedis()->get('iphone_apk_zip_name_business');
        $down_apk_zip_name = getRedis()->get('iphone_down_apk_zip_name_business');
        $this->assign('hosts_zip_name', $hosts_zip_name);
        $this->assign('lua_zip_name', $lua_zip_name);
        $this->assign('apk_zip_name', $apk_zip_name);
        $this->assign('down_apk_zip_name', $down_apk_zip_name);
        $html = new Html();
        $this->assign('hosts_file', $html->createInput('file', 'hosts_file'));
        $this->assign('hosts_file_password', $html->createInput('text', 'hosts_file_password'));
        $this->assign('lua_file', $html->createInput('file', 'lua_file'));
        $this->assign('lua_file_password', $html->createInput('text', 'lua_file_password'));
        $this->assign('apk_file', $html->createInput('file', 'apk_file'));
        $this->assign('apk_file_password', $html->createInput('text', 'apk_file_password'));
        $this->assign('down_apk_file', $html->createInput('file', 'down_apk_file'));
        $this->assign('down_apk_file_password', $html->createInput('text', 'down_apk_file_password'));
        $this->nav = array(
            '商用版相关设置' => array('icon' => 'icon_grid', 'selected' => 1),
        );
        $this->main = $this->fetch('Iphone:iphoneConfigBusiness');
        $this->_out();
    }

    //手机管理->代理服务器
    function proxyServerList() {
        if (!hasAsoRole('PSL')) error(ERROR_MSG);
        $method = I('get.method') ? I('get.method') : 'show';
        $html = new \Home\Org\Html();
        $db = M('proxy_server_mst');
        $type_list = array_flip(C('PROXYTYPE'));
        switch ($method) {
            case 'show':
                $search_name = I("post.search_name") ? I("post.search_name") : "";
                $search_host_version = I("post.search_host_version") ? I("post.search_host_version") : "";
                $proxy_type = I("post.proxy_type") ? I("post.proxy_type") : "";
                $status = I('post.status') ? I('post.status') : '';

                $wh = "ip is not null";
                if (!empty($search_name)) {
                    $wh .= " and name like '%{$search_name}%'";
                }
                if (!empty($search_host_version)) {
                    $wh .= " and host_version like '%{$search_host_version}%'";
                }
                if (!empty($status)) {
                    $wh .= " and status = " . ($status - 1);
                }
                if(!empty($proxy_type)){
                    $wh .= " AND proxy_type = {$proxy_type}";
                }
                $data = $db->where($wh)->select();
                foreach ($data as &$v) {
                    $v['selectid'] = '<input name="id[]" type="checkbox" value="' . $v['id'] . '"/>';
                    $old_sid_part = $v['sid_part'];
                    $v['sid_part'] = $old_sid_part.$v['sid_part_start']."<br/>".$old_sid_part.$v['sid_part_end'];
                    $v['proxy_type'] = $type_list[$v['proxy_type']];
                    $v['status'] = $this->creatAjaxRadio2("proxy_server_mst", "status", $v['id'], $v['status']);
                    $v['caozuo'] = $this->createOperate(array(
                        array('act' => 'edit', 'id' => $v['id']),
                        array('act' => 'del', 'id' => $v['id']),
                    ), "proxyServerList");
                }
                $this->assign('data', $data);
                $this->assign('group_del', $html->createInput('radio', 'group_del', 'no', array('是' => 'yes', '否' => 'no')));//批量删除
                $this->assign('type_list', $html->createInput("select", "proxy_type", $proxy_type, C('PROXYTYPE')));
                $this->assign('status', $html->createInput("select", "status", $status, array('启用' => 2, '禁用' => 1)));
                $this->nav = array(
                    '代理服务器列表' => array('icon' => 'icon_grid', 'selected' => 1),
                    '添加' => array('link' => '/index.php?m=Home&c=Iphone&a=proxyServerList&method=add', 'icon' => 'icon_add'),
                );
                $this->assign("search_name", $html->createInput("text", "search_name", $search_name));
                $this->assign("search_host_version", $html->createInput("text", "search_host_version", $search_host_version));
                $this->assign("url", U('Iphone/proxyServerList', array("method" => "show")));
                $this->main = $this->fetch('Iphone:proxyServerList');
                $this->_out();
                break;
            case 'add':
                if ($_POST) {
                    $arr['name'] = trim($_POST['name']);
                    $arr['proxy_type'] = trim($_POST['proxy_type']);
                    $arr['device_type'] = trim($_POST['device_type']);
                    $arr['ip'] = trim($_POST['ip']);
                    $arr['host_version'] = trim($_POST['host_version']);
                    $arr['sid_part'] = trim($_POST['sid_part']);
                    $arr['sid_part_start'] = trim($_POST['sid_part_start']);
                    $arr['sid_part_end'] = trim($_POST['sid_part_end']);
                    if ($arr['sid_part_start'] > $arr['sid_part_end']) {
                        error("ip段开始不能大于结束");
                    }
                    $arr['allocationId'] = trim($_POST['allocationId']);
                    $arr['region'] = trim($_POST['region']);
                    $arr['region_name'] = trim($_POST['region_name']);
                    $arr['InstanceId'] = trim($_POST['InstanceId']);
                    $arr['add_time'] = date('Y-m-d H:i:s');
                    $arr['update_time'] = date('Y-m-d H:i:s');
                    $update = $db->add($arr);
                    if ($update) {
//                        $data = $db->where("id=$update")->find();
//                        getRedis()->set("proxy_server_info@".$data['sid_part']."@".$data['sid_part_start']."@".$data['sid_part_end'], $data);
//                        getRedis()->set("proxy_server_info@".$update, $data);
//
//                        //TODO 将所有启用的代理服务器
//                        $result_arr = M('proxy_server_mst')->where('status=1')->select();
//                        foreach ($result_arr as $val){
//                            $ip_str = '';
//                            for ($i=$val['sid_part_start'];$i<=$val['sid_part_end'];$i++) {
//                                $ip_str = $val['sid_part'] . $i;
//                                getRedis()->hSet('proxy_server_ip_list', $ip_str, $val['id']);
//                            }
//                        }
                        success('添加成功', U('Iphone/proxyServerList'));
                    } else {
                        error('添加失败');
                    }
                }
                $this->assign('name', $html->createInput('text', 'name'));
                $this->assign('device_type', $html->createInput("select", "device_type", null, C('PROXYDEVICETYPE')));
                $this->assign('proxy_type', $html->createInput("select", "proxy_type", null, C('PROXYTYPE')));
                $this->assign('ip', $html->createInput('text', 'ip'));
                $this->assign('host_version', $html->createInput('text', 'host_version'));
                $this->assign('sid_part', $html->createInput('selected', 'sid_part', null, getIphoneSidList()));
                $this->assign('sid_part_start', $html->createInput('text', 'sid_part_start'));
                $this->assign('sid_part_end', $html->createInput('text', 'sid_part_end'));
                $this->assign('allocationId', $html->createInput('text', 'allocationId'));
                $this->assign('region', $html->createInput('text', 'region'));
                $this->assign('region_name', $html->createInput('text', 'region_name'));
                $this->assign('InstanceId', $html->createInput('text', 'InstanceId'));
                $this->nav = array(
                    '代理服务器列表' => array('link' => '/index.php?m=Home&c=Iphone&a=proxyServerList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('Iphone:proxyServerList_add');
                $this->_out();
                break;
            case 'edit':
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $old_data = $data; //TODO 保存之前的记录
                if ($_POST) {
                    $arr['name'] = trim($_POST['name']);
                    $arr['ip'] = trim($_POST['ip']);
                    $arr['proxy_type'] = trim($_POST['proxy_type']);
                    $arr['device_type'] = trim($_POST['device_type']);
                    $arr['host_version'] = trim($_POST['host_version']);
                    $arr['sid_part'] = trim($_POST['sid_part']);
                    $arr['sid_part_start'] = trim($_POST['sid_part_start']);
                    $arr['sid_part_end'] = trim($_POST['sid_part_end']);
                    if ($arr['sid_part_start'] > $arr['sid_part_end']) {
                        error("ip段开始不能大于结束");
                    }
                    $arr['allocationId'] = trim($_POST['allocationId']);
                    $arr['region'] = trim($_POST['region']);
                    $arr['region_name'] = trim($_POST['region_name']);
                    $arr['update_time'] = date('Y-m-d H:i:s');
                    $id = I('post.id');

                    $update = $db->where("id=$id")->save($arr);
                    if ($update) {
//                        $data = $db->where("id=$id")->find();
//                        getRedis()->set("proxy_server_info@".$data['sid_part']."@".$data['sid_part_start']."@".$data['sid_part_end'], $data);
//                        getRedis()->set("proxy_server_info@".$id, $data);
//
//                        //TODO 将所有启用的代理服务器的ip取出 存入hset redis
//                        $result_arr = M('proxy_server_mst')->where('status=1')->select();
//                        foreach ($result_arr as $val){
//                            $ip_str = '';
//                            for ($i=$val['sid_part_start'];$i<=$val['sid_part_end'];$i++) {
//                                $ip_str = $val['sid_part'] . $i;
//                                getRedis()->hSet('proxy_server_ip_list', $ip_str, $val['id']);
//                            }
//                        }
                        success('修改成功', U('Iphone/proxyServerList'));
                    } else {
                        error('修改失败');
                    }
                }

                $this->assign('id', $id);
                $this->assign('name', $html->createInput('text', 'name',$data['name']));
                $this->assign('device_type', $html->createInput("select", "device_type", $data['device_type'], C('PROXYDEVICETYPE')));
                $this->assign('proxy_type', $html->createInput("select", "proxy_type", $data['proxy_type'], C('PROXYTYPE')));
                $this->assign('ip', $html->createInput('text', 'ip',$data['ip']));
                $this->assign('host_version', $html->createInput('text', 'host_version',$data['host_version']));
                if($data['device_type'] == 1){
                    $this->assign('sid_part', $html->createInput('selected', 'sid_part', $data['sid_part'], getIphoneSidList()));
                }else{
                    $this->assign('sid_part', $html->createInput('selected', 'sid_part', $data['sid_part'], getAgreementSidList()));
                }
                $this->assign('sid_part_start', $html->createInput('text', 'sid_part_start',$data['sid_part_start']));
                $this->assign('sid_part_end', $html->createInput('text', 'sid_part_end',$data['sid_part_end']));
                $this->assign('allocationId', $html->createInput('text', 'allocationId',$data['allocationId']));
                $this->assign('region', $html->createInput('text', 'region',$data['region']));
                $this->assign('region_name', $html->createInput('text', 'region_name',$data['region_name']));
                $this->nav = array(
                    '代理服务器列表' => array('link' => '/index.php?m=Home&c=Iphone&a=proxyServerList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Iphone&a=proxyServerList&method=add', 'icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Iphone:proxyServerList_edit');
                $this->_out();
                break;
            case 'del':
                if (!hasAsoRole('PSL')) error(ERROR_MSG);
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $update = $db->where("id=$id")->delete();
                if ($update) {
                    getRedis()->del("proxy_server_info@".$data['sid_part']."@".$data['sid_part_start']."@".$data['sid_part_end']);
//                    getRedis()->del("proxy_server_info@" . $data['id']);
//                    if($data['device_type'] == 1){
//                        //TODO 手机设备
//                        $iphone_data = $iphone_db->where("proxy_server_id = {$id}")->select();
//                        $arr1['proxy_server_id'] = 0;
//                        $iphone_db->where("proxy_server_id = {$id}")->save($arr1);
//                        foreach ($iphone_data as $val) {
//                            $val['proxy_server_id'] = 0;
//                            getRedis()->set("google_api_iphone_info@" . $val['deviceid'], $val);
//                        }
//                    }else{
//                        //TODO 协议设备
//                        $agree_data = M('agreement_mst')->where("proxy_server_id = {$id}")->select();
//                        $arr1['proxy_server_id'] = $data['id'];
//                        M('agreement_mst')->where("proxy_server_id = {$id}")->save($arr1);
//                        foreach ($agree_data as $val) {
//                            $val['proxy_server_id'] = 0;
//                            getRedis()->set("agreement_task_info@" . $val['sid'], $val);
//                        }
//                    }
//

                    success('删除成功', U('Iphone/proxyServerList'));
                } else {
                    error('删除失败');
                }
                break;
            case 'group':
                //批量操作
                $idArr = $_POST['id'];
                $group_del = $_POST['group_del'];
                $datas = $db->query("select * from proxy_server_mst where id in ({$idArr})");
                if ($group_del == "yes") {
                    $db->query("delete from proxy_server_mst where id in ({$idArr})");
                    foreach ($datas as $val) {
                        if (!empty($val['id'])) {
                            getRedis()->del("proxy_server_info@".$val['sid_part']."@".$val['sid_part_start']."@".$val['sid_part_end']);
//                            getRedis()->del("proxy_server_info@" . $val['id']);
                        }
                    }
//                    $iphone_data = $iphone_db->where("proxy_server_id in ({$idArr})")->select();
//                    $arr1['proxy_server_id'] = 0;
//                    $iphone_db->where("proxy_server_id in ({$idArr})")->save($arr1);
//                    foreach ($iphone_data as $val) {
//                        $val['proxy_server_id'] = 0;
//                        getRedis()->set("google_api_iphone_info@" . $val['deviceid'], $val);
//                    }
                    echo '删除成功';
                    exit;
                }
                exit;
        }
    }

    function gidSelectAjax(){
        $html = new \Home\Org\Html();
        $type = I('type');

        if($type == 1){
            echo $html->createInput('selected', 'sid_part', null, getIphoneSidList());
        }elseif($type == 2){
            echo $html->createInput('selected', 'sid_part', null, getAgreementSidList());
        }elseif ($type == 3){
            echo $html->createInput('selected', 'sid_part', null, getAgreementSidList());
        }
        exit;
    }

    //手机管理->手机管理段查看
    function iphoneClientListSegmentShow() {
        if (!hasAsoRole('ICLSSS')) error(ERROR_MSG);
        $method = $_GET['method'] ? $_GET['method'] : 'show';
        $db = M('iphone_mst');
        $html = new \Home\Org\Html();
        $redis_key = "iphone_client_list_segment_show@";
        switch ($method) {
            case 'show':
                $data = $db->query("select substring_index(sid, '.', 3) as duan,deviceid,`tag` from iphone_mst order by duan");
                $total = array();
                $result = array();
                $total_result = array();
                $now = time();
                foreach ($data as &$v) {
                    $heartbeat_redis = getRedis()->get("aso_iphone_heartbeat_time@" . $v['deviceid']);
                    if (($now - strtotime($heartbeat_redis)) < 600) {
                        $result[$v['duan']]['time_count'] += 1;
                    }
                    $result[$v['duan']]['count'] += 1;
                }
                foreach ($result as $key => $val) {
                    if ($val['count'] >= 10) {
                        $total['count'] += $val['count'];
                        $total['time_count'] += $val['time_count'];
                        $total_result[$key]['count'] = $val['count'];
                        $total_result[$key]['time_count'] = $val['time_count'];
                        $total_result[$key]['count_rate'] = round($val['time_count']/$val['count'],3) * 100 . "%";
                        $total_result[$key]['segment'] = $key;
                        $redis_val = getRedis()->get($redis_key.$key);
                        $total_result[$key]['remark'] = $html->createInput("text", "remark", $redis_val,null,"attr={$key}");
                    }
                }
                $total['count_rate'] = round($total['time_count']/$total['count'],3) * 100 . "%";
                $total['segment'] = "合计";
                $this->assign('total_result', $total_result);
                $this->assign('total', $total);
                $this->nav = array(
                    '手机管理信息按段查看' => array('icon' => 'icon_grid', 'selected' => 1),
                );
                $this->main = $this->fetch('Iphone:iphoneClientListSegmentShow');
                $this->_out();
                break;
            case 'ajax':
                $sid = trim($_POST['sid']);
                $remark = trim($_POST['remark']);
                getRedis()->set($redis_key.$sid,$remark);
                echo "备注成功";exit;
                break;
        }
    }

    //手机管理->手机管理TAG查看
    function iphoneClientListShow() {
        if (!hasAsoRole('ICLSSS')) error(ERROR_MSG);
        $method = I('method') ? I('method') : 'show';
        $db = M('iphone_mst');
        $iphone_tag_list1 = getIphoneTagList(2);
        switch ($method) {
            case 'show':
                $data = $db->query("select tag,deviceid from iphone_mst order by tag");
                $now = time();
                $total = array();
                $result = array();
                $total_result = array();
                foreach ($data as &$v) {
                    $heartbeat_redis = getRedis()->get("aso_iphone_heartbeat_time@" . $v['deviceid']);
                    if (($now - strtotime($heartbeat_redis)) < 600) {
                        $result[$v['tag']]['time_count'] += 1;
                    }
                    $result[$v['tag']]['count'] += 1;
                }
                foreach ($result as $key => $val) {
                    if ($val['count'] >= 7) {
                        $total['count'] += $val['count'];
                        $total['time_count'] += $val['time_count'];
                        $total_result[$key]['count'] = $val['count'];
                        $total_result[$key]['time_count'] = $val['time_count'];
                        $total_result[$key]['count_rate'] = round($val['time_count']/$val['count'],3) * 100 . "%";
                        $total_result[$key]['tag'] = $iphone_tag_list1[$key];
                    }
                }
                $total['count_rate'] = round($total['time_count']/$total['count'],3) * 100 . "%";
                $total['tag'] = "合计";
                $this->assign('total_result', $total_result);
                $this->assign('total', $total);
                $this->nav = array(
                    '手机管理TAG查看' => array('icon' => 'icon_grid', 'selected' => 1),
                );
                $this->main = $this->fetch('Iphone:iphoneClientListShow');
                $this->_out();
                break;
        }
    }

    //任务管理->真机任务管理->商业单综合查看
    function totalListBusiness()
    {
        if (!hasAsoRole('TLBS')) error(ERROR_MSG);
        $method = I('method') ? I('method') : 'show';
        $html = new \Home\Org\Html();
        $task_db = M('search_keyword_ip_task');
        switch ($method) {
            case 'show':
                $search_start = $_POST['search_start'] ? trim($_POST['search_start']) : "2017-09-01";
                $search_end = $_POST['search_end'] ? trim($_POST['search_end']) : date("Y-m-d",time());
                $search_end_sql = $search_end." 23:59:59";
                $search_package_name = trim($_POST['search_package_name']);
                $search_cp = trim($_POST['search_cp']);
                $wh = "start >= '{$search_start}' and end <= '{$search_end_sql}'";
                if (!empty($search_package_name)) {
                    $wh .= " and package_name = '{$search_package_name}'";
                }
                if (!empty($search_cp)) {
                    $wh .= " and cp = '{$search_cp}'";
                }
                $data1 = $task_db->field("id,game_name,package_name,start,end,count")->where($wh)->order('start asc')->select();
                $result = array();
                $history_time = strtotime("2017-01-01");
                foreach ($data1 as $key => $val) {
                    //获得包名的开始时间
                    $now_start_time = strtotime($result[$val['package_name']]['start']);
                    if ($now_start_time < $history_time) {
                        $result[$val['package_name']]['start'] = $val['start'];
                    } else {
                        if ($now_start_time > strtotime($val['start'])) {
                            $result[$val['package_name']]['start'] = $val['start'];
                        }
                    }
                    //获得包名的结束时间
                    $now_end_time = strtotime($result[$val['package_name']]['end']);
                    if ($now_end_time < $history_time) {
                        $result[$val['package_name']]['end'] = $val['end'];
                    } else {
                        if ($now_end_time < strtotime($val['end'])) {
                            $result[$val['package_name']]['end'] = $val['end'];
                        }
                    }
                    //获得包名的应用名，包名，任务数，下发数，提交数，成功数，详情
                    $result[$val['package_name']]['game_name'] = $val['game_name'];
                    $result[$val['package_name']]['package_name'] = $val['package_name'];
                    $result[$val['package_name']]['count'] += $val['count'];
                    //任务的下发数
                    $issued_num = intval(getRedis()->get('search_keyword_issued_task_id_' . $val['id']));
                    $result[$val['package_name']]['issued_num'] += $issued_num;
                    //任务的成功数
                    $success_nums = intval(getRedis()->get('search_task_success_id_' . $val['id']));
                    $result[$val['package_name']]['success_nums'] += $success_nums;
                    //获取任务的结果记录
                    $hTaskAll = getRedis()->hGet('google_aso_task@' . $val['id']);
                    if($hTaskAll){
                        $totalNums = 0;
                        foreach ($hTaskAll as $resKey => $count){
                            $totalNums += $count;
                        }
                        $result[$val['package_name']]['submit_nums'] += $totalNums;
                    }
                    $result[$val['package_name']]['zhankai'] = "<span class=\"open_group success_log_field\" attr='{$search_start}_{$search_end}_{$val['package_name']}'>展开</span>";
                }
                $this->assign('result', $result);
                $this->assign("url", U('Iphone/totalListBusiness'));
                $this->assign('search_start', $html->createInput('date', 'search_start', $search_start));
                $this->assign('search_end', $html->createInput('date', 'search_end', $search_end));
                $this->assign('search_package_name', $html->createInput('text', 'search_package_name', $search_package_name));
                $this->assign('search_cp', $html->createInput('select', 'search_cp', $search_cp, getCpList()));
                $this->nav = array(
                    '商业单综合查看' => array('icon' => 'icon_grid', 'selected' => 1),
                );
                $this->main = $this->fetch('Iphone:totalListBusiness');
                $this->_out();
                break;
        }
    }

    //商业单综合查看弹窗
    function totalListBusinessDetailList() {
        if (!hasAsoRole('TLBS')) {
            echo "没有权限";exit;
        }
        $groupid = I('groupid');
        $group_arr = explode("_",$groupid);
        $search_end_sql = $group_arr[1]." 23:59:59";
        $db = M('search_keyword_ip_task');
        $data = $db->where("start >= '{$group_arr[0]}' and end <= '{$search_end_sql}' and package_name = '{$group_arr[2]}'")->order("start asc")->select();
        $iphone_tag_list1 = getIphoneTagList(2);
        foreach ($data as &$v) {
            $v['tag'] = $iphone_tag_list1[$v['tag']];
            //任务的下发数
            $issued_num = intval(getRedis()->get('search_keyword_issued_task_id_' . $v['id']));
            $v['issued_num'] = $issued_num;
            //任务的成功数
            $success_nums = intval(getRedis()->get('search_task_success_id_' . $v['id']));
            $v['success_nums'] = $success_nums;
            //获取任务的结果记录
            $hTaskAll = getRedis()->hGet('google_aso_task@' . $v['id']);
            if($hTaskAll){
                $totalNums = 0;
                foreach ($hTaskAll as $resKey => $count){
                    $totalNums += $count;
                }
                $v['submit_nums'] = $totalNums;
            }
        }
        $html = "<table><th>ID</th><th>TAG</th><th>应用名</th><th>包名</th><th>关键词</th><th>任务数</th><th>下发数</th><th>提交数</th><th>成功数</th><th>开始/结束时间</th>";
        foreach ($data as $val) {
            $html .= "<tr>";
            $html .= "<td>" . $val['id'] . "</td>";
            $html .= "<td>" . $val['tag'] . "</td>";
            $html .= "<td><div style=\"overflow-y: scroll;width: 100px;height: 40px;white-space: normal;\">" . $val['game_name'] . "</div></td>";
            $html .= "<td><div style=\"overflow-y: scroll;width: 100px;height: 40px;white-space: normal;\">" . $val['package_name'] . "</div></td>";
            $html .= "<td>" . $val['keyword'] . "</td>";
            $html .= "<td>" . $val['count'] . "</td>";
            $html .= "<td>" . $val['issued_num'] . "</td>";
            $html .= "<td>" . $val['submit_nums'] . "</td>";
            $html .= "<td>" . $val['success_nums'] . "</td>";
            $html .= "<td>" . $val['start'] . "<br>" . $val['end'] . "</td>";
            $html .= "</tr>";
        }
        $html .= "</table>";
        echo $html;
        exit;
    }

    function iphoneSidList() {
        if (!hasAsoRole('ICLSSS')) error(ERROR_MSG);
        $method = I('get.method') ? I('get.method') : 'show';
        $html = new \Home\Org\Html();
        $db = M('sid_result_log');
        switch ($method) {
            case 'show':
                $start = $_POST["start"] ? $_POST["start"] : date('Y-m-d H',strtotime('-1 hour')) . ":00:00";
                $end = $_POST["end"] ? $_POST["end"] : date('Y-m-d H') . ":00:00";
                $sql = "SELECT LEFT(sid,10) AS 'sid',COUNT(*) AS 'count', count(case WHEN result_type = 100 THEN id END) AS 'success', count(case WHEN result_type = 105 THEN id END) AS 'accept_outtime', count(case WHEN result_type = 121 THEN id END) AS 'googleplay_outtime', count(case WHEN result_type = 106 THEN id END) AS 'app_fail' FROM sid_result_log WHERE add_time >= '{$start}' and add_time <='{$end}' GROUP BY LEFT(sid,10)";
                $data = $db->query($sql);
                foreach ($data as &$v) {
                    $v['rate'] = round($v['success']/$v['count'],4) * 100 . "%";
                    $v['memo'] = getRedis()->get("iphone_client_list_segment_show@{$v['sid']}");
                }
                $this->assign('data', $data);
                $this->nav = array(
                    '手机段查看' => array('icon' => 'icon_grid', 'selected' => 1),
                );
                $this->assign("start", $html->createInput("datetime1", "start", $start));
                $this->assign("end", $html->createInput("datetime1", "end", $end));
                $this->assign("url", U('Iphone/iphoneSidList', array("method" => "show")));
                $this->main = $this->fetch('Iphone:iphoneSidList');
                $this->_out();
                break;
        }
    }
}