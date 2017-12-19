<?php
/**
 * 任务管理
 */
namespace Home\Controller;

use Home\Org\Html;
use Think\controller;

define('HOST_URL', 'http://36.7.151.221:8086/');

class TaskController extends RoleController
{

    function createOperate($array, $control) {
        $caozuo = '';
        foreach ($array as $v) {
            if ($v['act'] == 'edit')
                $caozuo .= '<a href="' . U('Task/' . $control, array('method' => 'edit', 'id' => $v['id'])) . '"><span class="icon_edit" title="修改"></span></a> ';
            if ($v['act'] == 'edit_one')
                $caozuo .= '<a href="' . U('Task/' . $control, array('method' => 'edit_one', 'id' => $v['id'])) . '"><span class="icon_edit" title="修改"></span></a> ';
            if ($v['act'] == 'del')
                $caozuo .= '<a href="' . U('Task/' . $control, array('method' => 'del', 'id' => $v['id'])) . '" onclick="javascript:return confirm(\'你确定要删除id为' . $v['id'] . '的数据吗?\')"><span class="icon_delete" title="删除"></span></a> ';
            if ($v['act'] == 'del_one')
                $caozuo .= '<a href="' . U('Task/' . $control, array('method' => 'del_one', 'id' => $v['id'])) . '" onclick="javascript:return confirm(\'你确定要删除id为' . $v['id'] . '的数据吗?\')"><span class="icon_delete" title="删除"></span></a> ';
            if ($v['act'] == 'copy')
                $caozuo .= '<a href="' . U('Task/' . $control, array('method' => 'copy', 'id' => $v['id'])) . '"><span class="icon_star" title="复制"></span></a> ';
        }
        return $caozuo;
    }

    //普通的按钮切换
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

    //无颜色的任务组按钮切换
    function creatAjaxRadio4($table, $field, $id, $value, $array = array())
    {
        if ($value == 0) {
            $class0 = "ajax_self";
            $class1 = "ajax_self";
        } else if ($value == 1) {
            $class0 = "ajax_self";
            $class1 = "ajax_self";
        }
        if (!empty($array)) {
            $arr = array_flip($array);
            $str = "<span class=\"{$class0}\" ajax=\"/index.php?m=Home&c=Ajax&a=index&table={$table}&key={$field}&value=0&id={$id}\">" . $arr[0] . "</span> <span class=\"{$class1}\" ajax=\"/index.php?m=Home&c=Ajax&a=index&table={$table}&key={$field}&value=1&id={$id}\">" . $arr[1] . "</span> </td>";
        } else {
            $str = "<span class=\"{$class0}\" ajax=\"/index.php?m=Home&c=Ajax&a=index&table={$table}&key={$field}&value=0&id={$id}\">否</span> <span class=\"{$class1}\" ajax=\"/index.php?m=Home&c=Ajax&a=index&table={$table}&key={$field}&value=1&id={$id}\">是</span> </td>";
        }
        return $str;
    }

