<?php
/**
 * 动态包管理
 */
namespace Home\Controller;

use Home\Org\Html;
use Think\controller;

class DynamicController extends RoleController
{
    static $filepath = '/data/www/googlemanager/Uploads/dynamic/';
//    static $filepath = 'D:/phpStudy/WWW/googlemanager/Uploads/dynamic/';

    function createOperate($array, $control)
    {
        $caozuo = '';
        foreach ($array as $v) {
            if ($v['act'] == 'edit')
                $caozuo .= '<a href="' . U('Dynamic/' . $control, array('method' => 'edit', 'id' => $v['id'])) . '"><span class="icon_edit" title="修改"></span></a> ';
            if ($v['act'] == 'del')
                $caozuo .= '<a href="' . U('Dynamic/' . $control, array('method' => 'del', 'id' => $v['id'])) . '" onclick="javascript:return confirm(\'你确定要删除id为' . $v['id'] . '的数据吗?\')"><span class="icon_delete" title="删除"></span></a>';
            if ($v['act'] == 'copy')
                $caozuo .= '<a href="' . U('Dynamic/' . $control, array('method' => 'copy', 'id' => $v['id'])) . '"><span class="icon_star" title="复制"></span></a> ';
        }
        return $caozuo;
    }

    function creatAjaxRadio2($table, $field, $id, $value, $array = array())
    {
        if ($value == 0) {
            $class0 = "ajax ajax_sel";
            $class1 = "ajax";
        } else if ($value == 1) {
            $class0 = "ajax";
            $class1 = "ajax ajax_sel";
        }
        if (!empty($array)) {
            $arr = array_flip($array);
            $str = "<span class=\"{$class0}\" ajax=\"/index.php?m=Home&c=Ajax&a=index&table={$table}&key={$field}&value=0&id={$id}\">" . $arr[0] . "</span> <span class=\"{$class1}\" ajax=\"/index.php?m=Home&c=Ajax&a=index&table={$table}&key={$field}&value=1&id={$id}\">" . $arr[1] . "</span> </td>";
        } else {
            $str = "<span class=\"{$class0}\" ajax=\"/index.php?m=Home&c=Ajax&a=index&table={$table}&key={$field}&value=0&id={$id}\">否</span> <span class=\"{$class1}\" ajax=\"/index.php?m=Home&c=Ajax&a=index&table={$table}&key={$field}&value=1&id={$id}\">是</span> </td>";
        }
        return $str;
    }

