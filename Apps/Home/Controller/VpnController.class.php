<?php
/**
 * VPN管理
 */
namespace Home\Controller;

use Home\Org\Html;
use Think\controller;

class VpnController extends RoleController
{
    //VPN管理->VPN管理
    function vpnList()
    {
        if (!hasAsoRole('VPNS,VPNO')) error(ERROR_MSG);
        $method = I('get.method') ? I('get.method') : 'show';
        $html = new \Home\Org\Html();
        $db = M('vpn_mst', null, C('DB_ASO_DATA'));
        switch ($method) {
            case 'show':
                $tableName = 'vpn_mst';
                //搜索
                $searchArr = array(
                    '搜索' => array(
                        'id' => array('name' => 'id', 'type' => 'text'),
                        '组id' => array('name' => 'group_id', 'type' => 'text'),
                        '账号来源' => array('name' => 'channel', 'type' => 'text',  'sign' => 'like'),
                        '国内国外' => array('name' => 'country_type', 'type' => 'select',  'data' => C('COUNTRYTYPE')),
                        '是否启用' => array('name' => 'status', 'type' => 'select', 'data' => C('YESORNO')),
                    )
                );
                $searchHtml = TableController::createSearch1($tableName, $searchArr);
                //分页
                $wh = IphoneController::getWhereConfig($tableName);
                $count = $db->where($wh)->count();
                $pagesize = 1000;
                $parameter = TableController::getGlobalWhere($tableName) ? merge($_GET, array('where' => TableController::getGlobalWhere($tableName))) : '';
                $page = new \Home\Org\Page($count, $pagesize, $parameter);
                $data = $db->where($wh)->order('id desc')->limit($page->firstRow, $page->listRows)->select();
                $pager = $page->show();
                $this->pager = '<div class="pager">' . $pager . '</div>';
                $group_name_arr = getVpnGroupList(2);
                $country_type_arr = array_flip(C('COUNTRYTYPE'));

                $clientIds = array();
                foreach ($data as &$v) {
                    $clientIds[] = intval(getRedis()->get("google_client_vpn_id@".$v['id']));
                }
                $clientList = array();
                if(!empty($clientIds)){
                    $clientList = M('agreement_mst')->where(array('id' => array('IN', $clientIds)))->getField('id,sid');
                }

                foreach ($data as &$v) {
                    $v['selectid'] = '<input name="id[]" type="checkbox" value="' . $v['id'] . '"/>';
                    $v['group_id'] = $group_name_arr[$v['group_id']];  //分组id
                    $v['country_type'] = $country_type_arr[$v['country_type']];  //分组id
                    $client_id = getRedis()->get("google_client_vpn_id@".$v['id']);
                    $v['sid'] = $clientList[$client_id];
                    if ((strtotime($v['lasttime']) - time()) > 86400*7) {
                        $v['lasttime'] = $v['lasttime'];  //到期时间
                    } else {
                        $v['lasttime'] = "<span style='color:red'>" . $v['lasttime'] . "</span>";  //到期时间
                    }
                    $v['expiration_time'] = ($v['expiration_time'] == "0000-00-00 00:00:00") ? "" : $v['expiration_time'];  //冻结时间
                    if (!hasAsoRole('VPNO')) {
                        $v['status'] = parseYn($v['status']);  //0禁用 1启用
                        $v['dynamic'] = parseYn($v['dynamic']);  //动态ip 0不动态 1动态
                        $v['caozuo'] = "";
                    } else {
                        $v['status'] = $this->creatAjaxRadio2("vpn_mst", "status", $v['id'], $v['status']);
                        $v['dynamic'] = $this->creatAjaxRadio2("vpn_mst", "dynamic", $v['id'], $v['dynamic']);
                        $v['caozuo'] = $this->createOperate(array(
                            array('act' => 'edit', 'id' => $v['id']),
                            array('act' => 'del', 'id' => $v['id']),
                        ), "vpnList");
                    }
                }
                $this->assign('data', $data);
                $this->assign('group_groupid', $html->createInput('select', 'group_groupid',null,getVpnGroupList()));//批量修改VPS组
                $this->assign('group_country_type', $html->createInput('select', 'group_country_type',null,C('COUNTRYTYPE')));//批量修改国内国外
                $this->assign('group_lasttime', $html->createInput('text', 'group_lasttime'));//批量修改日期
                $this->assign('group_status', $html->createInput('radio', 'group_status','keep',array('不修改'=>'keep','启用'=>'yes','禁用'=>'no')));//批量修改状态
                $this->assign('group_del', $html->createInput('radio', 'group_del','no',array('是'=>'yes','否'=>'no')));//批量删除
                if (!hasAsoRole('VPNO')) {
                    $this->nav = array(
                        'VPN列表' => array('icon' => 'icon_grid', 'selected' => 1),
                    );
                } else {
                    $this->nav = array(
                        'VPN列表' => array('icon' => 'icon_grid', 'selected' => 1),
                        '添加' => array('link' => '/index.php?m=Home&c=Vpn&a=vpnList&method=add', 'icon' => 'icon_add'),
                    );
                }
                $this->main = $searchHtml . $this->fetch('Vpn:vpnList');
                $this->_out();
                break;
            case 'add':
                if (!hasAsoRole('VPNO')) error(ERROR_MSG);
                if ($_POST) {
                    $arr['group_id'] = $_POST['group_id'];
                    $arr['channel'] = trim($_POST['channel']);
                    $arr['score'] = trim($_POST['score']);
                    $arr['dynamic'] = $_POST['dynamic'];
                    $arr['status'] = $_POST['status'];
                    $arr['lasttime'] = $_POST['lasttime'];
                    $arr['remark'] = trim($_POST['remark']);
                    $arr['country_type'] = $_POST['country_type'];
                    $arr['time'] = date('Y-m-d H:i:s');
                    $data_post = trim($_POST['data']);
                    $data_post = trim($data_post, ";");
                    $data_post = str_replace("；",";",$data_post);
                    $data_post = str_replace("，",",",$data_post);
                    $data_arr = explode(";", $data_post);
                    $data_arr_new = array();
                    if (empty($data_arr)) {
                        error('数据不能为空');
                    } else {
                        foreach ($data_arr as $key => $val) {
                            $val_arr = explode(",", $val);
                            if (count($val_arr) != 3) {
                                error('第' . ($key + 1) . '组数据格式错误');
                            } else {
                                if (empty($val_arr[0]) || empty($val_arr[1]) || empty($val_arr[2])) {
                                    error('第' . ($key + 1) . '组数据不能为空');
                                } else {
                                    $val_arr[0] = trim($val_arr[0]);
                                    $val_arr[1] = trim($val_arr[1]);
                                    $val_arr[2] = trim($val_arr[2]);
                                    $data_arr_new[$key] = implode(",", $val_arr);
                                }
                            }
                        }
                        $arr['data'] = implode(";", $data_arr_new);
                    }
                    if (strtotime($arr['lasttime']) < time()) {
                        error("过期时间不能小于当天");
                    }
                    $update = $db->add($arr);
                    if ($update) {
                        $data = $db->where("id=$update")->find();
                        getRedis()->set("google_vpn_detail_id@" . $data['id'], $data);
                        $files = getUrlData(C('APIURL')."/client/loadvpn");
                        success('添加成功', U('Vpn/vpnList'));
                    } else {
                        error('添加失败');
                    }
                }
                $this->assign('group_id', $html->createInput('selected', 'group_id',null,getVpnGroupList()));
                $this->assign('country_type', $html->createInput('selected', 'country_type',null,C('COUNTRYTYPE')));
                $this->assign('channel', $html->createInput('text', 'channel'));
                $this->assign('score', $html->createInput('text', 'score'));
                $this->assign('dynamic', $html->createInput('radio', 'dynamic', 0, C('YESORNO')));
                $this->assign('status', $html->createInput('radio', 'status', 0, C('YESORNO')));
                $this->assign('lasttime', $html->createInput('date', 'lasttime'));
                $this->assign('remark', $html->createInput('textarea', 'remark'));
                $this->assign('data', $html->createInput('textarea', 'data'));
                $this->nav = array(
                    'VPN列表' => array('link' => '/index.php?m=Home&c=Vpn&a=vpnList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('Vpn:vpnList_add');
                $this->_out();
                break;
            case 'edit':
                if (!hasAsoRole('VPNO')) error(ERROR_MSG);
                if ($_POST) {
                    $arr['group_id'] = $_POST['group_id'];
                    $arr['channel'] = trim($_POST['channel']);
                    $arr['score'] = trim($_POST['score']);
                    $arr['dynamic'] = $_POST['dynamic'];
                    $arr['status'] = $_POST['status'];
                    $arr['lasttime'] = $_POST['lasttime'];
                    $arr['remark'] = trim($_POST['remark']);
                    $arr['country_type'] = $_POST['country_type'];
                    $data_post = trim($_POST['data']);
                    $data_post = trim($data_post, ";");
                    $data_post = str_replace("；",";",$data_post);
                    $data_post = str_replace("，",",",$data_post);
                    $data_arr = explode(";", $data_post);
                    $data_arr_new = array();
                    if (empty($data_arr)) {
                        error('数据不能为空');
                    } else {
                        foreach ($data_arr as $key => $val) {
                            $val_arr = explode(",", $val);
                            if (count($val_arr) != 3) {
                                error('第' . ($key + 1) . '组数据格式错误');
                            } else {
                                if (empty($val_arr[0]) || empty($val_arr[1]) || empty($val_arr[2])) {
                                    error('第' . ($key + 1) . '组数据不能为空');
                                } else {
                                    $val_arr[0] = trim($val_arr[0]);
                                    $val_arr[1] = trim($val_arr[1]);
                                    $val_arr[2] = trim($val_arr[2]);
                                    $data_arr_new[$key] = implode(",", $val_arr);
                                }
                            }
                        }
                        $arr['data'] = implode(";", $data_arr_new);
                    }
                    if (strtotime($arr['lasttime']) < time()) {
                        error("过期时间不能小于当天");
                    }
                    $id = I('post.id');
                    $update = $db->where("id=$id")->save($arr);
                    if ($update) {
                        $data = $db->where("id=$id")->find();
                        getRedis()->set("google_vpn_detail_id@" . $data['id'], $data);
                        $files = getUrlData(C('APIURL')."/client/loadvpn");
                        success('修改成功', U('Vpn/vpnList'));
                    } else {
                        error('修改失败');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $this->assign('id', $id);
                $this->assign('group_id', $html->createInput('selected', 'group_id', $data['group_id'],getVpnGroupList()));
                $this->assign('country_type', $html->createInput('selected', 'country_type',$data['country_type'],C('COUNTRYTYPE')));
                $this->assign('channel', $html->createInput('text', 'channel', $data['channel']));
                $this->assign('score', $html->createInput('text', 'score', $data['score']));
                $this->assign('dynamic', $html->createInput('radio', 'dynamic', $data['dynamic'], C('YESORNO')));
                $this->assign('status', $html->createInput('radio', 'status', $data['status'], C('YESORNO')));
                $this->assign('lasttime', $html->createInput('date', 'lasttime', $data['lasttime']));
                $this->assign('remark', $html->createInput('textarea', 'remark', $data['remark']));
                $this->assign('data', $html->createInput('textarea', 'data', $data['data']));
                $this->nav = array(
                    'VPN列表' => array('link' => '/index.php?m=Home&c=Vpn&a=vpnList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Vpn&a=vpnList&method=add', 'icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Vpn:vpnList_edit');
                $this->_out();
                break;
            case 'del':
                if (!hasAsoRole('VPNO')) error(ERROR_MSG);
                $id = I('id');
                $update = $db->where("id=$id")->delete();
                if ($update) {
                    getRedis()->del("google_vpn_detail_id@" . $id);
                    $files = getUrlData(C('APIURL')."/client/loadvpn");
                    success('删除成功', U('Vpn/vpnList'));
                } else {
                    error('删除失败');
                }
                break;
            case 'group':
                //导出账号
                $idArr = $_POST['id'];
                $group_groupid = $_POST['group_groupid'];
                $group_country_type = $_POST['group_country_type'];
                $group_lasttime = $_POST['group_lasttime'];
                $group_status = $_POST['group_status'];
                $group_del = $_POST['group_del'];
                $s = $t = 0;
                if ($group_del == "yes") {
                    $sql = "delete from vpn_mst where id in ({$idArr})";
                    M('vpn_mst')->query($sql);
                    $id_str = explode(",",$idArr);
                    foreach ($id_str as $val) {
                        getRedis()->del("google_vpn_info@" . $val);
                        $s++;
                    }
                    $files = getUrlData(C('APIURL')."/client/loadvpn");
                    echo '删除成功'.$s.'条';exit;
                } else {
                    if ($group_status == 'yes' || $group_status == 'no') {
                        $arr['status'] = ($group_status == 'yes') ? 1 : 0;
                    }
                    if (!empty($group_lasttime)) {
                        $arr['lasttime'] = $group_lasttime;
                    }
                    if (!empty($group_groupid)) {
                        $arr['group_id'] = $group_groupid;
                    }
                    if (!empty($group_country_type)) {
                        $arr['country_type'] = $group_country_type;
                    }
                    $where_vpn['_string'] = 'id in (' . $idArr . ')';
                    $list = M('vpn_mst')->where($where_vpn)->save($arr);
                    if ($list) {
                        $datas = M('vpn_mst')->where($where_vpn)->select();
                        foreach ($datas as $val) {
                            getRedis()->set("google_vpn_detail_id@" . $val['id'], $val);
                            $s++;
                        }
                        $files = getUrlData(C('APIURL')."/client/loadvpn");
                        echo '修改成功'.$s.'条';exit;
                    }
                }
                exit;
        }
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

    function createOperate($array, $control)
    {
        $caozuo = '';
        foreach ($array as $v) {
            if ($v['act'] == 'edit')
                $caozuo .= '<a href="' . U('Vpn/' . $control, array('method' => 'edit', 'id' => $v['id'])) . '"><span class="icon_edit" title="修改"></span></a> ';
            if ($v['act'] == 'del')
                $caozuo .= '<a href="' . U('Vpn/' . $control, array('method' => 'del', 'id' => $v['id'])) . '" onclick="javascript:return confirm(\'你确定要删除id为' . $v['id'] . '的数据吗?\')"><span class="icon_delete" title="删除"></span></a>';
            if ($v['act'] == 'copy')
                $caozuo .= '<a href="' . U('Vpn/' . $control, array('method' => 'copy', 'id' => $v['id'])) . '"><span class="icon_star" title="复制"></span></a> ';
        }
        return $caozuo;
    }

    //VPN管理->VPN文件导入
    function vpnFileImport(){
        if (!hasAsoRole('VPNFIO')) error(ERROR_MSG);
        $db = M('vpn_mst', null, C('DB_ASO_DATA'));
        if($_FILES)
        {
            $group_id = I('post.group_id');
            $dynamic = I('dynamic');
            $country_type = I('post.country_type');
            $lasttime = I('lasttime');
            $channel = I('channel');
            $type = I('type');
            if(empty($channel))
            {
                error("未填写账号来源");
            }
            if(empty($lasttime))
            {
                error("未选择到期时间");
            }
            if(isset($_FILES['efile']))
            {
                $file = $_FILES['efile'];
                if($file['error']===0)
                {
                    if ($type == 1) {
                        $file_name = explode(".",$file['name']);
                        $str = file_get_contents($file['tmp_name']);
                        $str = trim($str);
                        $str = str_replace("：",":",$str);
                        $str = str_replace("  "," ",$str);
                        $arr = explode("\n",$str);
                        $s = 0;
                        $t = 0;
                        for($i=0;$i<=(count($arr)-2);$i=$i+2) {
                            $str1 = explode(" ",$arr[$i]);
                            $array1 = explode(":",$str1[0]);
                            $array2 = explode(":",$str1[1]);
                            $array3 = explode(":",$arr[$i+1]);
                            if($array1[0] != "账号" || $array2[0] != "密码") {
                                error("文件内容格式错误");
                            }
                            $result = array();
                            $result['channel'] = $channel." ".trim($array1[1]);
                            $result['score'] = 1;
                            $result['group_id'] = $group_id;
                            $result['country_type'] = $country_type;
                            $result['lasttime'] = $lasttime;
                            $result['dynamic'] = $dynamic;
                            $result['status'] = 0;
                            $result['data'] = trim($array3[1]).",".trim($array1[1]).",".trim($array2[1]);
                            $update = $db->add($result);
                            if ($update) {
                                $data = $db->where("id=$update")->find();
                                getRedis()->set("aso_api_vpn_info@" . $data['id'], $data);
                                $files = file_get_contents(C('APIURL')."/client/loadvpn");
                                $s++;
                            } else {
                                $t++;
                            }
                        }
                        success('添加成功'.$s.'条，失败'.$t.'条', U('Vpn/vpnList'));
                    } else if ($type == 2) {
                        $file_name = explode(".",$file['name']);
                        $str = file_get_contents($file['tmp_name']);
                        $str = trim($str);
                        $str = str_replace("：",":",$str);
                        $str = str_replace("  "," ",$str);
                        $arr = explode("\n",$str);
                        $s = 0;
                        $t = 0;
                        foreach ($arr as $val) {
                            $new_array = explode("@",$val);
                            $array1 = explode(",",$new_array[0]);
                            $result = array();
                            $result['channel'] = $channel." ".trim($array1[1]);
                            $result['score'] = 1;
                            $result['group_id'] = $group_id;
                            $result['country_type'] = $country_type;
                            $result['lasttime'] = $lasttime;
                            $result['dynamic'] = $dynamic;
                            $result['status'] = 0;
                            $result['data'] = trim($new_array[0]);
                            if (!empty($new_array[1])) {
                                $update = $db->where("id=".$new_array[1])->save($result);
                                if ($update) {
                                    $data = $db->where("id=".$new_array[1])->find();
                                    getRedis()->set("aso_api_vpn_info@" . $data['id'], $data);
                                    $s++;
                                } else {
                                    $t++;
                                }
                            } else {
                                $update = $db->add($result);
                                if ($update) {
                                    $data = $db->where("id=$update")->find();
                                    getRedis()->set("aso_api_vpn_info@" . $data['id'], $data);
                                    $s++;
                                } else {
                                    $t++;
                                }
                            }
                        }
                        $files = file_get_contents(C('APIURL')."/client/loadvpn");
                        success('添加成功'.$s.'条，失败'.$t.'条', U('Vpn/vpnList'));
                    }
                }
                else
                    error('文件上传失败，请重新上传');
            }
        }
        $html = new \Home\Org\Html();
        $this->assign('group_id', $html->createInput('selected', 'group_id',null,getVpnGroupList()));
        $this->assign('channel', $html->createInput('text', 'channel'));
        $this->assign('dynamic', $html->createInput('radio', 'dynamic', 0, C('YESORNO')));
        $this->assign('lasttime', $html->createInput('date', 'lasttime'));
        $this->assign('country_type', $html->createInput('selected', 'country_type',null,C('COUNTRYTYPE')));
        $this->assign('type', $html->createInput('selected', 'type',1,array('格式一'=>1,'格式二'=>2)));
        $this->assign('efile', $html->createInput('file', 'efile',null,null,'accept="text/plain"'));
        $this->nav = TableController::createNav(null, array('VPN文件导入'=>array()));
        $this->main = $this->fetch('Vpn:vpnFileImport');
        $this->_out();
    }
}