    //Iphone管理->应用管理
    public function appManager()
    {
        if (!hasAsoRole('GGAMES,GGAMEO')) error(ERROR_MSG);
        $method = $_GET['method'] ? $_GET['method'] : 'show';
        $html = new \Home\Org\Html();
        $db = M('google_app_config');
        switch ($method) {
            case 'show':
                $tableName = 'google_app_config';
                $searchArr = array(
                    '搜索' => array(
                        'CP名称：' => array('name' => 'cp_name', 'type' => 'select','data'=>getCpList()),
                        '游戏名称：' => array('name' => 'game_name', 'type' => 'text', 'sign' => 'like'),
                        '包名：' => array('name' => 'package_name', 'type' => 'text'),
						'是否抓关键字：' => array('name' => 'gkw', 'type' => 'select','data'=>getGkwList()),
                    )
                );
                $searchHtml = TableController::createSearch1($tableName, $searchArr);
                //分页
                $wh = IphoneController::getWhereConfig($tableName);
                $count = $db->where($wh)->count();
                $pagesize = 100;
                $parameter = TableController::getGlobalWhere1($tableName) ? merge($_GET, array('where' => TableController::getGlobalWhere1($tableName))) : '';
                $page = new \Home\Org\Page($count, $pagesize, $parameter);
                $data = $db->where($wh)->order('id desc')->limit($page->firstRow, $page->listRows)->select();
                $pager = $page->show();
                $this->pager = '<div class="pager">' . $pager . '</div>';
                //数据处理
                foreach ($data as &$v) {
                    if (!hasAsoRole('GGAMEO')) {
                        $v['status'] = parseYn($v['status']);
                        $v['zhankai'] = "";
                        $v['caozuo'] = "";
                    } else {
                        $v['status'] = IphoneController::creatAjaxRadio2("google_app_config", "status", $v['id'], $v['status']);
						$v['gkw'] = IphoneController::creatAjaxRadio2("google_app_config", "gkw", $v['id'], $v['gkw']);
                        $v['zhankai'] = "<span class=\"open_group success_log_field\" attr='{$v['id']}'>展开</span>";
                        $v['caozuo'] = $this->createOperate(array(
                            array('act' => 'edit', 'id' => $v['id']),
                            //array('act' => 'del', 'id' => $v['id']),
                        ), "appManager");
                    }
                }
                $this->assign('data', $data);
                if (!hasAsoRole('GGAMEO')) {
                    $this->nav = array(
                        '应用列表' => array('icon' => 'icon_grid', 'selected' => 1),
                    );
                } else {
                    $this->nav = array(
                        '应用列表' => array('icon' => 'icon_grid', 'selected' => 1),
                        '添加' => array('link' => '/index.php?m=Home&c=Task&a=appManager&method=add', 'icon' => 'icon_add'),
                        '批量添加' => array('link' => '/index.php?m=Home&c=Task&a=appManager&method=import', 'icon' => 'icon_add'),
                    );
                }
                $this->main = $searchHtml . $this->fetch('Task:appManager');
                $this->_out();
                break;
            case 'add':
                if (!hasAsoRole('GGAMEO')) error(ERROR_MSG);
                if ($_POST) {
                    $arr['game_name'] = trim($_POST['game_name']);
                    $arr['package_name'] = trim($_POST['package_name']);
                    $arr['cp_name'] = $_POST['cp_name'];
                    $arr['add_time'] = date('Y-m-d H:i:s');
                    $arr['update_time'] = date('Y-m-d H:i:s');
                    $find = $db->where("game_name='{$arr['game_name']}' OR package_name='{$arr['package_name']}'")->find();
                    if ($find) {
                        error('添加失败,应用已存在！');
                    }
                    $addResult = $db->add($arr);
                    if ($addResult) {
                        success('添加成功', U('Task/appManager'));
                    } else {
                        error('添加失败');
                    }
                }
                $this->assign('game_name', $html->createInput('text', 'game_name'));
                $this->assign('package_name', $html->createInput('text', 'package_name'));
                $this->assign('cp_name', $html->createInput('selected', 'cp_name', null, getCpList()));
                $this->nav = array(
                    '应用列表' => array('link' => '/index.php?m=Home&c=Task&a=appManager&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                    '批量添加' => array('link' => '/index.php?m=Home&c=Task&a=appManager&method=import', 'icon' => 'icon_add'),
                );
                $this->main = $this->fetch('Task:appManager_add');
                $this->_out();
                break;
            case 'edit':
                if (!hasAsoRole('GGAMEO')) error(ERROR_MSG);
                if ($_POST) {
					$arr['game_id'] = trim($_POST['game_id']);
                    $arr['game_name'] = trim($_POST['game_name']);
                    $arr['cp_name'] = $_POST['cp_name'];
                    $arr['update_time'] = date('Y-m-d H:i:s');
                    $id = I('post.id');
                    $find = $db->where("id != {$id} and (game_name='{$arr['game_name']}' or package_name='{$arr['package_name']}')")->find();
                    if ($find) {
                        if ($find['game_name'] == $arr['game_name']) {
                            error('修改失败,游戏名称已存在！');
                        } elseif ($find['package_name'] == $arr['package_name']) {
                            error('修改失败,包名已存在！');
                        }
                    }
                    $update = $db->where("id=$id")->save($arr);
                    if ($update) {
                        success('修改成功', U('Task/appManager'));
                    } else {
                        error('修改失败');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $this->assign('id', $id);
				$this->assign('game_id', $html->createInput('text', 'game_id', $data['game_id']));
                $this->assign('game_name', $html->createInput('text', 'game_name', $data['game_name']));
                $this->assign('cp_name', $html->createInput('selected', 'cp_name', $data['cp_name'], getCpList()));
                $this->nav = array(
                    '应用列表' => array('link' => '/index.php?m=Home&c=Task&a=appManager&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Task&a=appManager&method=add', 'icon' => 'icon_add'),
                    '批量添加' => array('link' => '/index.php?m=Home&c=Task&a=appManager&method=import', 'icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:appManager_edit');
                $this->_out();
                break;
            case 'del':
                if (!hasAsoRole('GGAMEO')) error(ERROR_MSG);
                $id = I('id');
                $update = $db->where("id=$id")->delete();
                if ($update) {
                    success('删除成功', U('Task/appManager'));
                } else {
                    error('删除失败');
                }
                break;
            case 'import':
                if ($_FILES) {
                    if(isset($_FILES['efile']))
                    {
                        $file = $_FILES['efile'];
                        if($file['error']===0)
                        {
                            $cp_data = M("google_cp_config")->select();
                            foreach($cp_data as $v){
                                $cp_list[$v['cid']] = $v['name'];
                            }
                            import('@.Org.ReadExcel');
                            $reader = new \ReadExcel();
                            $data = $reader->readstr($file['tmp_name'], substr($file['name'], strrpos($file['name'],'.')+1),'A',1,'C');
                            if(!empty($data))
                            {
                                $s = $f = 0;
                                foreach($data as $v)
                                {
                                    if (!trim($v['0']) || !trim($v['1']) || !trim($v['2'])) {
                                        $f++;
                                        continue;
                                    }
                                    $arr['game_name'] = trim($v['0']);
                                    $arr['package_name'] = trim($v['1']);
                                    $cp_name = trim($v['2']);
                                    $arr['cp_name'] = $cp_list[$cp_name];
                                    $arr['add_time'] = date('Y-m-d H:i:s');
                                    $arr['update_time'] = date('Y-m-d H:i:s');
                                    $addResult = $db->add($arr);
                                    if ($addResult) {
                                        $s++;
                                    } else {
                                        $f++;
                                    }
                                }
                                success("导入数据 成功{$s}条，失败{$f}条", U('Task/appManager'));
                            }
                            else
                                error('上传文件为空');
                        }
                        else
                            error('文件上传失败，请重新上传');
                    }
                }
                $this->assign('efile', $html->createInput('file', 'efile'));//文件
                $this->nav = array(
                    '应用列表' => array('link' => '/index.php?m=Home&c=Task&a=appManager&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Task&a=appManager&method=add', 'icon' => 'icon_add'),
                    '批量添加' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:appManager_import');
                $this->_out();
                break;
        }
    }

    //Iphone管理->组任务管理
    function taskManager() {
        if (!hasAsoRole('GTASKS,GTASKO,GTASKO1')) error(ERROR_MSG);
        $html = new \Home\Org\Html();
        $method = I('get.method') ? I('get.method') : 'show';
        $db = M('google_task_config');
        $group_db = M('google_task_group');
        $tag_list = getTaskTagList(2);
        $country_table_tmp = M("country_table_mst")->select();
        $country_table_tmp_list = array();
        foreach ($country_table_tmp as $val) {
            $country_table_tmp_list[$val['table_name']] = $val['table_name'];
        }
        //获得评论组
        $comment_group_data = M('account_comment_log')->select();
        foreach ($comment_group_data as $val) {
            $comment_group_list[$val['title']] = $val['id'];
        }
        switch ($method) {
            case 'show':
                $tableName = 'google_task_group';

                $task_status_list = array(
                    '不限' => 0,
                    '正在执行' => 1,
                    '已完成' => 2,
                    '未执行' => 3,
                );

                $tast_status = $_GET['task_status'];
                $this->assign('task_status', $tast_status);
                unset($_GET['task_status'], $_GET['task_status_sign']);

                $admin_name = getAdminName();
                if ($admin_name == "汪涛") {
                    $cp_list = array("耿明游戏"=>"耿明游戏");
                } else {
                    $cp_list = getCpList();
                }
                
                $searchArr = array(
                    '搜索' => array(
                        'TAG' => array('name' => 'tag', 'type' => 'select', 'data' => getTaskTagList()),
                        'CP' => array('name' => 'cp', 'type' => 'select', 'data' => getCpList()),
                        '游戏' => array('name' => 'package_name', 'type' => 'select', 'data' => getGameList()),
                        '任务类型' => array('name' => 'task_type', 'type' => 'select', 'data' => getTaskTypeList()),
						'账号国家：' => array('name' => 'country', 'type' => 'select','data'=>getCountryList()),
                        '任务标题' => array('name' => 'task_name', 'type' => 'text'),
                        '包名' => array('name' => 'package_name', 'type' => 'text'),
                        '任务状态：' => array('name' => 'task_status', 'type' => 'select', 'data'=> $task_status_list),
                    )
                );
                $searchHtml = TableController::createSearch1($tableName, $searchArr);
                //分页
                $wh = IphoneController::getWhereConfig($tableName);

                if($tast_status == 1){
                    $tmp_task_sql = "SELECT `groupid` FROM google_task_config WHERE `start` <= '" . date('Y-m-d H:i:s') . "' AND '" . date('Y-m-d H:i:s') . "' <= `end` AND `status` = 1";

                }elseif($tast_status == 2){
                    $tmp_task_sql = "SELECT `groupid` FROM google_task_config WHERE '" . date('Y-m-d H:i:s') . "' > `end` AND `status` = 1";
                }elseif($tast_status == 3){
                    $tmp_task_sql = "SELECT `groupid` FROM google_task_config WHERE '" . date('Y-m-d H:i:s') . "' > `start` AND `status` = 1";
                }

                if($tast_status){
                    $tmp_task_list = M()->query($tmp_task_sql);
                    if($tmp_task_list){
                        $temp_group_ids = array();
                        foreach ($tmp_task_list as $val){
                            $temp_group_ids[] = intval($val['groupid']);
                        }
                        $temp_where = " id IN (" . implode(',', $temp_group_ids) . ")";
                        unset($temp_group_ids);
                    }else{
                        $temp_where = " 1 = 0 ";
                    }
                    unset($tmp_task_list);
                }

                if ($admin_name == "汪涛") {
                    if($wh != ''){
                        $wh .= " AND ";
                    }
                    $wh .= "cp = '耿明游戏'";
                }

                if($temp_where != ''){
                    if($wh != ''){
                        $wh .= ' AND ';
                    }
                    $wh .= $temp_where;
                }

                if($admin_name == 'admin'){
                    //echo $wh;exit;
                }

                $count = $group_db->where($wh)->count();
                $pagesize = 300;
                $parameter = TableController::getGlobalWhere($tableName) ? merge($_GET, array('where' => TableController::getGlobalWhere($tableName))) : '';
                $page = new \Home\Org\Page($count, $pagesize, $parameter);
                $data = $group_db->where($wh)->order('id desc')->limit($page->firstRow, $page->listRows)->select();
                $pager = $page->show();
                $this->pager = '<div class="pager">' . $pager . '</div>';
                $task_type_list = getTaskTypeList(2);
                $get_game_list = getGameList(4);
                $country_language_list = getCountryLanguage(2);
                $now_time = time();
				$db_2=M("google_app_config");
                foreach ($data as $key => &$v) {
                    $v['task_type'] = $task_type_list[$v['task_type']];
                    $v['tag'] = $tag_list[$v['tag']];
                    $old_package_name = $v['package_name'];
                    //$v['package_name'] = $get_game_list[$v['package_name']];
					$data_2=array();
					$data_2=$db_2->field('game_name')->where('status=1 and package_name=\''.$v['package_name'].'\'')->select();
					$v['game_name']=$data_2[0]['game_name'];
					$v['package_name'] = "<a href='https://www.appannie.com/apps/google-play/app/{$old_package_name}/app-ranking' target='_blank'>{$old_package_name}</a>";
					
                    //$v['country'] = $country_language_list[$v['country'] . '#' . $v['language']];
                    if (strtotime($v['group_start']) <= $now_time && strtotime($v['group_end']) >= $now_time) {
                        $v['group_start'] = "<span style='color:red'>" . $v['group_start'] . "</span>";
                        $v['group_end'] = "<span style='color:red'>" . $v['group_end'] . "</span>";
                    } else if (strtotime($v['group_start']) > $now_time) {
                        $v['group_start'] = "<span style='color:blue'>" . $v['group_start'] . "</span>";
                        $v['group_end'] = "<span style='color:blue'>" . $v['group_end'] . "</span>";
                    } else if (strtotime($v['group_end']) < $now_time) {
                        $v['group_start'] = "<span style='color:orange'>" . $v['group_start'] . "</span>";
                        $v['group_end'] = "<span style='color:orange'>" . $v['group_end'] . "</span>";
                    } else {
                        $v['group_start'] = $v['group_start'];
                        $v['group_end'] = $v['group_end'];
                    }

                    //TODO 处理子任务id获取任务的下发数 提交数 成功数
                    $task_ids = explode(',', $v['ids']);
                    $get_total_count = M()->query("SELECT SUM(count) AS t FROM google_task_config WHERE id IN ({$v['ids']})");
                    $v['total_count'] = $get_total_count[0]['t'];
                    foreach ($task_ids as $config_task_id){
                        $v['issued_nums'] += getRedis()->get("protocol_issue_task_id_{$config_task_id}");    //下发数
                        $v['success_nums'] += getRedis()->get("app_task_success_nums_id_{$config_task_id}"); //成功数
                        $v['rate_success'] += getRedis()->get("pro_task_comment_success#{$config_task_id}");  //评论成功数
                        $hTaskAll = getRedis()->hGet("google_pro_task@{$config_task_id}");
                        if($hTaskAll){
                            $totalNums = 0;
                            foreach ($hTaskAll as $resKey => $count){
                                $totalNums += $count;
                            }
                            $v['submit_nums'] += $totalNums;
                        }
                    }



                    $v['exception'] = '';
                    if (!empty($v['status_success'])) {
                        $status_success_arr = explode("/", $v['status_success']);
                        if ($status_success_arr[0] == $status_success_arr[1]) {
                            $v['exception'] = 'vpnException2';
                        }
                    }
                    if (!hasAsoRole('GTASKO1')) {
                        $v['status'] = parseYn($v['status']);
                    } else {
                        $v['status'] = $this->creatAjaxRadio4("google_task_group", "status", $v['id'], $v['status']);
                    }
                    if (!hasAsoRole('GTASKO')) {
                        $v['caozuo'] = $this->createOperate(array(
                            array('act' => 'edit', 'id' => $v['id']),
                        ), "taskManager");
                        $v['zhankai'] = "";
                        $v['link'] = "";
                    } else {
                        $v['caozuo'] = $this->createOperate(array(
                            array('act' => 'del', 'id' => $v['id']),
                        ), "taskManager");
                        $v['zhankai'] = "<span class=\"open_group success_log_field\" attr='{$v['id']}'>展开</span>";
                        $v['link'] = "<a href='https://www.appannie.com/apps/google-play/app/{$old_package_name}/app-ranking' target='_blank'>跳转</a>";
                    }
                }
                $this->assign('data', $data);
                if (!hasAsoRole('GTASKO')) {
                    $this->nav = array(
                        '组任务管理' => array('icon' => 'icon_grid', 'selected' => 1),
                    );
                } else {
                    $this->nav = array(
                        '组任务管理' => array('icon' => 'icon_grid', 'selected' => 1),
                        '添加组任务' => array('link' => '/index.php?m=Home&c=Task&a=taskManager&method=add', 'icon' => 'icon_add'),
                        '批量添加' => array('link' => '/index.php?m=Home&c=Task&a=taskManager&method=import', 'icon' => 'icon_add'),
                    );
                }
                $this->main = $searchHtml . $this->fetch('Task:taskManager');
                $this->_out();
                break;
            case 'add':
                if (!hasAsoRole('GTASKO')) error(ERROR_MSG);
                if ($_POST) {
                    if (empty($_POST['package_name'])) {
                        error('未选择包名');
                    }
                    $count = $_POST['count'];
                    $start = $_POST['start'];
                    $end = $_POST['end'];
                    $keyword = $_POST['keyword'];
                    $is_average = $_POST['is_average'];
                    $comment_start_id = $_POST['comment_start_id'];
                    $arr['cp'] = $_POST['cp'];
                    $package_name_arr = explode("##",$_POST['package_name']);
                    $arr['package_name'] = $package_name_arr[2];
                    $arr['game_id'] = $package_name_arr[0];
                    $arr['task_name'] = trim($_POST['task_name']);
                    $arr['task_type'] = $_POST['task_type'];
                    $country_language = explode('#', $_POST['country']);
                    $arr['country'] = trim($country_language[0]);
                    $arr['language'] = trim($country_language[1]);
                    if($_POST['language']){
                        $language_arr = explode('#', $_POST['language']);
                        $arr['language'] = trim($language_arr[1]);
                    }

                    $arr['table_name'] = trim($_POST['table_name']);
                    $arr['tag'] = $_POST['tag'];
                    $arr['score'] = trim($_POST['score']);
                    $arr['comment_rate'] = trim($_POST['comment_rate']);
                    $arr['star'] = trim($_POST['star']);
                    $arr['answer_amount'] = trim($_POST['answer_amount']);
                    $arr['comment_detail'] = trim($_POST['comment_detail']);
                    $arr['comment_type'] = intval($_POST['comment_type']);
                    $arr['remark'] = trim($_POST['remark']);
                    $arr['add_time'] = date("Y-m-d H:i:s");
                    $arr['admin_name'] = getAdminName();
                    $arr['operate_type'] = "新增";
                    $update = $group_db->add($arr);
                    $s=$e=0;
                    if ($update) {
                        foreach ($keyword as $key => $val) {
                            $arr1 = $arr;
                            $val = trim($val);
                            $val = str_replace("，", ",", $val);
                            $keyword_sub_arr = explode(",",$val);
                            $arr1['count'] = $count[$key];
                            $arr1['start'] = $start[$key];
                            $arr1['end'] = $end[$key];
                            $arr1['groupid'] = $update;
                            $arr1['is_average'] = $is_average[$key];
                            $arr1['comment_start_id'] = $comment_start_id[$key];
                            foreach ($keyword_sub_arr as $val1) {
                                $val1 = trim($val1);
                                $arr1['keyword'] = $val1;
                                $update1 = $db->add($arr1);
                                if ($update1) {
                                    $s++;
                                } else {
                                    $e++;
                                }
                            }
                        }
                        $ids_str = "";
                        $success_count = 0;
                        $total_count = 0;
                        $group_count = 0;
                        $start = "";
                        $end = "";
                        $datas2 = $db->field("id,status,keyword,count,start,end")->where("groupid=" . $update)->order("start")->select();
                        foreach ($datas2 as $val) {
                            if (strtotime($start) > strtotime($val['start']) || $start == "") {
                                $start = $val['start'];
                            }
                            if (strtotime($end) < strtotime($val['end']) || $end == "") {
                                $end = $val['end'];
                            }
                            $group_count += $val['count'];
                            $ids_str .= $val['id'] . ",";
                            if ($val['status'] == 1) {
                                $success_count++;
                            }
                            $total_count++;
                        }
                        $ids_str = trim($ids_str, ",");
                        $arr1['ids'] = $ids_str;
                        $arr1['group_count'] = $group_count;
                        $arr1['group_start'] = $start;
                        $arr1['group_end'] = $end;
                        $arr1['status_success'] = $success_count . "/" . $total_count;
                        $group_db->where("id=" . $update)->save($arr1);
                        success('添加组成功' . $s . '个,失败' . $e . '个', U('Task/taskManager'));
                    } else {
                        error('添加组失败');
                    }
                }
                $this->assign('cp', $html->createInput('select', 'cp', null, getCpList()));
                $this->assign('package_name', $html->createInput('selected', 'package_name', null, getGameList(2)));
                $this->assign('task_name', $html->createInput('text', 'task_name'));
                $this->assign('task_type', $html->createInput('selected', 'task_type', null, getTaskTypeList()));
                $this->assign('country', $html->createInput('selected', 'country', null, getCountryLanguage()));
                $this->assign('language', $html->createInput('selected', 'language', null, getCountryLanguage()));
                $this->assign('table_name', $html->createInput('select', 'table_name', null, $country_table_tmp_list));
                $this->assign('tag', $html->createInput('selected', 'tag', null, getTaskTagList()));
                $this->assign('score', $html->createInput('text', 'score'));
                $this->assign('remark', $html->createInput('textarea', 'remark'));
                $this->assign('count', $html->createInput('text', 'count[]',null,null,"style='width:75px'"));
                $this->assign('start', $html->createInput('text', 'start[]',date("Y-m-d 16:00:00")));
                $this->assign('end', $html->createInput('text', 'end[]',date("Y-m-d 15:59:00",time()+86400)));
                $this->assign('is_average', $html->createInput('selected', 'is_average[]',null,C('YESORNO')));
                $this->assign('keyword', $html->createInput('textarea', 'keyword[]', null, null, array('cols' => '40', 'rows' => '1')));
                $this->assign('comment_rate', $html->createInput('text', 'comment_rate'));
                $this->assign('comment_type', $html->createInput('selected', 'comment_type', null,C('COMMENTTYPE')));
                $this->assign('star', $html->createInput('text', 'star'));
                $this->assign('answer_amount', $html->createInput('text', 'answer_amount'));
                $this->assign('comment_detail', $html->createInput('textarea', 'comment_detail'));
                $this->assign('comment_start_id', $html->createInput('select', 'comment_start_id[]',null,$comment_group_list));

                $this->nav = array(
                    '组任务管理' => array('link' => '/index.php?m=Home&c=Task&a=taskManager&method=show', 'icon' => 'icon_grid'),
                    '添加组任务' => array('icon' => 'icon_add', 'selected' => 1),
                    '批量添加' => array('link' => '/index.php?m=Home&c=Task&a=taskManager&method=import', 'icon' => 'icon_add'),
                );
                $this->main = $this->fetch('Task:taskManager_add');
                $this->_out();
                break;
            case 'edit_one':
                if (!hasAsoRole('GTASKO')) error(ERROR_MSG);
                if ($_POST) {
                    if (empty($_POST['package_name'])) {
                        error('未选择包名');
                    }
                    if (empty($_POST['count'])) {
                        error('未填写次数');
                    }
                    $arr['cp'] = $_POST['cp'];
                    $package_name_arr = explode("##",$_POST['package_name']);
                    $arr['package_name'] = $package_name_arr[1];
                    $arr['game_id'] = $package_name_arr[0];
                    $arr['task_name'] = trim($_POST['task_name']);
                    $arr['task_type'] = trim($_POST['task_type']);
                    $country_language = explode('#', $_POST['country']);
                    $arr['country'] = trim($country_language[0]);
                    $arr['language'] = trim($_POST['language']);
                    $arr['table_name'] = trim($_POST['table_name']);
                    $arr['tag'] = $_POST['tag'];
                    $arr['remark'] = trim($_POST['remark']);
                    $arr['keyword'] = trim($_POST['keyword']);
                    $arr['count'] = trim($_POST['count']);
                    $arr['start'] = trim($_POST['start']);
                    $arr['end'] = trim($_POST['end']);
                    $arr['is_average'] = $_POST['is_average'];
                    $arr['comment_rate'] = $_POST['comment_rate'];
                    $arr['comment_type'] = $_POST['comment_type'];
                    $arr['star'] = $_POST['star'];
                    $arr['answer_amount'] = $_POST['answer_amount'];
                    $arr['comment_detail'] = $_POST['comment_detail'];
                    $arr['comment_start_id'] = $_POST['comment_start_id'];
                    $arr['score'] = trim($_POST['score']);
                    $arr['update_time'] = date("Y-m-d H:i:s");
                    $arr['admin_name'] = getAdminName();
                    $arr['operate_type'] = "修改单条";
                    $id = I('post.id');
                    $update = $db->where("id=$id")->save($arr);
                    if ($update) {
                        $datas = $db->where("id=" . $id)->find();
                        //修改所在组状态
                        $ids_str = "";
                        $group_count = 0;
                        $datas2 = $db->where("groupid=" . $datas['groupid'])->select();
                        if (count($datas2) == 1) {
                            $arr1['group_start'] = $datas2[0]['start'];
                            $arr1['group_end'] = $datas2[0]['end'];
                            $arr1['package_name'] = $datas2[0]['package_name'];
                            $arr1['cp'] = $datas2[0]['cp'];
                            $arr1['game_id'] = $datas2[0]['game_id'];
                            $arr1['task_name'] = $datas2[0]['task_name'];
                            $arr1['task_type'] = $datas2[0]['task_type'];
                            $arr1['country'] = $datas2[0]['country'];
                            $arr1['language'] = $datas2[0]['language'];
                            $arr1['table_name'] = $datas2[0]['table_name'];
                            $arr1['tag'] = $datas2[0]['tag'];
                            $arr1['remark'] = $datas2[0]['remark'];
                            $arr1['keyword'] = $datas2[0]['keyword'];
                            $arr1['score'] = $datas2[0]['score'];
                            $arr1['admin_name'] = $datas2[0]['admin_name'];
                            $arr1['operate_type'] = $datas2[0]['operate_type'];
                            $arr1['ids'] = $datas2[0]['id'];
                            $arr1['group_count'] = $datas2[0]['count'];
                            $group_db->where("id=" . $datas['groupid'])->save($arr1);
                        } else {
                            foreach ($datas2 as $val) {
                                $group_count += $val['count'];
                                $ids_str .= $val['id'] . ",";
                            }
                            $ids_str = trim($ids_str, ",");
                            $arr1['ids'] = $ids_str;
                            $arr1['group_count'] = $group_count;
                            $group_db->where("id=" . $datas['groupid'])->save($arr1);
                        }
                        success('修改成功', U('Task/taskManager'));
                    } else {
                        error('修改失败');
                    }
                }
                $id = I('id');
                $this->assign('id', $id);
                $data = $db->where("id=$id")->find();
                $this->assign('cp', $html->createInput('select', 'cp', $data['cp'], getCpList()));
                $this->assign('package_name', $html->createInput('selected', 'package_name', $data['game_id'].'##'.$data['package_name'], getGameList(3)));
                $this->assign('task_name', $html->createInput('text', 'task_name',$data['task_name']));
                $this->assign('task_type', $html->createInput('selected', 'task_type', $data['task_type'], getTaskTypeList()));
                $this->assign('country', $html->createInput('select', 'country', $data['country'], getOnlyCountryList()));
                $this->assign('language', $html->createInput('selected', 'language', $data['language'], getCountryLanguage(2)));
                $this->assign('table_name', $html->createInput('select', 'table_name', $data['table_name'], $country_table_tmp_list));
                $this->assign('tag', $html->createInput('selected', 'tag', $data['tag'], getTaskTagList()));
                $this->assign('remark', $html->createInput('textarea', 'remark',$data['remark']));
                $this->assign('keyword', $html->createInput('text', 'keyword',$data['keyword']));
                $this->assign('count', $html->createInput('text', 'count',$data['count']));
                $this->assign('start', $html->createInput('datetime1', 'start',$data['start']));
                $this->assign('end', $html->createInput('datetime1', 'end',$data['end']));
                $this->assign('score', $html->createInput('text', 'score',$data['score']));
                $this->assign('is_average', $html->createInput('selected', 'is_average',$data['is_average'],C('YESORNO')));
                $this->assign('comment_rate', $html->createInput('text', 'comment_rate',$data['comment_rate']));
                $this->assign('comment_type', $html->createInput('selected', 'comment_type',$data['comment_type'],C('COMMENTTYPE')));
                $this->assign('star', $html->createInput('textarea', 'star',$data['star']));
                $this->assign('comment_detail', $html->createInput('textarea', 'comment_detail',$data['comment_detail']));
                $this->assign('comment_start_id', $html->createInput('select', 'comment_start_id',$data['comment_start_id'],$comment_group_list));
                $this->assign("answer_amount", $html->createInput('text', 'answer_amount', $data['answer_amount']));
                $this->nav = array(
                    '组任务管理' => array('link' => '/index.php?m=Home&c=Task&a=taskManager&method=show', 'icon' => 'icon_grid'),
                    '添加组任务' => array('link' => '/index.php?m=Home&c=Task&a=taskManager&method=add', 'icon' => 'icon_add'),
                    '批量添加' => array('link' => '/index.php?m=Home&c=Task&a=taskManager&method=import', 'icon' => 'icon_add'),
                    '修改单条' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:taskManager_edit_one');
                $this->_out();
                break;
            case 'del':
                if (!hasAsoRole('GTASKO')) error(ERROR_MSG);
                $id = I('id');
                $data = $db->where("status > 0 and groupid ={$id}")->find();
                if (!empty($data)) {
                    error('操作失败,有子任务正在进行中');
                } else {
                    $db->query("delete from google_task_config where groupid={$id}");
                    $group_db->query("delete from google_task_group where id={$id}");
                    success('删除成功', U('Task/taskManager'));
                }
                break;
            case 'del_one':
                if (!hasAsoRole('GTASKO')) error(ERROR_MSG);
                $id = I('id');
                $data = $db->where("id ={$id}")->find();
                if ($data['status'] > 0) {
                    error('操作失败,该任务正在进行中');
                } else {
                    $db->query("delete from google_task_config where id={$id}");
                    //修改所在组状态
                    $ids_str = "";
                    $group_count = 0;
                    $success_count = 0;
                    $total_count = 0;
                    $datas2 = $db->field("id,count,status")->where("groupid=" . $data['groupid'])->select();
                    if (!empty($datas2)) {
                        foreach ($datas2 as $val) {
                            $group_count += $val['count'];
                            $ids_str .= $val['id'] . ",";
                            if ($val['status'] == 1) {
                                $success_count++;
                            }
                            $total_count++;
                        }
                        $ids_str = trim($ids_str, ",");
                        $arr1['ids'] = $ids_str;
                        $arr1['group_count'] = $group_count;
                        $arr1['status_success'] = $success_count."/".$total_count;
                        if ($success_count == $total_count) {
                            $arr1['status'] = 1;
                        } else if ($success_count == 0) {
                            $arr1['status'] = 0;
                        }
                        $group_db->where("id=" . $data['groupid'])->save($arr1);
                    } else {
                        $group_db->query("delete from google_task_group where id={$data['groupid']}");
                    }
                    success('修改成功', U('Task/taskManager'));
                }
                break;
            case 'import':
                if ($_FILES) {
                    if(isset($_FILES['efile']))
                    {
                        $file = $_FILES['efile'];
                        if($file['error']===0)
                        {
                            import('@.Org.ReadExcel');
                            $reader = new \ReadExcel();
                            $data = $reader->readstr($file['tmp_name'], substr($file['name'], strrpos($file['name'],'.')+1),'A',1,'C');
                            if(!empty($data))
                            {
                                $get_country_language = getCountryLanguage();
                                $yes_or_no = C('YESORNO');
                                $pacakge_data = M("google_app_config")->select();
                                foreach($pacakge_data as $v){
                                    $package_name_list[$v['package_name']] = $v['id']."##".$v['game_name']."##".$v['package_name'];
                                }
                                $s=$e=$gs=$ge=0;
                                foreach($data as $v)
                                {
                                    if (!trim($v['0'])) {
                                        continue;
                                    }
                                    $arr['tag'] = trim($v['0']);
                                    $arr['cp'] = trim($v['1']);
                                    $package_name_arr = explode("##",$package_name_list[$v['2']]);
                                    $arr['package_name'] = $package_name_arr[2];
                                    $arr['game_id'] = $package_name_arr[0];
                                    $arr['task_name'] = trim($v['3']);
                                    $arr['task_type'] = trim($v['4']);
                                    $country_language = explode('#', $get_country_language[$v['5']]);
                                    $arr['country'] = trim($country_language[0]);
                                    $arr['language'] = trim($country_language[1]);
                                    if($v['19']){
                                        $language_arr = explode('#', $get_country_language[$v['19']]);
                                        $arr['language'] = $language_arr[1];
                                    }
                                    $arr['table_name'] = trim($v['6']);
                                    $arr['score'] = trim($v['7']);
                                    $arr['comment_rate'] = trim($v['8']);
                                    $arr['comment_type'] = trim($v['9']);
                                    $arr['star'] = trim($v['10']);
                                    $arr['comment_detail'] = trim($v['11']);
                                    $arr['remark'] = trim($v['12']);
                                    $arr['add_time'] = date("Y-m-d H:i:s");
                                    $arr['admin_name'] = getAdminName();
                                    $arr['operate_type'] = "批量新增";
                                    $arr1 = $arr;
                                    $arr['group_count'] = trim($v['13']);
                                    $arr['group_start'] = date("Y-m-d H:i:s",strtotime(trim($v['14'])));
                                    $arr['group_end'] = date("Y-m-d H:i:s",strtotime(trim($v['15'])));
                                    $update = $group_db->add($arr);
                                    if ($update) {
                                        $arr1['count'] = trim($v['13']);
                                        $arr1['start'] = date("Y-m-d H:i:s",strtotime(trim($v['14'])));
                                        $arr1['end'] = date("Y-m-d H:i:s",strtotime(trim($v['15'])));
                                        $arr1['keyword'] = trim($v['16']);
                                        $arr1['is_average'] = $yes_or_no[trim($v['17'])];
                                        $arr1['comment_start_id'] = $comment_group_list[trim($v['18'])];
                                        $arr1['groupid'] = $update;
                                        $update1 = $db->add($arr1);
                                        if ($update1) {
                                            $s++;
                                        } else {
                                            echo $db->getDbError();exit;
                                            $e++;
                                        }
                                        $ids_str = "";
                                        $success_count = 0;
                                        $total_count = 0;
                                        $group_count = 0;
                                        $start = "";
                                        $end = "";
                                        $datas2 = $db->field("id,status,keyword,count,start,end")->where("groupid=" . $update)->order("start")->select();
                                        foreach ($datas2 as $val3) {
                                            if (strtotime($start) > strtotime($val3['start']) || $start == "") {
                                                $start = $val3['start'];
                                            }
                                            if (strtotime($end) < strtotime($val3['end']) || $end == "") {
                                                $end = $val3['end'];
                                            }
                                            $group_count += $val3['count'];
                                            $ids_str .= $val3['id'] . ",";
                                            if ($val3['status'] == 1) {
                                                $success_count++;
                                            }
                                            $total_count++;
                                        }
                                        $ids_str = trim($ids_str, ",");
                                        $arr3['ids'] = $ids_str;
                                        $arr3['group_count'] = $group_count;
                                        $arr3['group_start'] = $start;
                                        $arr3['group_end'] = $end;
                                        $arr3['status_success'] = $success_count . "/" . $total_count;
                                        $group_db->where("id=" . $update)->save($arr3);
                                        $gs++;
                                    } else {
                                        $ge++;
                                    }
                                }
                                success("生成任务 成功{$s}条，失败{$e}条", U('Task/taskManager'));
                            }
                            else
                                error('上传文件为空');
                        }
                        else
                            error('文件上传失败，请重新上传');
                    }
                }
                $this->assign('efile', $html->createInput('file', 'efile'));//文件
                $this->nav = array(
                    '组任务管理' => array('link' => '/index.php?m=Home&c=Task&a=taskManager&method=show', 'icon' => 'icon_grid'),
                    '添加组任务' => array('link' => '/index.php?m=Home&c=Task&a=taskManager&method=add', 'icon' => 'icon_add'),
                    '批量添加' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:taskManager_import');
                $this->_out();
                break;
        }
    }

    //组任务管理展开弹窗
    function taskGroupDetailList() {
        $db = M('google_task_config');
        $now = time();
        $groupid = I('groupid');
        $data = $db->where("groupid = {$groupid}")->order('start desc')->select();
        $task_type_list = getTaskTypeList(2);
        $get_game_list = getGameList(4);
        $country_language_list = getCountryLanguage(2);
        $tag_list = getTaskTagList(2);
        foreach ($data as &$v) {
            $v['task_type'] = $task_type_list[$v['task_type']];
            $v['tag'] = $tag_list[$v['tag']];
            $v['send'] = getRedis()->get("protocol_issue_task_id_{$v['id']}");
            $v['success'] = getRedis()->get("app_task_success_nums_id_{$v['id']}");
            $v['error'] = $v['send']-$v['success'];
            $v['package_name'] = $get_game_list[$v['package_name']];
            $v['is_average'] = parseYn($v['is_average']);
            $v['country'] = $country_language_list[$v['country'] . '#' . $v['language']];
            if (!hasAsoRole('GTASKO1')) {
                $v['status'] = parseYn($v['status']);
            } else {
                $v['status'] = $this->creatAjaxRadio2("google_task_config", "status", $v['id'], $v['status']);
            }
            if (!hasAsoRole('GTASKO')) {
                $v['caozuo'] = "";
                $v['zhankai'] = "";
            } else {
                if (!hasAsoRole('GTASKO1')) {
                    $v['caozuo'] = $this->createOperate(array(
                        array('act' => 'edit_one', 'id' => $v['id']),
                        array('act' => 'del_one', 'id' => $v['id']),
                    ), "taskManager");
                } else {
                    $v['caozuo'] = $this->createOperate(array(
                        array('act' => 'edit_one', 'id' => $v['id']),
                        array('act' => 'del_one', 'id' => $v['id']),
                    ), "taskManager");
                }
                $v['zhankai'] = "<span class=\"open_group success_log_field\" attr='{$v['id']}'>展开</span>";
            }
        }
        $html = "<table><th>ID</th><th>tag</th><th>CP</th><th>包名</th><th>任务标题</th><th>关键词</th><th>数量</th><th>下发数</th><th>成功数</th><th>失败数</th><th>任务类型</th><th>开始/结束时间</th><th>国家语言</th><th>是否启用</th><th>是否平均</th><th>操作</th><th>备注</th><th>优先级</th><th>组id</th><th>评论概率</th><th>评论操作</th><th>最后操作</th>";
        foreach ($data as $val) {
            $html .= "<tr>";
            $html .= "<td>" . $val['id'] . "</td>";
            $html .= "<td>" . $val['tag'] . "</td>";
            $html .= "<td>" . $val['cp'] . "</td>";
            $html .= "<td><div style=\"overflow-y: scroll;width: 200px;height: 40px;white-space: normal;\">" . $val['package_name'] . "</div></td>";
            $html .= "<td>" . $val['task_name'] . "</td>";
            $html .= "<td>" . $val['keyword'] . "</td>";
            $html .= "<td>" . $val['count'] . "</td>";
            $html .= "<td>" . $val['send'] . "</td>";
            $html .= "<td>" . $val['success'] . "</td>";
            $html .= "<td>" . $val['error'] . "</td>";
            $html .= "<td>" . $val['task_type'] . "</td>";
            $html .= "<td>" . $val['start'] . "<br>" . $val['end'] . "</td>";
            $html .= "<td>" . $val['country'] . "</td>";
            $html .= "<td>" . $val['status'] . "</td>";
            $html .= "<td>" . $val['is_average'] . "</td>";
            $html .= "<td>" . $val['caozuo'] . "</td>";
            $html .= "<td>" . $val['remark'] . "</td>";
            $html .= "<td>" . $val['score'] . "</td>";
            $html .= "<td>" . $val['groupid'] . "</td>";
            $html .= "<td>" . $val['comment_rate'] . "</td>";
            $html .= "<td>" . $val['comment_type'] . "</td>";
            $html .= "<td>" . $val['admin_name'] . $val['operate_type'] . "</td>";
            $html .= "</tr>";
        }
        $html .= "</table>";
        echo $html;
        exit;
    }

    //CP联动游戏
    function gidSelectAjax() {
        $html = new \Home\Org\Html();
        $cp = I('cp');
        $type = I('type');
        $wh = "cp_name='{$cp}' and status=1";
        $game_list = M('google_app_config', null, C('DB_ASO_DATA'))->where($wh)->select();
        foreach ($game_list as $v) {
            if ($type == 2) {
                $cache[$v['game_name'] . '(' . $v['package_name'].')'] = $v['id']."##".$v['game_name']."##".$v['package_name'];
            } else if ($type == 3) {
                $cache[$v['game_name'] . '(' . $v['package_name'].')'] = $v['id']."##".$v['package_name'];
            } else {
                $cache[$v['game_name'] . '(' . $v['package_name'].')'] = $v['package_name'];
            }
        }
        $result = $html->createInput('select', 'package_name', null, $cache);
        echo $result;
    }

    //任务管理->单条任务查看
    function oneTaskManager() {
        if (!hasAsoRole('OTMS')) error(ERROR_MSG);
        $method = I('get.method') ? I('get.method') : 'show';
        $db = M('google_task_config');
        $tag_list = getTaskTagList(2);
        switch ($method) {
            case 'show':
                $task_status_list = array(
                    '不限' => 0,
                    '正在执行' => 1,
                    '已完成' => 2,
                    '未执行' => 3,
                );

                $tast_status = $_GET['task_status'];
                $this->assign('task_status', $tast_status);
                unset($_GET['task_status'], $_GET['task_status_sign']);

                $tableName = 'google_task_config';
                $admin_name = getAdminName();
                if ($admin_name == "汪涛") {
                    $cp_list = array("耿明游戏"=>"耿明游戏");
                } else {
                    $cp_list = getCpList();
                }
                $searchArr = array(
                    '搜索' => array(
                        'TAG' => array('name' => 'tag', 'type' => 'select', 'data' => getTaskTagList()),
                        'CP' => array('name' => 'cp', 'type' => 'select', 'data' => getCpList()),
                        '游戏' => array('name' => 'package_name', 'type' => 'text'),
                        '账号国家：' => array('name' => 'country', 'type' => 'select','data'=>getCountryList()),
                        '任务类型' => array('name' => 'task_type', 'type' => 'select', 'data' => getTaskTypeList()),
                        '任务标题' => array('name' => 'task_name', 'type' => 'text'),
                        '开始时间' => array('name' => 'end', 'type' => 'datetime1', 'sign' => 'egt'),
                        '结束时间' => array('name' => 'start', 'type' => 'datetime1', 'sign' => 'elt'),
                        '任务状态：' => array('name' => 'task_status', 'type' => 'select', 'data'=> $task_status_list),
                    )
                );
                $searchHtml = TableController::createSearch1($tableName, $searchArr);
                //分页
                $wh = IphoneController::getWhereConfig($tableName);
                if ($admin_name == "汪涛") {
                    if($wh != ''){
                        $wh .= " AND ";
                    }
                    $wh .= "cp = '耿明游戏'";
                }

                if($tast_status == 1){
                    $temp_where = " status = 1 AND `start` <= '" . date('Y-m-d H:i:s') . "' AND '" . date('Y-m-d H:i:s') . "' <= `end`";
                }elseif($tast_status == 2){
                    $temp_where = " status = 1 AND '" . date('Y-m-d H:i:s') . "' > `end`";
                }elseif($tast_status == 3){
                    $temp_where = " status = 1 AND `start` > '" . date('Y-m-d H:i:s') . "'";
                }

                if($temp_where != ''){
                    if($wh != ''){
                        $wh .= ' AND ';
                    }
                    $wh .= $temp_where;
                }

                $count = $db->where($wh)->count();
                $pagesize = 100;
                $parameter = TableController::getGlobalWhere($tableName) ? merge($_GET, array('where' => TableController::getGlobalWhere($tableName))) : '';
                $page = new \Home\Org\Page($count, $pagesize, $parameter);
                $data = $db->where($wh)->order('id desc')->limit($page->firstRow, $page->listRows)->select();
                $pager = $page->show();
                $this->pager = '<div class="pager">' . $pager . '</div>';
                $task_type_list = getTaskTypeList(2);
                $get_game_list = getGameList(1);
                $get_game_list1 = array_flip($get_game_list);
                $country_language_list = getCountryLanguage(2);
                $now_time = time();
                $total_data = array();
                foreach ($data as $key => &$v) {
                    $v['tag'] = $tag_list[$v['tag']];
                    $v['task_type'] = $task_type_list[$v['task_type']];
                    $v['package_name'] = $get_game_list1[$v['package_name']];
                    if (strtotime($v['start']) <= $now_time && strtotime($v['end']) >= $now_time) {
                        $v['start'] = "<span style='color:red'>" . $v['start'] . "</span>";
                        $v['end'] = "<span style='color:red'>" . $v['end'] . "</span>";
                    } else if (strtotime($v['start']) > $now_time) {
                        $v['start'] = "<span style='color:blue'>" . $v['start'] . "</span>";
                        $v['end'] = "<span style='color:blue'>" . $v['end'] . "</span>";
                    } else if (strtotime($v['end']) < $now_time) {
                        $v['start'] = "<span style='color:orange'>" . $v['start'] . "</span>";
                        $v['end'] = "<span style='color:orange'>" . $v['end'] . "</span>";
                    } else {
                        $v['start'] = $v['start'];
                        $v['end'] = $v['end'];
                    }
                    $v['country'] = $country_language_list[$v['country'] . '#' . $v['language']];
                    $v['game_id'] = $v['game_id'];

                    $v['is_average'] = parseYn($v['is_average']);

                    //
                    $get_all = getRedis()->hGet("google_pro_task@{$v['id']}");
                    $total_submit = 0;
                    foreach ($get_all as $val){
                        $total_submit += $val;
                    }

                    $v['total_submit'] = $total_submit;
                    $v['issued'] = intval(getRedis()->get("protocol_issue_task_id_{$v['id']}"));
                    $v['success'] = intval(getRedis()->get("app_task_success_nums_id_{$v['id']}"));
                    if($v['comment_rate']){
                        $v['rate_success'] = getRedis()->get("pro_task_comment_success#{$v['id']}");
                    }

                    if (!hasAsoRole('GTASKO')) {
                        $v['caozuo'] = "";
                        $v['status'] = parseYn($v['status']);
                    } else {
                        $v['status'] = IphoneController::creatAjaxRadio2("google_task_config", "status", $v['id'], $v['status']);
                        if (!hasAsoRole('GTASKO1')) {
                            $v['caozuo'] = $this->createOperate(array(
                                array('act' => 'edit_one', 'id' => $v['id']),
                                array('act' => 'del_one', 'id' => $v['id']),
                            ), "taskManager");
                        } else {
                            $v['caozuo'] = $this->createOperate(array(
                                array('act' => 'edit_one', 'id' => $v['id']),
                                array('act' => 'del_one', 'id' => $v['id']),
                            ), "taskManager");
                        }
                    }

                    $total_data['count'] += $v['count'];
                    $total_data['issued_num'] += $v['issued'];
                    $total_data['submit_nums'] += $v['total_submit'];
                    $total_data['success_nums'] += $v['success'];
                    $total_data['submit_rate'] = round($total_data['submit_nums']/$total_data['issued_num'],3) * 100 . "%";;
                    $total_data['success_rate'] = round($total_data['success_nums']/$total_data['issued_num'],3) * 100 . "%";

                }
                file_put_contents(FileController::$filepath.'FileoneTaskManager-'.getAdminName().'.txt', serialize($data));
                $this->assign('data', $data);
                $this->assign('total', $total_data);
                $this->nav = array(
                    '单条任务查看' => array('icon' => 'icon_grid', 'selected' => 1),
                );
                $this->main = $searchHtml . $this->fetch('Task:oneTaskManager');
                $this->_out();
                break;
        }
    }

    //任务管理->搜索关键词
    function searchKeywordList() {
        if (!hasAsoRole('OTMS')) error(ERROR_MSG);
        $method = I('get.method') ? I('get.method') : 'show';
        $db = M('search_task_log');
        switch ($method) {
            case 'show':
                $tableName = 'search_task_log';
                $searchArr = array(
                    '搜索' => array(
                        'ID' => array('name' => 'id', 'type' => 'text'),
                        'IP' => array('name' => 'sid', 'type' => 'text'),
                    )
                );
                $searchHtml = TableController::createSearch1($tableName, $searchArr);
                //分页
                $wh = IphoneController::getWhereConfig($tableName);
                $count = $db->where($wh)->count();
                $pagesize = 20;
                $parameter = TableController::getGlobalWhere($tableName) ? merge($_GET, array('where' => TableController::getGlobalWhere($tableName))) : '';
                $page = new \Home\Org\Page($count, $pagesize, $parameter);
                $data = $db->where($wh)->order('id desc')->limit($page->firstRow, $page->listRows)->select();
                $pager = $page->show();
                $this->pager = '<div class="pager">' . $pager . '</div>';
                foreach ($data as $key => &$v) {
                    $account_info = getRedis()->get("account_id_".$v['account_id']);
                    $v['account_gmail'] = $account_info['gmail'];
                    $v['account_password'] = $account_info['password'];
                }
                $this->assign('data', $data);

                //获取任务信息
                $searchList = M('search_keyword_ip_task')->where(array('type' => 2))->getField('id,keyword,package_name,type');
                $this->assign('keyword_list', $searchList);

                $this->nav = array(
                    '搜索关键词' => array('icon' => 'icon_grid', 'selected' => 1),
                );
                $this->main = $searchHtml . $this->fetch('Task:searchKeywordList');
                $this->_out();
                break;
        }
    }

    //任务管理->账号任务管理->账号任务管理
    function accountBindingList() {
        if (!hasAsoRole('ABL')) error(ERROR_MSG);
        $method = I('get.method') ? I('get.method') : 'show';
        $html = new \Home\Org\Html();
        $db = M('account_binging_mst');
        $model_data = M("iphone_model")->select();
        foreach ($model_data as $val) {
            $model_list[$val['name']] = $val['mid'];
        }
        $model_list1 = array_flip($model_list);
        $country_data = M("country_mst")->select();
        foreach ($country_data as $val) {
            $country_list[$val['name']] = $val['id'];
        }
        $country_list1 = array_flip($country_list);
        $account_group_data = M("account_group")->select();
        foreach ($account_group_data as $val) {
            $account_group_list[$val['group_name']] = $val['id'];
        }
        $account_group_list1 = array_flip($account_group_list);
        $iphone_binding_list = array_flip(C('IPHONEBINDINGTYPE'));
        $type_list = array_flip(C('SEARCHKEYWORDTYPE'));
        $tag_list = getIphoneTagList(2);
        switch ($method) {
            case 'show':
                $time_start = $_POST['time_start'] ? $_POST['time_start'] : date("Y-m-d");
                $time_end = $_POST['time_end'] ? $_POST['time_end'] : date("Y-m-d");
                $search_type = $_POST['search_type'] ? $_POST['search_type'] : "";
                $search_model = $_POST['search_model'] ? $_POST['search_model'] : "";
                $search_country = $_POST['search_country'] ? $_POST['search_country'] : "";
                $time_end1 = $time_end . " 23:59:59";
                $wh = "start >= '{$time_start}' and start <= '{$time_end1}'";
                if ($search_type != "") {
                    $wh .= " and type = {$search_type}";
                }
                if ($search_model != "") {
                    $wh .= " and model_type = {$search_model}";
                }
                if ($search_country != "") {
                    $wh .= " and country_id = {$search_country}";
                }
                $data = $db->where($wh)->order('id desc')->select();
                foreach ($data as &$v) {
                    $v['selectid'] = '<input name="id[]" type="checkbox" value="' . $v['id'] . '"/>';
                    $v['type'] = $iphone_binding_list[$v['type']];  //是否启用
                    $v['tag'] = $tag_list[$v['tag']];  //tag
                    $v['country_id'] = $country_list1[$v['country_id']];  //国家
                    $v['model_type'] = $model_list1[$v['model_type']];  //手机模式
                    $v['task_type'] = $type_list[$v['task_type']];  //任务模式
                    $v['status'] = $this->creatAjaxRadio2("account_binging_mst", "status", $v['id'], $v['status']);
                    $v['group_id'] = $account_group_list1[$v['group_id']];  //账号追踪组
                    $v['issued_num'] = getRedis()->get('account_task_issued_id@' . $v['id']);  //账号追踪组
                    $v['success_num'] = getRedis()->get('account_task_success_id_' . $v['id']); //绑定成功数
                    $v['caozuo'] = $this->createOperate(array(
                        array('act' => 'edit', 'id' => $v['id']),
                        array('act' => 'del', 'id' => $v['id']),
                    ), "accountBindingList");
                }
                $this->assign('data', $data);
                $this->assign('group_count', $html->createInput('text', 'group_count', '不修改'));//批量修改值
                $this->assign('group_type', $html->createInput('select', 'group_type', null, C('IPHONEBINDINGTYPE')));//批量修改类型
                $this->assign('group_country_id', $html->createInput('select', 'group_country_id', null, $country_list));//批量修改国家
                $this->assign('group_model_type', $html->createInput('select', 'group_model_type', null, $model_list));//批量修改模式
                $this->assign('group_del', $html->createInput('radio', 'group_del', 'no', array('是' => 'yes', '否' => 'no')));//批量删除
                $this->nav = array(
                    '账号任务管理' => array('icon' => 'icon_grid', 'selected' => 1),
                    '添加' => array('link' => '/index.php?m=Home&c=Task&a=accountBindingList&method=add', 'icon' => 'icon_add'),
                );
                $this->assign("time_start", $html->createInput("date", "time_start", $time_start));
                $this->assign("time_end", $html->createInput("date", "time_end", $time_end));
                $this->assign("search_type", $html->createInput("select", "search_type", $search_type, C('IPHONEBINDINGTYPE')));
                $this->assign("search_country", $html->createInput("select", "search_country", $search_country, $country_list));
                $this->assign("search_model", $html->createInput("select", "search_model", $search_model, $model_list));
                $this->assign("url", U('Task/accountBindingList', array("method" => "show")));
                $this->main = $this->fetch('Task:accountBindingList');
                $this->_out();
                break;
            case 'add':
                if (!hasAsoRole('ABL')) error(ERROR_MSG);
                if ($_POST) {
                    if (empty($_POST['tag'])) {
                        error("未选择tag");
                    }
                    $arr['tag'] = $_POST['tag'];
                    $arr['type'] = $_POST['type'];
                    $arr['start'] = $_POST['start'];
                    $arr['end'] = $_POST['end'];
                    $arr['count'] = trim($_POST['count']);
                    $arr['country_id'] = $_POST['country_id'];
                    $arr['model_type'] = $_POST['model_type'];
                    $arr['task_type'] = $_POST['task_type'];
                    $arr['status'] = $_POST['status'];
                    if (!empty($_POST['group_id'])) {
                        $arr['group_id'] = $_POST['group_id'];
                    }
                    $arr['table_name'] = $_POST['table_name'];
                    $arr['time'] = date('Y-m-d H:i:s');
                    $update = $db->add($arr);
                    if ($update) {
                        success('添加成功', U('Task/accountBindingList'));
                    } else {
                        error('添加失败');
                    }
                }
                $country_table_tmp = M("country_table_mst")->select();
                $country_table_tmp_list = array();
                foreach ($country_table_tmp as $val) {
                    $country_table_tmp_list[$val['table_name']] = $val['table_name'];
                }
                $this->assign('count', $html->createInput('text', 'count'));
                $this->assign('start', $html->createInput('datetime1', 'start'));
                $this->assign('end', $html->createInput('datetime1', 'end'));
                $this->assign('type', $html->createInput('selected', 'type', null, C('IPHONEBINDINGTYPE')));
                $this->assign('country_id', $html->createInput('select', 'country_id', null, $country_list));
                $this->assign('model_type', $html->createInput('selected', 'model_type', null, $model_list));
                $this->assign('task_type', $html->createInput('selected', 'task_type', null, C('SEARCHKEYWORDTYPE')));
                $this->assign('status', $html->createInput('radio', 'status', 1, C('YESORNO')));
                $this->assign('group_id', $html->createInput('select', 'group_id', null, $account_group_list));
                $this->assign('table_name', $html->createInput('select', 'table_name', null, $country_table_tmp_list));
                $this->assign('tag', $html->createInput('select', 'tag',null,getIphoneTagList()));
                $this->nav = array(
                    '账号任务管理' => array('link' => '/index.php?m=Home&c=Task&a=accountBindingList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:accountBindingList_add');
                $this->_out();
                break;
            case 'edit':
                if (!hasAsoRole('ABL')) error(ERROR_MSG);
                if ($_POST) {
                    if (empty($_POST['tag'])) {
                        error("未选择tag");
                    }
                    $arr['type'] = $_POST['type'];
                    $arr['start'] = $_POST['start'];
                    $arr['end'] = $_POST['end'];
                    $arr['count'] = trim($_POST['count']);
                    $arr['country_id'] = $_POST['country_id'];
                    $arr['model_type'] = $_POST['model_type'];
                    $arr['task_type'] = $_POST['task_type'];
                    $arr['status'] = $_POST['status'];
                    if (!empty($_POST['group_id'])) {
                        $arr['group_id'] = $_POST['group_id'];
                    }else{
                        $arr['group_id'] = 0;
                    }
                    $arr['table_name'] = $_POST['table_name'];
                    $arr['tag'] = $_POST['tag'];
                    $id = I('post.id');
                    $update = $db->where("id=$id")->save($arr);
                    if ($update) {
                        success('修改成功', U('Task/accountBindingList'));
                    } else {
                        error('修改失败');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $country_data = M('country_mst')->where("id={$data['country_id']}")->find();
                $short_name = strtolower($country_data['short_name']);
                $country_table_tmp = M("country_table_mst")->where("table_name like '_%{$short_name}%'")->select();
                $country_table_tmp_list = array('' => '');
                foreach ($country_table_tmp as $val) {
                    $country_table_tmp_list[$val['table_name']] = $val['table_name'];
                }
                $this->assign('id', $id);
                $this->assign('count', $html->createInput('text', 'count',$data['count']));
                $this->assign('start', $html->createInput('datetime1', 'start',$data['start']));
                $this->assign('end', $html->createInput('datetime1', 'end',$data['end']));
                $this->assign('type', $html->createInput('selected', 'type', $data['type'], C('IPHONEBINDINGTYPE')));
                $this->assign('country_id', $html->createInput('select', 'country_id', $data['country_id'], $country_list));
                $this->assign('model_type', $html->createInput('selected', 'model_type', $data['model_type'], $model_list));
                $this->assign('task_type', $html->createInput('selected', 'task_type', $data['task_type'], C('SEARCHKEYWORDTYPE')));
                $this->assign('tag', $html->createInput('selected', 'tag', $data['tag'], getIphoneTagList()));
                $this->assign('status', $html->createInput('radio', 'status', $data['status'], C('YESORNO')));
                $this->assign('group_id', $html->createInput('selected', 'group_id', $data['group_id'], $account_group_list));
                $this->assign('table_name', $html->createInput('selected', 'table_name', $data['table_name'], $country_table_tmp_list));
                $this->nav = array(
                    '账号任务管理' => array('link' => '/index.php?m=Home&c=Task&a=accountBindingList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Task&a=accountBindingList&method=add', 'icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:accountBindingList_edit');
                $this->_out();
                break;
            case 'del':
                if (!hasAsoRole('ABL')) error(ERROR_MSG);
                $id = I('id');
                $update = $db->where("id=$id")->delete();
                if ($update) {
                    success('删除成功', U('Task/accountBindingList'));
                } else {
                    error('删除失败');
                }
                break;
            case 'group':
                if (!hasAsoRole('ABL')) error(ERROR_MSG);
                //批量操作
                $idArr = $_POST['id'];
                $group_status = $_POST['group_status'];
                $group_tag = trim($_POST['group_tag']);
                $group_port = trim($_POST['group_port']);
                $group_hosts_can_update = $_POST['group_hosts_can_update'];
                $group_lua_can_update = $_POST['group_lua_can_update'];
                $group_apk_can_update = $_POST['group_apk_can_update'];
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
                    if ($group_net_type != '') {
                        $arr['net_type'] = $group_net_type;
                    }
                    if ($group_tag != "不修改") {
                        $arr['tag'] = $group_tag;
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
                        if ($group_net_type != '') {
                            $arr['net_type'] = $group_net_type;
                        }
                        if ($group_tag != "不修改") {
                            $val['tag'] = $group_tag;
                        }
                        if ($group_port != "不修改") {
                            $val['tag'] = $group_port;
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
                break;
            case 'ajax':
                $country_id = I('country_id');
                $country_data = M('country_mst')->where("id={$country_id}")->find();
                $short_name = strtolower($country_data['short_name']);
                $country_table_tmp = M("country_table_mst")->where("table_name like '%_{$short_name}%'")->select();
                $country_table_tmp_list = array();
                foreach ($country_table_tmp as $val) {
                    $country_table_tmp_list[$val['table_name']] = $val['table_name'];
                }
                echo $html->createInput('select', 'table_name', null, $country_table_tmp_list);exit;
                break;
        }
    }

    /**
     * 获取真机任务上个小时任务配额以及完成情况以及当前小时配额情况
     * @param $tag
     */
    private function _get_aso_last_config($tag){
        $key = 'aso_last_now_config@' . date('YmdH');
        if($tag){
            $key .= '#' . $tag;
        }
        $aso_redis_config = getRedis()->hGet($key);
        if($aso_redis_config){
            //TODO redis中有记录直接从redis中读取

            return array('last_hour_count' => $aso_redis_config['last_hour_count'], 'last_hour_success' => $aso_redis_config['last_hour_success']);
        }else{
            //TODO 从数据库中获取

            $redis_key = "search_keyword_ip_task_info@"; //真机ASO

            $lastWhere = " status = 1 AND `start` <= '" . date('Y-m-d H:59:59', strtotime('-2 hour')) . "' AND end >= '" . date('Y-m-d H:59:59', strtotime('-1 hour')) . "'";
            if($tag){
                $lastWhere .= " AND `tag` = " . $tag;
            }
            $lastSql = "SELECT id,`count`,`start`,`end` FROM search_keyword_ip_task WHERE " . $lastWhere;

            $lastList = M()->query($lastSql);
            $lastHourCount = 0;
            $last_task_ids = '';
            foreach ($lastList as $val){
                if($last_task_ids != ''){
                    $last_task_ids .= ',';
                }
                $last_task_ids .= $val['id'];

                //计算时间差多少个小时数
                $astr = strtotime($val['start']);
                $bstr = strtotime($val['end']);
                $hours = ceil(($bstr - $astr)/3600);
                $lastHourCount = $lastHourCount + ceil($val['count']/$hours);
                unset($val);
            }
            getRedis()->hSet($key, 'last_hour_count', $lastHourCount, 3600); //上一个小时配额数


            //获取上一个小时的成功数
            $lastSuccessCount = M()->query("SELECT count(*) AS t FROM submit_result_info WHERE result_type = 100 AND search_key IN (" . $last_task_ids . ") AND add_time >= '" . strtotime(date('Y-m-d H:0:0', strtotime('-1 hour'))) ."' AND add_time <= '" . strtotime(date('Y-m-d H:0:0')) . "'");

            $lastSuccessCount = $lastSuccessCount[0]['t'] ? $lastSuccessCount[0]['t'] : 0;

            getRedis()->hSet($key, 'last_hour_success', $lastSuccessCount, 3600); //上一个小时配额数

            return array('last_hour_count' => $aso_redis_config['last_hour_count'], 'last_hour_success' => $lastSuccessCount);
        }

    }

    function task_result_detail(){
        $task_id = intval($_POST['task_id']);
        $hTaskAll = getRedis()->hGet("google_aso_task@{$task_id}");
        if($hTaskAll){
            $totalNums = 0;
            foreach ($hTaskAll as $resKey => $count){
                $totalNums += $count;
                if($resKey == 'result_type@100'){
                    $success_nums = $count;
                }
            }

            $result_type_arr = array(
                100 => '成功', 400 => '授权账号任务成功[400]', 21 => '切换国家失败[21]', 101 => '上传go信息失败[101]', 102 => '未知[102]', 104 => '搜索完毕，没有找到[104]', 105 => '等待Accept协议超时[105]', 106 => '打开APP失败[106]',107 => 'ACCESSTASK_NOT_START ACCESSTASK没有启动', 108 => 'ACCESSTASK_FAIL ACCESSTASK写入的文件是Fail', 109 => 'SCRIPT_TIMEOUT 脚本超时', 160 => '查询没有找到[160]', 161 => '查询Item未知错误[161]', 121 => '出现账号超时的策划栏，没有点击到重试按钮[121]', 122 => '点击 Install 按钮失败[122]', 123 => '点击完善用户信息的continue失败[123]', 124 => '在checkskipbtn方法中点击ErrorAccount的continue按钮失败[124]', 125 => '在checkskipbtn方法中 点击skip按钮失败[125]', 126 => '检测是否在Dialog超时[126]', 127 => '检测是否存在Skip按钮超时[127]', 111 => '点击Accept协议之后等待GooglePlay主界面超时[111]', 162 => '启用AccessTask不成功[162]', 110 => 'LISTVIEW 超时[110]', -1 => '返回的device_country有误[-1]', -2 => '返回的dInfo为空[-2]', 120 => '账号sign out[120]', 130 => "Can't  download app 对话框[130]", 131 => '点击 Accept  按钮失败[131]', 311 => '下载gData失败[311]', 511 => '下载gData失败[511]', 128 => '切换国家超时[128]', 132 => 'MoreInfo超时[132]', 134 => 'install 超时[134]', 112 => '点击MoreInfo后listview超时[112]', 186 => 'gData广播出错[186]', 187 => 'gData下载失败[187]', 188 => 'gData下载MD5错误[188]');

            $task_info = getRedis()->get('search_keyword_ip_task_info@' . $task_id);

            $task_result_str = "任务编号：{$task_id} <br /> 包名：{$task_info['package_name']} <br /> 应用名：{$task_info['nick_name']} <br /> 关键词：{$task_info['keyword']} <br />";
            $arr = array();
            foreach ($hTaskAll as $resKey => $count){
                $arr[str_replace('result_type@', '', $resKey)]['rate'] = round($count/$totalNums,4) * 100;
                $arr[str_replace('result_type@', '', $resKey)]['count'] =  $count;
            }
            //从高到低排序
            arsort($arr);

            $html = "<table><th>状态码</th><th>数量</th><th>比例</th><th width='100px'>说明</th>";
            foreach ($arr as $key => $value){
                $html .= "<tr>";
                $html .= "<td width='50'>{$key}</td>";
                $html .= "<td width='50'>{$value['count']}</td>";
                $html .= "<td width='50'>{$value['rate']}%</td>";
                $html .= "<td width='300'>{$result_type_arr[$key]}</td>";
                $html .= "</tr>";
            }
            $task_result_str .= $html . '</table>';
            echo $task_result_str;
        }else{
            echo '暂无任务结果数据';
        }
        exit();
    }

    //任务管理->真机任务管理->真机任务列表
    public function searchKeywordIpTaskList(){
        if (!hasAsoRole('SKITLS,SKITLO')) error(ERROR_MSG);
        $method = $_GET['method'] ? $_GET['method'] : 'show';
        $html = new \Home\Org\Html();
        $db = M('search_keyword_ip_task');
        $redis_key = "search_keyword_ip_task_info@";
        $redis_ip_key = "google_search_ip_task@";
        $type_list = array_flip(C('SEARCHKEYWORDTYPE'));
        $iphone_tag_list1 = getIphoneTagList(2);
        $country_table_tmp = M("country_table_mst")->select();
        $country_table_tmp_list = array();
        foreach ($country_table_tmp as $val) {
            $country_table_tmp_list[$val['table_name']] = $val['table_name'];
        }
        $gid_table_tmp = M("google_app_config")->select();
        foreach ($gid_table_tmp as $val) {
            $gid_name_list[$val['id']] = $val['game_name'];
        }
        $country_table_tmp_list = array();
        foreach ($country_table_tmp as $val) {
            $country_table_tmp_list[$val['table_name']] = $val['table_name'];
        }
        $comment_type_list = array_flip(C('COMMENTTYPE'));
        $task_class_type_list = array_flip(C('TASKORDERCLASSTYPE'));
        switch ($method) {
            case 'show':
                $tast_status = $_GET['task_status'];
                $this->assign('task_status', $tast_status);
                unset($_GET['task_status'], $_GET['task_status_sign']);

                $tableName = 'search_keyword_ip_task';
                $task_status_list = array(
                    '不限' => 0,
                    '正在执行' => 1,
                    '已完成' => 2,
                    '未执行' => 3,
                );

                $admin_name = getAdminName();
                if ($admin_name == "汪涛") {
                    $cp_list = array("耿明游戏"=>"耿明游戏");
                } else {
                    $cp_list = getCpList();
                }
                $searchArr = array(
                    '搜索' => array(
                        //'ID：' => array('name' => 'id', 'type' => 'text'),
                        'CP：' => array('name' => 'cp', 'type' => 'select','data'=>$cp_list),
                        'TAG：' => array('name' => 'tag', 'type' => 'select','data'=>getIphoneTagList()),
                        '账号国家：' => array('name' => 'country', 'type' => 'select','data'=>getCountryList()),
                        '应用：' => array('name' => 'nick_name', 'type' => 'text','sign' => 'like'),
                        '包名：' => array('name' => 'package_name', 'type' => 'text','sign' => 'like'),
                        '关键词：' => array('name' => 'keyword', 'type' => 'text','sign' => 'like'),
                        '任务状态：' => array('name' => 'task_status', 'type' => 'select', 'data'=> $task_status_list),
                        '任务分类：' => array('name' => 'task_class', 'type' => 'select', 'data'=> C('TASKORDERCLASSTYPE')),
                    )
                );

                $searchHtml = TableController::createSearch1($tableName, $searchArr);

                //分页
                $wh = IphoneController::getWhereConfig($tableName);
                if($tast_status == 1){
                    $temp_where = " status = 1 AND `start` <= '" . date('Y-m-d H:i:s') . "' AND '" . date('Y-m-d H:i:s') . "' <= `end`";
                }elseif($tast_status == 2){
                    $temp_where = " status = 1 AND '" . date('Y-m-d H:i:s') . "' > `end`";
                }elseif($tast_status == 3){
                    $temp_where = " status = 1 AND `start` > '" . date('Y-m-d H:i:s') . "'";
                }

                if ($admin_name == "汪涛") {
                    if($wh != ''){
                        $wh .= " AND ";
                    }
                    $wh .= "cp = '耿明游戏'";
                }

                if($temp_where != ''){
                    if($wh != ''){
                        $wh .= ' AND ';
                    }
                    $wh .= $temp_where;
                }
                if($wh != ''){
                    $wh .= ' AND ';
                }
                $wh .= " comment_rate = 0 ";
                $count = $db->where($wh)->count();
                $pagesize = 200;
                $parameter = TableController::getGlobalWhere1($tableName) ? merge($_GET, array('where' => TableController::getGlobalWhere1($tableName))) : '';
                $page = new \Home\Org\Page($count, $pagesize, $parameter);
                $data = $db->where($wh)->order('id desc')->limit($page->firstRow, $page->listRows)->select();
                if($data){
                    //========================这里统计上个小时的配额和完成数======================

                    $get_last_config = $this->_get_aso_last_config($_GET['tag'] ? $_GET['tag'] : 0);
                    if($get_last_config){
                        $this->assign('last_hour_count', $get_last_config['last_hour_count']); //上一个小时配额数
                        $this->assign('last_hour_success', $get_last_config['last_hour_success']);
                    }

                    $nowWhere = " status = 1 AND `start` <= '" . date('Y-m-d H:0:0') . "' AND end >= '" . date('Y-m-d H:0:0', strtotime('+1 hour')) . "'";
                    if($_GET['tag']){
                        $nowWhere .= " AND `tag` = " . $_GET['tag'];
                    }
                    $nowList = M()->query("SELECT id,`count`,`start`,`end` FROM search_keyword_ip_task WHERE " . $nowWhere);
                    $nowHourCount = 0;
                    foreach ($nowList as $val){
                        //计算时间差多少个小时数
                        $astr = strtotime($val['start']);
                        $bstr = strtotime($val['end']);
                        $hours = ceil(($bstr - $astr)/3600);
                        $nowHourCount = $nowHourCount + round($val['count']/$hours);
                    }
                    $this->assign('now_hour_count', $nowHourCount); //当前一个小时的配额数

                    //========================这里统计上个小时的配额和完成数======================

                }

                $pager = $page->show();
                $this->pager = '<div class="pager">' . $pager . '</div>';
                $now_time = time();
                $total = array();
                //数据处理
                foreach ($data as &$v) {
                    $v['exception'] = '';
                    if ($v['status'] == 9) {
                        $v['exception'] = 'vpnException1';
                    }
                    $v['start_date'] = $v['start'];
                    $v['nick_name'] =$gid_name_list[$v['game_id']];
                    if (strtotime($v['start']) <= $now_time && strtotime($v['end']) >= $now_time && $v['status'] == 1) {
                        $v['start'] = "<span style='color:red'>" . $v['start'] . "</span>";
                        $v['end'] = "<span style='color:red'>" . $v['end'] . "</span>";
                    } else if (strtotime($v['start']) > $now_time && $v['status'] == 1) {
                        $v['start'] = "<span style='color:blue'>" . $v['start'] . "</span>";
                        $v['end'] = "<span style='color:blue'>" . $v['end'] . "</span>";
                    } else if (strtotime($v['end']) < $now_time && $v['status'] == 1) {
                        $v['start'] = "<span style='color:orange'>" . $v['start'] . "</span>";
                        $v['end'] = "<span style='color:orange'>" . $v['end'] . "</span>";
                    } elseif($v['status'] == 0) {
                        $v['start'] = "<span style='color:#CCC'>" . $v['start'] . "</span>";
                        $v['end'] = "<span style='color:#CCC'>" . $v['end'] . "</span>";
                    } else {
                        $v['start'] = $v['start'];
                        $v['end'] = $v['end'];
                    }
                    $v['tag'] = $iphone_tag_list1[$v['tag']];
                    $v['tag'] .=  '<br />'. $task_class_type_list[$v['task_class']];
                    $v['comment_type'] = $comment_type_list[$v['comment_type']];
                    $v['comment_rate'] = $v['comment_rate']."‰";
                    if($v['comment_rate'] > 0){
                        $v['comment_success'] = intval(getRedis()->get('search_comment_success_id_' . $v['id']));
                        //intval($comment_count_data[$v['id']]);
                    }else{
//                        if(intval(getRedis()->get('search_comment_success_id_' . $v['id']))){
//                            echo $v['id'] . '<br />';
//                        }
                    }

                    $v['type'] = $type_list[$v['type']];
                    if (!hasAsoRole('SKITLO')) {
                        $v['caozuo'] = "";
                        $v['status'] = parseYn($v['status']);
                    } else {
                        $v['status'] = IphoneController::creatAjaxRadio2("search_keyword_ip_task", "status", $v['id'], $v['status']);
                        $v['caozuo'] = $this->createOperate(array(
                            array('act' => 'edit', 'id' => $v['id']),
                            array('act' => 'del', 'id' => $v['id']),
                            array('act' => 'copy', 'id' => $v['id']),
                        ), "searchKeywordIpTaskList");
                    }



                    //todo 任务的下发数
                    $issued_num = intval(getRedis()->get('search_keyword_issued_task_id_' . $v['id']));
                    $v['issued_num'] = $issued_num;
                    $total['issued_num'] += $v['issued_num'];
                    //todo 任务的成功数
                    $success_nums = intval(getRedis()->get('search_task_success_id_' . $v['id']));
                    $v['success_nums'] = $success_nums;
                    //TODO 获取任务的结果记录
                    $hTaskAll = getRedis()->hGet('google_aso_task@' . $v['id']);
                    $totalNums = 0;
                    if($hTaskAll){
                        foreach ($hTaskAll as $resKey => $count){
                            $totalNums += $count;
                        }
                        $v['submit_nums'] = $totalNums;
                        $v['zhankai'] = "<span class=\"open_group success_log_field\" attr='{$v['id']}'>展开</span>";
                    }else{
                        $v['zhankai'] = '';
                    }

                    $v['success_nums'] = $success_nums;
                    $total['count'] += $v['count'];
                    $total['submit_nums'] += $v['submit_nums'];
                    $total['success_nums'] += $v['success_nums'];
                }
                $total['submit_rate'] = round($total['submit_nums']/$total['issued_num'],3) * 100 . "%";
                $total['success_rate'] = round($total['success_nums']/$total['issued_num'],3) * 100 . "%";
                $this->assign('data', $data);
                $this->assign('total', $total);
                if (!hasAsoRole('SKITLO')) {
                    $this->nav = array(
                        '真机任务列表' => array('icon' => 'icon_grid', 'selected' => 1),
                    );
                } else {
                    $this->nav = array(
                        '真机任务列表' => array('icon' => 'icon_grid', 'selected' => 1),
                        '添加' => array('link' => '/index.php?m=Home&c=Task&a=searchKeywordIpTaskList&method=add', 'icon' => 'icon_add'),
                        '批量添加' => array('link' => '/index.php?m=Home&c=Task&a=searchKeywordIpTaskList&method=import', 'icon' => 'icon_add'),
                        '多个关键词批量添加' => array('link' => '/index.php?m=Home&c=Task&a=searchKeywordIpTaskList&method=import_more_keyword', 'icon' => 'icon_add'),
                    );
                }

                $result_type_arr = array(
                    100 => '成功', 400 => '授权账号任务成功[400]', 21 => '切换国家失败[21]', 101 => '上传go信息失败[101]', 102 => '未知[102]', 104 => '搜索完毕，没有找到[104]', 105 => '等待Accept协议超时[105]', 106 => '打开APP失败[106]',107 => 'ACCESSTASK_NOT_START ACCESSTASK没有启动', 108 => 'ACCESSTASK_FAIL ACCESSTASK写入的文件是Fail', 109 => 'SCRIPT_TIMEOUT 脚本超时', 160 => '查询没有找到[160]', 161 => '查询Item未知错误[161]', 121 => '出现账号超时的策划栏，没有点击到重试按钮[121]', 122 => '点击 Install 按钮失败[122]', 123 => '点击完善用户信息的continue失败[123]', 124 => '在checkskipbtn方法中点击ErrorAccount的continue按钮失败[124]', 125 => '在checkskipbtn方法中 点击skip按钮失败[125]', 126 => '检测是否在Dialog超时[126]', 127 => '检测是否存在Skip按钮超时[127]', 111 => '点击Accept协议之后等待GooglePlay主界面超时[111]', 162 => '启用AccessTask不成功[162]', 110 => 'LISTVIEW 超时[110]', -1 => '返回的device_country有误[-1]', -2 => '返回的dInfo为空[-2]', 120 => '账号sign out[120]', 130 => "Can't  download app 对话框[130]", 131 => '点击 Accept  按钮失败[131]', 311 => '下载gData失败[311]', 511 => '下载gData失败[511]', 128 => '切换国家超时[128]', 132 => 'MoreInfo超时[132]', 134 => 'install 超时[134]', 112 => '点击MoreInfo后listview超时[112]', 186 => 'gData广播出错[186]', 187 => 'gData下载失败[187]', 188 => 'gData下载MD5错误[188]');
                $this->assign('result_type_arr', $result_type_arr);

                $this->main = $searchHtml . $this->fetch('Task:searchKeywordIpTaskList');
                $this->_out();
                break;
            case 'add':
                if (!hasAsoRole('SKITLO')) error(ERROR_MSG);
                if ($_POST) {
                    if (empty($_POST['tag'])) {
                        error("未选择tag");
                    }
                    $ipcut = $_POST['ip'];
                    $ip_start = trim($_POST['ip_start']);
                    $ip_end = trim($_POST['ip_end']);
                    $n = $ip_end - $ip_start;
                    $ip_str = "";
                    for($i=0;$i<=$n;$i++) {
                        $ip_str .= ($ip_str == "") ? $ipcut . ($ip_start+$i) : "," . $ipcut . ($ip_start+$i);
                    }
                    $arr['tag'] = $_POST['tag'];
                    $arr['ip'] = $ip_str;
                    $arr['cp'] = $_POST['cp'];
                    $package_name_arr = explode("##",$_POST['package_name']);
                    $arr['game_id'] = $package_name_arr[0];
                    $arr['game_name'] = $package_name_arr[1];
                    $arr['package_name'] = $package_name_arr[2];
                    $arr['nick_name'] = trim($_POST['nick_name']);
                    $arr['keyword'] = trim($_POST['keyword']);
                    
					$secord_keyword_arr = $_POST['secord_keyword'];
					$arr['secord_keyword']='';
					foreach($secord_keyword_arr as $key=>$value){
						$arr['secord_keyword'].=$value.'$$$';
					}

                    $store_country_language = explode('#', $_POST['store_country']);
                    $arr['store_country'] = trim($store_country_language[0]);

                    $country_language = explode('#', $_POST['country']);
                    $arr['country'] = trim($country_language[0]);
                    $arr['language'] = trim($country_language[1]);
                    $arr['signature'] = trim($_POST['signature']);
                    $arr['app_version'] = trim($_POST['app_version']);
                    $arr['versionName'] = trim($_POST['versionName']);
                    $arr['type'] = $_POST['type'];
                    $arr['task_class'] = $_POST['task_class'];
                    $arr['score'] = trim($_POST['score']);
                    $arr['comment_rate'] = trim($_POST['comment_rate']);
                    $arr['star'] = trim($_POST['star']);
                    $arr['comment_detail'] = trim($_POST['comment_detail']);
                    $arr['comment_type'] = intval($_POST['comment_type']);
					$arr['num_keyword'] = intval($_POST['num_keyword']);
					$arr['num_detail'] = intval($_POST['num_detail']);
                    $arr['developerName'] = trim($_POST['developerName']);
                    $arr['table_name'] = trim($_POST['table_name']);
                    $arr['hot'] = trim($_POST['hot']);
                    $arr['add_time'] = date('Y-m-d H:i:s');
                    $arr['is_open'] = trim($_POST['is_open']);
                    $arr['effective_rank'] = trim($_POST['effective_rank']);
                    $update_country_language = explode('#', $_POST['update_country']);
                    $arr['update_country'] = trim($update_country_language[0]);
                    $arr['update_language'] = trim($update_country_language[1]);
                    $arr['update_table_name'] = trim($_POST['update_table_name']);
                    $arr['is_update'] = trim($_POST['is_update']);
                    $arr['is_fast'] = trim($_POST['is_fast']);
                    $arr['is_enter'] = trim($_POST['is_enter']);
                    $arr['del_model'] = trim($_POST['del_model']);
                    $arr['remark'] = trim($_POST['remark']);
                    $arr['status'] = 1;
                    $arr['admin_name'] = getAdminName();
                    $arr['operate_type'] = "新增任务";
                    if($arr['type'] == 5 || $arr['type'] == 7){
                        $arr['game_id'] = 0;
                        $arr['game_name'] = '';
                        $arr['package_name'] = '';
                        $arr['nick_name'] = '';
                        $arr['keyword'] = '';
                    }
                    $start_arr = $_POST['start'];
                    $end_arr = $_POST['end'];
                    $count_arr = $_POST['count'];
                    $comment_start_id_arr = $_POST['comment_start_id'];
                    $s = $t = 0;
                    foreach ($start_arr as $key=>$val) {
                        $arr['start'] = $val;
                        $arr['end'] = $end_arr[$key];
                        $arr['count'] = intval($count_arr[$key]);
                        $arr['comment_start_id'] = intval($comment_start_id_arr[$key]);
                        $result = $db->add($arr);
                        if ($result) {
                            $this_id = $result;
                            $datas = $db->where("id={$result}")->find();
                            getRedis()->set($redis_key.$datas['id'],$datas);
                            $ip_str = explode(",",$arr['ip']);
                            foreach ($ip_str as $val) {
                                getRedis()->sAdd($redis_ip_key.$val,$this_id);
                            }
                            $s++;
                        } else {
                            $t++;
                        }
                    }
                    success("添加成功{$s}条，失败{$t}条", U('Task/searchKeywordIpTaskList'));
                }
                $this->assign('tag', $html->createInput('select', 'tag',null,getIphoneTagList()));
                $this->assign('ip', $html->createInput('selected', 'ip',null,getIphoneSidList()));
                $this->assign('ip_start', $html->createInput('text', 'ip_start'));
                $this->assign('ip_end', $html->createInput('text', 'ip_end'));
                $this->assign('date1', $html->createInput('text', 'date1[]', date("Y-m-d")));
                $this->assign('date2', $html->createInput('text', 'date2[]', date("Y-m-d")));
                $this->assign('start', $html->createInput('text', 'start[]',date("Y-m-d 16").":00:00"));
                $this->assign('end', $html->createInput('text', 'end[]',date("Y-m-d 15",time()+86400).":59:00"));
                $this->assign('country', $html->createInput('select', 'country', null, getCountryLanguage()));
                $this->assign('store_country', $html->createInput('select', 'store_country', null, getCountryLanguage()));
                $this->assign('cp', $html->createInput('select', 'cp', null, getCpList()));
                $this->assign('package_name', $html->createInput('select', 'package_name', null, getGameList(2)));
                $this->assign('nick_name', $html->createInput('text', 'nick_name', null, null, array('size' => 40)));
                $this->assign('keyword', $html->createInput('text', 'keyword'));
                $this->assign('position', $html->createInput('textarea', 'position'));
                $this->assign('signature', $html->createInput('textarea', 'signature'));
                $this->assign('app_version', $html->createInput('text', 'app_version'));
                $this->assign('developerName', $html->createInput('text', 'developerName'));
                $this->assign('versionName', $html->createInput('text', 'versionName'));
                $this->assign('count', $html->createInput('text', 'count[]'));
                $this->assign('type', $html->createInput('selected', 'type', "2", C('SEARCHKEYWORDTYPE')));
                $this->assign('task_class', $html->createInput('select', 'task_class', null, C('TASKORDERCLASSTYPE')));
                $this->assign('is_open', $html->createInput('selected', 'is_open', 1, array('下载完打开APP'=>'1','下载后不打开'=>'0')));
                $this->assign('score', $html->createInput('text', 'score'));
                $this->assign('table_name', $html->createInput('select', 'table_name', null, $country_table_tmp_list));
                $this->assign('comment_rate', $html->createInput('text', 'comment_rate'));
                $this->assign('star', $html->createInput('textarea', 'star'));
                $this->assign('comment_detail', $html->createInput('textarea', 'comment_detail'));
                $this->assign('update_country', $html->createInput('select', 'update_country', null, getCountryLanguage()));
                $this->assign('update_table_name', $html->createInput('select', 'update_table_name', null, $country_table_tmp_list));
                $this->assign('is_update', $html->createInput('selected', 'is_update', null, array('否'=>'0','是'=>'1')));
                $this->assign('is_fast', $html->createInput('select', 'is_fast', null, array('否'=>'2','是'=>'1')));
                $this->assign('is_enter', $html->createInput('select', 'is_enter', null, array('否'=>'2','是'=>'1')));
                $this->assign('del_model', $html->createInput('select', 'del_model', null, array('一个字符退'=>'1','一下退完'=>'2','添加字符'=>'3')));
                $this->assign('remark', $html->createInput('textarea', 'remark'));
                //获得评论组
                $comment_group_data = M('account_comment_log')->select();
                foreach ($comment_group_data as $val) {
                    $comment_group_list[$val['title']] = $val['id'];
                }
                $this->assign('comment_start_id', $html->createInput('select', 'comment_start_id[]',null,$comment_group_list));
                $this->assign('comment_type', $html->createInput('selected', 'comment_type', null,C('COMMENTTYPE')));
                $this->assign('hot', $html->createInput('text', 'hot'));
                $this->assign('effective_rank', $html->createInput('text', 'effective_rank'));
                $this->nav = array(
                    '应用列表' => array('link' => '/index.php?m=Home&c=Task&a=searchKeywordIpTaskList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                    '批量添加' => array('link' => '/index.php?m=Home&c=Task&a=searchKeywordIpTaskList&method=import', 'icon' => 'icon_add'),
                    '多个关键词批量添加' => array('link' => '/index.php?m=Home&c=Task&a=searchKeywordIpTaskList&method=import_more_keyword', 'icon' => 'icon_add'),
                );
                $this->main = $this->fetch('Task:searchKeywordIpTaskList_add');
                $this->_out();
                break;
            case 'edit':
                if (!hasAsoRole('SKITLO')) error(ERROR_MSG);
                if ($_POST) {
                    if (empty($_POST['tag'])) {
                        error("未选择tag");
                    }
                    $ipcut = $_POST['ip'];
                    $ip_start = trim($_POST['ip_start']);
                    $ip_end = trim($_POST['ip_end']);
                    $n = $ip_end - $ip_start;
                    $ip_str = "";
                    for($i=0;$i<=$n;$i++) {
                        $ip_str .= ($ip_str == "") ? $ipcut . ($ip_start+$i) : "," . $ipcut . ($ip_start+$i);
                    }
                    $arr['tag'] = $_POST['tag'];
                    $arr['ip'] = $ip_str;
                    $arr['cp'] = $_POST['cp'];
                    $package_name_arr = explode("##",$_POST['package_name']);
                    $arr['game_id'] = $package_name_arr[0];
                    $arr['game_name'] = $package_name_arr[1];
                    $arr['package_name'] = $package_name_arr[2];
                    $arr['nick_name'] = trim($_POST['nick_name']);
                    $arr['keyword'] = trim($_POST['keyword']);
                    $arr['secord_keyword'] = trim($_POST['secord_keyword']);

                    $arr['start'] = $_POST['start'];
                    $arr['end'] = $_POST['end'];
                    $store_country_language = explode('#', $_POST['store_country']);
                    $arr['store_country'] = trim($store_country_language[0]);
                    $country_language = explode('#', $_POST['country']);
                    $arr['country'] = trim($country_language[0]);
                    $arr['language'] = trim($country_language[1]);
                    $arr['signature'] = trim($_POST['signature']);
                    $arr['position'] = trim($_POST['position']);
                    $arr['app_version'] = trim($_POST['app_version']);
                    $arr['versionName'] = trim($_POST['versionName']);
                    $arr['type'] = $_POST['type'];
                    $arr['task_class'] = $_POST['task_class'];
                    $arr['score'] = trim($_POST['score']);
                    $arr['comment_rate'] = trim($_POST['comment_rate']);
                    $arr['star'] = trim($_POST['star']);
                    $arr['comment_detail'] = trim($_POST['comment_detail']);
                    $arr['comment_start_id'] = intval($_POST['comment_start_id']);
                    $arr['comment_type'] = intval($_POST['comment_type']);
                    $arr['developerName'] = trim($_POST['developerName']);
                    $arr['table_name'] = trim($_POST['table_name']);
                    $arr['hot'] = trim($_POST['hot']);
                    $arr['is_open'] = trim($_POST['is_open']);
                    $arr['effective_rank'] = intval($_POST['effective_rank']);
                    $update_country_language = explode('#', $_POST['update_country']);
                    $arr['update_country'] = trim($update_country_language[0]);
                    $arr['update_language'] = trim($update_country_language[1]);
                    $arr['update_table_name'] = trim($_POST['update_table_name']);
                    $arr['is_update'] = trim($_POST['is_update']);
                    $arr['is_fast'] = trim($_POST['is_fast']);
                    $arr['is_enter'] = trim($_POST['is_enter']);
                    $arr['del_model'] = trim($_POST['del_model']);
                    $arr['remark'] = trim($_POST['remark']);
                    $arr['num_keyword'] = trim($_POST['num_keyword']);
                    $arr['num_detail'] = trim($_POST['num_detail']);
                    $arr['count'] = intval($arr['num_keyword']) + intval($arr['num_detail']);
                    $id = I('post.id');

                    if($arr['type'] == 5 || $arr['type'] == 7){
                        $arr['game_id'] = 0;
                        $arr['game_name'] = '';
                        $arr['package_name'] = '';
                        $arr['nick_name'] = '';
                        $arr['keyword'] = '';
                    }

                    $old_data = $db->where("id={$id}")->find();
                    $update = $db->where("id={$id}")->save($arr);
                    if ($update) {
                        $old_ip_str = explode(",",$old_data['ip']);
                        foreach ($old_ip_str as $val) {
                            getRedis()->sDel($redis_ip_key.$val,$id);
                        }
                        $datas = $db->where("id={$id}")->find();
                        getRedis()->set($redis_key.$id,$datas);
                        $ip_str = explode(",",$arr['ip']);
                        foreach ($ip_str as $val) {
                            getRedis()->sAdd($redis_ip_key.$val,$id);
                        }
                        success('修改成功', U('Task/searchKeywordIpTaskList'));
                    } else {
                        error('修改失败');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $package_name_old = $data['game_id']."##".$data['game_name']."##".$data['package_name'];
                $old_ip_arr = explode(",",$data['ip']);
                $old_ip = substr($old_ip_arr[0],0,-1);
                if (count($old_ip_arr) > 1) {
                    $old_ip_start = substr($old_ip_arr[0],-1);
                    $old_ip_end = substr(end($old_ip_arr),-1);
                } else {
                    $old_ip_start = $old_ip_end = substr($old_ip_arr[0],-1);
                }
                $this->assign('id', $id);
                $this->assign('tag', $html->createInput('select', 'tag',$data['tag'],getIphoneTagList()));
                $this->assign('ip', $html->createInput('selected', 'ip', $old_ip,getIphoneSidList()));
                $this->assign('ip_start', $html->createInput('text', 'ip_start', $old_ip_start));
                $this->assign('ip_end', $html->createInput('text', 'ip_end', $old_ip_end));
                $this->assign('start', $html->createInput('datetime1', 'start', $data['start']));
                $this->assign('end', $html->createInput('datetime1', 'end', $data['end']));
                $this->assign('country', $html->createInput('selected', 'country', $data['country'].'#'.$data['language'], getCountryLanguage()));
                $this->assign('store_country', $html->createInput('selected', 'store_country', $data['store_country'], getOnlyCountryList()));
                $this->assign('cp', $html->createInput('select', 'cp', $data['cp'], getCpList()));
                $this->assign('package_name', $html->createInput('selected', 'package_name', $package_name_old, getGameList(2)));
                $this->assign('nick_name', $html->createInput('text', 'nick_name',$data['nick_name'], null, array('size' => 40)));
                $this->assign('signature', $html->createInput('textarea', 'signature', $data['signature']));
                $this->assign('position', $html->createInput('textarea', 'position', $data['position']));
                $this->assign('app_version', $html->createInput('text', 'app_version', $data['app_version']));
                $this->assign('versionName', $html->createInput('text', 'versionName', $data['versionName']));
                $this->assign('developerName', $html->createInput('text', 'developerName', $data['developerName']));
                $this->assign('keyword', $html->createInput('text', 'keyword', $data['keyword']));
                $this->assign('num_keyword', $html->createInput('text', 'num_keyword', $data['num_keyword']));
                $this->assign('num_detail', $html->createInput('text', 'num_detail', $data['num_detail']));
                $this->assign('secord_keyword', $html->createInput('textarea', 'secord_keyword', $data['secord_keyword']));
                $this->assign('count', $html->createInput('text', 'count', $data['count']));
                $this->assign('type', $html->createInput('selected', 'type', $data['type'],C('SEARCHKEYWORDTYPE')));
                $this->assign('task_class', $html->createInput('select', 'task_class', $data['task_class'],C('TASKORDERCLASSTYPE')));
                $this->assign('score', $html->createInput('text', 'score', $data['score']));
                $this->assign('is_open', $html->createInput('selected', 'is_open', $data['is_open'], array('下载完打开APP'=>'1','下载后不打开'=>'0')));
                $this->assign('table_name', $html->createInput('select', 'table_name', $data['table_name'], $country_table_tmp_list));
                $this->assign('comment_rate', $html->createInput('text', 'comment_rate',$data['comment_rate']));
                $this->assign('star', $html->createInput('textarea', 'star',$data['star']));
                $this->assign('comment_detail', $html->createInput('textarea', 'comment_detail',$data['comment_detail']));
                $this->assign('comment_start_id', $html->createInput('text', 'comment_start_id',$data['comment_start_id']));
                $this->assign('comment_type', $html->createInput('selected', 'comment_type', $data['comment_type'],C('COMMENTTYPE')));
                $this->assign('hot', $html->createInput('text', 'hot', $data['hot']));
                $this->assign('effective_rank', $html->createInput('text', 'effective_rank', $data['effective_rank']));
                $this->assign('update_country', $html->createInput('select', 'update_country', $data['update_country'].'#'.$data['update_language'], getCountryLanguage()));
                $this->assign('update_table_name', $html->createInput('select', 'update_table_name', $data['update_table_name'], $country_table_tmp_list));
                $this->assign('is_update', $html->createInput('selected', 'is_update', $data['is_update'], array('否'=>'0','是'=>'1')));
                $this->assign('is_fast', $html->createInput('select', 'is_fast', $data['is_fast'], array('否'=>'2','是'=>'1')));
                $this->assign('is_enter', $html->createInput('select', 'is_enter', $data['is_enter'], array('否'=>'2','是'=>'1')));
                $this->assign('del_model', $html->createInput('select', 'del_model', $data['del_model'], array('一个字符退'=>'1','一下退完'=>'2','添加字符'=>'3')));
                $this->assign('remark', $html->createInput('textarea', 'remark', $data['remark']));
                $this->nav = array(
                    '应用列表' => array('link' => '/index.php?m=Home&c=Task&a=searchKeywordIpTaskList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Task&a=searchKeywordIpTaskList&method=add', 'icon' => 'icon_add'),
                    '批量添加' => array('link' => '/index.php?m=Home&c=Task&a=searchKeywordIpTaskList&method=import', 'icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                    '多个关键词批量添加' => array('link' => '/index.php?m=Home&c=Task&a=searchKeywordIpTaskList&method=import_more_keyword', 'icon' => 'icon_add'),
                );
                $this->main = $this->fetch('Task:searchKeywordIpTaskList_edit');
                $this->_out();
                break;
            case 'del':
                error("删除失败");
                if (!hasAsoRole('SKITLO')) error(ERROR_MSG);
                $id = I('id');
                $old_data = $db->where("id={$id}")->find();
                $update = $db->where("id=$id")->delete();
                if ($update) {
                    $old_ip_str = explode(",",$old_data['ip']);
                    foreach ($old_ip_str as $val) {
                        getRedis()->sDel($redis_ip_key.$val,$id);
                    }
                    getRedis()->del($redis_key.$id);
                    success('删除成功', U('Task/searchKeywordIpTaskList'));
                } else {
                    error('删除失败');
                }
                break;
            case 'copy':
                if (!hasAsoRole('SKITLO')) error(ERROR_MSG);
                $id = I('id');
                $old_data = $db->where("id={$id}")->find();
                $old_data['tag'] = "";
                $old_data['count'] = 0;
                $old_data['start'] = "";
                $old_data['end'] = "";
                $old_data['status'] = 0;
                unset($old_data['id']);
                $update = $db->add($old_data);
                if ($update) {
                    $old_data['id'] = $update;
                    getRedis()->set($redis_key.$update,$old_data);
                    $ip_str = explode(",",$old_data['ip']);
                    foreach ($ip_str as $val) {
                        getRedis()->sAdd($redis_ip_key.$val,$update);
                    }
                    success('复制成功', U('Task/searchKeywordIpTaskList'));
                } else {
                    error('复制失败');
                }
                break;
            case 'ajax':
                $short_name = I('short_name');
                $short_name = strtolower($short_name);
                $country_table_tmp = M("country_table_mst")->where("table_name like '%_{$short_name}%'")->select();
                $country_table_tmp_list = array();
                foreach ($country_table_tmp as $val) {
                    $country_table_tmp_list[$val['table_name']] = $val['table_name'];
                }
                echo $html->createInput('select', 'table_name', null, $country_table_tmp_list);exit;
                break;
            case 'ajax1':
                $short_name = I('short_name');
                $short_name = strtolower($short_name);
                $country_table_tmp = M("country_table_mst")->where("table_name like '%_{$short_name}%'")->select();
                $country_table_tmp_list = array();
                foreach ($country_table_tmp as $val) {
                    $country_table_tmp_list[$val['table_name']] = $val['table_name'];
                }
                echo $html->createInput('select', 'update_table_name', null, $country_table_tmp_list);exit;
                break;
            case 'ajax_get_package':
                $host_url = 'http://36.7.151.221:8086/';
                header("Content-type: text/html; charset=utf-8");
                $game_id = I('get.game_id');
                $arr = M('google_app_config')->where('id='.$game_id)->find();
                $arr['game_id'] = $game_id;
                $country_arr = explode("#", I('get.country'));

                //判断是否有无缓存信息
                $getRedisInfo = getRedis()->get('google_app_info@' . $arr['game_id']);

                if($arr['game_id'] == 839){
                        //处理apk
                        $getRedisInfo['server_url'] = str_replace($host_url, '/data/www/googlemanager/', $getRedisInfo['server_url']);
                        //下载成功调用春华的jar包
                        exec("java -jar /home/www/gtils/GoogleDelta.jar '" . $getRedisInfo['server_url'] . "' '" . $getRedisInfo['server_url'] . "_delta'");

                        //echo "java -jar /home/www/gtils/GoogleDelta.jar '" . $getRedisInfo['server_url'] . "' '" . $getRedisInfo['server_url'] . "_delta'";//exit;

                        $return_data = array(
                            'appName' => $getRedisInfo['appName'],'versionCode' => $getRedisInfo['versionCode'], 'versionName' => $getRedisInfo['versionName'], 'url' => $getRedisInfo['url'], 'is_redis' => 2, 'developerName' => $getRedisInfo['developerName']
                        );
                        $this->ajaxReturn(array('status' => 1, 'info' => '获取成功', 'data' => $return_data), 'json');
                }

                //apk安装日期目录
                $apk_date = date('md');

                //获取是否有误apk记录
                $google_apk_info = M('google_apk_mst')->where('game_id='.$arr['game_id'])->field(TRUE)->find();
                if($google_apk_info && $google_apk_info['down_load_url']){
                    $apk_file = str_replace($host_url .'Uploads/downloadPkgs/', '', $google_apk_info['down_load_url']);
                    $apk_file_arr = explode('/', $apk_file);
                    $apk_date = $apk_file_arr[0];
                }

                $getAccountInfo = $this->_getAccounInfo();
                $getAccountInfo['packageName'] = $arr['package_name'];
                $getAccountInfo['vendingCountry'] = $country_arr[0];
                $account_data['account_ids'][0] = $getAccountInfo;

                $account_file = 'detail_package_' . date('YmdHis') . rand(0, 9999) . '.txt';

                //TODO 将协议数据写入文件
                file_put_contents('/home/www/gtils/' . $account_file, json_encode($account_data));

                $locale='de_DE.UTF-8';
                setlocale(LC_ALL,$locale);
                putenv('LC_ALL='.$locale);
                //echo exec('locale charmap');

                //TODO
                exec('java -jar /home/www/gtils/gtils.jar detail 1 /home/www/gtils/' . $account_file, $output, $return_var);

                //TODO 删除临时文件
                @unlink('/home/www/gtils/' . $account_file);

                $data = json_decode($output[0], TRUE);
                $data = $data['results'][0];

                
                if($data['result'] != 'success'){
                    $this->ajaxReturn(array('status' => 0, 'info' => $data['result']), 'json');
                }

                if(($data['versionCode'] == $getRedisInfo['versionCode']) && ($data['appName'] == $getRedisInfo['appName'])){

                    //处理apk
                    $getRedisInfo['server_url'] = str_replace($host_url, '/data/www/googlemanager/', $getRedisInfo['server_url']);
                    //下载成功调用春华的jar包
                    exec("java -jar /home/www/gtils/GoogleDelta.jar '" . $getRedisInfo['server_url'] . "' '" . $getRedisInfo['server_url'] . "_delta'");

                    //echo "java -jar /home/www/gtils/GoogleDelta.jar '" . $getRedisInfo['server_url'] . "' '" . $getRedisInfo['server_url'] . "_delta'";//exit;

                    $return_data = array(
                        'appName' => $getRedisInfo['appName'],'versionCode' => $getRedisInfo['versionCode'], 'versionName' => $getRedisInfo['versionName'], 'url' => $getRedisInfo['url'], 'is_redis' => 2, 'developerName' => $getRedisInfo['developerName']
                    );
                    $this->ajaxReturn(array('status' => 1, 'info' => '获取成功', 'data' => $return_data), 'json');
                }

                //TODO 存在 versionCode 不同直接重新下载
                $apk_name = $data['appName'];
                $apk_name = str_replace(' /\/ ', '', $apk_name);
                $apk_name = str_replace(' / ', '', $apk_name);
                $apk_name = str_replace(' : ', '', $apk_name);
                $apk_name = str_replace('：', '', $apk_name);
                $apk_name = str_replace(':', '', $apk_name);
                $apk_name = str_replace(' * ', '', $apk_name);
                $apk_name = str_replace(' ? ', '', $apk_name);
                $apk_name = str_replace(' " ', '', $apk_name);
                $apk_name = str_replace(' < ', '', $apk_name);
                $apk_name = str_replace(' > ', '', $apk_name);
                $apk_name = str_replace(' | ', '', $apk_name);
                $apk_name = str_replace('/', ' ', $apk_name);
                $apk_name = str_replace('+', '', $apk_name);
                $apk_name = str_replace('🔥', '', $apk_name);

                $apk_name_temp = str_replace(" ", "\ ", $apk_name);
                $apk_name_temp = str_replace("&", "\&", $apk_name_temp);
                $apk_name_temp = str_replace("'", "\'", $apk_name_temp);
                $apk_name_temp = str_replace("(", "\(", $apk_name_temp);
                $apk_name_temp = str_replace(")", "\)", $apk_name_temp);

                $filePath = '/data/www/googlemanager/Uploads/downloadPkgs/' . $apk_date;

                if($data['additionalUrls']){
                    $obb_key = 'google_app_info@' . $arr['game_id'] . '#ooblist';
                    getRedis()->del($obb_key);
                    $obb_i = 1;
                    foreach ($data['additionalUrls'] as $oob_url){
                        $file_obb_url = 'http://192.168.11.250/downloadPkgs/' . $apk_date . '/' . $arr['package_name'] . '-' . $data['versionCode'] . '-' . $data['versionName'];
                        $down_obb_url = $host_url . 'Uploads/downloadPkgs/'. $apk_date . '/';
                        $file_obb_name = '';
                        if($obb_i == 1){
                            $file_obb_name = "\(" . $apk_name_temp . "\).obb";
                            $file_obb_name1 = "(" . $apk_name . ").obb";
                        }else{
                            $file_obb_name = "\(" . $apk_name_temp . "\)_" . $obb_i . ".obb";
                            $file_obb_name1 = "(" . $apk_name . ")_" . $obb_i . ".obb";

                        }
                        $file_obb_url .= $file_obb_name1;
                        $down_obb_url .= $file_obb_name1;

                        exec('wget "' . $oob_url . '" -O ' . $filePath . '/' . $file_obb_name, $output, $return_var);
                        //echo 'wget "' . $oob_url . '" -O ' . $filePath . '/' . $file_obb_name . '<br />';
                        if($return_var != 0){
                            exec('wget "' . $oob_url . '" -O ' . $filePath . '/' . $file_obb_name, $output, $return_var);
                        }

                        //TODO 本地服务器上路径
                        $obb_file_path = '/downloadPkgs/' . $apk_date . '/' . $arr['package_name'] . '-' . $data['versionCode'] . '-' . $data['versionName'] . $file_obb_name1;

                        getRedis()->lPush($obb_key, $file_obb_url . '$$' . ($filePath . '/' . $file_obb_name1) . '$$' . $obb_file_path . '$$' . $down_obb_url);

                        if($return_var == 0){
                            //TODO 下载成功调用春华的jar包 参数1原文件路径 参数2输出的新文件的路径
                            exec('java -jar /home/www/gtils/GoogleDelta.jar "' . $filePath . '/' . $file_obb_name1 . '" "' . $filePath . '/' . $file_obb_name1 . '_delta"');
                            //echo 'java -jar /home/www/gtils/GoogleDelta.jar "' . $filePath . '/' . $file_obb_name1 . '" "' . $filePath . '/' . $file_obb_name1 . '_delta"' . '<br/>';
                        }else{
                            //TODO 下载资源包不成功 需要服务器端再次下载处理
                            file_put_contents('/home/www/gtils/download_app.txt', $filePath . '/' . $file_obb_name . '|' . $oob_url);
                        }

                        $obb_i = $obb_i + 1;
                    }
                }


                //TODO 存入redis中
                //TODO 任务下载的地址链接
                $url = 'http://192.168.11.250/downloadPkgs/' . $apk_date . '/' . $arr['package_name'] . '-' . $data['versionCode'] . '-' . $data['versionName'] . '(' . $apk_name . ').apk';
                //本地服务器的路径地址
                $file_path = '/downloadPkgs/' . $apk_date . '/' . $arr['package_name'] . '-' . $data['versionCode'] . '-' . $data['versionName'] . '(' . $apk_name . ').apk';
                //TODO redis
                $appInfo = array(
                    'appName' => $data['appName'],'versionCode' => $data['versionCode'], 'versionName' => $data['versionName'], 'downloadUrl' => $data['downloadUrl'], 'last_time' => date('Y-m-d H:i:s'), 'country' => $country_arr[0], 'url' => $url, 'file_path' => $file_path, 'server_url' => $host_url . 'Uploads/downloadPkgs/'. $apk_date. '/(' . $apk_name . ').apk', 'developerName' => $data['developerName'], 'server_file_path' => "{$filePath}/({$apk_name}).apk",
                );
                getRedis()->set('google_app_info@' . $arr['game_id'], $appInfo);

                $return_data = array(
                    'appName' => $data['appName'], 'versionCode' => $data['versionCode'], 'versionName' => $data['versionName'], 'url' => $url, 'is_redis' => 2, 'developerName' => $data['developerName']
                );

                //创建保存目录
                if (!file_exists($filePath) && !mkdir($filePath, 0777, true)) {
                    //TODO 创建目录失败
                } else {
                    $output = array();
                    exec('wget "' . $data['downloadUrl'] . '" -O ' . $filePath . "/\(" . $apk_name_temp . "\).apk", $output, $return_var);
                    if ($return_var != 0) {
                        $output = array();
                        exec('wget "' . $data['downloadUrl'] . '" -O ' . $filePath . "/\(" . $apk_name_temp . "\).apk", $output, $return_var);
                    }
                }

                if ($return_var == 0) {

                    //TODO 下载成功调用春华的jar包
                    exec('java -jar /home/www/gtils/GoogleDelta.jar ' . $filePath . "/\(" . $apk_name_temp . "\).apk". ' ' . $filePath . "/\(" . $apk_name_temp . "\).apk" . '_delta');

                    $checkApk = M('google_apk_mst')->where('game_id=' . $game_id)->count();
                    //下载成功记录下载时间和应用信息
                    $apk_arr = array(
                        'game_id' => $game_id, 'down_load_url' => $host_url . 'Uploads/downloadPkgs/' . $apk_date . '/(' . $apk_name . ').apk',
                        'path_url' => $file_path, 'add_time' => date('Y-m-d H:i:s'), 'country' => $country_arr[0]
                    );
                    if ($checkApk) {
                        M('google_apk_mst')->where('game_id=' . $game_id)->save($apk_arr);
                    } else {
                        M('google_apk_mst')->add($apk_arr);
                    }


                    //TODO 调用春华jar包
                    $sign_file = rand(0, 99999) . '.txt';
                    exec('java -jar /home/www/gtils/ApkSignatureGetter.jar "/data/www/googlemanager/Uploads/downloadPkgs/' . $apk_date . '/(' . $apk_name . ').apk' .'" ' . $sign_file);
                    $get_sign = file_get_contents("/home/www/gtils/ApkSignatureGetter.jar" . $sign_file);
                    $get_sign_arr = explode('	', $get_sign);
                    if($get_sign_arr[1]){
                        $get_sign_arr[1] = str_replace(PHP_EOL, '', $get_sign_arr[1]);
                        getRedis()->set('google_apk_sign@' . $arr['package_name'], $get_sign_arr[1]);
                    }

                    @unlink("/home/www/gtils/ApkSignatureGetter.jar" . $sign_file);
                } else {
                    getRedis()->lPush('google_apk_mst_error_log', date('Y-m-d H:i:s') . '====>' . 'wget "' . $data['downloadUrl'] . '" -O ' . $filePath . "/\(" . $apk_name_temp . "\).apk");
                    $apk_arr = array(
                        'game_id' => $game_id, 'down_load_url' => $host_url . 'Uploads/downloadPkgs/' . $apk_date . '/(' . $apk_name . ').apk',
                        'path_url' => $file_path, 'add_time' => date('Y-m-d H:i:s'), 'country' => $country_arr[0],
                        'is_exist' => 2, //TODO 表示程序下载失败 需要服务器端再次处理
                    );
                    M('google_apk_mst')->add($apk_arr);
                }

                //todo 更新正在执行和未执行的任务
                $update_sql = "UPDATE search_keyword_ip_task SET `nick_name`='{$data['appName']}', `app_version`='{$data['versionCode']}', `versionName`='{$data['versionName']}', `signature`='{$url}',`developerName`='{$data['developerName']}' WHERE `package_name`='{$arr['package_name']}' AND `end` >= '" . date('Y-m-d H:00:00') . "'";
                M()->query($update_sql);

                $this->ajaxReturn(array('status' => 1, 'info' => '获取成功', 'data' => $return_data), 'json');

                break;
            case 'ajax_get_package_new':

                $host_url = 'http://36.7.151.221:8086/';
                $api_down_url = 'http://36.7.151.221:8085/';
                header("Content-type: text/html; charset=utf-8");
                $game_id = I('get.game_id');
                $arr = M('google_app_config')->where('id='.$game_id)->find();
                $arr['game_id'] = $game_id;
                $country_arr = explode("#", I('get.country'));

                //判断是否有无缓存信息
                $getRedisInfo = getRedis()->get('google_app_info@' . $arr['game_id']);
                //apk安装日期目录
                $apk_date = date('md');

                //获取是否有误apk记录
                $google_apk_info = M('google_apk_mst')->where('game_id='.$arr['game_id'])->field(TRUE)->find();
                if($google_apk_info && $google_apk_info['down_load_url']){
                    $apk_file = str_replace($host_url .'Uploads/downloadPkgs/', '', $google_apk_info['down_load_url']);
                    $apk_file_arr = explode('/', $apk_file);
                    $apk_date = $apk_file_arr[0];
                }

                $getAccountInfo = $this->_getAccounInfo();
                $getAccountInfo['packageName'] = $arr['package_name'];
                $getAccountInfo['vendingCountry'] = $country_arr[0];
                $account_data['account_ids'][0] = $getAccountInfo;

                $account_file = 'detail_package_' . date('YmdHis') . rand(0, 9999) . '.txt';

                //TODO 将协议数据写入文件
                file_put_contents('/home/www/gtils/' . $account_file, json_encode($account_data));

                $locale='de_DE.UTF-8';
                setlocale(LC_ALL,$locale);
                putenv('LC_ALL='.$locale);
                //echo exec('locale charmap');

                //TODO
                exec('java -jar /home/www/gtils/gtils.jar detail 1 /home/www/gtils/' . $account_file, $output, $return_var);

                //TODO 删除临时文件
                @unlink('/home/www/gtils/' . $account_file);

                $data = json_decode($output[0], TRUE);
                $data = $data['results'][0];
                dump($data);
                if($data['result'] != 'success'){
                    $this->ajaxReturn(array('status' => 0, 'info' => $data['result']), 'json');
                }


                if(($data['versionCode'] == $getRedisInfo['versionCode']) && ($data['appName'] == $getRedisInfo['appName'])){

                    //处理apk
                    $getRedisInfo['server_url'] = str_replace($host_url, '/data/www/googlemanager/', $getRedisInfo['server_url']);
                    //下载成功调用春华的jar包
                    exec("java -jar /home/www/gtils/GoogleDelta.jar '" . $getRedisInfo['server_url'] . "' '" . $getRedisInfo['server_url'] . "_delta'");

                    //TODO 获取当前版本号redis信息
                    $apk_version_info = getRedis()->get("google_app_info@{$arr['game_id']}#{$data['versionCode']}");
                    if($apk_version_info){
                        $task_downapk_url = $apk_version_info;
                    }else{
                        //TODO
                        $task_downapk_url = $api_down_url . str_replace('/data/www/googlemanager/','', $getRedisInfo['server_url']) . "_delta";
                        getRedis()->set("google_app_info@{$arr['game_id']}#{$data['versionCode']}", $task_downapk_url);
                    }

                    $return_data = array(
                        'appName' => $getRedisInfo['appName'],'versionCode' => $getRedisInfo['versionCode'], 'versionName' => $getRedisInfo['versionName'], 'url' => $task_downapk_url, 'is_redis' => 2, 'developerName' => $getRedisInfo['developerName']
                    );
                    $this->ajaxReturn(array('status' => 1, 'info' => '获取成功', 'data' => $return_data), 'json');
                }


                break;
            case 'ajax_package_info':
                $game_id = I('get.game_id');
                $arr = M('google_app_config')->where('id='.$game_id)->find();
                $arr['game_id'] = $game_id;
                $country_arr = explode("#", I('get.country'));

                //判断是否有无缓存信息
                $getRedisInfo = getRedis()->get('google_app_info@' . $arr['game_id']);
                if($getRedisInfo){

                    if($getRedisInfo['appName'] && $getRedisInfo['versionCode'] && $getRedisInfo['versionName'] && $getRedisInfo['url']){
                        $return_data = array(
                            'appName' => $getRedisInfo['appName'],'versionCode' => $getRedisInfo['versionCode'], 'versionName' => $getRedisInfo['versionName'], 'url' => $getRedisInfo['url'], 'is_redis' => 2, 'developerName' => $getRedisInfo['developerName']
                        );
                        $this->ajaxReturn(array('status' => 1, 'info' => '获取成功', 'data' => $return_data), 'json');
                    }else{
                        $this->ajaxReturn(array('status' => 0, 'info' => '获取失败'), 'json');
                    }

                }else{
                    $this->ajaxReturn(array('status' => 0, 'info' => '获取失败'), 'json');
                }
                break;
            case 'ajax_get_search':
                $game_id = I('get.game_id');
                $arr = M('google_app_config')->where('id='.$game_id)->find();
                $arr['game_id'] = $game_id;
                $country_arr = explode("#", I('get.country'));

                $account_data = array();
                $getAccountInfo = $this->_getAccounInfo();
                $getAccountInfo['packageName'] = $arr['package_name'];
                $getAccountInfo['vendingCountry'] = $country_arr[0];
                $getAccountInfo['keyWords'] = trim(I('get.keyword'));
                $account_data['account_ids'][] = $getAccountInfo;

                $locale='de_DE.UTF-8';
                setlocale(LC_ALL,$locale);
                putenv('LC_ALL='.$locale);

                //TODO 生成的临时账号数据文件
                $rand_text_name = 'search_' . date('YmdHis') . rand(0, 999) . '.txt';

                //TODO 将协议数据写入文件
                file_put_contents('/home/www/gtils/' . $rand_text_name, json_encode($account_data));

                //TODO
                exec('java -jar /home/www/gtils/gtils10.jar search 1 /home/www/gtils/' . $rand_text_name, $output, $return_var);

                @unlink('/home/www/gtils/' . $rand_text_name);

                $data = json_decode($output[0], TRUE);

                if($data['results'][0]['rank'] > -1){
                    $this->ajaxReturn(array('status' => 1, 'info' => '校验成功,当前关键词即时排名[' . $data['results'][0]['rank'] . ']！', 'data' => array('rank' => $data['results'][0]['rank'])), 'json');
                }
                if($data['results'][0]['rank'] == -1){
                    $this->ajaxReturn(array('status' => 0, 'info' => '当前关键词没有搜索到！'), 'json');
                }
                $this->ajaxReturn(array('status' => 0, 'info' => $data['result']), 'json');

                break;
            case 'import':
                if ($_FILES) {
                    if(isset($_FILES['efile']))
                    {
                        $file = $_FILES['efile'];
                        if($file['error']===0)
                        {
                            $cp_data = M("google_cp_config")->select();
                            foreach($cp_data as $v){
                                $cp_list[$v['cid']] = $v['name'];
                            }
                            $package_data = M("google_app_config")->where('status=1')->select();
                            foreach($package_data as $v){
                                $package_list[$v['package_name']] = $v['id']."##".$v['game_name']."##".$v['package_name'];
                            }
                            import('@.Org.ReadExcel');
                            $reader = new \ReadExcel();
                            $data = $reader->readstr($file['tmp_name'], substr($file['name'], strrpos($file['name'],'.')+1),'A',1,'C');
                            if(!empty($data))
                            {
                                $s = $f = 0;
                                foreach($data as $v)
                                {
                                    if (!trim($v['0']) || !trim($v['1']) || !trim($v['2']) || !trim($v['3']) || !trim($v['5'])) {
                                        $f++;
                                        continue;
                                    }
                                    $arr['tag'] = trim($v['0']);
                                    $country_name = trim($v['1']);
                                    $country_language_list = getCountryLanguage(1);
                                    $country_name = $country_language_list[$country_name];
                                    $country_language = explode('#', $country_name);
                                    $arr['country'] = trim($country_language[0]);
                                    $arr['language'] = trim($country_language[1]);
                                    $cp_name = trim($v['2']);
                                    $arr['cp'] = $cp_list[$cp_name];
                                    $package_name_data = trim($v['3']);
                                    $package_name = $package_list[$package_name_data];
                                    $package_name_arr = explode("##",$package_name);
                                    $arr['game_id'] = $package_name_arr[0];
                                    $arr['game_name'] = $package_name_arr[1];
                                    $arr['package_name'] = $package_name_arr[2];
                                    $arr['keyword'] = trim($v['4']) ? trim($v['4']) : '';
                                    if(trim($v['16'])){
                                        $arr['secord_keyword'] = trim($v['16']);
                                    }
                                    $arr['add_time'] = date('Y-m-d H:i:s');
                                    $start_time = trim($v['5']);
                                    $end_time = trim($v['6']);
                                    $arr['start'] = date("Y-m-d H:i:s",strtotime($start_time));
                                    $arr['end'] = date("Y-m-d H:i:s",strtotime($end_time));
                                    $arr['count'] = trim($v['7']);
                                    $arr['hot'] = trim($v['8']);
                                    if($v['9']){
                                        $store_country_name = trim($v['9']);
                                        $store_country_name = $country_language_list[$store_country_name];
                                        $store_country_name_arr = explode('#', $store_country_name);
                                        $arr['store_country'] = trim($store_country_name_arr[0]);
                                    }

                                    $arr['comment_rate'] = $v[10] ? $v[10] : 0;
                                    $arr['comment_type'] = $v[11] ? $v[11] : 0;
                                    $arr['star'] = $v[12] ? $v[12] : 0;
                                    $arr['comment_start_id'] = $v[13] ? $v[13] : 0;
                                    $arr['score'] = $v[15] ? $v[15] : 0;
                                    $arr['table_name'] = $v[14] ? $v[14] : "";
                                    $arr['task_class'] = $v[17] ? $v[17] : "";
                                    $arr['admin_name'] = getAdminName();
                                    $arr['operate_type'] = "导入任务";

                                    $arr['status'] = 9;
                                    $arr['type'] = 2;
                                    $addResult = $db->add($arr);
                                    if ($addResult) {
                                        $s++;
                                    } else {
                                        $f++;
                                    }
                                }
                                success("导入数据 成功{$s}条，失败{$f}条", U('Task/searchKeywordIpTaskList'));
                            }
                            else
                                error('上传文件为空');
                        }
                        else
                            error('文件上传失败，请重新上传');
                    }
                }
                $this->assign('efile', $html->createInput('file', 'efile'));//文件
                $this->nav = array(
                    '应用列表' => array('link' => '/index.php?m=Home&c=Task&a=searchKeywordIpTaskList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Task&a=searchKeywordIpTaskList&method=add', 'icon' => 'icon_add'),
                    '批量添加' => array('icon' => 'icon_edit', 'selected' => 1),
                    '多个关键词批量添加' => array('link' => '/index.php?m=Home&c=Task&a=searchKeywordIpTaskList&method=import_more_keyword', 'icon' => 'icon_add'),
                );
                $this->main = $this->fetch('Task:searchKeywordIpTaskList_import');
                $this->_out();
                break;
            case 'import_more_keyword':
                if ($_FILES) {
                    if(isset($_FILES['efile'])){
                        $file = $_FILES['efile'];
                        if($file['error']===0)
                        {
                            $cp_data = M("google_cp_config")->select();
                            foreach($cp_data as $v){
                                $cp_list[$v['cid']] = $v['name'];
                            }
                            $package_data = M("google_app_config")->where('status=1')->select();
                            foreach($package_data as $v){
                                $package_list[$v['package_name']] = $v['id']."##".$v['game_name']."##".$v['package_name']."##".$v['cp_name'];
                            }
                            import('@.Org.ReadExcel');
                            $reader = new \ReadExcel();
                            $data = $reader->readstr($file['tmp_name'], substr($file['name'], strrpos($file['name'],'.')+1),'A',1,'C');
                            if(!empty($data))
                            {
                                $s = $f = 0;
                                foreach($data as $v)
                                {
                                    if (!trim($v['0']) || !trim($v['1']) || !trim($v['2']) || !trim($v['3'])) {
                                        $f++;
                                        continue;
                                    }
                                    $arr['tag'] = 2;
                                    $country_name = trim($v[0]);
                                    $country_name = strtoupper($country_name);
                                    $countryInfo = M('country_mst')->where("short_name='{$country_name}'")->find();
                                    if(!$countryInfo){
                                        $f++;
                                        continue;
                                    }
                                    $arr['country'] = $country_name;
                                    $arr['language'] = trim($countryInfo['language']);
                                    $arr['store_country'] = $country_name;
                                    $package_name_data = trim($v['1']);
                                    $package_name = $package_list[$package_name_data];
                                    $package_name_arr = explode("##",$package_name);
                                    $arr['game_id'] = $package_name_arr[0];
                                    $arr['game_name'] = $package_name_arr[1];
                                    $arr['package_name'] = $package_name_arr[2];
                                    $arr['cp'] = $package_name_arr[3];
                                    $arr['keyword'] = '';
                                    $arr['add_time'] = date('Y-m-d H:i:s');
                                    $start_time = trim($v['2']);
                                    $end_time = trim($v['3']);
                                    $arr['start'] = date("Y-m-d H:i:s",strtotime($start_time));
                                    $arr['end'] = date("Y-m-d H:i:s",strtotime($end_time));
                                    $keyword_count = intval(trim($v['5']));         //关键词个数
                                    if($keyword_count){
                                        //TODO 这里获取关键词信息
                                        $temp_where = array(
                                            'package_name' => $arr['package_name'],
                                            'country' => $arr['country'],
                                            'datetime' => date('Y-m-d'),
                                            'rank' => array('GT', 3),
                                        );
                                        $list = M('app_keywords')->field('id,word,rank')->where($temp_where)->order('rank ASC')->limit("{$keyword_count}")->select();
                                        if($list){
                                            $keywords_arr = array();
                                            foreach($list as $keywordInfo){
                                                $keywords_arr[] = $keywordInfo['word'];
                                            }
                                            $arr['secord_keyword'] = implode('$$', $keywords_arr);
                                            $arr['num_keyword'] = intval(trim($v['6']));  //走关键词数量$arr['num_keyword'] = intval(trim($v['8']));  //走关键词数量
                                        }else{
                                            $arr['secord_keyword'] = '';
                                            $arr['num_keyword'] = 0;
                                        }
                                    }else{
                                        if(trim($v['4'])){
                                            $keyword_arr = explode('$$', $v['4']);
                                            if(count($keyword_arr) == 1){
                                                $arr['keyword'] = trim($v['4']);
                                                $arr['num_keyword'] = intval(trim($v['6']));
                                            }else{
                                                $arr['secord_keyword'] = trim($v['4']);
                                                $arr['num_keyword'] = intval(trim($v['6']));
                                            }
                                        }
                                    }

                                    $arr['num_detail'] = intval(trim($v['7']));  //走关键词数量
                                    $arr['count'] = $arr['num_keyword'] + $arr['num_detail'];  //关键词数量+走detail数量
                                    $arr['table_name'] = $v[8] ? $v[8] : "";
                                    $arr['comment_rate'] = $v[9] ? $v[9] : 0;
                                    $arr['comment_type'] = $v[10] ? $v[10] : 0;
                                    $arr['star'] = $v[11] ? $v[11] : 0;
                                    $arr['comment_start_id'] = $v[12] ? $v[12] : 0;
                                    $arr['score'] = $v[13] ? $v[13] : 0;
                                    $arr['task_class'] = $v[14] ? $v[14] : "";
                                    $arr['admin_name'] = getAdminName();
                                    $arr['operate_type'] = "导入任务";
                                    $arr['status'] = 9;
                                    $arr['type'] = 2;

                                    $addResult = $db->add($arr);
                                    if ($addResult) {
                                        $s++;
                                    } else {
                                        echo $db->getDbError();exit;
                                        $f++;
                                    }
                                }
                                success("导入数据 成功{$s}条，失败{$f}条", U('Task/searchKeywordIpTaskList'));
                            }
                            else
                                error('上传文件为空');
                        }
                        else
                            error('文件上传失败，请重新上传');
                    }
                }
                $this->assign('efile', $html->createInput('file', 'efile'));//文件
                $this->nav = array(
                    '应用列表' => array('link' => '/index.php?m=Home&c=Task&a=searchKeywordIpTaskList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Task&a=searchKeywordIpTaskList&method=add', 'icon' => 'icon_add'),
                    '批量添加' => array('link' => '/index.php?m=Home&c=Task&a=searchKeywordIpTaskList&method=import', 'icon' => 'icon_add'),
                    '多个关键词批量添加' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:searchKeywordIpTaskList_importMoreKey');
                $this->_out();
                break;
        }
    }

    public function searchRank(){
        if (!hasAsoRole('SYYPM')) error(ERROR_MSG);
        $method = $_GET['method'] ? $_GET['method'] : 'show';
        $html = new \Home\Org\Html();
        switch ($method) {
            case 'show':
                $this->assign('country', $html->createInput('select', 'country', null, getCountryLanguage()));
                $this->assign('cp', $html->createInput('select', 'cp', null, getCpList()));
                $this->assign('package_name', $html->createInput('select', 'package_name', null, getGameList(2)));
                $this->assign('nick_name', $html->createInput('text', 'nick_name', null, null, array('size' => 40)));
                $this->assign('keyword', $html->createInput('text', 'keyword'));
                $this->main = $this->fetch('Task:searchRank');
                $this->_out();
                break;
            case 'ajax_get_search':
                $game_id = I('get.game_id');
                $arr = M('google_app_config')->where('id='.$game_id)->find();
                $arr['game_id'] = $game_id;
                $country_arr = explode("#", I('get.country'));

                $account_data = array();
                $getAccountInfo = $this->_getAccounInfo(1084);
                $getAccountInfo['packageName'] = $arr['package_name'];
                $getAccountInfo['vendingCountry'] = $country_arr[0];
                $getAccountInfo['keyWords'] = trim(I('get.keyword'));
                //'language' => 'en',
                //'country' => 'US',
                //$getAccountInfo['language'] = 'zh';
                //$getAccountInfo['country'] = 'TW';

                $account_data['account_ids'][] = $getAccountInfo;

                $locale='de_DE.UTF-8';
                setlocale(LC_ALL,$locale);
                putenv('LC_ALL='.$locale);

                //TODO 生成的临时账号数据文件
                $rand_text_name = 'search_' . date('YmdHis') . rand(0, 999) . '.txt';

                //TODO 将协议数据写入文件
                file_put_contents('/home/www/gtils/' . $rand_text_name, json_encode($account_data));

                //TODO
                exec('java -jar /home/www/gtils/gtils10.jar search 1 /home/www/gtils/' . $rand_text_name, $output, $return_var);

                //@unlink('/home/www/gtils/' . $rand_text_name);

                $data = json_decode($output[0], TRUE);

                if($data['results'][0]['rank'] > -1){
                    $this->ajaxReturn(array('status' => 1, 'info' => '校验成功,当前关键词可以搜索到！', 'data' => array('rank' => $data['results'][0]['rank'])), 'json');
                }
                if($data['results'][0]['rank'] == -1){
                    $this->ajaxReturn(array('status' => 0, 'info' => '当前关键词没有搜索到！'), 'json');
                }
                $this->ajaxReturn(array('status' => 0, 'info' => $data['result']), 'json');

                break;
        }
    }

    //任务管理->账号任务管理->国家运营商管理
    function countryInfoList() {
        if (!hasAsoRole('CIL')) error(ERROR_MSG);
        $method = I('method') ? I('method') : 'show';
        $html = new \Home\Org\Html();
        $db = M('country_info_mst');
        switch ($method) {
            case 'show':
                $tableName = 'country_info_mst';
                $searchArr = array(
                    '搜索' => array(
                        '国家简码：' => array('name' => 'country_short', 'type' => 'text'),
                    )
                );
                $searchHtml = TableController::createSearch1($tableName, $searchArr);
                //分页
                $wh = IphoneController::getWhereConfig($tableName);
                $count = $db->where($wh)->count();
                $pagesize = 100;
                $parameter = TableController::getGlobalWhere1($tableName) ? merge($_GET, array('where' => TableController::getGlobalWhere1($tableName))) : '';
                $page = new \Home\Org\Page($count, $pagesize, $parameter);
                $data = $db->where($wh)->order('id desc')->limit($page->firstRow, $page->listRows)->select();
                $pager = $page->show();
                $this->pager = '<div class="pager">' . $pager . '</div>';
                //数据处理
                foreach ($data as &$v) {
                        $v['caozuo'] = $this->createOperate(array(
                            array('act' => 'edit', 'id' => $v['id']),
                            array('act' => 'del', 'id' => $v['id']),
                        ), "countryInfoList");
                }
                $this->assign('data', $data);
                    $this->nav = array(
                        '国家运营商管理' => array('icon' => 'icon_grid', 'selected' => 1),
                        '添加' => array('link' => '/index.php?m=Home&c=Task&a=countryInfoList&method=add', 'icon' => 'icon_add'),
                    );
                $this->main = $searchHtml . $this->fetch('Task:countryInfoList');
                $this->_out();
                break;
            case 'add':
                if (!hasAsoRole('CIL')) error(ERROR_MSG);
                if ($_POST) {
                    $arr['mcc'] = trim($_POST['mcc']);
                    $arr['mnc'] = trim($_POST['mnc']);
                    $arr['operator'] = trim($_POST['operator']);
                    $arr['country_short'] = trim($_POST['country_short']);
                    $arr['time_zone'] = trim($_POST['time_zone']);
                    $arr['country_code'] = trim($_POST['country_code']);
                    $addResult = $db->add($arr);
                    if ($addResult) {
                        success('添加成功', U('Task/countryInfoList'));
                    } else {
                        error('添加失败');
                    }
                }
                $this->assign('mcc', $html->createInput('text', 'mcc'));
                $this->assign('mnc', $html->createInput('text', 'mnc'));
                $this->assign('operator', $html->createInput('text', 'operator'));
                $this->assign('country_short', $html->createInput('text', 'country_short'));
                $this->assign('time_zone', $html->createInput('text', 'time_zone'));
                $this->assign('country_code', $html->createInput('text', 'country_code'));
                $this->nav = array(
                    '国家运营商管理' => array('link' => '/index.php?m=Home&c=Task&a=countryInfoList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:countryInfoList_add');
                $this->_out();
                break;
            case 'edit':
                if (!hasAsoRole('CIL')) error(ERROR_MSG);
                if ($_POST) {
                    $arr['mcc'] = trim($_POST['mcc']);
                    $arr['mnc'] = trim($_POST['mnc']);
                    $arr['operator'] = trim($_POST['operator']);
                    $arr['country_short'] = trim($_POST['country_short']);
                    $arr['time_zone'] = trim($_POST['time_zone']);
                    $arr['country_code'] = trim($_POST['country_code']);
                    $id = I('post.id');
                    $update = $db->where("id=$id")->save($arr);
                    if ($update) {
                        success('修改成功', U('Task/countryInfoList'));
                    } else {
                        error('修改失败');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $this->assign('id', $id);
                $this->assign('mcc', $html->createInput('text', 'mcc', $data['mcc']));
                $this->assign('mnc', $html->createInput('text', 'mnc', $data['mnc']));
                $this->assign('operator', $html->createInput('text', 'operator', $data['operator']));
                $this->assign('country_short', $html->createInput('text', 'country_short', $data['country_short']));
                $this->assign('time_zone', $html->createInput('text', 'time_zone', $data['time_zone']));
                $this->assign('country_code', $html->createInput('text', 'country_code', $data['country_code']));
                $this->nav = array(
                    '国家运营商管理' => array('link' => '/index.php?m=Home&c=Task&a=countryInfoList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Task&a=countryInfoList&method=add', 'icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:countryInfoList_edit');
                $this->_out();
                break;
            case 'del':
                if (!hasAsoRole('CIL')) error(ERROR_MSG);
                $id = I('id');
                $update = $db->where("id=$id")->delete();
                if ($update) {
                    success('删除成功', U('Task/countryInfoList'));
                } else {
                    error('删除失败');
                }
                break;
        }
    }

    //任务管理->账号任务管理->国家管理
    function countryMst() {
        if (!hasAsoRole('CIL')) error(ERROR_MSG);
        $method = I('method') ? I('method') : 'show';
        $html = new \Home\Org\Html();
        $db = M('country_mst');
        $short_name_data = M('country_info_mst')->query("select DISTINCT country_short from country_info_mst");
        foreach ($short_name_data as $val) {
            $short_name_list[$val['country_short']] = $val['country_short'];
        }
        switch ($method) {
            case 'show':
                //分页
                $count = $db->count();
                $pagesize = 100;
                $parameter = '';
                $page = new \Home\Org\Page($count, $pagesize, $parameter);
                $data = $db->order('id desc')->limit($page->firstRow, $page->listRows)->select();
                $pager = $page->show();
                $this->pager = '<div class="pager">' . $pager . '</div>';
                //数据处理
                foreach ($data as &$v) {
                    $key = "account_machine_list_".$v['short_name'];
                    $v['count'] = getRedis()->zCard($key);
                    $v['caozuo'] = $this->createOperate(array(
                        array('act' => 'edit', 'id' => $v['id']),
                        array('act' => 'del', 'id' => $v['id']),
                    ), "countryMst");
                }

                $result = M('country_table_mst')->where("`table_name` LIKE '%from%'")->order('suffix ASC')->select();
                foreach ($result as &$v) {
                    $key = "account_machine_list_" . $v['short_name'] . '_' . $v['suffix'];
                    $v['count'] = getRedis()->zCard($key);
                    $v['caozuo'] = '改绑账号：' . $v['table_name'] . '=>' . $v['remark'];
                    $v['name'] = $v['country'];
                    $v['language'] = $v['short_name'];
                    $data[] = $v;
                }


                $this->assign('data', $data);
                $this->nav = array(
                    '国家管理' => array('icon' => 'icon_grid', 'selected' => 1),
                    '添加' => array('link' => '/index.php?m=Home&c=Task&a=countryMst&method=add', 'icon' => 'icon_add'),
                );
                $this->main = $this->fetch('Task:countryMst');
                $this->_out();
                break;
            case 'add':
                if ($_POST) {
                    $arr['name'] = trim($_POST['name']);
                    $arr['short_name'] = trim($_POST['short_name']);
                    $arr['language'] = trim($_POST['language']);
                    $result = $db->add($arr);
                    if ($result) {
                        success('添加成功', U('Task/countryMst'));
                    } else {
                        error('添加失败');
                    }
                }
                $this->assign('name', $html->createInput('text', 'name'));
                $this->assign('short_name', $html->createInput('select', 'short_name',null,$short_name_list));
                $this->assign('language', $html->createInput('text', 'language'));
                $this->nav = array(
                    '国家管理' => array('link' => '/index.php?m=Home&c=Task&a=countryMst&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:countryMst_add');
                $this->_out();
                break;
            case 'edit':
                if ($_POST) {
                    $arr['name'] = trim($_POST['name']);
                    $arr['short_name'] = trim($_POST['short_name']);
                    $arr['language'] = trim($_POST['language']);
                    $id = I('post.id');
                    $update = $db->where("id=$id")->save($arr);
                    if ($update) {
                        success('修改成功', U('Task/countryMst'));
                    } else {
                        error('修改失败');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $this->assign('id', $id);
                $this->assign('name', $html->createInput('text', 'name', $data['name']));
                $this->assign('short_name', $html->createInput('select', 'short_name', $data['short_name'], $short_name_list));
                $this->assign('language', $html->createInput('text', 'language', $data['language']));
                $this->nav = array(
                    '国家管理' => array('link' => '/index.php?m=Home&c=Task&a=countryMst&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Task&a=countryMst&method=add', 'icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:countryMst_edit');
                $this->_out();
                break;
            case 'del':
                $id = I('id');
                $update = $db->where("id=$id")->delete();
                if ($update) {
                    success('删除成功', U('Task/countryMst'));
                } else {
                    error('删除失败');
                }
                break;
        }
    }

    //任务管理->协议任务管理->协议管理
    function agreementList()
    {
        if (!hasAsoRole('AMLO')) error(ERROR_MSG);
        $method = I('get.method') ? I('get.method') : 'show';
        $html = new \Home\Org\Html();
        $db = M('agreement_mst');
        $task_tag_list1 = getTaskTagList(2);
        switch ($method) {
            case 'show':
                $agreement_sid_one = "";
                $agreement_sid_list = getAgreementSidList();
                foreach ($agreement_sid_list as $val) {
                    if (!empty($val)) {
                        $agreement_sid_one = $val;
                        break;
                    }
                }
                $search_id = I("post.search_id") ? I("post.search_id") : "";
                $search_tag = I("post.search_tag") ? I("post.search_tag") : "";
                if (isset($_POST['search_sid_group'])) {
                    if ($_POST['search_sid_group'] == "") {
                        $agreement_sid_one = "";
                    } else {
                        $agreement_sid_one = $_POST['search_sid_group'];
                    }
                }
                $wh = "sid is not null ";
                if (!empty($search_id)) {
                    $wh .= " and sid like '%{$search_id}%'";
                }
                if (!empty($agreement_sid_one)) {
                    $wh .= " and sid like '%{$agreement_sid_one}%'";
                }
                if (!empty($search_tag)) {
                    $wh .= " and tag like '%{$search_tag}%'";
                }
                $data = $db->where($wh)->order('id desc')->select();
                foreach ($data as &$v) {
                    $v['selectid'] = '<input name="id[]" type="checkbox" value="' . $v['id'] . '"/>';
                    $heartbeat_redis = getRedis()->get("agreement_heartbeat_time@" . $v['sid']);
                    $v['exception'] = '';
                    if (!empty($heartbeat_redis)) {
                        if (time() - strtotime($heartbeat_redis) > 600) {
                            $v['exception'] = 'exception';
                            $v['heartbeat'] = $heartbeat_redis;
                        } else {
                            $v['heartbeat'] = "<span style='color:red'>" . $heartbeat_redis . "</span>";
                        }
                    }
                    $v['tag'] = $task_tag_list1[$v['tag']];  //tag
                    $v['used_vpn'] = getRedis()->get("google_api_client_useing_vpn@".$v['id']);  //当前使用的vpn
                    $v['status'] = IphoneController::creatAjaxRadio2("agreement_mst", "status", $v['id'], $v['status']);
                    $v['caozuo'] = $this->createOperate(array(
                        array('act' => 'edit', 'id' => $v['id']),
                        array('act' => 'del', 'id' => $v['id']),
                    ), "agreementList");
                }
                $this->assign('data', $data);
                $this->assign('group_tag', $html->createInput('select', 'group_tag',null,getTaskTagList()));//批量修改tag
                $this->assign('group_thread', $html->createInput('text', 'group_thread', '不修改'));//批量修改端口
                $this->assign('group_status', $html->createInput('select', 'group_status',null,C('YESORNO')));//批量启用禁用
                $this->assign('group_del', $html->createInput('radio', 'group_del', 'no', array('是' => 'yes', '否' => 'no')));//批量删除

                $this->nav = array(
                    '协议列表' => array('icon' => 'icon_grid', 'selected' => 1),
                    '添加' => array('link' => '/index.php?m=Home&c=Task&a=agreementList&method=add', 'icon' => 'icon_add'),
                );
                $this->assign("search_id", $html->createInput("text", "search_id", $search_id));
                $this->assign("search_tag", $html->createInput("select", "search_tag", $search_tag, getTaskTagList()));
                $this->assign("search_sid_group", $html->createInput("select", "search_sid_group", $agreement_sid_one, getAgreementSidList()));
                $this->assign("url", U('Task/agreementList', array("method" => "show")));
                $this->main = $this->fetch('Task:agreementList');
                $this->_out();
                break;
            case 'add':
                if ($_POST) {
                    $arr['tag'] = trim($_POST['tag']);
                    $arr['thread'] = trim($_POST['thread']);
                    $arr['addtime'] = date('Y-m-d H:i:s');
                    $update = $db->add($arr);
                    if ($update) {
                        $data = $db->where("id=$update")->find();
                        getRedis()->set("agreement_task_info@" . $data['sid'], $data);
                        success('添加成功', U('Task/agreementList'));
                    } else {
                        error('添加失败');
                    }
                }
                $this->assign('tag', $html->createInput('select', 'tag',null,getTaskTagList()));
                $this->assign('thread', $html->createInput('text', 'thread'));
                $this->nav = array(
                    '协议列表' => array('link' => '/index.php?m=Home&c=Task&a=agreementList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:agreementList_add');
                $this->_out();
                break;
            case 'edit':
                if ($_POST) {
                    $arr['tag'] = trim($_POST['tag']);
                    $arr['thread'] = trim($_POST['thread']);
                    $id = I('post.id');
                    $update = $db->where("id=$id")->save($arr);
                    if ($update) {
                        $data = $db->where("id=$id")->find();
                        getRedis()->set("agreement_task_info@" . $data['sid'], $data);
                        success('修改成功', U('Task/agreementList'));
                    } else {
                        error('修改失败');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $this->assign('id', $id);
                $this->assign('tag', $html->createInput('select', 'tag',$data['tag'],getTaskTagList()));
                $this->assign('thread', $html->createInput('text', 'thread',$data['thread']));
                $this->nav = array(
                    '协议列表' => array('link' => '/index.php?m=Home&c=Task&a=agreementList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Task&a=agreementList&method=add', 'icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:agreementList_edit');
                $this->_out();
                break;
            case 'del':
                if (!hasAsoRole('IPHONEO')) error(ERROR_MSG);
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $update = $db->where("id=$id")->delete();
                if ($update) {
                    getRedis()->del("agreement_task_info@" . $data['sid']);
                    success('删除成功', U('Task/agreementList'));
                } else {
                    error('删除失败');
                }
                break;
            case 'group':
                //批量操作
                $idArr = $_POST['id'];
                $group_tag = trim($_POST['group_tag']);
                $group_thread = trim($_POST['group_thread']);
                $group_status = trim($_POST['group_status']);
                $group_del = $_POST['group_del'];
                $datas = M('agreement_mst')->query("select * from agreement_mst where id in ({$idArr})");
                if ($group_del == "yes") {
                    M('agreement_mst')->query("delete from agreement_mst where id in ({$idArr})");
                    foreach ($datas as $val) {
                        if (!empty($val['sid'])) {
                            getRedis()->del("agreement_task_info@" . $val['sid']);
                        }
                    }
                    echo '删除成功';
                    exit;
                } else {
                    if ($group_tag != "") {
                        $arr['tag'] = $group_tag;
                    }
                    if ($group_thread != "不修改") {
                        $arr['thread'] = $group_thread;
                    }
                    if ($group_status != "") {
                        $arr['status'] = $group_status;
                    }
                    $where_vps['_string'] = 'id in (' . $idArr . ')';
                    $list = M('agreement_mst')->where($where_vps)->save($arr);
                    foreach ($datas as $val) {
                        if ($group_tag != "") {
                            $val['tag'] = $group_tag;
                        }
                        if ($group_thread != "不修改") {
                            $val['thread'] = $group_thread;
                        }
                        if ($group_status != "") {
                            $val['status'] = $group_status;
                        }
                        if (!empty($val['sid'])) {
                            getRedis()->set("agreement_task_info@" . $val['sid'], $val);
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

    //应用管理展开弹窗
    function appGroupDetailList() {
        $db = M('country_mst');
        $groupid = I('groupid');
        $data = $db->query("select DISTINCT short_name,name from country_mst");
        $result = array();
        foreach ($data as $val) {
            $now_maxid = getRedis()->get("app_maxid_app_id_{$groupid}_{$val['short_name']}");
            $maxid = getRedis()->get("account_max_score_{$val['short_name']}");
            $tmp['name'] = $val['name'];
            $tmp['maxid'] = $maxid;
            $tmp['total_account'] = getRedis()->zcard("account_machine_list_{$val['short_name']}");
            $tmp['used_account'] = getRedis()->zSize("account_machine_list_{$val['short_name']}",1,$now_maxid);
            $tmp['nouse_account'] = getRedis()->zSize("account_machine_list_{$val['short_name']}",($now_maxid+1),$maxid);
            array_push($result,$tmp);
        }
        $html = "<table><th>国家</th><th>总数</th><th>已使用</th><th>剩余</th>";
        foreach ($result as $val) {
            $html .= "<tr>";
            $html .= "<td>" . $val['name'] . "</td>";
            $html .= "<td>" . $val['total_account'] . "</td>";
            $html .= "<td>" . $val['used_account'] . "</td>";
            $html .= "<td>" . $val['nouse_account'] . "</td>";
            $html .= "</tr>";
        }
        $html .= "</table>";
        echo $html;
        exit;
    }

    //立即更新任务
    function updateTask() {
        $option = $_POST['option'];
        if ($option == "update") {
            //$files = getUrlData("http://gpup.lettersharing.com/account/fixedTime");
            $files = getUrlData("http://36.7.151.221:8085/account/fixedTime");
            $files = getUrlData("http://36.7.151.221:8085/account/fixedProTask");
        }
        echo '更新Redis成功';exit;
    }

    //CP联动游戏
    function shortNameSelectAjax() {
        $html = new \Home\Org\Html();
        $cp = I('cp');
        $language_data = M('language_mst')->query("select language from language_mst where short_name='{$cp}'");
        foreach ($language_data as $v) {
            $cache[$v['language']] = $v['language'];
        }
        $result = $html->createInput('selected', 'language', null, $cache);
        echo $result;
    }

    //任务管理->账号任务管理->账号追踪组
    function accountGroupList() {
        if (!hasAsoRole('AGL')) error(ERROR_MSG);
        $method = I('get.method') ? I('get.method') : 'show';
        $html = new \Home\Org\Html();
        $type_arr = array("白号"=>2,"老号"=>3);
        $type_arr1 = array_flip($type_arr);
        switch ($method) {
            case 'show':
                $tableName = 'account_group';
                $searchArr = array(
                    '搜索' => array(
                        '账号类型' => array('name' => 'type', 'type' => 'select', 'data' => $type_arr),
                    )
                );
                $searchHtml = TableController::createSearch1($tableName, $searchArr);
                //分页
                $wh = IphoneController::getWhereConfig($tableName);
                $count = M("account_group")->where($wh)->count();
                $pagesize = 50;
                $parameter = TableController::getGlobalWhere($tableName) ? merge($_GET, array('where' => TableController::getGlobalWhere($tableName))) : '';
                $page = new \Home\Org\Page($count, $pagesize, $parameter);
                $pager = $page->show();
                $data = M("account_group")->where($wh)->limit($page->firstRow, $page->listRows)->select();
                foreach ($data as &$v) {
                    $v['type'] = $type_arr1[$v['type']];
                    $v['status'] = IphoneController::creatAjaxRadio2("account_group", "status", $v['id'], $v['status']);
                    $v['caozuo'] = $this->createOperate(array(
                        array('act' => 'edit', 'id' => $v['id']),
                    ), "accountGroupList");
                }
                $this->assign('data', $data);
                $this->nav = array(
                    '账号追踪组列表' => array('icon' => 'icon_grid'),
                    '账号导入' => array('link' => '/index.php?m=Home&c=Task&a=accountGroupList&method=import', 'icon' => 'icon_add'),
                );
                $this->pager = '<div class="pager">' . $pager . '</div>';
                $this->main = $searchHtml . $this->fetch('Task:accountGroupList');
                $this->_out();
                break;
            case 'edit':
                if ($_POST) {
                    $arr['group_name'] = trim($_POST['group_name']);
                    $id = I('post.id');
                    $update = M("account_group")->where("id=$id")->save($arr);
                    if ($update) {
                        success('修改成功', U('Task/accountGroupList'));
                    } else {
                        error('修改失败');
                    }
                }
                $id = I('id');
                $data = M("account_group")->where("id=$id")->find();
                $this->assign('id', $id);
                $this->assign('group_name', $html->createInput('text', 'group_name',$data['group_name']));
                $this->nav = array(
                    '账号追踪组列表' => array('link' => '/index.php?m=Home&c=Task&a=accountGroupList&method=show', 'icon' => 'icon_grid'),
                    '账号导入' => array('link' => '/index.php?m=Home&c=Task&a=accountGroupList&method=import', 'icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:accountGroupList_edit');
                $this->_out();
                break;
            case 'import':
                ini_set('memory_limit', '-1');
                ini_set('max_execution_time', '360000');
                if (isset($_POST['start_date'])) {
                    $group_name = $_POST['group_name'] ? $_POST['group_name'] : "";
                    $start_date = $_POST['start_date'] ? $_POST['start_date'] : "";
                    $end_date = $_POST['end_date'] ? $_POST['end_date'] : "";
                    $search_start = date("Y-m-d",strtotime($start_date));
                    $search_end = date("Y-m-d",strtotime($end_date)+86400);
                    $sql = "SELECT * FROM account_mark WHERE is_handle = 0 AND creat_time >= '{$search_start}' AND creat_time < '{$search_end}'";
                    $mark_data = M("account_mark")->query($sql);
                    foreach ($mark_data as $val){
                        $data1 = $val['str'];
                        $data1 = explode('&', $data1);
                        $data2 = array();
                        foreach ($data1 as $val1){
                            $temp = explode('=', $val1);
                            if($temp[0] == 'Result' || $temp[0] == 'Sex'){
                                $data2[$temp[0]] =  iconv("GB2312","UTF-8", decodeDesStr($temp[1]));
                            }else{
                                $data2[$temp[0]] = decodeDesStr($temp[1]);
                            }
                            $data2[$temp[0]] = trim($data2[$temp[0]]);
                        }
                        $temps['gmail'] = trim($data2['User']);
                        $temps['password'] = trim($data2['Pwd']);
                        $temps['creat_time'] = $val['creat_time'];
                        $temps['secondGmail'] = trim($data2['Email']);
                        $temps['surname'] = trim($data2['FirstName']);
                        $temps['true_name'] = trim($data2['LastName']);
                        $temps['birthday'] = date("Y-m-d",strtotime($data2['Birthday']));
                        $temps['sex'] = trim($data2['Sex']);
                        $temps['result_str'] = trim($data2['Result']);
                        $temps['machine_name'] = trim($data2['machine_name']);
                        $temps['group_id'] = 99992;
                        $temps['add_time'] = time();
                        $temps['group_source'] = 2;
                        $data[] = implode('||', $temps);
                    }
                    $total = count($data);
                    if ($total <= 0) {
                        error('读取文件内容失败，请重新上传2');
                    }
                    //写入处理之后文件内容
                    if (IS_WIN) {
                        $WriteFilePath = './Uploads/tmp/' . 'new_2_' . date("YmdHis") . ".csv";
                    } else {
                        $WriteFilePath = '/data/www/googlemanager/Uploads/tmp/' . 'new_2_' . date("YmdHis") . ".csv";
                    }
                    file_put_contents($WriteFilePath, implode(PHP_EOL, $data));
                    //如果数据表数据全部被删除或者没有一条新增信息，从表信息获取增长ID值
                    $AlltableInfo = M("account_info")->query("show table status like 'account_info'");
                    $Auto_increment = $AlltableInfo[0]['Auto_increment'];
                    $startID = $Auto_increment;
                    if (IS_WIN) {
                        $mysql_cmd = 'D:/phpStudy/MySQL/bin/mysql';
                    } else {
                        $mysql_cmd = '/opt/mysql/bin/mysql';
                    }
                    $logSQl = $mysql_cmd . ' -h' . C('DB_HOST') . ' -u' . C('DB_USER') . ' -p' . C('DB_PWD') . ' --local-infile=1 deviceinfo -e  "load  data local infile \'' . $WriteFilePath . '\'  ignore into table account_info fields terminated by \'||\' enclosed by \'\"\' lines terminated by \'\n\' ';
                    $logSQl .= '(gmail,password,creat_time,secondGmail,surname,true_name,birthday,sex,result_str,machine_name,group_id,add_time,group_source);"';
                    exec($logSQl, $out, $status);
                    $status == 1 && error('导入账号信息失败，请重新上传！');
                    $endID = M("account_info")->max('id');
                    if (!$endID || $endID < $startID) {
                        $AlltableInfo = M("account_info")->query("show table status like 'account_info'");
                        $Auto_increment = $AlltableInfo[0]['Auto_increment'];
                        $endID = $Auto_increment == 1 ? 0 : $Auto_increment - 1;
                    }
                    if ($endID == $startID - 1) {
                        $startID = 0;
                        $endID = 0;
                    }
                    $insert_success = $startID == 0 ? $endID - $startID : $endID - $startID + 1;
                    $insert_error = $total - $insert_success;
                    $arrLog['group_name'] = $group_name;
                    $arrLog['start_id'] = $startID;
                    $arrLog['end_id'] = $endID;
                    $arrLog['add_time'] = date("Y-m-d H:i:s");
                    $arrLog['type'] = 2;
                    $insert_result = M("account_group")->add($arrLog);
                    M("account_info")->query("update account_info set group_id={$insert_result} where id>={$startID} and id<={$endID}");
                    success('操作成功,插入总数' . $total . ',成功数' . $insert_success . '条，失败 ' . $insert_error . '条', U('Task/accountGroupList'));
                }
                if (isset($_FILES['efile'])) {
                    $group_name = $_POST['group_name'] ? $_POST['group_name'] : "";
                    $file = $_FILES['efile'];
                    if ($file['error'] === 0) {
                        if ($file['name']) {
                            $upload = new \Think\Upload();
                            $upload->rootPath = './Uploads/'; // 设置附件上传根目录
                            $upload->savePath = 'tmp/'; //  设置附件上传目录
                            $upload->autoSub = false;
                            $upload->exts = array('csv');
                            if (!is_dir($upload->rootPath . $upload->savePath)) {
                                mkdir($upload->rootPath . $upload->savePath, 0777, true);
                            }
                            $info = $upload->upload();
                            if (!$info) {
                                error($upload->getError());
                            }
                        }
                        $Filename = $upload->rootPath . $info['efile']['savepath'] . $info['efile']['savename'];
                        $Filename = realpath($Filename);
                        chmod($Filename, 0777);
                        $txtContent = null;
                        $contents_before = file_get_contents($Filename);
                        $contents_after = iconv('gb2312', 'UTF-8//IGNORE', $contents_before);
                        file_put_contents($Filename, $contents_after);
                        $csvfile = fopen($Filename, 'r');
                        while ($csvdata = fgetcsv($csvfile)) {
                            $Txtlist[] = $csvdata;
                        }
                        $data = $temp = array();
                        foreach ($Txtlist as $value) {
                            if (!trim($value['0'])) continue;
                            if (strpos($value['0'],"@") < 1) continue;
                            $temp['gmail'] = trim($value[0]);
                            $temp['password'] = trim($value[1]);
                            $temp['creat_time'] = date("Y-m-d H:i:s", strtotime($value[2]));
                            if (strtotime($temp['creat_time'])<strtotime("1990-01-01")) {
                                error("时间格式不正确");
                            }
                            $temp['secondGmail'] = trim($value[3]);
                            $temp['is_find'] = trim($value[4]);
                            $temp['group_source'] = trim($value[5]);
                            $temp['group_id'] = 99993;
                            $temp['add_time'] = time();
                            $data[] = implode('||', $temp);
                        }
                        $total = count($data);
                        if ($total <= 0) {
                            error('读取文件内容失败，请重新上传2',"",60);
                        }
                        //写入处理之后文件内容
                        if (IS_WIN) {
                            $WriteFilePath = './Uploads/tmp/' . 'new_3_' . date("YmdHis") . ".csv";
                        } else {
                            $WriteFilePath = '/data/www/googlemanager/Uploads/tmp/' . 'new_3_' . date("YmdHis") . ".csv";
                        }
                        file_put_contents($WriteFilePath, implode(PHP_EOL, $data));
                        //如果数据表数据全部被删除或者没有一条新增信息，从表信息获取增长ID值
                        $AlltableInfo = M("account_info")->query("show table status like 'account_info'");
                        $Auto_increment = $AlltableInfo[0]['Auto_increment'];
                        $startID = $Auto_increment;
                        if (IS_WIN) {
                            $mysql_cmd = 'D:/phpStudy/MySQL/bin/mysql';
                        } else {
                            $mysql_cmd = '/opt/mysql/bin/mysql';
                        }
                        $logSQl = $mysql_cmd . ' -h' . C('DB_HOST') . ' -u' . C('DB_USER') . ' -p' . C('DB_PWD') . ' --local-infile=1 deviceinfo -e  "load  data local infile \'' . $WriteFilePath . '\'  ignore into table account_info fields terminated by \'||\' enclosed by \'\"\' lines terminated by \'\n\' ';
                        $logSQl .= '(gmail,password,creat_time,secondGmail,is_find,group_source,group_id,add_time);"';
//                        print_r($logSQl);exit;
                        exec($logSQl, $out, $status);
                        $status == 1 && error('导入账号信息失败，请重新上传！');
                        $endID = M("account_info")->max('id');
                        if (!$endID || $endID < $startID) {
                            $AlltableInfo = M("account_info")->query("show table status like 'account_info'");
                            $Auto_increment = $AlltableInfo[0]['Auto_increment'];
                            $endID = $Auto_increment == 1 ? 0 : $Auto_increment - 1;
                        }
                        if ($endID == $startID - 1) {
                            $startID = 0;
                            $endID = 0;
                        }
                        $insert_success = $startID == 0 ? $endID - $startID : $endID - $startID + 1;
                        $insert_error = $total - $insert_success;
                        $arrLog['group_name'] = $group_name;
                        $arrLog['start_id'] = $startID;
                        $arrLog['end_id'] = $endID;
                        $arrLog['add_time'] = date("Y-m-d H:i:s");
                        $arrLog['type'] = 3;
                        $insert_result = M("account_group")->add($arrLog);
                        M("account_info")->query("update account_info set group_id={$insert_result} where id>={$startID} and id<={$endID}");
                        success('操作成功,插入总数' . $total . ',成功数' . $insert_success . '条，失败 ' . $insert_error . '条', U('Task/accountGroupList'));
                    } else {
                        error('文件上传失败，请重新上传！');
                    }
                }
                $this->assign('account_type', $html->createInput('select', 'account_type',null,$type_arr));//批量启用禁用
                $this->assign('group_name', $html->createInput('text', 'group_name'));//分组名称
                $this->assign("url", U('Task/accountGroupList', array("method" => "import")));
                $this->nav = array(
                    '账号追踪组列表' => array('link' => '/index.php?m=Home&c=Task&a=accountGroupList&method=show', 'icon' => 'icon_grid'),
                    '账号导入' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:accountGroupList_import');
                $this->_out();
                break;
            case 'ajax':
                $account_type = I('account_type');
                $result = "";
                if ($account_type == 2) {
                    $result .= "<div class=\"l\">时间段：</div>";
                    $result .= "<div class=\"r\">".$html->createInput('text', 'start_date',date('Y-m-d'))."-".$html->createInput('text', 'end_date',date('Y-m-d'))."</div>";
                } else if ($account_type == 3) {
                    $result .= "<div class=\"l\">csv文件：</div>";
                    $result .= "<div class=\"r\">".$html->createInput('file', 'efile')."</div>";
                }
                echo $result;exit;
                break;
        }
    }

    //任务管理->账号任务管理->国家表管理
    function countryDBMst() {
        if (!hasAsoRole('CDBM')) error(ERROR_MSG);
        $method = I('get.method') ? I('get.method') : 'show';
        $db = M("country_table_mst");
        $country_db = M("country_info_mst");
        $html = new \Home\Org\Html();
        $country_data = $country_db->query("select DISTINCT country_short,short_name from country_info_mst ORDER BY country_short ASC");
        foreach ($country_data as $val) {
            $country_short = strtolower($val['country_short']);
            $country_list[$country_short] = $val['short_name'];
        }
        switch ($method) {
            case 'show':
                $result = $db->order('suffix ASC')->select();
                foreach ($result as &$v) {
                    if($v['suffix']){
                        $key = "account_machine_list_" . $v['short_name'] . '_' . $v['suffix'];
                    }else{
                        $key = "account_machine_list_".strtoupper($v['short_name']);
                    }
                    $v['count'] = getRedis()->zCard($key);
                    $v['caozuo'] = $this->createOperate(array(
                        array('act' => 'edit', 'id' => $v['id']),
                    ), "countryDBMst");
                }
                $this->assign('result', $result);
                $this->nav = array(
                    '国家表管理列表' => array('icon' => 'icon_grid'),
                    '新建表' => array('link' => '/index.php?m=Home&c=Task&a=countryDBMst&method=add', 'icon' => 'icon_add'),
                );
                $this->main = $this->fetch('Task:countryDBMst');
                $this->_out();
                break;
            case 'add':
                if ($_POST) {
                    $country = trim($_POST['country']);
                    $suffix = trim($_POST['suffix']);
                    if (empty($country)) {
                        error('未选择国家');
                    }
                    if (!empty($suffix)) {
                        if (!preg_match("/^[_0-9a-zA-Z]{1,24}$/i",$suffix)) {
                            error("后缀名格式不正确");
                        }
                        $suffix_str = "_".$suffix;
                    }
                    $table_name = "true_account_".$country.$suffix_str;
                    $arr['country'] = $country_list[$country];
                    $arr['table_name'] = $table_name;
                    $arr['suffix'] = $suffix;
                    $arr['short_name'] = $country;
                    $arr['remark'] = trim($_POST['remark']);
                    $arr['add_time'] = date("Y-m-d H:i:s");
                    $find_one = $db->where("table_name='{$table_name}'")->find();
                    if (!empty($find_one)) {
                        error("表已存在");
                    }
                    $sql = "CREATE TABLE `{$table_name}` (
                              `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键 自动增长',
                              `gmail` char(50) NOT NULL COMMENT '账号信息',
                              `account_id` int(11) NOT NULL,
                              `add_time` int(11) NOT NULL COMMENT '添加时间',
                              `imei` char(50) NOT NULL,
                              `ip_address` char(35) NOT NULL,
                              `sid` char(50) NOT NULL COMMENT 'ip',
                              `androidid` char(50) NOT NULL COMMENT '安卓ID',
                              `group_id` int(11) NOT NULL,
                              PRIMARY KEY (`id`),
                              UNIQUE KEY `account_id` (`account_id`) USING BTREE
                            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
                    $db->query($sql);
                    $db->add($arr);
                    success('添加成功', U('Task/countryDBMst'));
                }
                $country_list1 = array_flip($country_list);
                $this->assign('country', $html->createInput('select', 'country',null,$country_list1));
                $this->assign('remark', $html->createInput('text', 'remark'));
                $this->assign('suffix', $html->createInput('text', 'suffix'));
                $this->nav = array(
                    '国家表管理列表' => array('link' => '/index.php?m=Home&c=Task&a=countryDBMst&method=show', 'icon' => 'icon_grid'),
                    '新建表' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:countryDBMst_add');
                $this->_out();
                break;
            case 'edit':
                if ($_POST) {
                    $arr['remark'] = trim($_POST['remark']);
                    $id = I('post.id');
                    $update = $db->where("id=$id")->save($arr);
                    if ($update) {
                        success('修改成功', U('Task/countryDBMst'));
                    } else {
                        error('修改失败');
                    }
                }
                $id = I('id');
                $data = M("account_group")->where("id=$id")->find();
                $this->assign('id', $id);
                $this->assign('remark', $html->createInput('text', 'remark',$data['remark']));
                $this->nav = array(
                    '国家表管理列表' => array('link' => '/index.php?m=Home&c=Task&a=countryDBMst&method=show', 'icon' => 'icon_grid'),
                    '新建表' => array('link' => '/index.php?m=Home&c=Task&a=countryDBMst&method=add', 'icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:countryDBMst_edit');
                $this->_out();
                break;
        }
    }


    private function _getAccounInfo($account_id){
        $accountIds = array(
            //377378, 377126, 377229, 377404, 377008
            1084,1088,1075,1863,1087,1076
        );
        
        if($account_id){
            $accountInfo = getRedis()->get('account_id_' . $account_id);
        }else{
            $accountInfo = getRedis()->get('account_id_' . $accountIds[rand(0, (count($accountIds) - 1))]);
        }

        //$accountInfo = getRedis()->get('account_id_105310');
        $packageName = '';
        $keyword = '';
        $downloadInfo = array(
            'digest' => $accountInfo['digest'],'androidID' => $accountInfo['androidID'],'vendingSecureAuthToken' => $accountInfo['vendingSecureAuthToken'],
            'vendingAuthToken' => $accountInfo['vendingAuthToken'],'deviceDataVersionInfo' => $accountInfo['deviceDataVersionInfo'],'otherTarget' => $accountInfo['otherTarget'] ? $accountInfo['otherTarget'] : '',
            'vendingVersionCode' => $accountInfo['vendingVersionCode'],'vendingApiVersion' => $accountInfo['vendingApiVersion'],'tocCookie' => $accountInfo['tocCookie'],
            'loggingID' => $accountInfo['loggingID'],'AdId' => $accountInfo['AdId'],'supportTarget' => $accountInfo['supportTarget'] ? $accountInfo['supportTarget'] : '',
            'vendingVersionName' => $accountInfo['vendingVersionName']
        );

        if($accountInfo['targetsList'] != ''){
            $downloadInfo['targetsList'] = $accountInfo['targetsList'];
        }

        //获取账号机器信息
        if(strlen($accountInfo['configurationMNC']) == 1){
            $accountInfo['configurationMNC'] = '0' . $accountInfo['configurationMNC'];
        }

        $returnMachineInfo = array(
            'buildSdkInt' => $accountInfo['buildSdkInt'],
            'buildDevice' => $accountInfo['buildDevice'],
            'buildHardware' => $accountInfo['buildHardware'],
            'buildProduct' => $accountInfo['buildProduct'],
            'buildRelease' => $accountInfo['buildRelease'],
            'buildModel' => $accountInfo['buildModel'],
            'buildID' => $accountInfo['buildID'],
            'publicAndroidID' => $accountInfo['publicAndroidId'],
            'language' => 'en',
            'country' => 'US',
            'buildBrand' => $accountInfo['buildBrand'],
            'buildBoard' => $accountInfo['buildBoard'],
            'configurationMCC' => $accountInfo['configurationMCC'] ? $accountInfo['configurationMCC'] : "",
            'configurationMNC' => $accountInfo['configurationMNC'] ? $accountInfo['configurationMNC'] : "",
            'buildFingerPrint' => $accountInfo['buildFingerPrint'] ? $accountInfo['buildFingerPrint'] : "",
            'buildManufacture' => $accountInfo['buildManufacture'] ? $accountInfo['buildManufacture'] : "",
            'buildRadioVersion' => $accountInfo['buildRadioVersion'] ? $accountInfo['buildRadioVersion'] : "",
        );

        return array_merge($accountInfo, $returnMachineInfo);
    }

    //任务管理->真机任务管理->评论库
    function commentList() {
        if (!hasAsoRole('CLS')) error(ERROR_MSG);
        $method = I('get.method') ? I('get.method') : 'show';
        $db = M("comment_mst");
        $html = new \Home\Org\Html();
        switch ($method) {
            case 'show':
                $tableName = 'account_comment_log';
                $searchArr = array(
                    '搜索' => array(
                        '文件标题或描述&nbsp;' => array('name' => 'title', 'type' => 'text', 'sign' => 'like'),
                    )
                );
                $searchHtml = TableController::createSearch1($tableName, $searchArr);
                //分页
                $wh = IphoneController::getWhereConfig($tableName);
                $count = M("account_comment_log")->where($wh)->count();
                $pagesize = 50;
                $parameter = TableController::getGlobalWhere($tableName) ? merge($_GET, array('where' => TableController::getGlobalWhere($tableName))) : '';
                $page = new \Home\Org\Page($count, $pagesize, $parameter);
                $pager = $page->show();
                $data = M("account_comment_log")->where($wh)->limit($page->firstRow, $page->listRows)->select();
                $this->assign('data', $data);
                $this->nav = array(
                    '评论库' => array('icon' => 'icon_grid'),
                    '评论导入' => array('link' => '/index.php?m=Home&c=Task&a=commentList&method=import', 'icon' => 'icon_add'),
                );
                $this->pager = '<div class="pager">' . $pager . '</div>';
                $this->main = $searchHtml . $this->fetch('Task:commentList');
                $this->_out();
                break;
            case 'import':
                ini_set('memory_limit', '-1');
                ini_set('max_execution_time', '360000');
                if (isset($_FILES['efile'])) {
                    $game_type = $_POST['game_type'];
                    if (empty($game_type)) {
                        error("未填写游戏类型");
                    }
                    $title = $_POST['title'];
                    $title || error('请填写标题或描述！');
                    $file = $_FILES['efile'];
                    if ($file['error'] === 0) {
                        //判断文件是否已上传
                        $account_comment_log = M('account_comment_log', null, C('DB_ASO_DATA'));
                        $fileInfo = explode('.', $file['name']);
                        $find = $account_comment_log->where(array("file_name" => $fileInfo[0]))->find();
                        if ($find) {
                            error('上传文件名已存在，请检查文件是否已上传，如果没有上传请更改上传文件名，重新上传！');
                        }
                        if ($file['name']) {
                            $upload = new \Think\Upload();
                            $upload->rootPath = './Uploads/'; // 设置附件上传根目录
                            $upload->savePath = 'comment/'; //  设置附件上传目录
                            $upload->autoSub = false;
                            $upload->exts = array('xlsx');
                            if (!is_dir($upload->rootPath . $upload->savePath)) {
                                mkdir($upload->rootPath . $upload->savePath, 0777, true);
                            }
                            $info = $upload->upload();
                            if (!$info) {
                                error($upload->getError());
                            }
                        }
//                        $Filename = $upload->rootPath . $info['efile']['savepath'] . $info['efile']['savename'];
//                        $Filename = realpath($Filename);
//                        chmod($Filename, 0777);
//                        $txtContent = null;
//                        $contents_before = file_get_contents($Filename);
//                        $isUTF8 = $this->isUTF8($contents_before);
//                        if ($isUTF8) {
//                            $contents_after = $contents_before;
//                        } else {
//                            $contents_after = iconv('gb2312', 'UTF-8//IGNORE', $contents_before);
//                        }
//                        file_put_contents($Filename, $contents_after);
//                        $csvfile = fopen($Filename, 'r');
//                        while ($csvdata = fgetcsv($csvfile)) {
//                            $Txtlist[] = $csvdata;
//                        }
                        import('@.Org.ReadExcel');
                        $reader = new \ReadExcel();
                        $Txtlist = $reader->readstr($upload->rootPath . $info['efile']['savepath'] . $info['efile']['savename'], $info['efile']['ext'],'A',1,'C');
                        if(empty($Txtlist)){
                            error('读取文件内容失败',"",60);
                        }

                        $data = $temp = array();
                        foreach ($Txtlist as $value) {
                            if (!trim($value['1']) || $value['0'] == "标题") continue;
                            $temp['title'] = ''; //trim($value[0]);
                            $temp['content'] = trim($value[1]);
                            $temp['rate'] = trim($value[2]);
                            $temp['game_type'] = $game_type;
                            $temp['add_time'] = date("Y-m-d H:i:s");
                            $data[] = implode('||', $temp);
                        }
                        $total = count($data);
                        if ($total <= 0) {
                            error('读取文件内容失败，请重新上传2',"",60);
                        }
                        //写入处理之后文件内容
                        if (IS_WIN) {
                            $WriteFilePath = './Uploads/tmp/' . 'comment' . date("YmdHis") . ".csv";
                        } else {
                            $WriteFilePath = '/data/www/googlemanager/Uploads/tmp/' . 'comment' . date("YmdHis") . ".csv";
                        }
                        file_put_contents($WriteFilePath, implode(PHP_EOL, $data));
                        //如果数据表数据全部被删除或者没有一条新增信息，从表信息获取增长ID值
                        $AlltableInfo = $db->query("show table status like 'comment_mst'");
                        $Auto_increment = $AlltableInfo[0]['Auto_increment'];
                        $startID = $Auto_increment;
                        if (IS_WIN) {
                            $mysql_cmd = 'D:/phpStudy/MySQL/bin/mysql';
                        } else {
                            $mysql_cmd = '/opt/mysql/bin/mysql';
                        }
                        $logSQl = $mysql_cmd . ' -h' . C('DB_HOST') . ' -u' . C('DB_USER') . ' -p' . C('DB_PWD') . ' --local-infile=1 deviceinfo -e  "load  data local infile \'' . $WriteFilePath . '\'  ignore into table comment_mst fields terminated by \'||\' enclosed by \'\"\' lines terminated by \'\n\' ';
                        $logSQl .= '(title,content,rate,game_type,add_time);"';
//                        print_r($logSQl);exit;
                        exec($logSQl, $out, $status);
                        $status == 1 && error('导入账号信息失败，请重新上传！');
                        $endID = $db->max('id');
                        if (!$endID || $endID < $startID) {
                            $AlltableInfo = $db->query("show table status like 'comment_mst'");
                            $Auto_increment = $AlltableInfo[0]['Auto_increment'];
                            $endID = $Auto_increment == 1 ? 0 : $Auto_increment - 1;
                        }
                        if ($endID == $startID - 1) {
                            $startID = 0;
                            $endID = 0;
                        }
                        $arrLog['title'] = $title;
                        $arrLog['file_name'] = $fileInfo[0];
                        $arrLog['channel'] = $game_type ? $game_type : '未知';
                        $arrLog['operate_name'] = getAdminName();
                        $arrLog['total'] = $total;
                        $arrLog['success'] = $startID == 0 ? $endID - $startID : $endID - $startID + 1;
                        $arrLog['error'] = $total - $arrLog['success'];
                        $arrLog['old_url'] = 'http://' . $_SERVER['HTTP_HOST'] . substr($upload->rootPath . $info['efile']['savepath'] . $info['efile']['savename'], 1);
                        $arrLog['comment_id'] = $startID . ',' . $endID;
                        $arrLog['time'] = date("Y-m-d H:i:s", time());
                        $result = $account_comment_log->add($arrLog);
                        if ($result !== false) {
                            success('操作成功,插入总数' . $total . ',成功数' . $arrLog['success'] . '条，失败 ' . $arrLog['error'] . '条', U('Task/commentList'));
                        } else {
                            error('操作日志表添加失败！');
                        }
                    } else {
                        error('文件上传失败，请重新上传！');
                    }
                }
                $this->assign('efile', $html->createInput('file', 'efile'));//文件
                $this->assign('title', $html->createInput('textarea', 'title'));
                $this->assign('game_type', $html->createInput('text', 'game_type'));//文件
                $this->assign("url", U('Task/commentList', array("method" => "import")));
                $this->nav = array(
                    '评论库' => array('link' => '/index.php?m=Home&c=Task&a=commentList&method=show', 'icon' => 'icon_grid'),
                    '评论导入' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:commentList_import');
                $this->_out();
                break;
        }
    }

    //关键词跟踪
    function keywordCollect() {
        if (!hasAsoRole('KCS,KCSO')) error(ERROR_MSG);
        $method = $_GET['method'] ? $_GET['method'] : 'today';
        $keyword_log_db = M('keyword_log');
        $flag_db = M('keyword_collect_flag');
        $html = new \Home\Org\Html();
        $game_data = M('game_mst', null, C('DB_ASO_DATA'))->select();
        foreach ($game_data as $val) {
            $game_data_arr1[$val['gid']] = $val['gid']." ".$val['name'];
        }
        $keyword_flag_arr = array_flip(C('KEYWORDFLAG'));
        $iphone_tag_list1 = getIphoneTagList(2);
        switch ($method) {
            case 'today':
                $country_language = $_POST['country_language'];
                $start = $_POST['start'] ? $_POST['start'] : date("Y-m-d",time()-86400)." 15:00:00";
                $end = $_POST['end'] ? $_POST['end'] : date("Y-m-d",time())." 15:00:00";
                $search_start = $start ." 00:00:00";
                $search_end = $end." 23:59:59";
                $search_tag = $_POST['search_tag'];
                $search_cp = $_POST['search_cp'];
                $search_package_name = $_POST['search_package_name'];
                $search_keyword = $_POST['search_keyword'];
                $wh = "type = 2";
                if (!empty($search_package_name) || !empty($search_keyword)) {
                    if (!empty($search_package_name)) {
                        $wh .= " and package_name like '%{$search_package_name}%'";
                    }
                    if (!empty($search_keyword)) {
                        $wh .= " and keyword like '%{$search_keyword}%'";
                    }
                } else {
                     $wh .= " and end<='{$search_end}' and start>='{$search_start}'";
                }
                if (!empty($search_tag)) {
                    $wh .= " and tag = '{$search_tag}'";
                }
                if (!empty($search_cp)) {
                    $wh .= " and cp = '{$search_cp}'";
                }
                if (!empty($country_language)) {
                    $country_language_arr = explode("#",$country_language);
                    $short_name = $country_language_arr[0];
                    $language = $country_language_arr[1];
                    $wh .= " and country = '{$short_name}' and language = '{$language}'";
                }
                $data = M('search_keyword_ip_task')->where($wh)->select();
                $country_str = "";
                $package_name_str = "";
                $keyword_str = "";
                $id_str = "";
                $rate = array();
                foreach ($data as $val) {
                    $start_date = date("Y-m-d",strtotime($val['start'])-86400*7);
                    $end_date = date('Y-m-d', time() - 2*86400);
                    $country_str .= ($country_str != "") ? ",'".$val['country']."'" : "'".$val['country']."'";
                    $package_name_str .= ($package_name_str != "") ? ",'".$val['package_name']."'" : "'".$val['package_name']."'";
                    $keyword_str .= ($keyword_str != "") ? ",'".$val['keyword']."'" : "'".$val['keyword']."'";
                    $id_str .= ($id_str != "") ? ",'".$val['id']."'" : "'".$val['id']."'";
                    $rate[$val['id']]['id'] = $val['id'];
                    $rate[$val['id']]['country'] = $val['country'];
                    $rate[$val['id']]['package_name'] = $val['package_name'];
                    $rate[$val['id']]['game_name'] = $val['game_name'];
                    $appannieUrl = "https://www.appannie.com/apps/google-play/app/".$val['package_name']."/keywords/?countries={$val['country']}&device=&start_date={$start_date}&end_date={$end_date}";
                    $rate[$val['id']]['package_name_url'] = "<a target=\"_blank\" href=\"{$appannieUrl}\" title=\"点击查看appannie\">{$val['package_name']}</a>";
                    $rate[$val['id']]['keyword'] = $val['keyword'];
                    $rate[$val['id']]['cp'] = $val['cp'];
                    $rate[$val['id']]['tag'] = $iphone_tag_list1[$val['tag']];
                    $rate[$val['id']]['count'] = $val['count'];
                    $rate[$val['id']]['count_s'] = getSuccessTask($val['id']);
                    $rate[$val['id']]['count_d'] = getSumTask($val['id']);
                    $rate[$val['id']]['ranking'] = "99999";
                    $rate[$val['id']]['hot'] = $val['hot'];
                    $rate[$val['id']]['start'] = $val['start'];
                    $rate[$val['id']]['end'] = $val['end'];
                    $rate[$val['id']]['flag_status'] = $val['flag_status'];
                    $rate[$val['id']]['remark'] = $val['remark'];
                }
                if (!empty($search_package_name) || !empty($search_keyword)) {
                    $wh = "country in ({$country_str}) and package_name in ({$package_name_str}) and keyword in ({$keyword_str})";
                } else {
                    $wh = "country in ({$country_str}) and package_name in ({$package_name_str}) and keyword in ({$keyword_str}) and time>='{$search_start}'";
                }
                $sql = "select * from (select * from keyword_log where {$wh} order by id desc) a group by a.country,a.package_name,a.keyword";
                $keyword_log_data = $keyword_log_db->query($sql);
                foreach ($keyword_log_data as $val) {
                    $keyword_log_list[$val['country']."_".$val['package_name']."_".$val['keyword']]['ranking'] = $val['ranking'];
                    $keyword_log_list[$val['country']."_".$val['package_name']."_".$val['keyword']]['diff'] = $val['diff'];
                }
                foreach ($rate as &$v) {
                    $old_country = $v['country'];
                    $old_package_name = $v['package_name'];
                    $old_keyword = $v['keyword'];
                    $old_flag = $v['flag_status'];
                    $v['old_remark'] = $v['remark'];
                    $v['remark'] = $html->createInput("textarea","remark",$v['remark'],null,"id='{$v['id']}' class='change_remark'");
                    $v['ranking'] = $keyword_log_list[$old_country."_".$old_package_name."_".$old_keyword]['ranking'];
                    $v['diff'] = $keyword_log_list[$old_country."_".$old_package_name."_".$old_keyword]['diff'];
                    $v['exception'] = '';
                    if ($old_flag == 1) {
                        $v['exception'] = 'vpnException1';
                    } else if ($old_flag == 2) {
                        $v['exception'] = 'vpnException2';
                    } else if ($old_flag == 3) {
                        $v['exception'] = 'vpnException3';
                    }
                    if (!hasAsoRole('KCSO')) {
                        $v['flag'] = $keyword_flag_arr[$old_flag];
                    } else {
                        $v['flag'] = $this->creatAjaxRadio($old_flag,$v['id']);
                    }
                    $v['rate'] = round($v['count_s']/$v['count_d'],3) * 100 . "%";
                    if ($v['diff']<0) {
                        $v['diff'] = "<span class='img-down'></span><span style='color:green'>".abs($v['diff'])."</span>";
                    } else if ($v['diff']>0) {
                        $v['diff'] = "<span class='img-up'></span><span style='color:red'>".$v['diff']."</span>";
                    } else {
                        $v['diff'] = "<span class='img-nochange'></span><span style='color:grey'>".$v['diff']."</span>";
                    }
                    $v['history'] = "<span class='history img-history' attr='{$old_country}_{$old_package_name}_{$old_keyword}' style='cursor: pointer;margin: 0px; float: none;'></span>";
                }
                file_put_contents(FileController::$filepath.'FilekeywordCollect-'.getAdminName().'.txt', serialize($rate));
                $this->assign('keyword_log_data', $rate);
                $this->assign("url",U('Task/keywordCollect',array("method"=>"today")));
                $this->assign("start",$html->createInput("datetime1","start",$start));
                $this->assign("end",$html->createInput("datetime1","end",$end));
                $this->assign("search_tag",$html->createInput("select","search_tag",$search_tag,getIphoneTagList()));
                $this->assign("search_cp",$html->createInput("select","search_cp",$search_cp,getCpList()));
                $this->assign("search_package_name",$html->createInput("text","search_package_name",$search_package_name));
                $this->assign("search_keyword",$html->createInput("text","search_keyword",$search_keyword));
                $this->assign("country_language",$html->createInput("select","country_language",$country_language,getCountryLanguage()));
                $this->nav = array(
                    '真机关键词跟踪' => array('icon' => 'icon_grid', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:keywordCollect');
                $this->_out();
                break;
        }
    }

    function creatAjaxRadio($value, $id) {
        if ($value == 1) {
            $class0 = "three_ajax three_ajax_sel";
            $class1 = "three_ajax";
            $class2 = "three_ajax";
        } else if ($value == 2) {
            $class0 = "three_ajax";
            $class1 = "three_ajax three_ajax_sel";
            $class2 = "three_ajax";
        } else if ($value == 3) {
            $class0 = "three_ajax";
            $class1 = "three_ajax";
            $class2 = "three_ajax three_ajax_sel";
        } else if ($value == 0) {
            $class0 = "three_ajax";
            $class1 = "three_ajax";
            $class2 = "three_ajax";
        }
        $str = "<span class=\"{$class0}\" status=\"1\" id=\"{$id}\">有效</span> <span class=\"{$class1}\" status=\"2\" id=\"{$id}\">无效</span> <span class=\"{$class2}\" status=\"3\" id=\"{$id}\">疑似有效</span></td>";
        return $str;
    }

    function packageNameKeywordStatusAjax() {
        if (!hasAsoRole('KCSO')) {
            echo "no";exit;
        };
        $db = M('search_keyword_ip_task');
        $task_id = I('task_id');
        $status = I('status');
        $wh = "id='{$task_id}'";
        $arr['flag_status'] = $status;
        $arr['update_time'] = date("Y-m-d H:i:s");
        $update = $db->where($wh)->save($arr);
        if ($update) {
            echo "yes";exit;
        } else {
            echo "no1";exit;
        }
    }

    function packageNameKeywordRemarkAjax() {
        if (!hasAsoRole('KCSO')) {
            echo "no";exit;
        };
        $db = M('search_keyword_ip_task');
        $task_id = I('task_id');
        $remark = I('remark');
        $wh = "id='{$task_id}'";
        $arr['remark'] = $remark;
        $arr['update_time'] = date("Y-m-d H:i:s");
        $update = $db->where($wh)->save($arr);
        if ($update) {
            echo "yes";exit;
        } else {
            echo "no";exit;
        }
    }

    //获得关键词历史数据绘图
    function getKeywordListData() {
        $db = M('keyword_log');
        $datas = I("datas");
        $datas_arr = explode("_",$datas);
        $d_time = date("Y-m-d",time()-86400*6);
        $data = $db->where("country='{$datas_arr[0]}' and package_name='{$datas_arr[1]}' and keyword='{$datas_arr[2]}' and time >='{$d_time}' and ranking != 9999")->select();

        $result = array();
        $result1 = array();
        $result2 = array();
        $copy = 251;
        foreach($data as $val) {
            $str1 = $val['time'];
            array_push($result1,$str1);
            $str2 = intval($val['ranking']);
            if ($str2 == -1) {
                $str2 = $copy;
            } else {
                $copy = $str2;
            }
            array_push($result2,$str2);
        }
        $result['str1'] = $result1;
        $result['str2'] = $result2;
        $result['str3'] = $datas_arr[1];
        $result['str4'] = $datas;
        $result['str5'] = "七天内排名变化";
        $result['str6'] = 12;
        echo json_encode($result);exit;
    }

    //历史排名导出
    function historyRankExport() {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '360000');
        if (!hasAsoRole('HRE')) error(ERROR_MSG);
        $method = $_GET['method'] ? $_GET['method'] : 'show';
        $keyword_log_db = M('keyword_log');
        $task_db = M('search_keyword_ip_task');
        $html = new \Home\Org\Html();
        $game_data = M('game_mst', null, C('DB_ASO_DATA'))->select();
        foreach ($game_data as $val) {
            $game_data_arr1[$val['gid']] = $val['gid']." ".$val['name'];
        }
        $iphone_tag_list1 = getIphoneTagList(2);
        switch ($method) {
            case 'show':
                $search_start = $_POST['search_start'] ? $_POST['search_start'] : date("Y-m-d",time()-86400*6);
                $search_end = $_POST['search_end'] ? $_POST['search_end'] : date("Y-m-d");
                $sql_end = $search_end." 23:59:59";
                $search_package_name = $_POST['search_package_name'];
                $search_keyword = $_POST['search_keyword'];
                if (!empty($_POST)) {
                    $keyword_log_wh = "time >= '{$search_start}' and time <= '{$sql_end}'";
                    $task_wh = "type = 2 and start >='{$search_start}' and start <= '{$sql_end}'";
                    if (!empty($search_package_name) || !empty($search_keyword)) {
                        if (!empty($search_package_name)) {
                            $task_wh .= " and package_name like '%{$search_package_name}%'";
                        }
                        if (!empty($search_keyword)) {
                            $task_wh .= " and keyword like '%{$search_keyword}%'";
                        }
                    }
                    $data = $task_db->where($task_wh)->order("package_name,keyword,country,start asc")->select();
                    $result = array();
                    $package_name_str = "";
                    $keyword_str = "";
                    foreach ($data as $val) {
                        $package_name_str .= ",'".$val['package_name']."'";
                        $keyword_str .= ",'".$val['keyword']."'";
                        $key = $val['package_name']."_".$val['keyword'];
                        $result[$key]["package_name"] = $val['package_name'];
                        $result[$key]["keyword"] = $val['keyword'];
                        $result[$key]['history'] = "<span class='history img-history' attr='{$val['package_name']}_{$val['keyword']}_{$search_start}_{$search_end}' style='cursor: pointer;margin: 0px; float: none;'></span>";
                        $tmp_arr = getRedis()->hGet("search_task_slot_census@".$val['id']);
                        $tmp_arr1 = array();
                        if (!empty($tmp_arr)) {
                            $keys_arr = array_keys($tmp_arr);
                            foreach ($keys_arr as $tmp_key1) {
                                foreach ($tmp_arr as $tmp_key => $tmp_val) {
                                    if (strtotime($tmp_key) <= strtotime($tmp_key1)) {
                                        $tmp_arr1[$tmp_key1] += $tmp_arr[$tmp_key];
                                    }
                                }
                            }
                            foreach ($tmp_arr1 as $tmp_key => $tmp_val) {
                                $result[$key]["data"][$val['country']."_".$tmp_key]['success'] = $tmp_val;
                            }
                        }
                    }
                    $package_name_str = trim($package_name_str,",");
                    $keyword_str = trim($keyword_str,",");
                    $keyword_log_wh .= " and package_name in ({$package_name_str}) and keyword in ({$keyword_str})";
                    $keyword_data = $keyword_log_db->where($keyword_log_wh)->select();
                    foreach ($keyword_data as $val) {
                        $h_time = substr($val['time'],0,13).":00:00";
                        $key = $val['package_name']."_".$val['keyword']."_".$val['country']."_".$h_time;
                        $keyword_list[$key] = $val['ranking'];
                        if (strpos($keyword_list[$val['package_name']."_".$val['keyword']]['country'],$val['country']) === false) {
                            $keyword_list[$val['package_name']."_".$val['keyword']]['country'] .= ",".$val['country'];
                        }
                    }
                    $this->assign("result",$result);
                    //生成表格
//                    $this->createRankingExcel($search_start,$search_end,$result,$keyword_list);
//                    $this->assign("export","<input type=\"button\" name=\"export\" value=\"    导出数据    \" onclick=\"location.href='index.php?m=Home&c=Task&a=historyRankExport&method=export&search_start='\">");
                }
                $this->assign("url",U('Task/historyRankExport',array("method"=>"show")));
                $this->assign("search_start",$html->createInput("date","search_start",$search_start));
                $this->assign("search_end",$html->createInput("date","search_end",$search_end));
                $this->assign("search_package_name",$html->createInput("text","search_package_name",$search_package_name));
                $this->assign("search_keyword",$html->createInput("text","search_keyword",$search_keyword));
                $this->nav = array(
                    '历史排名导出' => array('icon' => 'icon_grid', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:historyRankExport');
                $this->_out();
                break;
            case 'export':
                $tname = "historyRankExport-".getAdminName().".xlsx";
                $name = FileController::$filepath.$tname;
                $fp = fopen( $name ,"r");
                Header("Content-type: application/octet-stream");
                header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
                Header("Accept-Ranges: bytes");
                Header("Accept-Length: ". filesize ($name) );
                Header("Content-Disposition: attachment; filename=$tname");
                echo fread( $fp ,filesize($name ));
                fclose($fp);
                unlink($name);
                exit();
                break;
        }
    }

    function  createRankingExcel($search_start,$search_end,$result,$keyword_list) {
        import('@.Org.PHPExcel');
        $excel = new \PHPExcel();
        $writer  =new \PHPExcel_Writer_Excel2007($excel);
        $sheet = $excel->getActiveSheet();

        $w = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T', 'U','V','W','X','Y','Z');
        $h = array('0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19', '20','21','22','23');
        $date_count = ceil((strtotime($search_end) - strtotime($search_start))/86400) + 1;
        $ws = array();
        for ($i=0;$i<$date_count;$i++) {
            if ($i == 0) {
                $ws = $w;
            } else {
                foreach ($w as $val) {
                    $ws[] = $w[$i-1].$val;
                }
            }
        }
        //生成表格头部
//        $sheet = $excel->createSheet(0);
        $sheet->setTitle("历史排名导出");
        $f=1;
        $sheet->setCellValue('A'.$f, "包名");
        $sheet->setCellValue('B'.$f, "关键词");
        $sheet->setCellValue('C'.$f, "国家排名/成功数");
        for ($i=0;$i<$date_count;$i++) {
            $sheet->setCellValue($ws[$i*24+3].$f, date("Y-m-d",strtotime($search_start)+86400*$i));
            $sheet->mergeCells($ws[$i*24+3].$f.':'.$ws[($i+1)*24+2].$f);
            $sheet->getStyle($ws[$i*24+3].$f)->applyFromArray(
	            array(
	                'font' => array (
	                    'bold' => true
	                ),
	                'alignment' => array(
	                    'horizontal' => "center"
	                )
	            )
	        );
        }
        $f++;
        for ($i=0;$i<$date_count;$i++) {
            for($j=0;$j<24;$j++) {
                $sheet->setCellValue($ws[$i*24+3+$j].$f, $h[$j]);
            }
        }
        $f++;
        foreach($result as $key => $val) {
            $sheet->setCellValue('A'.$f, $val['package_name']);
            $sheet->setCellValue('B'.$f, $val['keyword']);
            $country_str = trim($keyword_list[$key]['country'],",");
            if (!empty($country_str)) {
                $country_arr = explode(",",$country_str);
                foreach ($country_arr as $country) {
                    $sheet->setCellValue('c'.$f, $country);
                    for ($i=0;$i<$date_count;$i++) {
                        $tmp_date = date("Y-m-d",strtotime($search_start)+86400*$i);
                        for($j=0;$j<24;$j++) {
                            if ($j <10) {
                                $tmp_time = $tmp_date." 0".$j.":00:00";
                            } else {
                                $tmp_time = $tmp_date." ".$j.":00:00";
                            }
                            $rank = $keyword_list[$key."_".$country."_".$tmp_time] ? $keyword_list[$key."_".$country."_".$tmp_time] : "";
                            $success = $val['data'][$country."_".$tmp_time]['success'] ? $val['data'][$country."_".$tmp_time]['success'] : "";
                            $sheet->setCellValue($ws[$i*24+3+$j].$f, $rank);
                            $sheet->setCellValue($ws[$i*24+3+$j].($f+1), $success);
                        }
                    }
                    $f = $f+2;
                }
            } else {
                continue;
            }
        }
        $tname = "historyRankExport-".getAdminName().'.xlsx';
        $name = FileController::$filepath.$tname;
        $writer->save($name);
    }

    //获得历史排名绘图
    function getRankListData() {
        $datas = I("datas");
        $datas_arr = explode("_",$datas);
        $sql_end = $datas_arr[3]." 23:59:59";
        $today_end = date("Y-m-d 23:59:59");
        $task_data = M('search_keyword_ip_task')->where("type = 2 and package_name='{$datas_arr[0]}' and keyword='{$datas_arr[1]}' and start >='{$datas_arr[2]}' and start <='{$sql_end}'")->select();
        $keyword_data = M('keyword_log')->where("package_name='{$datas_arr[0]}' and keyword='{$datas_arr[1]}' and time >='{$datas_arr[2]}' and time <='{$today_end}' and ranking != 9999")->select();
        //处理数据
        $task_result = array();
        $keyword_result = array();
        $countrys = array();
        $country_str = "";
        foreach ($task_data as $val) {
            if (!in_array($val['country'],$countrys)) {
                array_push($countrys,$val['country']);
            }
            $tmp_arr = getRedis()->hGet("search_task_slot_census@".$val['id']);
            $tmp_arr1 = array();
            if (!empty($tmp_arr)) {
                $keys_arr = array_keys($tmp_arr);
                foreach ($keys_arr as $tmp_key1) {
                    foreach ($tmp_arr as $tmp_key => $tmp_val) {
                        if (strtotime($tmp_key) <= strtotime($tmp_key1)) {
                            $tmp_arr1[$tmp_key1] += $tmp_arr[$tmp_key];
                        }
                    }
                }
                foreach ($tmp_arr1 as $tmp_key => $tmp_val) {
                    $task_result[$val['country']."_".$tmp_key] = $tmp_val;
                }
            }
        }
        foreach ($keyword_data as $val) {
            $h_time = substr($val['time'],0,13).":00:00";
            $key = $val['country']."_".$h_time;
            $keyword_result[$key] = $val['ranking'];
            if (strpos($country_str,$val['country']) === false) {
                $country_str .= ",".$val['country'];
            }
        }
        $country_str = trim($country_str,",");
        //生成曲线图数组
        $date_count = ceil((strtotime($today_end) - strtotime($datas_arr[2]))/86400) + 1;
        $result = array();
        $result['title'] = $datas_arr[0];
        $result['subtitle'] = $datas_arr[1];
        $result['tickInterval'] = 12;
        for ($i=0;$i<$date_count;$i++) {
            $tmp_date = date("Y-m-d",strtotime($datas_arr[2])+86400*$i);
            for($j=0;$j<24;$j=$j+2) {
                if ($j < 10) {
                    $tmp_time = $tmp_date . " 0" . $j . ":00:00";
                } else {
                    $tmp_time = $tmp_date . " " . $j . ":00:00";
                }
                $result['time'][] = $tmp_time;
            }
        }
        $country_arr = explode(",",$country_str);
        $result['series'] = array();
        foreach ($country_arr as $country) {
            $tmp = array();
            $tmp1 = array();
            $copy = 251;
            for ($i=0;$i<$date_count;$i++) {
                $tmp_date = date("Y-m-d",strtotime($datas_arr[2])+86400*$i);
                for($j=0;$j<24;$j=$j+2) {
                    if ($j < 10) {
                        $tmp_time = $tmp_date . " 0" . $j . ":00:00";
                    } else {
                        $tmp_time = $tmp_date . " " . $j . ":00:00";
                    }
                    $ranking = $keyword_result[$country . "_" . $tmp_time] ? intval($keyword_result[$country . "_" . $tmp_time]) : 251;
                    if ($ranking == -1) {
                        $ranking = $copy;
                    } else {
                        $copy = $ranking;
                    }
                    $tmp['name'] = $country."排名";
                    $tmp['type'] = "spline";
                    $tmp['yAxis'] = 0;
                    $tmp['data'][] = $ranking;
                    $tmp['tooltip']["valueSuffix"] = " 名";
                    if (in_array($country,$countrys)) {
                        $success = $task_result[$country . "_" . $tmp_time] ? intval($task_result[$country . "_" . $tmp_time]) : 0;
                        $tmp1['name'] = $country."成功数";
                        $tmp1['type'] = "column";
                        $tmp1['yAxis'] = 1;
                        $tmp1['data'][] = $success;
                        $tmp1['tooltip']["valueSuffix"] = " 个";
                    }
                }
            }
            array_push($result['series'],$tmp);
            if (in_array($country,$countrys)) {
                array_push($result['series'],$tmp1);
            }
        }
        echo json_encode($result);exit;
    }

    private function isUTF8($str)
    {
        if ($str === mb_convert_encoding(mb_convert_encoding($str, "UTF-32", "UTF-8"), "UTF-8", "UTF-32")) {
            return true;
        } else {
            return false;
        }
    }

    //任务管理->真机任务管理->真机评论任务列表
    public function commentKeywordIpTaskList()
    {
        if (!hasAsoRole('SKITLS,SKITLO')) error(ERROR_MSG);
        $method = $_GET['method'] ? $_GET['method'] : 'show';
        $html = new \Home\Org\Html();
        $db = M('search_keyword_ip_task');
        $redis_key = "search_keyword_ip_task_info@";
        $redis_ip_key = "google_search_ip_task@";
        $type_list = array_flip(C('SEARCHKEYWORDTYPE'));
        $iphone_tag_list1 = getIphoneTagList(2);
        $country_table_tmp = M("country_table_mst")->select();
        $country_table_tmp_list = array();
        foreach ($country_table_tmp as $val) {
            $country_table_tmp_list[$val['table_name']] = $val['table_name'];
        }
        $gid_table_tmp = M("google_app_config")->select();
        foreach ($gid_table_tmp as $val) {
            $gid_name_list[$val['id']] = $val['game_name'];
        }
        $country_table_tmp_list = array();
        foreach ($country_table_tmp as $val) {
            $country_table_tmp_list[$val['table_name']] = $val['table_name'];
        }
        $comment_type_list = array_flip(C('COMMENTTYPE'));
        $task_class_type_list = array_flip(C('TASKORDERCLASSTYPE'));
        switch ($method) {
            case 'show':
                $tast_status = $_GET['task_status'];
                $this->assign('task_status', $tast_status);
                unset($_GET['task_status'], $_GET['task_status_sign']);

                $tableName = 'search_keyword_ip_task';
                $task_status_list = array(
                    '不限' => 0,
                    '正在执行' => 1,
                    '已完成' => 2,
                    '未执行' => 3,
                );

                $admin_name = getAdminName();
                if ($admin_name == "汪涛") {
                    $cp_list = array("耿明游戏"=>"耿明游戏");
                } else {
                    $cp_list = getCpList();
                }
                $searchArr = array(
                    '搜索' => array(
                        //'ID：' => array('name' => 'id', 'type' => 'text'),
                        'CP：' => array('name' => 'cp', 'type' => 'select','data'=>$cp_list),
                        '账号国家：' => array('name' => 'country', 'type' => 'select','data'=>getCountryList()),
                        '应用：' => array('name' => 'nick_name', 'type' => 'text','sign' => 'like'),
                        '包名：' => array('name' => 'package_name', 'type' => 'text','sign' => 'like'),
                        '关键词：' => array('name' => 'keyword', 'type' => 'text','sign' => 'like'),
                        '任务状态：' => array('name' => 'task_status', 'type' => 'select', 'data'=> $task_status_list),
                        '任务分类：' => array('name' => 'task_class', 'type' => 'select', 'data'=> C('TASKORDERCLASSTYPE')),
                    )
                );

                $searchHtml = TableController::createSearch1($tableName, $searchArr);

                //分页
                $wh = IphoneController::getWhereConfig($tableName);
                if($tast_status == 1){
                    $temp_where = " status = 1 AND `start` <= '" . date('Y-m-d H:i:s') . "' AND '" . date('Y-m-d H:i:s') . "' <= `end`";
                }elseif($tast_status == 2){
                    $temp_where = " status = 1 AND '" . date('Y-m-d H:i:s') . "' > `end`";
                }elseif($tast_status == 3){
                    $temp_where = " status = 1 AND `start` > '" . date('Y-m-d H:i:s') . "'";
                }

                if ($admin_name == "汪涛") {
                    if($wh != ''){
                        $wh .= " AND ";
                    }
                    $wh .= "cp = '耿明游戏'";
                }

                if($temp_where != ''){
                    if($wh != ''){
                        $wh .= ' AND ';
                    }
                    $wh .= $temp_where;
                }
                if($wh != ''){
                    $wh .= ' AND ';
                }
                $wh .= "comment_rate > 0";
                $count = $db->where($wh)->count();
                $pagesize = 200;
                $parameter = TableController::getGlobalWhere1($tableName) ? merge($_GET, array('where' => TableController::getGlobalWhere1($tableName))) : '';
                $page = new \Home\Org\Page($count, $pagesize, $parameter);
                $data = $db->where($wh)->order('id desc')->limit($page->firstRow, $page->listRows)->select();
                if($data){
                    //========================这里统计上个小时的配额和完成数======================

                    $get_last_config = $this->_get_aso_last_config($_GET['tag'] ? $_GET['tag'] : 0);
                    if($get_last_config){
                        $this->assign('last_hour_count', $get_last_config['last_hour_count']); //上一个小时配额数
                        $this->assign('last_hour_success', $get_last_config['last_hour_success']);
                    }

                    $nowWhere = " status = 1 AND `start` <= '" . date('Y-m-d H:0:0') . "' AND end >= '" . date('Y-m-d H:0:0', strtotime('+1 hour')) . "'";
                    if($_GET['tag']){
                        $nowWhere .= " AND `tag` = " . $_GET['tag'];
                    }
                    $nowList = M()->query("SELECT id,`count`,`start`,`end` FROM search_keyword_ip_task WHERE " . $nowWhere);
                    $nowHourCount = 0;
                    foreach ($nowList as $val){
                        //计算时间差多少个小时数
                        $astr = strtotime($val['start']);
                        $bstr = strtotime($val['end']);
                        $hours = ceil(($bstr - $astr)/3600);
                        $nowHourCount = $nowHourCount + round($val['count']/$hours);
                    }
                    $this->assign('now_hour_count', $nowHourCount); //当前一个小时的配额数

                    //========================这里统计上个小时的配额和完成数======================

                }

                $pager = $page->show();
                $this->pager = '<div class="pager">' . $pager . '</div>';
                $now_time = time();
                $total = array();
                //数据处理
                foreach ($data as &$v) {
                    $v['exception'] = '';
                    if ($v['status'] == 9) {
                        $v['exception'] = 'vpnException1';
                    }
                    $v['start_date'] = $v['start'];
                    $v['nick_name'] =$gid_name_list[$v['game_id']];
                    if (strtotime($v['start']) <= $now_time && strtotime($v['end']) >= $now_time && $v['status'] == 1) {
                        $v['start'] = "<span style='color:red'>" . $v['start'] . "</span>";
                        $v['end'] = "<span style='color:red'>" . $v['end'] . "</span>";
                    } else if (strtotime($v['start']) > $now_time && $v['status'] == 1) {
                        $v['start'] = "<span style='color:blue'>" . $v['start'] . "</span>";
                        $v['end'] = "<span style='color:blue'>" . $v['end'] . "</span>";
                    } else if (strtotime($v['end']) < $now_time && $v['status'] == 1) {
                        $v['start'] = "<span style='color:orange'>" . $v['start'] . "</span>";
                        $v['end'] = "<span style='color:orange'>" . $v['end'] . "</span>";
                    } elseif($v['status'] == 0) {
                        $v['start'] = "<span style='color:#CCC'>" . $v['start'] . "</span>";
                        $v['end'] = "<span style='color:#CCC'>" . $v['end'] . "</span>";
                    } else {
                        $v['start'] = $v['start'];
                        $v['end'] = $v['end'];
                    }
                    $v['tag'] = $iphone_tag_list1[$v['tag']];
                    $v['tag'] .=  '<br />'. $task_class_type_list[$v['task_class']];
                    $v['comment_type'] = $comment_type_list[$v['comment_type']];
                    $v['comment_rate'] = $v['comment_rate']."‰";
                    if($v['comment_rate'] > 0){
                        $v['comment_success'] = intval(getRedis()->get('search_comment_success_id_' . $v['id']));
                        //intval($comment_count_data[$v['id']]);
                    }else{
//                        if(intval(getRedis()->get('search_comment_success_id_' . $v['id']))){
//                            echo $v['id'] . '<br />';
//                        }
                    }

                    $v['type'] = $type_list[$v['type']];
                    if (!hasAsoRole('SKITLO')) {
                        $v['caozuo'] = "";
                        $v['status'] = parseYn($v['status']);
                    } else {
                        $v['status'] = IphoneController::creatAjaxRadio2("search_keyword_ip_task", "status", $v['id'], $v['status']);
                        $v['caozuo'] = $this->createOperate(array(
                            array('act' => 'edit', 'id' => $v['id']),
                            array('act' => 'del', 'id' => $v['id']),
                            array('act' => 'copy', 'id' => $v['id']),
                        ), "commentKeywordIpTaskList");
                    }



                    //todo 任务的下发数
                    $issued_num = intval(getRedis()->get('search_keyword_issued_task_id_' . $v['id']));
                    $v['issued_num'] = $issued_num;
                    $total['issued_num'] += $v['issued_num'];
                    //todo 任务的成功数
                    $success_nums = intval(getRedis()->get('search_task_success_id_' . $v['id']));
                    $v['success_nums'] = $success_nums;
                    //TODO 获取任务的结果记录
                    $hTaskAll = getRedis()->hGet('google_aso_task@' . $v['id']);
                    $totalNums = 0;
                    if($hTaskAll){
                        foreach ($hTaskAll as $resKey => $count){
                            $totalNums += $count;
                        }
                        $v['submit_nums'] = $totalNums;
                        $v['zhankai'] = "<span class=\"open_group success_log_field\" attr='{$v['id']}'>展开</span>";
                    }else{
                        $v['zhankai'] = '';
                    }

                    $v['success_nums'] = $success_nums;
                    $total['submit_nums'] += $v['submit_nums'];
                    $total['success_nums'] += $v['success_nums'];
                }
                $total['submit_rate'] = round($total['submit_nums']/$total['issued_num'],3) * 100 . "%";
                $total['success_rate'] = round($total['success_nums']/$total['issued_num'],3) * 100 . "%";
                $this->assign('data', $data);
                $this->assign('total', $total);
                if (!hasAsoRole('SKITLO')) {
                    $this->nav = array(
                        '真机任务列表' => array('icon' => 'icon_grid', 'selected' => 1),
                    );
                } else {
                    $this->nav = array(
                        '真机任务列表' => array('icon' => 'icon_grid', 'selected' => 1),
                        '添加' => array('link' => '/index.php?m=Home&c=Task&a=commentKeywordIpTaskList&method=add', 'icon' => 'icon_add'),
                        '批量添加' => array('link' => '/index.php?m=Home&c=Task&a=commentKeywordIpTaskList&method=import', 'icon' => 'icon_add'),
                    );
                }

                $result_type_arr = array(
                    100 => '成功', 400 => '授权账号任务成功[400]', 21 => '切换国家失败[21]', 101 => '上传go信息失败[101]', 102 => '未知[102]', 104 => '搜索完毕，没有找到[104]', 105 => '等待Accept协议超时[105]', 106 => '打开APP失败[106]',107 => 'ACCESSTASK_NOT_START ACCESSTASK没有启动', 108 => 'ACCESSTASK_FAIL ACCESSTASK写入的文件是Fail', 109 => 'SCRIPT_TIMEOUT 脚本超时', 160 => '查询没有找到[160]', 161 => '查询Item未知错误[161]', 121 => '出现账号超时的策划栏，没有点击到重试按钮[121]', 122 => '点击 Install 按钮失败[122]', 123 => '点击完善用户信息的continue失败[123]', 124 => '在checkskipbtn方法中点击ErrorAccount的continue按钮失败[124]', 125 => '在checkskipbtn方法中 点击skip按钮失败[125]', 126 => '检测是否在Dialog超时[126]', 127 => '检测是否存在Skip按钮超时[127]', 111 => '点击Accept协议之后等待GooglePlay主界面超时[111]', 162 => '启用AccessTask不成功[162]', 110 => 'LISTVIEW 超时[110]', -1 => '返回的device_country有误[-1]', -2 => '返回的dInfo为空[-2]', 120 => '账号sign out[120]', 130 => "Can't  download app 对话框[130]", 131 => '点击 Accept  按钮失败[131]', 311 => '下载gData失败[311]', 511 => '下载gData失败[511]', 128 => '切换国家超时[128]', 132 => 'MoreInfo超时[132]', 134 => 'install 超时[134]', 112 => '点击MoreInfo后listview超时[112]', 186 => 'gData广播出错[186]', 187 => 'gData下载失败[187]', 188 => 'gData下载MD5错误[188]');
                $this->assign('result_type_arr', $result_type_arr);

                $this->main = $searchHtml . $this->fetch('Task:commentKeywordIpTaskList');
                $this->_out();
                break;
            case 'add':
                if (!hasAsoRole('SKITLO')) error(ERROR_MSG);
                if ($_POST) {
                    if (empty($_POST['tag'])) {
                        error("未选择tag");
                    }
                    $ipcut = $_POST['ip'];
                    $ip_start = trim($_POST['ip_start']);
                    $ip_end = trim($_POST['ip_end']);
                    $n = $ip_end - $ip_start;
                    $ip_str = "";
                    for($i=0;$i<=$n;$i++) {
                        $ip_str .= ($ip_str == "") ? $ipcut . ($ip_start+$i) : "," . $ipcut . ($ip_start+$i);
                    }
                    $arr['tag'] = $_POST['tag'];
                    $arr['ip'] = $ip_str;
                    $arr['cp'] = $_POST['cp'];
                    $package_name_arr = explode("##",$_POST['package_name']);
                    $arr['game_id'] = $package_name_arr[0];
                    $arr['game_name'] = $package_name_arr[1];
                    $arr['package_name'] = $package_name_arr[2];
                    $arr['nick_name'] = trim($_POST['nick_name']);
                    $arr['keyword'] = trim($_POST['keyword']);
                    $arr['secord_keyword'] = trim($_POST['secord_keyword']);
                    $arr['position'] = trim($_POST['position']);

                    $store_country_language = explode('#', $_POST['store_country']);
                    $arr['store_country'] = trim($store_country_language[0]);

                    $country_language = explode('#', $_POST['country']);
                    $arr['country'] = trim($country_language[0]);
                    $arr['language'] = trim($country_language[1]);
                    $arr['signature'] = trim($_POST['signature']);
                    $arr['app_version'] = trim($_POST['app_version']);
                    $arr['versionName'] = trim($_POST['versionName']);
                    $arr['type'] = $_POST['type'];
                    $arr['task_class'] = $_POST['task_class'];
                    $arr['score'] = trim($_POST['score']);
                    $arr['comment_rate'] = trim($_POST['comment_rate']);
                    $arr['star'] = trim($_POST['star']);
                    $arr['comment_detail'] = trim($_POST['comment_detail']);
                    //$arr['comment_start_id'] = intval($_POST['comment_start_id']);
                    $arr['comment_type'] = intval($_POST['comment_type']);
                    $arr['developerName'] = trim($_POST['developerName']);
                    $arr['table_name'] = trim($_POST['table_name']);
                    $arr['hot'] = trim($_POST['hot']);
                    $arr['add_time'] = date('Y-m-d H:i:s');
                    $arr['is_open'] = trim($_POST['is_open']);
                    $arr['effective_rank'] = trim($_POST['effective_rank']);
                    $update_country_language = explode('#', $_POST['update_country']);
                    $arr['update_country'] = trim($update_country_language[0]);
                    $arr['update_language'] = trim($update_country_language[1]);
                    $arr['update_table_name'] = trim($_POST['update_table_name']);
                    $arr['is_update'] = trim($_POST['is_update']);
                    $arr['is_fast'] = trim($_POST['is_fast']);
                    $arr['is_enter'] = trim($_POST['is_enter']);
                    $arr['del_model'] = trim($_POST['del_model']);
                    $arr['remark'] = trim($_POST['remark']);
                    $arr['status'] = 1;
                    $arr['admin_name'] = getAdminName();
                    $arr['operate_type'] = "新增任务";
                    if($arr['type'] == 5 || $arr['type'] == 7){
                        $arr['game_id'] = 0;
                        $arr['game_name'] = '';
                        $arr['package_name'] = '';
                        $arr['nick_name'] = '';
                        $arr['keyword'] = '';
                    }
                    $start_arr = $_POST['start'];
                    $end_arr = $_POST['end'];
                    $count_arr = $_POST['count'];
                    $comment_start_id_arr = $_POST['comment_start_id'];
                    $s = $t = 0;
                    foreach ($start_arr as $key=>$val) {
                        $arr['start'] = $val;
                        $arr['end'] = $end_arr[$key];
                        $arr['count'] = intval($count_arr[$key]);
                        $arr['comment_start_id'] = intval($comment_start_id_arr[$key]);
                        $result = $db->add($arr);
                        if ($result) {
                            $this_id = $result;
                            $datas = $db->where("id={$result}")->find();
                            getRedis()->set($redis_key.$datas['id'],$datas);
                            $ip_str = explode(",",$arr['ip']);
                            foreach ($ip_str as $val) {
                                getRedis()->sAdd($redis_ip_key.$val,$this_id);
                            }
                            $s++;
                        } else {
                            $t++;
                        }
                    }
                    success("添加成功{$s}条，失败{$t}条", U('Task/commentKeywordIpTaskList'));
                }
                $this->assign('tag', $html->createInput('select', 'tag',null,getIphoneTagList()));
                $this->assign('ip', $html->createInput('selected', 'ip',null,getIphoneSidList()));
                $this->assign('ip_start', $html->createInput('text', 'ip_start'));
                $this->assign('ip_end', $html->createInput('text', 'ip_end'));
                $this->assign('date1', $html->createInput('text', 'date1[]', date("Y-m-d")));
                $this->assign('date2', $html->createInput('text', 'date2[]', date("Y-m-d")));
                $this->assign('start', $html->createInput('text', 'start[]',date("Y-m-d 16").":00:00"));
                $this->assign('end', $html->createInput('text', 'end[]',date("Y-m-d 15",time()+86400).":59:00"));
                $this->assign('country', $html->createInput('select', 'country', null, getCountryLanguage()));
                $this->assign('store_country', $html->createInput('select', 'store_country', null, getCountryLanguage()));
                $this->assign('cp', $html->createInput('select', 'cp', null, getCpList()));
                $this->assign('package_name', $html->createInput('select', 'package_name', null, getGameList(2)));
                $this->assign('nick_name', $html->createInput('text', 'nick_name', null, null, array('size' => 40)));
                $this->assign('keyword', $html->createInput('text', 'keyword'));
                $this->assign('secord_keyword', $html->createInput('text', 'secord_keyword'));
                $this->assign('position', $html->createInput('textarea', 'position'));
                $this->assign('signature', $html->createInput('textarea', 'signature'));
                $this->assign('app_version', $html->createInput('text', 'app_version'));
                $this->assign('developerName', $html->createInput('text', 'developerName'));
                $this->assign('versionName', $html->createInput('text', 'versionName'));
                $this->assign('count', $html->createInput('text', 'count[]'));
                $this->assign('type', $html->createInput('selected', 'type', null,C('SEARCHKEYWORDTYPE')));
                $this->assign('task_class', $html->createInput('select', 'task_class', null, C('TASKORDERCLASSTYPE')));
                $this->assign('is_open', $html->createInput('selected', 'is_open', 1, array('下载完打开APP'=>'1','下载后不打开'=>'0')));
                $this->assign('score', $html->createInput('text', 'score'));
                $this->assign('table_name', $html->createInput('select', 'table_name', null, $country_table_tmp_list));
                $this->assign('comment_rate', $html->createInput('text', 'comment_rate'));
                $this->assign('star', $html->createInput('textarea', 'star'));
                $this->assign('comment_detail', $html->createInput('textarea', 'comment_detail'));
                $this->assign('update_country', $html->createInput('select', 'update_country', null, getCountryLanguage()));
                $this->assign('update_table_name', $html->createInput('select', 'update_table_name', null, $country_table_tmp_list));
                $this->assign('is_update', $html->createInput('selected', 'is_update', null, array('否'=>'0','是'=>'1')));
                $this->assign('is_fast', $html->createInput('select', 'is_fast', null, array('否'=>'2','是'=>'1')));
                $this->assign('is_enter', $html->createInput('select', 'is_enter', null, array('否'=>'2','是'=>'1')));
                $this->assign('del_model', $html->createInput('select', 'del_model', null, array('一个字符退'=>'1','一下退完'=>'2','添加字符'=>'3')));
                $this->assign('remark', $html->createInput('textarea', 'remark'));
                //获得评论组
                $comment_group_data = M('account_comment_log')->select();
                foreach ($comment_group_data as $val) {
                    $comment_group_list[$val['title']] = $val['id'];
                }
                $this->assign('comment_start_id', $html->createInput('select', 'comment_start_id[]',null,$comment_group_list));
                $this->assign('comment_type', $html->createInput('selected', 'comment_type', null,C('COMMENTTYPE')));
                $this->assign('hot', $html->createInput('text', 'hot'));
                $this->assign('effective_rank', $html->createInput('text', 'effective_rank'));
                $this->nav = array(
                    '应用列表' => array('link' => '/index.php?m=Home&c=Task&a=commentKeywordIpTaskList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                    '批量添加' => array('link' => '/index.php?m=Home&c=Task&a=commentKeywordIpTaskList&method=import', 'icon' => 'icon_add'),
                );
                $this->main = $this->fetch('Task:commentKeywordIpTaskList_add');
                $this->_out();
                break;
            case 'edit':
                if (!hasAsoRole('SKITLO')) error(ERROR_MSG);
                if ($_POST) {
                    if (empty($_POST['tag'])) {
                        error("未选择tag");
                    }
                    $ipcut = $_POST['ip'];
                    $ip_start = trim($_POST['ip_start']);
                    $ip_end = trim($_POST['ip_end']);
                    $n = $ip_end - $ip_start;
                    $ip_str = "";
                    for($i=0;$i<=$n;$i++) {
                        $ip_str .= ($ip_str == "") ? $ipcut . ($ip_start+$i) : "," . $ipcut . ($ip_start+$i);
                    }
                    $arr['tag'] = $_POST['tag'];
                    $arr['ip'] = $ip_str;
                    $arr['cp'] = $_POST['cp'];
                    $package_name_arr = explode("##",$_POST['package_name']);
                    $arr['game_id'] = $package_name_arr[0];
                    $arr['game_name'] = $package_name_arr[1];
                    $arr['package_name'] = $package_name_arr[2];
                    $arr['nick_name'] = trim($_POST['nick_name']);
                    $arr['keyword'] = trim($_POST['keyword']);
                    $arr['secord_keyword'] = trim($_POST['secord_keyword']);
                    $arr['count'] = trim($_POST['count']);
                    $arr['start'] = $_POST['start'];
                    $arr['end'] = $_POST['end'];
                    $store_country_language = explode('#', $_POST['store_country']);
                    $arr['store_country'] = trim($store_country_language[0]);
                    $country_language = explode('#', $_POST['country']);
                    $arr['country'] = trim($country_language[0]);
                    $arr['language'] = trim($country_language[1]);
                    $arr['signature'] = trim($_POST['signature']);
                    $arr['position'] = trim($_POST['position']);
                    $arr['app_version'] = trim($_POST['app_version']);
                    $arr['versionName'] = trim($_POST['versionName']);
                    $arr['type'] = $_POST['type'];
                    $arr['task_class'] = $_POST['task_class'];
                    $arr['score'] = trim($_POST['score']);
                    $arr['comment_rate'] = trim($_POST['comment_rate']);
                    $arr['star'] = trim($_POST['star']);
                    $arr['comment_detail'] = trim($_POST['comment_detail']);
                    $arr['comment_start_id'] = intval($_POST['comment_start_id']);
                    $arr['comment_type'] = intval($_POST['comment_type']);
                    $arr['developerName'] = trim($_POST['developerName']);
                    $arr['table_name'] = trim($_POST['table_name']);
                    $arr['hot'] = trim($_POST['hot']);
                    $arr['is_open'] = trim($_POST['is_open']);
                    $arr['effective_rank'] = intval($_POST['effective_rank']);
                    $update_country_language = explode('#', $_POST['update_country']);
                    $arr['update_country'] = trim($update_country_language[0]);
                    $arr['update_language'] = trim($update_country_language[1]);
                    $arr['update_table_name'] = trim($_POST['update_table_name']);
                    $arr['is_update'] = trim($_POST['is_update']);
                    $arr['is_fast'] = trim($_POST['is_fast']);
                    $arr['is_enter'] = trim($_POST['is_enter']);
                    $arr['del_model'] = trim($_POST['del_model']);
                    $arr['remark'] = trim($_POST['remark']);
                    $id = I('post.id');

                    if($arr['type'] == 5 || $arr['type'] == 7){
                        $arr['game_id'] = 0;
                        $arr['game_name'] = '';
                        $arr['package_name'] = '';
                        $arr['nick_name'] = '';
                        $arr['keyword'] = '';
                    }

                    $old_data = $db->where("id={$id}")->find();
                    $update = $db->where("id={$id}")->save($arr);
                    if ($update) {
                        $old_ip_str = explode(",",$old_data['ip']);
                        foreach ($old_ip_str as $val) {
                            getRedis()->sDel($redis_ip_key.$val,$id);
                        }
                        $datas = $db->where("id={$id}")->find();
                        getRedis()->set($redis_key.$id,$datas);
                        $ip_str = explode(",",$arr['ip']);
                        foreach ($ip_str as $val) {
                            getRedis()->sAdd($redis_ip_key.$val,$id);
                        }
                        success('修改成功', U('Task/commentKeywordIpTaskList'));
                    } else {
                        error('修改失败');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $package_name_old = $data['game_id']."##".$data['game_name']."##".$data['package_name'];
                $old_ip_arr = explode(",",$data['ip']);
                $old_ip = substr($old_ip_arr[0],0,-1);
                if (count($old_ip_arr) > 1) {
                    $old_ip_start = substr($old_ip_arr[0],-1);
                    $old_ip_end = substr(end($old_ip_arr),-1);
                } else {
                    $old_ip_start = $old_ip_end = substr($old_ip_arr[0],-1);
                }
                $this->assign('id', $id);
                $this->assign('tag', $html->createInput('select', 'tag',$data['tag'],getIphoneTagList()));
                $this->assign('ip', $html->createInput('selected', 'ip', $old_ip,getIphoneSidList()));
                $this->assign('ip_start', $html->createInput('text', 'ip_start', $old_ip_start));
                $this->assign('ip_end', $html->createInput('text', 'ip_end', $old_ip_end));
                $this->assign('start', $html->createInput('datetime1', 'start', $data['start']));
                $this->assign('end', $html->createInput('datetime1', 'end', $data['end']));
                $this->assign('country', $html->createInput('selected', 'country', $data['country'].'#'.$data['language'], getCountryLanguage()));
                $this->assign('store_country', $html->createInput('selected', 'store_country', $data['store_country'], getOnlyCountryList()));
                $this->assign('cp', $html->createInput('select', 'cp', $data['cp'], getCpList()));
                $this->assign('package_name', $html->createInput('selected', 'package_name', $package_name_old, getGameList(2)));
                $this->assign('nick_name', $html->createInput('text', 'nick_name',$data['nick_name'], null, array('size' => 40)));
                $this->assign('signature', $html->createInput('textarea', 'signature', $data['signature']));
                $this->assign('position', $html->createInput('textarea', 'position', $data['position']));
                $this->assign('app_version', $html->createInput('text', 'app_version', $data['app_version']));
                $this->assign('versionName', $html->createInput('text', 'versionName', $data['versionName']));
                $this->assign('developerName', $html->createInput('text', 'developerName', $data['developerName']));
                $this->assign('keyword', $html->createInput('text', 'keyword', $data['keyword']));
                $this->assign('secord_keyword', $html->createInput('text', 'secord_keyword', $data['secord_keyword']));
                $this->assign('count', $html->createInput('text', 'count', $data['count']));
                $this->assign('type', $html->createInput('selected', 'type', $data['type'],C('SEARCHKEYWORDTYPE')));
                $this->assign('task_class', $html->createInput('select', 'task_class', $data['task_class'],C('TASKORDERCLASSTYPE')));
                $this->assign('score', $html->createInput('text', 'score', $data['score']));
                $this->assign('is_open', $html->createInput('selected', 'is_open', $data['is_open'], array('下载完打开APP'=>'1','下载后不打开'=>'0')));
                $this->assign('table_name', $html->createInput('select', 'table_name', $data['table_name'], $country_table_tmp_list));
                $this->assign('comment_rate', $html->createInput('text', 'comment_rate',$data['comment_rate']));
                $this->assign('star', $html->createInput('textarea', 'star',$data['star']));
                $this->assign('comment_detail', $html->createInput('textarea', 'comment_detail',$data['comment_detail']));
                $this->assign('comment_start_id', $html->createInput('text', 'comment_start_id',$data['comment_start_id']));
                $this->assign('comment_type', $html->createInput('selected', 'comment_type', $data['comment_type'],C('COMMENTTYPE')));
                $this->assign('hot', $html->createInput('text', 'hot', $data['hot']));
                $this->assign('effective_rank', $html->createInput('text', 'effective_rank', $data['effective_rank']));
                $this->assign('update_country', $html->createInput('select', 'update_country', $data['update_country'].'#'.$data['update_language'], getCountryLanguage()));
                $this->assign('update_table_name', $html->createInput('select', 'update_table_name', $data['update_table_name'], $country_table_tmp_list));
                $this->assign('is_update', $html->createInput('selected', 'is_update', $data['is_update'], array('否'=>'0','是'=>'1')));
                $this->assign('is_fast', $html->createInput('select', 'is_fast', $data['is_fast'], array('否'=>'2','是'=>'1')));
                $this->assign('is_enter', $html->createInput('select', 'is_enter', $data['is_enter'], array('否'=>'2','是'=>'1')));
                $this->assign('del_model', $html->createInput('select', 'del_model', $data['del_model'], array('一个字符退'=>'1','一下退完'=>'2','添加字符'=>'3')));
                $this->assign('remark', $html->createInput('textarea', 'remark', $data['remark']));
                $this->nav = array(
                    '应用列表' => array('link' => '/index.php?m=Home&c=Task&a=commentKeywordIpTaskList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Task&a=commentKeywordIpTaskList&method=add', 'icon' => 'icon_add'),
                    '批量添加' => array('link' => '/index.php?m=Home&c=Task&a=commentKeywordIpTaskList&method=import', 'icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:commentKeywordIpTaskList_edit');
                $this->_out();
                break;
            case 'del':
                if (!hasAsoRole('SKITLO')) error(ERROR_MSG);
                $id = I('id');
                $old_data = $db->where("id={$id}")->find();
                $update = $db->where("id=$id")->delete();
                if ($update) {
                    $old_ip_str = explode(",",$old_data['ip']);
                    foreach ($old_ip_str as $val) {
                        getRedis()->sDel($redis_ip_key.$val,$id);
                    }
                    getRedis()->del($redis_key.$id);
                    success('删除成功', U('Task/commentKeywordIpTaskList'));
                } else {
                    error('删除失败');
                }
                break;
            case 'copy':
                if (!hasAsoRole('SKITLO')) error(ERROR_MSG);
                $id = I('id');
                $old_data = $db->where("id={$id}")->find();
                $old_data['tag'] = "";
                $old_data['count'] = 0;
                $old_data['start'] = "";
                $old_data['end'] = "";
                $old_data['status'] = 0;
                unset($old_data['id']);
                $update = $db->add($old_data);
                if ($update) {
                    $old_data['id'] = $update;
                    getRedis()->set($redis_key.$update,$old_data);
                    $ip_str = explode(",",$old_data['ip']);
                    foreach ($ip_str as $val) {
                        getRedis()->sAdd($redis_ip_key.$val,$update);
                    }
                    success('复制成功', U('Task/commentKeywordIpTaskList'));
                } else {
                    error('复制失败');
                }
                break;
            case 'ajax':
                $short_name = I('short_name');
                $short_name = strtolower($short_name);
                $country_table_tmp = M("country_table_mst")->where("table_name like '%_{$short_name}%'")->select();
                $country_table_tmp_list = array();
                foreach ($country_table_tmp as $val) {
                    $country_table_tmp_list[$val['table_name']] = $val['table_name'];
                }
                echo $html->createInput('select', 'table_name', null, $country_table_tmp_list);exit;
                break;
            case 'ajax1':
                $short_name = I('short_name');
                $short_name = strtolower($short_name);
                $country_table_tmp = M("country_table_mst")->where("table_name like '%_{$short_name}%'")->select();
                $country_table_tmp_list = array();
                foreach ($country_table_tmp as $val) {
                    $country_table_tmp_list[$val['table_name']] = $val['table_name'];
                }
                echo $html->createInput('select', 'update_table_name', null, $country_table_tmp_list);exit;
                break;
            case 'ajax_get_package':
                $host_url = 'http://36.7.151.221:8086/';
                header("Content-type: text/html; charset=utf-8");
                $game_id = I('get.game_id');
                $arr = M('google_app_config')->where('id='.$game_id)->find();
                $arr['game_id'] = $game_id;
                $country_arr = explode("#", I('get.country'));

                //判断是否有无缓存信息
                $getRedisInfo = getRedis()->get('google_app_info@' . $arr['game_id']);
                //apk安装日期目录
                $apk_date = date('md');

                //获取是否有误apk记录
                $google_apk_info = M('google_apk_mst')->where('game_id='.$arr['game_id'])->field(TRUE)->find();
                if($google_apk_info && $google_apk_info['down_load_url']){
                    $apk_file = str_replace($host_url .'Uploads/downloadPkgs/', '', $google_apk_info['down_load_url']);
                    $apk_file_arr = explode('/', $apk_file);
                    $apk_date = $apk_file_arr[0];
                }

                $getAccountInfo = $this->_getAccounInfo();
                $getAccountInfo['packageName'] = $arr['package_name'];
                $getAccountInfo['vendingCountry'] = $country_arr[0];
                $account_data['account_ids'][0] = $getAccountInfo;

                $account_file = 'detail_package_' . date('YmdHis') . rand(0, 9999) . '.txt';

                //TODO 将协议数据写入文件
                file_put_contents('/home/www/gtils/' . $account_file, json_encode($account_data));

                $locale='de_DE.UTF-8';
                setlocale(LC_ALL,$locale);
                putenv('LC_ALL='.$locale);
                //echo exec('locale charmap');

                //TODO
                exec('java -jar /home/www/gtils/gtils.jar detail 1 /home/www/gtils/' . $account_file, $output, $return_var);

                //TODO 删除临时文件
                @unlink('/home/www/gtils/' . $account_file);

                $data = json_decode($output[0], TRUE);
                $data = $data['results'][0];


                if($data['result'] != 'success'){
                    $this->ajaxReturn(array('status' => 0, 'info' => $data['result']), 'json');
                }

                if(($data['versionCode'] == $getRedisInfo['versionCode']) && ($data['appName'] == $getRedisInfo['appName'])){

                    //处理apk
                    $getRedisInfo['server_url'] = str_replace($host_url, '/data/www/googlemanager/', $getRedisInfo['server_url']);
                    //下载成功调用春华的jar包
                    exec("java -jar /home/www/gtils/GoogleDelta.jar '" . $getRedisInfo['server_url'] . "' '" . $getRedisInfo['server_url'] . "_delta'");

                    //echo "java -jar /home/www/gtils/GoogleDelta.jar '" . $getRedisInfo['server_url'] . "' '" . $getRedisInfo['server_url'] . "_delta'";//exit;

                    $return_data = array(
                        'appName' => $getRedisInfo['appName'],'versionCode' => $getRedisInfo['versionCode'], 'versionName' => $getRedisInfo['versionName'], 'url' => $getRedisInfo['url'], 'is_redis' => 2, 'developerName' => $getRedisInfo['developerName']
                    );
                    $this->ajaxReturn(array('status' => 1, 'info' => '获取成功', 'data' => $return_data), 'json');
                }

                //TODO 存在 versionCode 不同直接重新下载
                $apk_name = $data['appName'];
                $apk_name = str_replace(' /\/ ', '', $apk_name);
                $apk_name = str_replace(' / ', '', $apk_name);
                $apk_name = str_replace(' : ', '', $apk_name);
                $apk_name = str_replace('：', '', $apk_name);
                $apk_name = str_replace(':', '', $apk_name);
                $apk_name = str_replace(' * ', '', $apk_name);
                $apk_name = str_replace(' ? ', '', $apk_name);
                $apk_name = str_replace(' " ', '', $apk_name);
                $apk_name = str_replace(' < ', '', $apk_name);
                $apk_name = str_replace(' > ', '', $apk_name);
                $apk_name = str_replace(' | ', '', $apk_name);
                $apk_name = str_replace('/', ' ', $apk_name);
                $apk_name = str_replace('+', '', $apk_name);
                $apk_name = str_replace('🔥', '', $apk_name);

                $apk_name_temp = str_replace(" ", "\ ", $apk_name);
                $apk_name_temp = str_replace("&", "\&", $apk_name_temp);
                $apk_name_temp = str_replace("'", "\'", $apk_name_temp);
                $apk_name_temp = str_replace("(", "\(", $apk_name_temp);
                $apk_name_temp = str_replace(")", "\)", $apk_name_temp);

                $filePath = '/data/www/googlemanager/Uploads/downloadPkgs/' . $apk_date;

                if($data['additionalUrls']){
                    $obb_key = 'google_app_info@' . $arr['game_id'] . '#ooblist';
                    getRedis()->del($obb_key);
                    $obb_i = 1;
                    foreach ($data['additionalUrls'] as $oob_url){
                        $file_obb_url = 'http://192.168.11.250/downloadPkgs/' . $apk_date . '/' . $arr['package_name'] . '-' . $data['versionCode'] . '-' . $data['versionName'];
                        $down_obb_url = $host_url . 'Uploads/downloadPkgs/'. $apk_date . '/';
                        $file_obb_name = '';
                        if($obb_i == 1){
                            $file_obb_name = "\(" . $apk_name_temp . "\).obb";
                            $file_obb_name1 = "(" . $apk_name . ").obb";
                        }else{
                            $file_obb_name = "\(" . $apk_name_temp . "\)_" . $obb_i . ".obb";
                            $file_obb_name1 = "(" . $apk_name . ")_" . $obb_i . ".obb";

                        }
                        $file_obb_url .= $file_obb_name1;
                        $down_obb_url .= $file_obb_name1;

                        exec('wget "' . $oob_url . '" -O ' . $filePath . '/' . $file_obb_name, $output, $return_var);
                        //echo 'wget "' . $oob_url . '" -O ' . $filePath . '/' . $file_obb_name . '<br />';
                        if($return_var != 0){
                            exec('wget "' . $oob_url . '" -O ' . $filePath . '/' . $file_obb_name, $output, $return_var);
                        }

                        //TODO 本地服务器上路径
                        $obb_file_path = '/downloadPkgs/' . $apk_date . '/' . $arr['package_name'] . '-' . $data['versionCode'] . '-' . $data['versionName'] . $file_obb_name1;

                        getRedis()->lPush($obb_key, $file_obb_url . '$$' . ($filePath . '/' . $file_obb_name1) . '$$' . $obb_file_path . '$$' . $down_obb_url);

                        if($return_var == 0){
                            //TODO 下载成功调用春华的jar包 参数1原文件路径 参数2输出的新文件的路径
                            exec('java -jar /home/www/gtils/GoogleDelta.jar "' . $filePath . '/' . $file_obb_name1 . '" "' . $filePath . '/' . $file_obb_name1 . '_delta"');
                            //echo 'java -jar /home/www/gtils/GoogleDelta.jar "' . $filePath . '/' . $file_obb_name1 . '" "' . $filePath . '/' . $file_obb_name1 . '_delta"' . '<br/>';
                        }else{
                            //TODO 下载资源包不成功 需要服务器端再次下载处理
                            file_put_contents('/home/www/gtils/download_app.txt', $filePath . '/' . $file_obb_name . '|' . $oob_url);
                        }

                        $obb_i = $obb_i + 1;
                    }
                }


                //TODO 存入redis中
                //TODO 任务下载的地址链接
                $url = 'http://192.168.11.250/downloadPkgs/' . $apk_date . '/' . $arr['package_name'] . '-' . $data['versionCode'] . '-' . $data['versionName'] . '(' . $apk_name . ').apk';
                //本地服务器的路径地址
                $file_path = '/downloadPkgs/' . $apk_date . '/' . $arr['package_name'] . '-' . $data['versionCode'] . '-' . $data['versionName'] . '(' . $apk_name . ').apk';
                //TODO redis
                $appInfo = array(
                    'appName' => $data['appName'],'versionCode' => $data['versionCode'], 'versionName' => $data['versionName'], 'downloadUrl' => $data['downloadUrl'], 'last_time' => date('Y-m-d H:i:s'), 'country' => $country_arr[0], 'url' => $url, 'file_path' => $file_path, 'server_url' => $host_url . 'Uploads/downloadPkgs/'. $apk_date. '/(' . $apk_name . ').apk', 'developerName' => $data['developerName'], 'server_file_path' => "{$filePath}/({$apk_name}).apk",
                );
                getRedis()->set('google_app_info@' . $arr['game_id'], $appInfo);

                $return_data = array(
                    'appName' => $data['appName'], 'versionCode' => $data['versionCode'], 'versionName' => $data['versionName'], 'url' => $url, 'is_redis' => 2, 'developerName' => $data['developerName']
                );

                //创建保存目录
                if (!file_exists($filePath) && !mkdir($filePath, 0777, true)) {
                    //TODO 创建目录失败
                } else {
                    $output = array();
                    exec('wget "' . $data['downloadUrl'] . '" -O ' . $filePath . "/\(" . $apk_name_temp . "\).apk", $output, $return_var);
                    if ($return_var != 0) {
                        $output = array();
                        exec('wget "' . $data['downloadUrl'] . '" -O ' . $filePath . "/\(" . $apk_name_temp . "\).apk", $output, $return_var);
                    }
                }

                if ($return_var == 0) {

                    //TODO 下载成功调用春华的jar包
                    exec('java -jar /home/www/gtils/GoogleDelta.jar ' . $filePath . "/\(" . $apk_name_temp . "\).apk". ' ' . $filePath . "/\(" . $apk_name_temp . "\).apk" . '_delta');

                    $checkApk = M('google_apk_mst')->where('game_id=' . $game_id)->count();
                    //下载成功记录下载时间和应用信息
                    $apk_arr = array(
                        'game_id' => $game_id, 'down_load_url' => $host_url . 'Uploads/downloadPkgs/' . $apk_date . '/(' . $apk_name . ').apk',
                        'path_url' => $file_path, 'add_time' => date('Y-m-d H:i:s'), 'country' => $country_arr[0]
                    );
                    if ($checkApk) {
                        M('google_apk_mst')->where('game_id=' . $game_id)->save($apk_arr);
                    } else {
                        M('google_apk_mst')->add($apk_arr);
                    }


                    //TODO 调用春华jar包
                    $sign_file = rand(0, 99999) . '.txt';
                    exec('java -jar /home/www/gtils/ApkSignatureGetter.jar "/data/www/googlemanager/Uploads/downloadPkgs/' . $apk_date . '/(' . $apk_name . ').apk' .'" ' . $sign_file);
                    $get_sign = file_get_contents("/home/www/gtils/ApkSignatureGetter.jar" . $sign_file);
                    $get_sign_arr = explode('	', $get_sign);
                    if($get_sign_arr[1]){
                        $get_sign_arr[1] = str_replace(PHP_EOL, '', $get_sign_arr[1]);
                        getRedis()->set('google_apk_sign@' . $arr['package_name'], $get_sign_arr[1]);
                    }

                    @unlink("/home/www/gtils/ApkSignatureGetter.jar" . $sign_file);
                } else {
                    getRedis()->lPush('google_apk_mst_error_log', date('Y-m-d H:i:s') . '====>' . 'wget "' . $data['downloadUrl'] . '" -O ' . $filePath . "/\(" . $apk_name_temp . "\).apk");
                    $apk_arr = array(
                        'game_id' => $game_id, 'down_load_url' => $host_url . 'Uploads/downloadPkgs/' . $apk_date . '/(' . $apk_name . ').apk',
                        'path_url' => $file_path, 'add_time' => date('Y-m-d H:i:s'), 'country' => $country_arr[0],
                        'is_exist' => 2, //TODO 表示程序下载失败 需要服务器端再次处理
                    );
                    M('google_apk_mst')->add($apk_arr);
                }

                //todo 更新正在执行和未执行的任务
                $update_sql = "UPDATE search_keyword_ip_task SET `nick_name`='{$data['appName']}', `app_version`='{$data['versionCode']}', `versionName`='{$data['versionName']}', `signature`='{$url}',`developerName`='{$data['developerName']}' WHERE `package_name`='{$arr['package_name']}' AND `end` >= '" . date('Y-m-d H:00:00') . "'";
                M()->query($update_sql);

                $this->ajaxReturn(array('status' => 1, 'info' => '获取成功', 'data' => $return_data), 'json');

                break;
            case 'ajax_get_package_new':

                $host_url = 'http://36.7.151.221:8086/';
                $api_down_url = 'http://36.7.151.221:8085/';
                header("Content-type: text/html; charset=utf-8");
                $game_id = I('get.game_id');
                $arr = M('google_app_config')->where('id='.$game_id)->find();
                $arr['game_id'] = $game_id;
                $country_arr = explode("#", I('get.country'));

                //判断是否有无缓存信息
                $getRedisInfo = getRedis()->get('google_app_info@' . $arr['game_id']);
                //apk安装日期目录
                $apk_date = date('md');

                //获取是否有误apk记录
                $google_apk_info = M('google_apk_mst')->where('game_id='.$arr['game_id'])->field(TRUE)->find();
                if($google_apk_info && $google_apk_info['down_load_url']){
                    $apk_file = str_replace($host_url .'Uploads/downloadPkgs/', '', $google_apk_info['down_load_url']);
                    $apk_file_arr = explode('/', $apk_file);
                    $apk_date = $apk_file_arr[0];
                }

                $getAccountInfo = $this->_getAccounInfo();
                $getAccountInfo['packageName'] = $arr['package_name'];
                $getAccountInfo['vendingCountry'] = $country_arr[0];
                $account_data['account_ids'][0] = $getAccountInfo;

                $account_file = 'detail_package_' . date('YmdHis') . rand(0, 9999) . '.txt';

                //TODO 将协议数据写入文件
                file_put_contents('/home/www/gtils/' . $account_file, json_encode($account_data));

                $locale='de_DE.UTF-8';
                setlocale(LC_ALL,$locale);
                putenv('LC_ALL='.$locale);
                //echo exec('locale charmap');

                //TODO
                exec('java -jar /home/www/gtils/gtils.jar detail 1 /home/www/gtils/' . $account_file, $output, $return_var);

                //TODO 删除临时文件
                @unlink('/home/www/gtils/' . $account_file);

                $data = json_decode($output[0], TRUE);
                $data = $data['results'][0];
                dump($data);
                if($data['result'] != 'success'){
                    $this->ajaxReturn(array('status' => 0, 'info' => $data['result']), 'json');
                }


                if(($data['versionCode'] == $getRedisInfo['versionCode']) && ($data['appName'] == $getRedisInfo['appName'])){

                    //处理apk
                    $getRedisInfo['server_url'] = str_replace($host_url, '/data/www/googlemanager/', $getRedisInfo['server_url']);
                    //下载成功调用春华的jar包
                    exec("java -jar /home/www/gtils/GoogleDelta.jar '" . $getRedisInfo['server_url'] . "' '" . $getRedisInfo['server_url'] . "_delta'");

                    //TODO 获取当前版本号redis信息
                    $apk_version_info = getRedis()->get("google_app_info@{$arr['game_id']}#{$data['versionCode']}");
                    if($apk_version_info){
                        $task_downapk_url = $apk_version_info;
                    }else{
                        //TODO
                        $task_downapk_url = $api_down_url . str_replace('/data/www/googlemanager/','', $getRedisInfo['server_url']) . "_delta";
                        getRedis()->set("google_app_info@{$arr['game_id']}#{$data['versionCode']}", $task_downapk_url);
                    }

                    $return_data = array(
                        'appName' => $getRedisInfo['appName'],'versionCode' => $getRedisInfo['versionCode'], 'versionName' => $getRedisInfo['versionName'], 'url' => $task_downapk_url, 'is_redis' => 2, 'developerName' => $getRedisInfo['developerName']
                    );
                    $this->ajaxReturn(array('status' => 1, 'info' => '获取成功', 'data' => $return_data), 'json');
                }


                break;
            case 'ajax_package_info':
                $game_id = I('get.game_id');
                $arr = M('google_app_config')->where('id='.$game_id)->find();
                $arr['game_id'] = $game_id;
                $country_arr = explode("#", I('get.country'));

                //判断是否有无缓存信息
                $getRedisInfo = getRedis()->get('google_app_info@' . $arr['game_id']);
                if($getRedisInfo){

                    if($getRedisInfo['appName'] && $getRedisInfo['versionCode'] && $getRedisInfo['versionName'] && $getRedisInfo['url']){
                        $return_data = array(
                            'appName' => $getRedisInfo['appName'],'versionCode' => $getRedisInfo['versionCode'], 'versionName' => $getRedisInfo['versionName'], 'url' => $getRedisInfo['url'], 'is_redis' => 2, 'developerName' => $getRedisInfo['developerName']
                        );
                        $this->ajaxReturn(array('status' => 1, 'info' => '获取成功', 'data' => $return_data), 'json');
                    }else{
                        $this->ajaxReturn(array('status' => 0, 'info' => '获取失败'), 'json');
                    }

                }else{
                    $this->ajaxReturn(array('status' => 0, 'info' => '获取失败'), 'json');
                }
                break;
            case 'ajax_get_search':
                $game_id = I('get.game_id');
                $arr = M('google_app_config')->where('id='.$game_id)->find();
                $arr['game_id'] = $game_id;
                $country_arr = explode("#", I('get.country'));

                $account_data = array();
                $getAccountInfo = $this->_getAccounInfo();
                $getAccountInfo['packageName'] = $arr['package_name'];
                $getAccountInfo['vendingCountry'] = $country_arr[0];
                $getAccountInfo['keyWords'] = trim(I('get.keyword'));
                $account_data['account_ids'][] = $getAccountInfo;

                $locale='de_DE.UTF-8';
                setlocale(LC_ALL,$locale);
                putenv('LC_ALL='.$locale);

                //TODO 生成的临时账号数据文件
                $rand_text_name = 'search_' . date('YmdHis') . rand(0, 999) . '.txt';

                //TODO 将协议数据写入文件
                file_put_contents('/home/www/gtils/' . $rand_text_name, json_encode($account_data));

                //TODO
                exec('java -jar /home/www/gtils/gtils10.jar search 1 /home/www/gtils/' . $rand_text_name, $output, $return_var);

                @unlink('/home/www/gtils/' . $rand_text_name);

                $data = json_decode($output[0], TRUE);

                if($data['results'][0]['rank'] > -1){
                    $this->ajaxReturn(array('status' => 1, 'info' => '校验成功,当前关键词即时排名[' . $data['results'][0]['rank'] . ']！', 'data' => array('rank' => $data['results'][0]['rank'])), 'json');
                }
                if($data['results'][0]['rank'] == -1){
                    $this->ajaxReturn(array('status' => 0, 'info' => '当前关键词没有搜索到！'), 'json');
                }
                $this->ajaxReturn(array('status' => 0, 'info' => $data['result']), 'json');

                break;
            case 'import':
                if ($_FILES) {
                    if(isset($_FILES['efile']))
                    {
                        $file = $_FILES['efile'];
                        if($file['error']===0)
                        {
                            $cp_data = M("google_cp_config")->select();
                            foreach($cp_data as $v){
                                $cp_list[$v['cid']] = $v['name'];
                            }
                            $package_data = M("google_app_config")->where('status=1')->select();
                            foreach($package_data as $v){
                                $package_list[$v['package_name']] = $v['id']."##".$v['game_name']."##".$v['package_name'];
                            }
                            import('@.Org.ReadExcel');
                            $reader = new \ReadExcel();
                            $data = $reader->readstr($file['tmp_name'], substr($file['name'], strrpos($file['name'],'.')+1),'A',1,'C');
                            if(!empty($data))
                            {
                                $s = $f = 0;
                                foreach($data as $v)
                                {
                                    if (!trim($v['0']) || !trim($v['1']) || !trim($v['2']) || !trim($v['3']) || !trim($v['4']) || !trim($v['5'])) {
                                        $f++;
                                        continue;
                                    }
                                    $arr['tag'] = trim($v['0']);
                                    $country_name = trim($v['1']);
                                    $country_language_list = getCountryLanguage(1);
                                    $country_name = $country_language_list[$country_name];
                                    $country_language = explode('#', $country_name);
                                    $arr['country'] = trim($country_language[0]);
                                    $arr['language'] = trim($country_language[1]);
                                    $cp_name = trim($v['2']);
                                    $arr['cp'] = $cp_list[$cp_name];
                                    $package_name_data = trim($v['3']);
                                    $package_name = $package_list[$package_name_data];
                                    $package_name_arr = explode("##",$package_name);
                                    $arr['game_id'] = $package_name_arr[0];
                                    $arr['game_name'] = $package_name_arr[1];
                                    $arr['package_name'] = $package_name_arr[2];
                                    $arr['keyword'] = trim($v['4']) ? trim($v['4']) : '';
                                    if(trim($v['16'])){
                                        $arr['secord_keyword'] = trim($v['16']);
                                    }
                                    $arr['add_time'] = date('Y-m-d H:i:s');
                                    $start_time = trim($v['5']);
                                    $end_time = trim($v['6']);
                                    $arr['start'] = date("Y-m-d H:i:s",strtotime($start_time));
                                    $arr['end'] = date("Y-m-d H:i:s",strtotime($end_time));
                                    $arr['count'] = trim($v['7']);
                                    $arr['hot'] = trim($v['8']);
                                    if($v['9']){
                                        $store_country_name = trim($v['9']);
                                        $store_country_name = $country_language_list[$store_country_name];
                                        $store_country_name_arr = explode('#', $store_country_name);
                                        $arr['store_country'] = trim($store_country_name_arr[0]);
                                    }

                                    $arr['comment_rate'] = $v[10] ? $v[10] : 0;
                                    $arr['comment_type'] = $v[11] ? $v[11] : 0;
                                    $arr['star'] = $v[12] ? $v[12] : 0;
                                    $arr['comment_start_id'] = $v[13] ? $v[13] : 0;
                                    $arr['score'] = $v[15] ? $v[15] : 0;
                                    $arr['table_name'] = $v[14] ? $v[14] : "";
                                    $arr['task_class'] = $v[17] ? $v[17] : "";
                                    $arr['admin_name'] = getAdminName();
                                    $arr['operate_type'] = "导入任务";

                                    $arr['status'] = 9;
                                    $arr['type'] = 2;
                                    $addResult = $db->add($arr);
                                    if ($addResult) {
                                        $s++;
                                    } else {
                                        $f++;
                                    }
                                }
                                success("导入数据 成功{$s}条，失败{$f}条", U('Task/commentKeywordIpTaskList'));
                            }
                            else
                                error('上传文件为空');
                        }
                        else
                            error('文件上传失败，请重新上传');
                    }
                }
                $this->assign('efile', $html->createInput('file', 'efile'));//文件
                $this->nav = array(
                    '应用列表' => array('link' => '/index.php?m=Home&c=Task&a=commentKeywordIpTaskList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Task&a=commentKeywordIpTaskList&method=add', 'icon' => 'icon_add'),
                    '批量添加' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Task:commentKeywordIpTaskList_import');
                $this->_out();
                break;
        }
    }
}