    //动态包管理->动态包类型管理
    function dynamicTypeList() {
        if (!hasAsoRole('DTLO')) error(ERROR_MSG);
        $method = $_GET['method'] ? $_GET['method'] : 'show';
        $db = M('dynamic_type_mst', null, C('DB_ASO_DATA'));
        $tag_list = getDynamicTagList();
        $tag_list1 = array_flip($tag_list);
        $html = new \Home\Org\Html();
        switch ($method) {
            case 'show':
                $data = $db->select();
                foreach ($data as &$v) {
                    $v['tid'] = $tag_list1[$v['tid']];
                    $v['caozuo'] = $this->createOperate(array(
                        array('act' => 'edit', 'id' => $v['id']),
                        array('act' => 'del', 'id' => $v['id']),
                    ), "dynamicTypeList");
                }
                $this->nav = array(
                    '动态包类型管理' => array('icon' => 'icon_grid', 'selected' => 1),
                    '添加' => array('link' => '/index.php?m=Home&c=Dynamic&a=dynamicTypeList&method=add', 'icon' => 'icon_add'),
                );
                $this->assign("data",$data);
                $this->assign("url",U('Dynamic/dynamicTypeList',array("method"=>"show")));
                $this->main = $this->fetch('Dynamic:dynamicTypeList');
                $this->_out();
                break;
            case 'add':
                if ($_POST) {
                    if (empty($_POST['type_name']) || empty($_POST['type_key']) || empty($_POST['type_score'])) {
                        error('信息不完整');
                    }
                    $arr['tid'] = $_POST['tid'];
                    $arr['type_name'] = trim($_POST['type_name']);
                    $arr['package_name'] = trim($_POST['package_name']);
                    $arr['type_key'] = trim($_POST['type_key']);
                    $arr['type_score'] = trim($_POST['type_score']);
                    $arr['add_time'] = date("Y-m-d H:i:s");//入库时间
                    $update = $db->add($arr);
                    if ($update) {
                        success('添加成功', U('Dynamic/dynamicTypeList'));
                    } else {
                        error('添加失败');
                    }
                }
                $this->assign('tid', $html->createInput('selected', 'tid', null, $tag_list));
                $this->assign('type_name', $html->createInput('text', 'type_name'));
                $this->assign('package_name', $html->createInput('text', 'package_name'));
                $this->assign('type_key', $html->createInput('text', 'type_key'));
                $this->assign('type_score', $html->createInput('text', 'type_score'));
                $this->nav = array(
                    '动态包类型管理' => array('link' => '/index.php?m=Home&c=Dynamic&a=dynamicTypeList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('Dynamic:dynamicTypeList_add');
                $this->_out();
                break;
            case 'edit':
                if ($_POST) {
                    if (empty($_POST['type_name']) || empty($_POST['type_key']) || empty($_POST['type_score'])) {
                        error('信息不完整');
                    }
                    $id = I('post.id');
                    $arr['tid'] = $_POST['tid'];
                    $arr['type_name'] = trim($_POST['type_name']);
                    $arr['package_name'] = trim($_POST['package_name']);
                    $arr['type_key'] = trim($_POST['type_key']);
                    $arr['type_score'] = trim($_POST['type_score']);
                    $arr['update_time'] = date("Y-m-d H:i:s");//修改时间
                    $update = $db->where("id=$id")->save($arr);
                    if ($update) {
                        success('修改成功', U('Dynamic/dynamicTypeList'));
                    } else {
                        error('修改失败');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $this->assign('id', $id);
                $this->assign('tid', $html->createInput('selected', 'tid', $data['tid'], $tag_list));
                $this->assign('type_name', $html->createInput('text', 'type_name',$data['type_name']));
                $this->assign('package_name', $html->createInput('text', 'package_name',$data['package_name']));
                $this->assign('type_key', $html->createInput('text', 'type_key',$data['type_key']));
                $this->assign('type_score', $html->createInput('text', 'type_score',$data['type_score']));
                $this->nav = array(
                    '动态包类型管理' => array('link' => '/index.php?m=Home&c=Dynamic&a=dynamicTypeList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Dynamic&a=dynamicTypeList&method=add','icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Dynamic:dynamicTypeList_edit');
                $this->_out();
                break;
            case 'del':
                $id = I('id');
                $update = $db->where("id=$id")->delete();
                if ($update) {
                    success('删除成功', U('Dynamic/dynamicTypeList'));
                } else {
                    error('删除失败');
                }
                break;
        }
    }

    //动态包管理->上传动态包管理
    function dynamicPackageList() {
        if (!hasAsoRole('DPLO')) error(ERROR_MSG);
        $method = $_GET['method'] ? $_GET['method'] : 'show';
        $db = M('dynamic_package_mst');
        $tag_list = getDynamicTagList(2);
        $type_list = getDynamicTypeKeyList();
        $type_list1 = getDynamicTypeKeyList(2);
        $html = new \Home\Org\Html();
        switch ($method) {
            case 'show':
                $data = $db->select();
                foreach ($data as &$v) {
                    $v['tid'] = $tag_list[$v['tid']];
                    $v['type_key'] = $type_list1[$v['type_key']];
                    $v['caozuo'] = $this->createOperate(array(
                        array('act' => 'edit', 'id' => $v['id']),
                        array('act' => 'del', 'id' => $v['id']),
                    ), "dynamicPackageList");
                }
                $this->nav = array(
                    '上传动态包管理' => array('icon' => 'icon_grid', 'selected' => 1),
                    '添加' => array('link' => '/index.php?m=Home&c=Dynamic&a=dynamicPackageList&method=add', 'icon' => 'icon_add'),
                );
                $this->assign("data",$data);
                $this->assign("url",U('Dynamic/dynamicPackageList',array("method"=>"show")));
                $this->main = $this->fetch('Dynamic:dynamicPackageList');
                $this->_out();
                break;
            case 'add':
                if ($_POST) {
                    if (empty($_POST['version']) || empty($_POST['type_key'])) {
                        error('信息不完整');
                    }
                    if ($_POST['file_type'] == 1) {
                        if ($_FILES) {
                            //上传文件
                            if (isset($_FILES['efile'])) {
                                $file = $_FILES['efile'];
                                $new_name = date("YmdHis")."_".$file['name'];
                                if ($file['error'] === 0) {
                                    $path = self::$filepath;
                                    move_uploaded_file($file['tmp_name'], $path . $new_name);
                                    $arr['url'] = $_SERVER['HTTP_HOST']."/Uploads/dynamic/".$new_name;
                                    $arr['file_name'] = $new_name;
                                    $arr['file_md5'] = md5_file($path . $new_name);
                                } else {
                                    error('文件上传失败，请重新上传！');
                                }
                            }
                        }
                    } else if ($_POST['file_type'] == 2) {
                        $arr['url'] = trim($_POST['url']);
                        $arr['file_name'] = trim($_POST['file_name']);
                        $arr['file_md5'] = trim($_POST['file_md5']);
                    }
                    $arr['version'] = trim($_POST['version']);
                    $arr['main_class'] = trim($_POST['main_class']);
                    $arr['entry'] = trim($_POST['entry']);
                    $arr['process'] = trim($_POST['process']);
                    $type_key_tag = explode("_",$_POST['type_key']);
                    $arr['tid'] = $type_key_tag[0];
                    $arr['type_key'] = $type_key_tag[1];
                    $arr['add_time'] = date("Y-m-d H:i:s");//入库时间
                    $update = $db->add($arr);
                    if ($update) {
                        success('添加成功', U('Dynamic/dynamicPackageList'));
                    } else {
                        error('添加失败');
                    }
                }
                $this->assign('version', $html->createInput('text', 'version'));
                $this->assign('main_class', $html->createInput('text', 'main_class'));
                $this->assign('entry', $html->createInput('text', 'entry'));
                $this->assign('process', $html->createInput('text', 'process'));
                $this->assign('type_key', $html->createInput('select', 'type_key', null,$type_list));
                $this->assign('file_type', $html->createInput('radio', 'file_type',1,array("普通上传"=>1,"输入更新地址"=>2)));
                $this->assign('efile', $html->createInput('file', 'efile'));
                $this->nav = array(
                    '上传动态包管理' => array('link' => '/index.php?m=Home&c=Dynamic&a=dynamicPackageList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('Dynamic:dynamicPackageList_add');
                $this->_out();
                break;
            case 'edit':
                if ($_POST) {
                    if (empty($_POST['version']) || empty($_POST['type_key'])) {
                        error('信息不完整');
                    }
                    $id = I('post.id');
                    if ($_POST['file_type'] == 1) {
                        if ($_FILES) {
                            //上传文件
                            if (isset($_FILES['efile'])) {
                                $file = $_FILES['efile'];
                                $new_name = date("YmdHis")."_".$file['name'];
                                if ($file['error'] === 0) {
                                    $path = self::$filepath;
                                    move_uploaded_file($file['tmp_name'], $path . $new_name);
                                    $arr['url'] = $_SERVER['HTTP_HOST']."/Uploads/dynamic/".$new_name;
                                    $arr['file_name'] = $new_name;
                                    $arr['file_md5'] = md5_file($path . $new_name);
                                } else {
                                    error('文件上传失败，请重新上传！');
                                }
                            }
                        }
                    } else if ($_POST['file_type'] == 2) {
                        $arr['url'] = trim($_POST['url']);
                        $arr['file_name'] = trim($_POST['file_name']);
                        $arr['file_md5'] = trim($_POST['file_md5']);
                    }
                    $arr['version'] = trim($_POST['version']);
                    $arr['main_class'] = trim($_POST['main_class']);
                    $arr['entry'] = trim($_POST['entry']);
                    $arr['process'] = trim($_POST['process']);
                    $type_key_tag = explode("_",$_POST['type_key']);
                    $arr['tid'] = $type_key_tag[0];
                    $arr['type_key'] = $type_key_tag[1];
                    $arr['update_time'] = date("Y-m-d H:i:s");//修改时间
                    $update = $db->where("id=$id")->save($arr);
                    if ($update) {
                        success('修改成功', U('Dynamic/dynamicPackageList'));
                    } else {
                        error('修改失败');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $this->assign('id', $id);
                $this->assign('version', $html->createInput('text', 'version', $data['version']));
                $this->assign('main_class', $html->createInput('text', 'main_class', $data['main_class']));
                $this->assign('entry', $html->createInput('text', 'entry', $data['entry']));
                $this->assign('process', $html->createInput('text', 'process', $data['process']));
                $this->assign('type_key', $html->createInput('select', 'type_key', $data['tid']."_".$data['type_key'],$type_list));
                $this->assign('file_type', $html->createInput('radio', 'file_type',0,array("不修改"=>0,"普通上传"=>1,"输入更新地址"=>2)));
                $this->nav = array(
                    '上传动态包管理' => array('link' => '/index.php?m=Home&c=Dynamic&a=dynamicPackageList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Dynamic&a=dynamicPackageList&method=add','icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Dynamic:dynamicPackageList_edit');
                $this->_out();
                break;
            case 'del':
                $id = I('id');
                $update = $db->where("id=$id")->delete();
                if ($update) {
                    success('删除成功', U('Dynamic/dynamicPackageList'));
                } else {
                    error('删除失败');
                }
                break;
            case 'ajax':
                $file_type = I('file_type');
                if ($file_type == 1) {
                    $str = "<li><div class=\"l\">文件：</div><div class=\"r\">".$html->createInput('file', 'efile')."</div></li>";
                    echo $str;exit;
                } else if ($file_type == 2) {
                    $str = "<li><div class=\"l\">更新地址：</div><div class=\"r\">".$html->createInput('textarea', 'url')."</div></li>";
                    $str .= "<li><div class=\"l\">文件名称：</div><div class=\"r\">".$html->createInput('textarea', 'file_name')."</div></li>";
                    $str .= "<li><div class=\"l\">文件MD5：</div><div class=\"r\">".$html->createInput('textarea', 'file_md5')."</div></li>";
                    echo $str;exit;
                } else if ($file_type == 0) {
                    $str = "";
                    echo $str;exit;
                }
        }
    }

    //动态包管理->动态更新记录
    function dynamicUpdateList() {
        if (!hasAsoRole('DULO')) error(ERROR_MSG);
        $method = $_GET['method'] ? $_GET['method'] : 'show';
        $db = M('dynamic_update_mst', null, C('DB_ASO_DATA'));
        $tag_list = getDynamicTagList(2);
        $type_list = getDynamicTypeKeyList();
        $type_list1 = getDynamicTypeKeyList(2);
        $html = new \Home\Org\Html();
        switch ($method) {
            case 'show':
                $data = $db->select();
                foreach ($data as &$v) {
                    $v['tid'] = $tag_list[$v['tid']];
                    $v['type_key'] = $type_list1[$v['type_key']];
                    $v['caozuo'] = $this->createOperate(array(
                        array('act' => 'edit', 'id' => $v['id']),
                        array('act' => 'del', 'id' => $v['id']),
                    ), "dynamicUpdateList");
                }
                $this->nav = array(
                    '动态更新记录' => array('icon' => 'icon_grid', 'selected' => 1),
                    '添加' => array('link' => '/index.php?m=Home&c=Dynamic&a=dynamicUpdateList&method=add', 'icon' => 'icon_add'),
                );
                $this->assign("data",$data);
                $this->assign("url",U('Dynamic/dynamicUpdateList',array("method"=>"show")));
                $this->main = $this->fetch('Dynamic:dynamicUpdateList');
                $this->_out();
                break;
            case 'add':
                if ($_POST) {
                    if (empty($_POST['sid_part']) || empty($_POST['sdk_version']) || empty($_POST['dynamic_version']) || empty($_POST['type_key'])) {
                        error('信息不完整');
                    }
                    $type_key_tag = explode("_",$_POST['type_key']);
                    $arr['tid'] = $type_key_tag[0];
                    $arr['type_key'] = $type_key_tag[1];
                    $arr['version'] = trim($_POST['version']);
                    $arr['sid_part'] = trim($_POST['sid_part']);
                    $arr['sdk_version'] = trim($_POST['sdk_version']);
                    $arr['sdk_version'] = str_replace("，", ",", $arr['sdk_version']);
                    $arr['dynamic_version'] = trim($_POST['dynamic_version']);
                    $arr['dynamic_version'] = str_replace("，", ",", $arr['dynamic_version']);
                    $arr['score'] = trim($_POST['score']);
                    $arr['memo'] = trim($_POST['memo']);
                    $arr['add_time'] = date("Y-m-d H:i:s");//入库时间
                    $update = $db->add($arr);
                    if ($update) {
                        success('添加成功', U('Dynamic/dynamicUpdateList'));
                    } else {
                        error('添加失败');
                    }
                }
                $this->assign('sid_part', $html->createInput('textarea', 'sid_part'));
                $this->assign('sdk_version', $html->createInput('text', 'sdk_version'));
                $this->assign('dynamic_version', $html->createInput('text', 'dynamic_version'));
                $this->assign('type_key', $html->createInput('select', 'type_key', null,$type_list));
                $this->assign('score', $html->createInput('text', 'score'));
                $this->assign('memo', $html->createInput('textarea', 'memo'));
                $this->nav = array(
                    '动态更新记录' => array('link' => '/index.php?m=Home&c=Dynamic&a=dynamicUpdateList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('Dynamic:dynamicUpdateList_add');
                $this->_out();
                break;
            case 'edit':
                if ($_POST) {
                    if (empty($_POST['sid_part']) || empty($_POST['sdk_version']) || empty($_POST['dynamic_version']) || empty($_POST['type_key'])) {
                        error('信息不完整');
                    }
                    $id = I('post.id');
                    $type_key_tag = explode("_",$_POST['type_key']);
                    $arr['tid'] = $type_key_tag[0];
                    $arr['type_key'] = $type_key_tag[1];
                    $arr['version'] = trim($_POST['version']);
                    $arr['sid_part'] = trim($_POST['sid_part']);
                    $arr['sdk_version'] = trim($_POST['sdk_version']);
                    $arr['sdk_version'] = str_replace("，", ",", $arr['sdk_version']);
                    $arr['dynamic_version'] = trim($_POST['dynamic_version']);
                    $arr['dynamic_version'] = str_replace("，", ",", $arr['dynamic_version']);
                    $arr['score'] = trim($_POST['score']);
                    $arr['memo'] = trim($_POST['memo']);
                    $arr['update_time'] = date("Y-m-d H:i:s");//修改时间
                    $update = $db->where("id=$id")->save($arr);
                    if ($update) {
                        success('修改成功', U('Dynamic/dynamicUpdateList'));
                    } else {
                        error('修改失败');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $version_data = M('dynamic_package_mst')->where("type_key=".$data['type_key'])->select();
                foreach ($version_data as $val) {
                    $version_list[$val['version']] = $val['version'];
                }
                $this->assign('id', $id);
                $this->assign('sid_part', $html->createInput('textarea', 'sid_part', $data['sid_part']));
                $this->assign('sdk_version', $html->createInput('text', 'sdk_version', $data['sdk_version']));
                $this->assign('dynamic_version', $html->createInput('text', 'dynamic_version', $data['dynamic_version']));
                $this->assign('type_key', $html->createInput('select', 'type_key', $data['tid']."_".$data['type_key'],$type_list));
                $this->assign('version', $html->createInput('select', 'version', $data['version'],$version_list));
                $this->assign('score', $html->createInput('text', 'score', $data['score']));
                $this->assign('memo', $html->createInput('textarea', 'memo', $data['memo']));
                $this->nav = array(
                    '动态更新记录' => array('link' => '/index.php?m=Home&c=Dynamic&a=dynamicUpdateList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Dynamic&a=dynamicUpdateList&method=add','icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Dynamic:dynamicUpdateList_edit');
                $this->_out();
                break;
            case 'del':
                $id = I('id');
                $update = $db->where("id=$id")->delete();
                if ($update) {
                    success('删除成功', U('Dynamic/dynamicUpdateList'));
                } else {
                    error('删除失败');
                }
                break;
            case 'ajax':
                $file_type = I('file_type');
                $file_type_data = explode("_",$file_type);
                $version_data = M('dynamic_package_mst')->where("type_key=".$file_type_data[1])->select();
                foreach ($version_data as $val) {
                    $version_list[$val['version']] = $val['version'];
                }
                $str = "<li><div class=\"l\">版本：</div><div class=\"r\">".$html->createInput('select', 'version',null,$version_list)."</div></li>";
                echo $str;exit;
        }
    }

    //立即更新任务
    function update_dynamic_redis() {
        $option = $_POST['option'];
        if ($option == "update") {
            $files = getUrlData("http://36.7.151.221:8085/dynamic/get_dynamic_update_list");
        }
        echo '更新Redis成功';exit;
    }
}