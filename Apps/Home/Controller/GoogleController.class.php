<?php
/**
 * Created by PhpStorm.
 * User: wushaoliang
 * Date: 2017/2/14
 * Time: 12:08
 */

namespace Home\Controller;

use Home\Org\Html;
use Think\controller;

class GoogleController extends RoleController
{

    public function taskManager()
    {
        if (!hasAsoRole('GTASKS,GTASKO,GTASKO1')) error(ERROR_MSG);
        $method = I('get.method') ? I('get.method') : 'show';
//        dump($method);exit;
        if (isset($_GET['keywords'])) {
            $method = 'show_detail';
        }
        $db = M('google_task_config');
        $group_db = M('google_task_group');
        switch ($method) {
            case 'show':
                $html = new \Home\Org\Html();
                $tableName = 'google_task_group';
                $now = time();
                $searchArr = array(
                    '搜索' => array(
                        'CP' => array('name' => 'cp', 'type' => 'select', 'data' => $this->getCpList()),
                        '游戏' => array('name' => 'packagename', 'type' => 'select', 'data' => $this->getGameList()),
                        '任务类型' => array('name' => 'task_type', 'type' => 'select', 'data' => array('刷榜任务' => 1, 'ASO任务' => 2)),
                        '任务标题' => array('name' => 'task_name', 'type' => 'text'),
                    )
                );
                $searchHtml = TableController::createSearch($tableName, $searchArr);
                //分页
                $wh = $this->getWhereConfig($tableName);
                $count = $group_db->where($wh)->count();
                $pagesize = 200;
                $parameter = TableController::getGlobalWhere($tableName) ? merge($_GET, array('where' => TableController::getGlobalWhere($tableName))) : '';
                $page = new \Home\Org\Page($count, $pagesize, $parameter);
                $data = $group_db->where($wh)->order('id desc')->limit($page->firstRow, $page->listRows)->select();
                $pager = $page->show();
                $this->pager = '<div class="pager">' . $pager . '</div>';
                foreach ($data as $key => &$v) {
                    $s = $e = 0;
                    $taskList = $this->getTaskList($v['id']);
                    $flag = false;
                    foreach ($taskList as $val) {
//                        if (strtotime($val['end_time']) < $now) {
//                            continue 1;
//                        }
                        $flag = true;
                        $v['sum_task'] += $val['promote'];
                        $taskLog = $this->getTaskLog($val['id'], $val['task_type']);
                        $v['faild_task'] += $taskLog['failed'];
                        $v['success_task'] += $taskLog['success'];
                    }
//                    if (!$flag) {
//                        unset($data[$key]);
//                    }
                    $v['id'] = $v['id'];
                    $v['taskName'] = $v['task_name'];
                    $v['cp'] = $v['cp'];
                    $v['gameName'] = $this->getGoogleGameNameById($v['packagename']) . "-" . $v['packagename'];
                    $v['country'] = "<span style='color:green'>" . $this->getGoogleCountryNameById($v['country']) . "#" . $v['language'] . "</span>";
                    $v['faild_task'] = "<span style='color:green'>" . $v['faild_task'] . "</span>";
                    $v['sum_task'] = "<span style='color:green'>" . $v['sum_task'] . "</span>";
                    $v['success_task'] = "<span style='color:green'>" . $v['success_task'] . "</span>";
                    $v['task_type'] = $v['task_type'] == 1 ? '<span style=\'color:green\'>刷榜任务</span>' : '<span style=\'color:red\'>ASO任务</span>';
                    if (!hasAsoRole('GTASKO1')) {
                        $v['status'] = parseYn($v['approved']);
                    } else {
                        $v['status'] = $this->creatAjaxRadio2("google_task_group", "approved", $v['id'], $v['approved']);
                    }
                    if (!hasAsoRole('GTASKO')) {
//                        $v['caozuo'] = "";
//                        $v['zhankai'] = "";
                        $v['caozuo'] = $this->createOperate(array(
                            array('act' => 'edit', 'id' => $v['id']),
                        ), "taskManager");
                        $v['zhankai'] = "<span class=\"open_group success_log_field\" attr='{$v['id']}'>展开</span>";
                    } else {
                        $v['caozuo'] = $this->createOperate(array(
                            array('act' => 'edit', 'id' => $v['id']),
                        ), "taskManager");
                        $v['zhankai'] = "<span class=\"open_group success_log_field\" attr='{$v['id']}'>展开</span>";
                    }
                }
                $this->assign('data', $data);
                if (!hasAsoRole('GTASKO')) {
                    $this->nav = array(
                        '计划任务列表' => array('icon' => 'icon_grid', 'selected' => 1),
                    );
                } else {
                    $this->nav = array(
                        '计划任务列表' => array('icon' => 'icon_grid', 'selected' => 1),
                        '历史任务列表' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=history_show', 'icon' => 'icon_grid'),
                        '计划任务明细' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=show_detail', 'icon' => 'icon_grid'),
                        '添加任务' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=add', 'icon' => 'icon_add'),
                    );
                }
                $this->main = $searchHtml . $this->fetch('taskManager');
                $this->_out();
                break;
            case 'history_show':
                $html = new \Home\Org\Html();
                $tableName = 'google_task_group';
                $now = time();
                $searchArr = array(
                    '搜索' => array(
                        '游戏' => array('name' => 'packagename', 'type' => 'select', 'data' => $this->getGameList()),
                        '任务类型' => array('name' => 'task_type', 'type' => 'select', 'data' => array('刷榜任务' => 1, 'ASO任务' => 2)),
                    )
                );
                $searchHtml = TableController::createSearch($tableName, $searchArr);
                //分页
                $wh = $this->getWhereConfig($tableName);
                $count = $group_db->where($wh)->count();
                $pagesize = 200;
                $parameter = TableController::getGlobalWhere($tableName) ? merge($_GET, array('where' => TableController::getGlobalWhere($tableName))) : '';
                $page = new \Home\Org\Page($count, $pagesize, $parameter);
                $data = $group_db->where($wh)->order('id desc')->limit($page->firstRow, $page->listRows)->select();
                $pager = $page->show();
                $this->pager = '<div class="pager">' . $pager . '</div>';
                foreach ($data as $key => &$v) {
                    $s = $e = 0;
                    $taskList = $this->getTaskList($v['id']);
                    $flag = false;
                    foreach ($taskList as $val) {
                        if (strtotime($val['end_time']) > $now) {
                            continue 1;
                        }
                        $flag = true;
                        $v['sum_task'] += $val['promote'];
                        $taskLog = $this->getTaskLog($val['id'], $val['task_type']);
                        $v['faild_task'] += $taskLog['failed'];
                        $v['success_task'] += $taskLog['success'];
                    }
                    if (!$flag) {
                        unset($data[$key]);
                        continue;
                    }
                    $v['id'] = $v['id'];
                    $v['taskName'] = $v['task_name'];
                    $v['cp'] = $v['cp'];
                    $v['gameName'] = $this->getGoogleGameNameById($v['packagename']) . "-" . $v['packagename'];
                    $v['country'] = "<span style='color:green'>" . $this->getGoogleCountryNameById($v['country']) . "#" . $v['language'] . "</span>";
                    $v['faild_task'] = "<span style='color:green'>" . $v['faild_task'] . "</span>";
                    $v['sum_task'] = "<span style='color:green'>" . $v['sum_task'] . "</span>";
                    $v['success_task'] = "<span style='color:green'>" . $v['success_task'] . "</span>";
                    $v['task_type'] = $v['task_type'] == 1 ? '刷榜任务' : 'ASO任务';
                    if (!hasAsoRole('GTASKO1')) {
                        $v['status'] = parseYn($v['approved']);
                    } else {
                        $v['status'] = parseYn($v['approved']);
                    }
                    if (!hasAsoRole('GTASKO')) {
//                        $v['caozuo'] = "";
//                        $v['zhankai'] = "";
//                        $v['caozuo'] = $this->createOperate(array(
//                            array('act' => 'edit', 'id' => $v['id']),
//                        ), "taskManager");
                        $v['caozuo'] = "<span class=\"open_group success_log_field\" attr='{$v['id']}'>展开</span>";
                    } else {
//                        $v['caozuo'] = $this->createOperate(array(
//                            array('act' => 'edit', 'id' => $v['id']),
//                        ), "taskManager");
                        $v['caozuo'] = "<span class=\"open_group success_log_field\" attr='{$v['id']}'>展开</span>";
                    }
                }
                $this->assign('data', $data);
                if (!hasAsoRole('GTASKO')) {
                    $this->nav = array(
                        '计划任务列表' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=show', 'icon' => 'icon_grid', 'selected' => 1),
                    );
                } else {
                    $this->nav = array(
                        '计划任务列表' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=show', 'icon' => 'icon_grid'),
                        '历史任务列表' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=history_show', 'selected' => 1, 'icon' => 'icon_grid'),
                        '计划任务明细' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=show_detail', 'icon' => 'icon_grid'),
                        '添加任务' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=add', 'icon' => 'icon_add'),
                    );
                }
                $this->main = $this->fetch('taskManager_his');
                $this->_out();
                break;
            case 'show_detail':
                $html = new \Home\Org\Html();
                $tableName = 'google_task_config';
                $now = time();
                $searchArr = array(
                    '搜索' => array(
                        'CP' => array('name' => 'cp', 'type' => 'select', 'data' => $this->getCpList()),
                        '游戏' => array('name' => 'packagename', 'type' => 'select', 'data' => $this->getGameList()),
                        '任务类型' => array('name' => 'task_type', 'type' => 'select', 'data' => array('刷榜任务' => 1, 'ASO任务' => 2)),
                        '关键词' => array('name' => 'keywords', 'type' => 'text'),
                        '开始日期' => array('name' => 'start_time__1', 'type' => 'date', 'sign' => 'egt'),
                        '结束日期' => array('name' => 'end_time__2', 'type' => 'date', 'sign' => 'lt'),
                    )
                );
                $searchHtml = TableController::createSearch($tableName, $searchArr);
                //分页
                $wh = $this->getWhereConfig($tableName);
                $count = $db->where($wh)->count();
                $pagesize = 200;
                $parameter = TableController::getGlobalWhere($tableName) ? merge($_GET, array('where' => TableController::getGlobalWhere($tableName))) : '';
                $page = new \Home\Org\Page($count, $pagesize, $parameter);
                $data = $db->where($wh)->order('id desc')->limit($page->firstRow, $page->listRows)->select();
                $pager = $page->show();
                $this->pager = '<div class="pager">' . $pager . '</div>';
                foreach ($data as $key => &$v) {
                    $v['id'] = $v['id'];
                    $v['cp'] = $v['cp'];
                    $v['gameName'] = $this->getGoogleGameNameById($v['packagename']) . "-" . $v['packagename'];
                    $v['taskName'] = $v['task_name'];
                    $taskLog = $this->getTaskLog($v['id'], $v['task_type']);
                    $v['keywords'] = $v['keywords'] ? $v['keywords'] : '';
                    $v['keywords'] = "<span style='color:green'>" . $v['keywords'] . "</span>";
                    $v['country'] = "<span style='color:green'>" . $this->getGoogleCountryNameById($v['country']) . "#" . $v['language'] . "</span>";
                    $v['faild_task'] = "<span style='color:green'>" . $taskLog['failed'] ? $taskLog['failed'] : 0 . "</span>";
                    $v['sum_task'] = "<span style='color:green'>" . $v['promote'] . "</span>";
                    $v['success_task'] = "<span style='color:green'>" . $taskLog['success'] . "</span>";
                    $v['task_type'] = $v['task_type'] == 1 ? '<span style=\'color:green\'>刷榜任务</span>' : '<span style=\'color:red\'>ASO任务</span>';
                    $v['status'] = parseYn($v['approved']);
                    if (strtotime($v['start_time']) < $now && strtotime($v['end_time']) > $now) {
                        $v['start_time'] = "<span style='color:red'>" . $v['start_time'] . "</span>";
                        $v['end_time'] = "<span style='color:red'>" . $v['end_time'] . "</span>";
                    } else if (strtotime($v['start']) > $now && strtotime($v['end']) > $now) {
                        $v['start_time'] = "<span style='color:blue'>" . $v['start_time'] . "</span>";
                        $v['end_time'] = "<span style='color:blue'>" . $v['end_time'] . "</span>";
                    } else if (strtotime($v['start_time']) < $now && strtotime($v['end_time']) < $now) {
                        $v['start_time'] = "<span style='color:orange'>" . $v['start_time'] . "</span>";
                        $v['end_time'] = "<span style='color:orange'>" . $v['end_time'] . "</span>";
                    } else {
                        $v['start_time'] = $v['start_time'];
                        $v['end_time'] = $v['end_time'];
                    }
                    if (!hasAsoRole('GTASKO')) {
                        $v['caozuo'] = "";
                    } else {
                        $v['caozuo'] = $this->createOperate(array(
                            array('act' => 'edit_one', 'id' => $v['id']),
                        ), "taskManager");
                    }
                }
                $this->assign('data', $data);
                if (!hasAsoRole('GTASKO')) {
                    $this->nav = array(
                        '计划任务列表' => array('icon' => 'icon_grid', 'selected' => 1),
                    );
                } else {
                    $this->nav = array(
                        '计划任务列表' => array('icon' => 'icon_grid', 'link' => '/index.php?m=Home&c=Google&a=taskManager&method=show'),
                        '历史任务列表' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=history_show', 'icon' => 'icon_grid'),
                        '计划任务明细' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=show_detail', 'icon' => 'icon_grid', 'selected' => 1),
                        '添加任务' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=add', 'icon' => 'icon_add'),
                    );
                }
                $this->main = $searchHtml . $this->fetch('taskManager_detail');
                $this->_out();
                break;
            case 'add':
                $html = new \Home\Org\Html();
                if (!hasAsoRole('GTASKO')) error(ERROR_MSG);
                if ($_POST) {

                    if (empty($_POST['cp'])) {
                        error('未选择CP');
                    }
                    if (empty($_POST['packagename'])) {
                        error('未选择游戏');
                    }
                    if (empty($_POST['task_name'])) {
                        error('未填写任务标题');
                    }
                    if (empty($_POST['task_type'])) {
                        error('未选择任务类型');
                    }
                    if (!isset($_POST['approved'])) {
                        error('未选择是否启用');
                    }
                    if (!isset($_POST['country'])) {
                        error('未选择国家语言');
                    }
                    $arr['cp'] = $taskData['cp'] = I('post.cp');
                    $arr['packagename'] = $taskData['packagename'] = I('post.packagename');
                    $arr['task_name'] = $taskData['task_name'] = I('post.task_name');
                    $arr['count'] = $taskData['count'] = I('post.count');
                    $arr['task_type'] = $taskData['task_type'] = I('post.task_type');
                    $arr['approved'] = $taskData['approved'] = I('post.approved');
                    $country_language = explode('#', I('post.country'));
                    $arr['country'] = $taskData['country'] = strtoupper($country_language[0]);
                    $arr['language'] = $taskData['language'] = $country_language[1];
                    $taskNum = I('post.taskNum');
                    $s = $e = 0;
                    $planArr = array();
                    for ($i = 1; $i <= $taskNum; $i++) {
                        $temp = array();
                        if (isset($_POST['promote' . $i]) && !$_POST['promote' . $i]) {
                            error('请填写 task' . $i . '任务数量');
                        }
                        if (isset($_POST['start_time' . $i]) && !$_POST['start_time' . $i]) {
                            error('请填写 task' . $i . '开始时间');
                        }
                        if (isset($_POST['end_time' . $i]) && !$_POST['end_time' . $i]) {
                            error('请填写 task' . $i . '结束时间');
                        }
                        if (isset($_POST['start_time' . $i]) && isset($_POST['end_time' . $i])) {
                            if ($_POST['start_time' . $i] == $_POST['end_time' . $i]) {
                                error('task' . $i . ' 开始时间不能等于结束时间');
                            }
                            if (strtotime($_POST['end_time' . $i]) < strtotime($_POST['start_time' . $i])) {
                                error('task' . $i . ' 结束时间不能小于开始时间');
                            }
                        }
//                        if (isset($_POST['country' . $i]) && !$_POST['country' . $i]) {
//                            error('请填写 task' . $i . '国家语言');
//                        }
                        if ($arr['task_type'] == 2) {
                            if (isset($_POST['keywords' . $i]) && !$_POST['keywords' . $i]) {
                                error('请填写 task' . $i . '关键词');
                            }
                            $temp['start_time'] = date('Y-m-d H:i:00', strtotime($_POST["start_time{$i}"]));
                            $temp['end_time'] = date('Y-m-d H:i:00', strtotime($_POST["end_time{$i}"]));
                            $temp['keywords'] = str_replace(array('，', '；', ';'), ',', $_POST['keywords' . $i]);
                            if (!$temp['keywords']) {
                                continue;
                            }
                        } else {
                            $temp['start_time'] = date('Y-m-d', strtotime($_POST["start_time{$i}"]));
                            $temp['end_time'] = date('Y-m-d', strtotime($_POST["end_time{$i}"]));
                        }
                        $temp['promote'] = $_POST['promote' . $i];
//                        $country_language = explode('-',$_POST['country' . $i]);
//                        $temp['country'] = strtoupper($country_language[0]);
//                        $temp['language'] = strtoupper($country_language[1]);
                        if (!$temp['promote'] || !$temp['start_time'] || !$temp['end_time']) {
                            continue;
                        }
                        $planArr[] = $temp;
                    }
                    if (empty($planArr)) {
                        error('请添加任务量！');
                    }
                    $arr['plan'] = json_encode($planArr);
                    $arr['note'] = $_POST['note'];
                    $arr['addTime'] = date('Y-m-d H:i:s');
                    $result = M('google_task_group')->add($arr);
                    if ($result !== false) {
                        foreach ($planArr as $value) {
                            if ($arr['task_type'] == 2) {
                                $keywordsArr = explode(',', $value['keywords']);
                                foreach ($keywordsArr as $keyWords) {
                                    if (!$keyWords) {
                                        continue;
                                    }
                                    $taskData['promote'] = $value['promote'];
                                    $taskData['start_time'] = $value['start_time'];
                                    $taskData['end_time'] = $value['end_time'];
//                                    $taskData['country'] = $value['country'];
//                                    $taskData['language'] = $value['language'];
                                    $taskData['keywords'] = $keyWords;
                                    $taskData['group_id'] = $result;
                                    $taskData['addTime'] = $taskData['lastUpdateTime'] = date('Y-m-d H:i:s');
                                    $addReuslt = M('google_task_config')->add($taskData);
                                    $addReuslt && $s++;
                                    $addReuslt || $e++;
                                }
                            } elseif ($arr['task_type'] == 1) {
                                $taskData['promote'] = $value['promote'];
                                $taskData['start_time'] = $value['start_time'];
                                $taskData['end_time'] = $value['end_time'];
//                                $taskData['country'] = $value['country'];
//                                $taskData['language'] = $value['language'];
                                $taskData['keywords'] = '';
                                $taskData['group_id'] = $result;
                                $taskData['addTime'] = $taskData['lastUpdateTime'] = date('Y-m-d H:i:s');
                                $addReuslt = M('google_task_config')->add($taskData);
                                $addReuslt && $s++;
                                $addReuslt || $e++;
                            }
                        }
                        success('添加任务成功' . $s . '个,失败' . $e . '个', U('Google/taskManager'));
                    } else {
                        error('保存失败！');
                    }
                }
                $cpList = $this->getCpList();
                $gidList = $this->getGameList();
                $country_language_list = $this->getCountryLanguage(2);
                $this->assign('country_language_list', $country_language_list);
                $this->assign('country', $html->createInput('select', 'country', null, $country_language_list));
                $this->assign('cp', $html->createInput('select', 'cp', null, $cpList));
                $this->assign('gid', $html->createInput('select', 'packagename', null, $gidList));
                $this->assign('task_type', $html->createInput('radio', 'task_type', 1, array('刷榜任务' => 1, 'ASO任务' => 2)));
                $this->assign('task_name', $html->createInput('text', 'task_name', '', '', array('size' => '50')));
                $this->assign('approved', $html->createInput('radio', 'approved', 1, array('是' => 1, '否' => 0)));
                $this->assign('note', $html->createInput('textarea', 'note', '', '', array('cols' => '40', 'rows' => '4')));
                $this->nav = array(
                    '计划任务列表' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=show', 'icon' => 'icon_grid'),
                    '历史任务列表' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=history_show', 'icon' => 'icon_grid'),
                    '计划任务明细' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=show_detail', 'icon' => 'icon_grid'),
                    '添加任务' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('taskManager_add');
                $this->_out();
                break;
            case 'edit':
                $html = new \Home\Org\Html();
                if (!hasAsoRole('GTASKO')) error(ERROR_MSG);
                if ($_POST) {
                    if (empty($_POST['cp'])) {
                        error('未选择CP');
                    }
                    if (empty($_POST['packagename'])) {
                        error('未选择游戏');
                    }
                    if (empty($_POST['task_name'])) {
                        error('未填写任务标题');
                    }
                    if (empty($_POST['task_type'])) {
                        error('未选择任务类型');
                    }
                    if (!isset($_POST['approved'])) {
                        error('未选择是否启用');
                    }
                    if (!isset($_POST['country'])) {
                        error('未选择国家语言');
                    }
                    $arr['cp'] = $taskData['cp'] = I('post.cp');
                    $arr['packagename'] = $taskData['packagename'] = I('post.packagename');
                    $arr['task_name'] = $taskData['task_name'] = I('post.task_name');
                    $arr['task_type'] = $taskData['task_type'] = I('post.task_type');
                    $arr['approved'] = $taskData['approved'] = I('post.approved');
                    $country_language = explode('#', I('post.country'));
                    $arr['country'] = $taskData['country'] = strtoupper($country_language[0]);
                    $arr['language'] = $taskData['language'] = $country_language[1];
                    $taskNum = I('post.taskNum');
                    $s = $e = 0;
                    $planArr = array();
                    for ($i = 1; $i <= $taskNum; $i++) {
                        $temp = array();
                        if (isset($_POST['promote' . $i]) && !$_POST['promote' . $i]) {
                            error('请填写 task' . $i . '任务数量');
                        }
                        if (isset($_POST['start_time' . $i]) && !$_POST['start_time' . $i]) {
                            error('请填写 task' . $i . '开始时间');
                        }
                        if (isset($_POST['end_time' . $i]) && !$_POST['end_time' . $i]) {
                            error('请填写 task' . $i . '结束时间');
                        }
                        if (isset($_POST['start_time' . $i]) && isset($_POST['end_time' . $i])) {
                            if ($_POST['start_time' . $i] == $_POST['end_time' . $i]) {
                                error('task' . $i . ' 开始时间不能等于结束时间');
                            }
                            if (strtotime($_POST['end_time' . $i]) < strtotime($_POST['start_time' . $i])) {
                                error('task' . $i . ' 结束时间不能小于开始时间');
                            }
                        }
//                        if (isset($_POST['country' . $i]) && !$_POST['country' . $i]) {
//                            error('请填写 task' . $i . '国家语言');
//                        }
                        if ($arr['task_type'] == 2) {
                            if (isset($_POST['keywords' . $i]) && !$_POST['keywords' . $i]) {
                                error('请填写 task' . $i . '关键词');
                            }
                            $temp['keywords'] = str_replace(array('，', '；', ';'), ',', $_POST['keywords' . $i]);
                            $temp['start_time'] = date('Y-m-d H:i:00', strtotime($_POST["start_time{$i}"]));
                            $temp['end_time'] = date('Y-m-d H:i:00', strtotime($_POST["end_time{$i}"]));
                            if (!$temp['keywords']) {
                                continue;
                            }
                        } else {
                            $temp['start_time'] = date('Y-m-d', strtotime($_POST["start_time{$i}"]));
                            $temp['end_time'] = date('Y-m-d', strtotime($_POST["end_time{$i}"]));
                        }
                        $temp['promote'] = $_POST['promote' . $i];
//                        $country_language = explode('-',$_POST['country' . $i]);
//                        $temp['country'] = strtoupper($country_language[0]);
//                        $temp['language'] = strtoupper($country_language[1]);
                        if (isset($_POST['taskid' . $i])) {
                            $temp['taskid'] = $_POST['taskid' . $i];
                        }
                        if (!$temp['promote'] || !$temp['start_time'] || !$temp['end_time']) {
                            continue;
                        }
                        $planArr[] = $temp;
                    }
                    if (empty($planArr)) {
                        error('请添加任务量！');
                    }
                    $arr['plan'] = json_encode($planArr);
                    $arr['note'] = $_POST['note'];
                    $arr['addTime'] = date('Y-m-d H:i:s');
                    $result = M('google_task_group')->where('id=' . $_POST['id'])->setField($arr);
                    $groupInfo = M('google_task_group')->where('id=' . $_POST['id'])->find($arr);
                    if ($result !== false) {
                        foreach ($planArr as $value) {
                            if ($arr['task_type'] == 2) {
                                $keywordsArr = explode(',', $value['keywords']);
                                foreach ($keywordsArr as $keyWords) {
                                    if (!$keyWords) {
                                        continue;
                                    }
                                    $taskData['promote'] = $value['promote'];
//                                    $taskData['country'] = $value['country'];
//                                    $taskData['language'] = $value['language'];
                                    $taskData['start_time'] = $value['start_time'];
                                    $taskData['end_time'] = $value['end_time'];
                                    $taskData['keywords'] = $keyWords;
                                    $taskData['group_id'] = $groupInfo['id'];
                                    $taskData['addTime'] = $taskData['lastUpdateTime'] = date('Y-m-d H:i:s');
                                    if ($value['taskid']) {
                                        $UpdateReuslt = M('google_task_config')->where('id=' . $value['taskid'])->setField($taskData);
                                        $UpdateReuslt !== false && $s++;
                                        $UpdateReuslt === false && $e++;
                                    } else {
                                        $addReuslt = M('google_task_config')->add($taskData);
                                        $addReuslt && $s++;
                                        $addReuslt || $e++;
                                    }
                                }
                            } elseif ($arr['task_type'] == 1) {
                                $taskData['promote'] = $value['promote'];
//                                $taskData['country'] = $value['country'];
//                                $taskData['language'] = $value['language'];
                                $taskData['start_time'] = $value['start_time'];
                                $taskData['end_time'] = $value['end_time'];
                                $taskData['keywords'] = '';
                                $taskData['group_id'] = $groupInfo['id'];
                                $taskData['addTime'] = $taskData['lastUpdateTime'] = date('Y-m-d H:i:s');
                                if ($value['taskid']) {
                                    $UpdateReuslt = M('google_task_config')->where('id=' . $value['taskid'])->setField($taskData);
                                    $UpdateReuslt !== false && $s++;
                                    $UpdateReuslt === false && $e++;
                                } else {
                                    $addReuslt = M('google_task_config')->add($taskData);
                                    $addReuslt && $s++;
                                    $addReuslt || $e++;
                                }
                            }
                        }
                        success('修改任务成功' . $s . '个,失败' . $e . '个', U('Google/taskManager'));
                    } else {
                        error('修改失败！');
                    }
                }
                $id = I('id');
                $data = $group_db->where("id=$id")->find();
                $cpList = $this->getCpList();
                $gidList = $this->getGameList();
                $country_language_list = $this->getCountryLanguage(2);
                $this->assign('country_language_list', $country_language_list);
                $this->assign('country', $html->createInput('select', 'country', $data['country'] . '#' . $data['language'], $country_language_list));
                $this->assign('cp', $html->createInput('select', 'cp', $data['cp'], $cpList));
                $this->assign('gid', $html->createInput('select', 'packagename', $data['packagename'], $gidList));
                $this->assign('task_type', $html->createInput('radio', 'task_type', $data['task_type'], array('刷榜任务' => 1, 'ASO任务' => 2)));
                $this->assign('task_name', $html->createInput('text', 'task_name', $data['task_name'], '', array('size' => '50')));
                $this->assign('approved', $html->createInput('radio', 'approved', $data['approved'], array('是' => 1, '否' => 0)));
                $this->assign('note', $html->createInput('textarea', 'note', $data['note'], '', array('cols' => '40', 'rows' => '4')));
                //获取任务详情
                $taskList = M('google_task_config')->where('group_id=' . $data['id'])->select();
                $this->assign('taskList', $taskList);
                $this->assign('id', $id);
                $this->nav = array(
                    '计划任务列表' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=show', 'icon' => 'icon_grid'),
                    '历史任务列表' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=history_show', 'icon' => 'icon_grid'),
                    '计划任务明细' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=show_detail', 'icon' => 'icon_grid'),
                    '添加任务' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->nav = array(
                    '计划任务列表' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=show', 'icon' => 'icon_grid'),
                    '历史任务列表' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=history_show', 'icon' => 'icon_grid'),
                    '计划任务明细' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=show_detail', 'icon' => 'icon_grid'),
                    '添加任务' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=add', 'icon' => 'icon_add'),
                    '修改任务' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('taskManager_edit');
                $this->_out();
                break;
            case 'edit_one':
                $html = new \Home\Org\Html();
                if (!hasAsoRole('GTASKO')) error(ERROR_MSG);
                if ($_POST) {
                    if (empty($_POST['cp'])) {
                        error('未选择CP');
                    }
                    if (empty($_POST['packagename'])) {
                        error('未选择游戏');
                    }
                    if (empty($_POST['task_name'])) {
                        error('未填写任务标题');
                    }
                    if (empty($_POST['task_type'])) {
                        error('未选择任务类型');
                    }
                    if (!isset($_POST['approved'])) {
                        error('未选择是否启用');
                    }
                    if (isset($_POST['promote']) && !$_POST['promote']) {
                        error('请填写任务数量');
                    }
                    if (isset($_POST['start_time']) && !$_POST['start_time']) {
                        error('请填写开始时间');
                    }
                    if (isset($_POST['end_time']) && !$_POST['end_time']) {
                        error('请填写结束时间');
                    }
                    if (isset($_POST['start_time']) && isset($_POST['end_time'])) {
                        if ($_POST['start_time'] == $_POST['end_time']) {
                            error('开始时间不能等于结束时间');
                        }
                        if (strtotime($_POST['end_time']) < strtotime($_POST['start_time'])) {
                            error('结束时间不能小于开始时间');
                        }
                    }
                    if (isset($_POST['country']) && !$_POST['country']) {
                        error('请选择国家语言');
                    }
                    if ($_POST['task_type'] == 2) {
                        if (isset($_POST['keywords']) && !$_POST['keywords']) {
                            error('请填写关键词');
                        }
                        $keyWords = str_replace(array('，', '；', ';'), ',', $_POST['keywords']);
                        $keywordsArr = explode(',', $keyWords);
                        $updateData['keywords'] = $keywordsArr[0];
                        $updateData['start_time'] = date('Y-m-d H:i:00', strtotime($_POST["start_time"]));
                        $updateData['end_time'] = date('Y-m-d H:i:00', strtotime($_POST["end_time"]));
                    } else {
                        $updateData['start_time'] = date('Y-m-d', strtotime($_POST["start_time"]));
                        $updateData['end_time'] = date('Y-m-d', strtotime($_POST["end_time"]));
                        $updateData['keywords'] = '';
                    }
                    $updateData['cp'] = $_POST['cp'];
                    $updateData['packagename'] = $_POST['packagename'];
                    $updateData['task_name'] = $_POST['task_name'];
                    $updateData['task_type'] = $_POST['task_type'];
                    $updateData['approved'] = $_POST['approved'];
                    $updateData['promote'] = $_POST['promote'];
                    $country_language = explode('-', $_POST['country']);
                    $updateData['country'] = strtoupper($country_language[0]);
                    $updateData['language'] = strtoupper($country_language[1]);
                    $updateData['note'] = $_POST['note'];
                    $updateResult = $db->where('id=' . $_POST['id'])->setField($updateData);
                    if ($updateResult !== false) {
                        success('修改单条任务成功！', U('Google/taskManager', array('method' => 'show_detail')));
                    } else {
                        error('修改失败！');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $country_language_list = $this->getCountryLanguage(2);
                $this->assign('country_language_list', $country_language_list);
                $cpList = $this->getCpList();
                $gidList = $this->getGameList();
                $this->assign('cp', $html->createInput('select', 'cp', $data['cp'], $cpList));
                $this->assign('gid', $html->createInput('select', 'packagename', $data['packagename'], $gidList));
                $this->assign('task_type', $html->createInput('radio', 'task_type', $data['task_type'], array('刷榜任务' => 1, 'ASO任务' => 2)));
                $this->assign('task_name', $html->createInput('text', 'task_name', $data['task_name'], '', array('size' => '50')));
                $this->assign('approved', $html->createInput('radio', 'approved', $data['approved'], array('是' => 1, '否' => 0)));
                $this->assign('promote', $html->createInput('text', 'promote', $data['promote']));
                $this->assign('start_time', $html->createInput('datetime1', 'start_time', $data['start_time']));
                $this->assign('end_time', $html->createInput('datetime1', 'end_time', $data['end_time']));
                $this->assign('note', $html->createInput('textarea', 'note', $data['note']));
                $this->assign('keywords', $html->createInput('text', 'keywords', $data['keywords']));
                $this->assign('country', $html->createInput('select', 'country', $data['country'] . '#' . $data['language'], $country_language_list));
                //获取任务详情
                $taskList = M('google_task_config')->where('group_id=' . $data['id'])->select();
                $this->assign('taskList', $taskList);
                $this->assign('id', $id);
                $this->assign('type', $data['task_type']);
                $this->nav = array(
                    '计划任务列表' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=show', 'icon' => 'icon_grid'),
                    '历史任务列表' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=history_show', 'icon' => 'icon_grid'),
                    '计划任务明细' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=show_detail', 'icon' => 'icon_grid'),
                    '添加任务' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->nav = array(
                    '计划任务列表' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=show', 'icon' => 'icon_grid'),
                    '历史任务列表' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=history_show', 'icon' => 'icon_grid'),
                    '计划任务明细' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=show_detail', 'icon' => 'icon_grid'),
                    '添加任务' => array('link' => '/index.php?m=Home&c=Google&a=taskManager&method=add', 'icon' => 'icon_add'),
                    '修改单条任务' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('taskManager_edit_one');
                $this->_out();
                break;
        }
    }


    public function taskGroupDetailList()
    {

        $db = M('google_task_config');
        $now = time();
        $groupid = I('groupid');
        $data = $db->where("group_id = {$groupid}")->order('id desc')->select();
        foreach ($data as $key => &$v) {
            $v['id'] = $v['id'];
            if ($v['task_type'] == 1) {
                $v['task_type'] = "<span style='color:green'>刷榜任务</span>";
            } elseif ($v['task_type'] == 2) {
                $v['task_type'] = "<span style='color:green'>ASO任务</span>";
            } else {
                $v['task_type'] = "<span style='color:green'>未知任务</span>";
            }
            $v['keywords'] = "<span style='color:green'>" . $v['keywords'] . "</span>";
            $v['taskName'] = $v['task_name'];
            $v['cp'] = $v['cp'];
            $v['gameName'] = $this->getGoogleGameNameById($v['packagename']) . "-" . $v['packagename'];
            $taskResultLog = M('google_task_config')->where('task_id=' . $v['id'])->find();
            $v['faild_task'] = "<span style='color:green'>" . ($taskResultLog['failed'] ? $taskResultLog['failed'] : 0) . "</span>";
            $v['sum_task'] = "<span style='color:green'>" . $v['promote'] . "</span>";
            $v['success_task'] = "<span style='color:green'>" . ($taskResultLog['promoted'] - $taskResultLog['failed']) . "</span>";
            if ((strtotime($v['start_time']) > $now || strtotime($v['end_time']) > $now) && I('notOperate')) {
                unset($data[$key]);
                continue;
            }
            if (strtotime($v['start_time']) < $now && strtotime($v['end_time']) > $now) {
                $v['start_time'] = "<span style='color:red'>" . $v['start_time'] . "</span>";
                $v['end_time'] = "<span style='color:red'>" . $v['end_time'] . "</span>";
            } else if (strtotime($v['start']) > $now && strtotime($v['end']) > $now) {
                $v['start_time'] = "<span style='color:blue'>" . $v['start_time'] . "</span>";
                $v['end_time'] = "<span style='color:blue'>" . $v['end_time'] . "</span>";
            } else if (strtotime($v['start_time']) < $now && strtotime($v['end_time']) < $now) {
                $v['start_time'] = "<span style='color:orange'>" . $v['start_time'] . "</span>";
                $v['end_time'] = "<span style='color:orange'>" . $v['end_time'] . "</span>";
            } else {
                $v['start_time'] = $v['start_time'];
                $v['end_time'] = $v['end_time'];
            }
            if (!I('notOperate')) {
                $v['status'] = parseYn($v['approved']);
            } else {
                $v['status'] = parseYn($v['approved']);
            }

            if (!hasAsoRole('GTASKO')) {
                $v['caozuo'] = "";
            } else {
                if (!hasAsoRole('GTASKO1')) {
                    $v['caozuo'] = $this->createOperate(array(
                        array('act' => 'edit_one', 'id' => $v['id']),
                    ), "taskManager");
                } else {
                    $v['caozuo'] = $this->createOperate(array(
                        array('act' => 'edit_one', 'id' => $v['id']),
                    ), "taskManager");
                }
            }
        }
        $html = "<div class='artDialog'><table class=\"display\"><tr><td>ID</td><td>游戏</td><td>国家语言</td><td>关键词</td><td>任务数</td><td>成功数</td><td>失败数</td><td>开始时间/结束时间</td><td>是否启用</td>";
        if (!I('notOperate')) {
            $html .= "<td>操作</td></tr>";
        } else {
            $html .= "</tr>";
        }
        foreach ($data as $val) {
            $html .= "<tr>";
            $html .= "<td>" . $val['id'] . "</td>";
            $html .= "<td>" . $val['gameName'] . "</td>";
            $html .= "<td>" . $this->getGoogleCountryNameById($val['country']) . "#".$v['language']."</td>";
            $html .= "<td>" . $val['keywords'] . "</td>";
            $html .= "<td>" . $val['sum_task'] . "</td>";
            $html .= "<td>" . $val['success_task'] . "</td>";
            $html .= "<td>" . $val['faild_task'] . "</td>";
            $html .= "<td>" . $val['start_time'] . "<br>" . $val['end_time'] . "</td>";
            $html .= "<td>" . $val['status'] . "</td>";
            if (!I('notOperate')) {
                $html .= "<td>" . $val['caozuo'] . "</td>";
            }
            $html .= "</tr>";
        }
        $html .= "</table></div>";
        echo $html;
        exit;
    }


    /**
     * 获取游戏
     */
    public function gidSelectAjax()
    {
        $html = new \Home\Org\Html();
        $cp = I('cp');
        $game_list = M('google_app_config')->where("cpName='" . $cp . "' and status=1")->select();
        foreach ($game_list as $v) {
            $cache[$v['gameName'] . '-' . $v['packagename']] = $v['packagename'];
        }
        $result = $html->createInput('selected', 'packagename', null, $cache);
        echo $result;
    }

    public function delTaskAjax()
    {
        $html = new \Home\Org\Html();
        $taskid = I('taskid');
        $Result = M('google_task_config')->where('id=' . $taskid)->delete();
        echo $Result;
    }


    /**获取任务的列表
     * @param $id
     * @param $type
     * @return array
     */
    private function getTaskList($groupid)
    {
        $db = M("google_task_config");
        $where['group_id'] = $groupid;
        $Tasklist = $db->where($where)->select();
        return $Tasklist;
    }


    /**获取任务执行结果
     * @param $taskid
     * @param $tasktype
     * @return array
     */
    private function getTaskLog($taskid, $tasktype)
    {
        $db = M("googel_result_log");
        $where['task_id'] = $taskid;
        $where['task_type'] = $tasktype;
        $find = $db->where($where)->find();
        if ($find) {
            return array('failed' => $find['failed'], 'success' => $find['promoted'] - $find['failed']);
        } else {
            return array('failed' => 0, 'success' => 0);
        }
    }


    /**获取游戏名称
     * @param $appid
     * @return string
     */
    private function getGoogleGameNameById($appid)
    {
        $db = M("google_app_config");
        $data = $db->select();
        foreach ($data as $v) {
            $apps[$v['packagename']] = $v['gameName'];
        }
        return isset($apps[$appid]) ? $apps[$appid] : red('未定义[' . $appid . ']');
    }

    /**获取游戏名称
     * @param $countryid
     * @return string
     */
    private function getGoogleCountryNameById($countryid)
    {
        $db = M("google_country");
        $data = $db->select();
        foreach ($data as $v) {
            $apps[$v['country_code']] = $v['name'];
        }
        return isset($apps[$countryid]) ? $apps[$countryid] : red('未定义[' . $countryid . ']');
    }

    /**
     * cp管理
     */
    public function cpManager()
    {
        if (!hasAsoRole('GCPS,GCPO')) error(ERROR_MSG);
        $method = I('method') ? I('method') : 'show';
        $html = new \Home\Org\Html();
        $db = M('google_cp_config');
        switch ($method) {
            case 'show':
                $tableName = 'google_cp_config';
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
                    $v['name'] = $v['name'];
                    if (!hasAsoRole('GCPO')) {
                        $v['caozuo'] = "";
                    } else {
                        $v['caozuo'] = $this->createOperate(array(
                            array('act' => 'edit', 'id' => $v['id']),
                            array('act' => 'del', 'id' => $v['id']),
//                            array('act' => 'copy', 'id' => $v['id']),
                        ), "cpManager");
                    }
                }
                $this->assign('data', $data);
                if (!hasAsoRole('GCPO')) {
                    $this->nav = array(
                        '应用列表' => array('icon' => 'icon_grid', 'selected' => 1),
                    );
                } else {
                    $this->nav = array(
                        '应用列表' => array('icon' => 'icon_grid', 'selected' => 1),
                        '添加' => array('link' => '/index.php?m=Home&c=Google&a=cpManager&method=add', 'icon' => 'icon_add'),
                    );
                }
                $this->main = $this->fetch('cpManager');
                $this->_out();
                break;
            case 'add':
                if (!hasAsoRole('GCPO')) error(ERROR_MSG);
                if ($_POST) {
                    $arr['name'] = I('post.name');
                    $arr['addTime'] = $arr['lastUpdateTime'] = date('Y-m-d H:i:s');
                    $update = $db->add($arr);
                    if ($update) {
                        success('添加成功', U('Google/cpManager'));
                    } else {
                        error('添加失败');
                    }
                }
                $this->assign('name', $html->createInput('text', 'name'));
                $this->nav = array(
                    '应用列表' => array('link' => '/index.php?m=Home&c=Google&a=cpManager&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('cpManager_add');
                $this->_out();
                break;
            case 'edit':
                if (!hasAsoRole('GCPO')) error(ERROR_MSG);
                if ($_POST) {
                    $arr['name'] = I('post.name');
                    $arr['lastUpdateTime'] = date('Y-m-d H:i:s');
                    $id = I('post.id');
                    $update = $db->where("id=$id")->save($arr);
                    if ($update) {
                        success('添加成功', U('Google/cpManager'));
                    } else {
                        error('添加失败');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $this->assign('id', $id);
                $this->assign('name', $html->createInput('text', 'name', $data['name']));
                $this->nav = array(
                    '应用列表' => array('link' => '/index.php?m=Home&c=Google&a=cpManager&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Google&a=cpManager&method=add', 'icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('cpManager_edit');
                $this->_out();
                break;
            case 'del':
                if (!hasAsoRole('GCPO')) error(ERROR_MSG);
                $id = I('id');
                $db->where("id=$id")->delete() ? success('删除成功', U('Google/cpManager')) : error('删除失败');
                break;
            case 'copy':
                if (!hasAsoRole('GCPO')) error(ERROR_MSG);
                $id = I('id');
                $data = $db->where("id=$id")->find();
                unset($data['id'], $data['name']);
                $data['addTime'] = $data['lastUpdateTime'] = date('Y-m-d H:i:s');
                $db->add($data) ? success('操作成功', U('Google/cpManager')) : error('操作失败');
                break;
        }
    }

    /**
     * 应用管理
     */
    public function appManager()
    {
        if (!hasAsoRole('GGAMES,GGAMEO')) error(ERROR_MSG);
        $method = I('method') ? I('method') : 'show';
        $html = new \Home\Org\Html();
        $db = M('google_app_config');
        switch ($method) {
            case 'show':
                $tableName = 'google_app_config';
                //搜索
                $searchArr = array(
                    '搜索' => array(
                        'CP名称&nbsp;' => array('name' => 'cpName', 'type' => 'text'),
                        '游戏名称&nbsp;' => array('name' => 'gameName', 'type' => 'text'),
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
                    $v['gameName'] = $v['gameName'];
                    $v['packagename'] = $v['packagename'];
                    $v['cpName'] = $v['cpName'];
                    if (!hasAsoRole('GGAMEO')) {
                        $v['status'] = parseYn($v['status']);
                        $v['caozuo'] = "";
                    } else {
                        $v['status'] = $this->creatAjaxRadio2("google_app_config", "status", $v['id'], $v['status']);
                        $v['caozuo'] = $this->createOperate(array(
                            array('act' => 'edit', 'id' => $v['id']),
                            array('act' => 'del', 'id' => $v['id']),
                            array('act' => 'copy', 'id' => $v['id']),
                        ), "appManager");
                    }
                    $v['addTime'] = $v['addTime'];
                }
                $this->assign('data', $data);
                if (!hasAsoRole('GGAMEO')) {
                    $this->nav = array(
                        '应用列表' => array('icon' => 'icon_grid', 'selected' => 1),
                    );
                } else {
                    $this->nav = array(
                        '应用列表' => array('icon' => 'icon_grid', 'selected' => 1),
                        '添加' => array('link' => '/index.php?m=Home&c=Google&a=appManager&method=add', 'icon' => 'icon_add'),
                    );
                }
                $this->main = $searchHtml . $this->fetch('appManager');
                $this->_out();
                break;
            case 'add':
                if (!hasAsoRole('GGAMEO')) error(ERROR_MSG);
                if ($_POST) {
                    $arr['gameName'] = I('post.gameName');
                    $arr['packagename'] = I('post.packagename');
                    $arr['cpName'] = I('post.cpName');
                    $arr['status'] = I('post.status');
                    $arr['addTime'] = date('Y-m-d H:i:s');
                    $whereapp['_string'] = "gameName='{$arr['gameName']}' OR packagename='{$arr['packagename']}'";
                    $find = $db->where($whereapp)->find();
                    if ($find) {
                        error('添加失败,应用已存在！');
                    }
                    $addResult = $db->add($arr);
                    if ($addResult) {
                        success('添加成功', U('Google/appManager'));
                    } else {
                        error('添加失败');
                    }
                }
                $this->assign('name', $html->createInput('text', 'gameName'));
                $this->assign('packagename', $html->createInput('text', 'packagename'));
                $this->assign('cp', $html->createInput('selected', 'cpName', null, $this->getCpList()));
                $this->assign('status', $html->createInput('radio', 'status', 1, C('YESORNO')));
                $this->nav = array(
                    '应用列表' => array('link' => '/index.php?m=Home&c=Google&a=appManager&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('appManager_add');
                $this->_out();
                break;
            case 'edit':
                if (!hasAsoRole('GGAMEO')) error(ERROR_MSG);
                if ($_POST) {
                    $arr['gameName'] = I('post.gameName');
                    $arr['packagename'] = I('post.packagename');
                    $arr['cpName'] = I('post.cpName');
                    $arr['status'] = I('post.status');
                    $arr['addTime'] = date('Y-m-d H:i:s');
                    $id = I('post.id');
                    $whereapp['_string'] = "(id!=$id) AND (gameName='{$arr['gameName']}' OR packagename='{$arr['packagename']}')";
                    $find = $db->where($whereapp)->find();
                    if ($find) {
                        if ($find['gameName'] == $arr['gameName']) {
                            error('修改失败,游戏名称已存在！');
                        } elseif ($find['packagename'] == $arr['packagename']) {
                            error('修改失败,包名已存在！');
                        }
                    }
                    $update = $db->where("id=$id")->save($arr);
                    if ($update) {
                        success('添加成功', U('Google/appManager'));
                    } else {
                        error('添加失败');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $this->assign('id', $id);
                $this->assign('name', $html->createInput('text', 'gameName', $data['gameName']));
                $this->assign('packagename', $html->createInput('text', 'packagename', $data['packagename']));
                $this->assign('cp', $html->createInput('selected', 'cpName', $data['cpName'], $this->getCpList()));
                $this->assign('status', $html->createInput('radio', 'status', $data['status'], C('YESORNO')));
                $this->nav = array(
                    '应用列表' => array('link' => '/index.php?m=Home&c=Google&a=appManager&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Google&a=appManager&method=add', 'icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('appManager_edit');
                $this->_out();
                break;
            case 'del':
                if (!hasAsoRole('GGAMEO')) error(ERROR_MSG);
                $id = I('id');
                $db->where("id=$id")->delete() ? success('删除成功', U('Google/appManager')) : error('删除失败');
                break;
            case 'copy':
                if (!hasAsoRole('GGAMEO')) error(ERROR_MSG);
                $id = I('id');
                $data = $db->where("id=$id")->find();
                unset($data['id']);
                $data['gameName'] = '';
                $data['packagename'] = '';
                $db->add($data) ? success('操作成功', U('Google/appManager')) : error('操作失败');
                break;
        }
    }

    /**
     * 国家语言管理
     */
    public function countrylanguageManager()
    {
        if (!hasAsoRole('GLAGS')) error(ERROR_MSG);
        $method = I('method') ? I('method') : 'show';
        $html = new \Home\Org\Html();
        $db = M('google_countrylanguage_config');
        switch ($method) {
            case 'show':
                $tableName = 'google_countrylanguage_config';
                //搜索
                $searchArr = array(
                    '搜索' => array(
                        '国家名称&nbsp;' => array('name' => 'countryName', 'type' => 'text'),
                        '语言&nbsp;' => array('name' => 'language', 'type' => 'text'),
                    )
                );
                $searchHtml = TableController::createSearch($tableName, $searchArr);
                //分页
                $wh = $this->getWhereConfig($tableName);
                $count = $db->where($wh)->count();
                $pagesize = 100;
                $parameter = TableController::getGlobalWhere($tableName) ? merge($_GET, array('where' => TableController::getGlobalWhere($tableName))) : '';
                $page = new \Home\Org\Page($count, $pagesize, $parameter);
                $data = $db->where($wh)->order('id desc')->limit($page->firstRow, $page->listRows)->select();
                $pager = $page->show();
                $this->pager = '<div class="pager">' . $pager . '</div>';

                foreach ($data as &$v) {
                    $v['id'] = $v['id'];
                    $v['country'] = $v['country'];
                    $v['language'] = $v['language'];
                    if (!hasAsoRole('GLAGS')) {
                        $v['caozuo'] = "";
                    } else {
                        $v['caozuo'] = $this->createOperate(array(
                            array('act' => 'edit', 'id' => $v['id']),
                            array('act' => 'del', 'id' => $v['id']),
                            array('act' => 'copy', 'id' => $v['id']),
                        ), "countrylanguageManager");
                    }
                }
                $this->assign('data', $data);
                if (!hasAsoRole('GLAGS')) {
                    $this->nav = array(
                        '国家语言列表' => array('icon' => 'icon_grid', 'selected' => 1),
                    );
                } else {
                    $this->nav = array(
                        '国家语言列表' => array('icon' => 'icon_grid', 'selected' => 1),
                        '添加' => array('link' => '/index.php?m=Home&c=Google&a=countrylanguageManager&method=add', 'icon' => 'icon_add'),
                    );
                }
                $this->main = $searchHtml . $this->fetch('countrylanguageManager');
                $this->_out();
                break;
            case 'add':
                if (!hasAsoRole('GLAGS')) error(ERROR_MSG);
                if ($_POST) {
                    $arr['country'] = strtoupper(I('post.country'));
                    $arr['language'] = I('post.language');
                    $whereapp['_string'] = "country='{$arr['country']}' AND language='{$arr['language']}'";
                    $find = $db->where($whereapp)->find();
                    if ($find) {
                        error('添加失败,记录已存在！');
                    }
                    $CountryInfo = M('google_country')->where(array('country_code' => $arr['country']))->find();
                    $arr['countryName'] = $CountryInfo['name'];
                    $addResult = $db->add($arr);
                    if ($addResult) {
                        success('添加成功', U('Google/countrylanguageManager'));
                    } else {
                        error('添加失败');
                    }
                }
                $this->assign('country_list', M('google_country')->getField('country_code,name', true));
                $this->assign('country', $html->createInput('text', 'country'));
                $this->assign('language', $html->createInput('text', 'language'));
                $this->nav = array(
                    '国家语言列表' => array('link' => '/index.php?m=Home&c=Google&a=countrylanguageManager&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('countrylanguageManager_add');
                $this->_out();
                break;
            case 'edit':
                if (!hasAsoRole('GLAGS')) error(ERROR_MSG);
                if ($_POST) {
                    $arr['country'] = strtoupper(I('post.country'));
                    $arr['language'] = I('post.language');
                    $id = I('post.id');
                    $whereapp['_string'] = "(id!=$id) AND (country='{$arr['country']}') AND (language='{$arr['language']}')";
                    $find = $db->where($whereapp)->find();
                    if ($find) {
                        error('修改失败,记录已存在！');
                    }
                    $CountryInfo = M('google_country')->where(array('country_code' => $arr['country']))->find();
                    $arr['countryName'] = $CountryInfo['name'];
                    $update = $db->where("id=$id")->save($arr);
                    if ($update!==false) {
                        success('修改成功', U('Google/countrylanguageManager'));
                    } else {
                        error('修改失败');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $this->assign('country_list', M('google_country')->getField('country_code,name', true));
                $this->assign('id', $id);
                $this->assign('country', $html->createInput('text', 'country', $data['country']));
                $this->assign('language', $html->createInput('text', 'language', $data['language']));
                $this->nav = array(
                    '国家语言列表' => array('link' => '/index.php?m=Home&c=Google&a=countrylanguageManager&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Google&a=countrylanguageManager&method=add', 'icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('countrylanguageManager_edit');
                $this->_out();
                break;
            case 'del':
                if (!hasAsoRole('GLAGS')) error(ERROR_MSG);
                $id = I('id');
                $db->where("id=$id")->delete() ? success('删除成功', U('Google/countrylanguageManager')) : error('删除失败');
                break;
            case 'copy':
                if (!hasAsoRole('GLAGS')) error(ERROR_MSG);
                $id = I('id');
                $data = $db->where("id=$id")->find();
                unset($data['id']);
                $data['country'] = '';
                $data['language'] = '';
                $data['countryName'] = '';
                $db->add($data) ? success('操作成功', U('Google/countrylanguageManager')) : error('操作失败');
                break;
        }
    }


    /**获取CP列表
     * @return mixed
     */
    private function getCpList()
    {
        $db = M("google_cp_config");
        $data = $db->select();
        foreach ($data as $v) {
            $cache[$v['name']] = $v['name'];
        }
        return $cache;
    }


    private function getGameList()
    {
        $db = M("google_app_config");
        $data = $db->where('status=1')->select();
        foreach ($data as $v) {
            $cache[$v['gameName'] . '-' . $v['packagename']] = $v['packagename'];
        }
        return $cache;
    }

    /**
     * 获取国家语言
     */
    private function getCountryLanguage($type = 1)
    {
        $db = M("google_countrylanguage_config");
        $data = $db->select();
        $returnData = array();
        foreach ($data as $value) {
            if ($type == 1) {
                $returnData[$value['country'] . '#' . $value['language']] = $value['countryName'] . '#' . $value['language'];
            } elseif ($type == 2) {
                $returnData[$value['countryName'] . '#' . $value['language']] = $value['country'] . '#' . $value['language'];
            }
        }
        return $returnData;
    }

    /**
     * @param $tableName
     * @return null|string
     */
    private function getWhereConfig($tableName)
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


    /**
     * @param $array
     * @param $control
     * @param null $page_num
     * @return string
     */
    private function createOperate($array, $control, $page_num = null)
    {
        $caozuo = '';
        if (!empty($page_num)) {
            foreach ($array as $v) {
                if ($v['act'] == 'edit')
                    $caozuo .= '<a href="' . U('Google/' . $control, array('method' => 'edit', 'id' => $v['id'], 'p' => $page_num)) . '"><span class="icon_edit" title="修改"></span></a> ';
                if ($v['act'] == 'edit_one')
                    $caozuo .= '<a href="' . U('Google/' . $control, array('method' => 'edit_one', 'id' => $v['id'], 'p' => $page_num)) . '"><span class="icon_edit" title="修改"></span></a> ';
                if ($v['act'] == 'del')
                    $caozuo .= '<a href="' . U('Google/' . $control, array('method' => 'del', 'id' => $v['id'], 'p' => $page_num)) . '" onclick="javascript:return confirm(\'你确定要删除id为' . $v['id'] . '的数据吗?\')"><span class="icon_delete" title="删除"></span></a>';
                if ($v['act'] == 'copy')
                    $caozuo .= '<a href="' . U('Google/' . $control, array('method' => 'copy', 'id' => $v['id'], 'p' => $page_num)) . '"><span class="icon_star" title="复制"></span></a> ';
            }
        } else {
            foreach ($array as $v) {
                if ($v['act'] == 'edit')
                    $caozuo .= '<a href="' . U('Google/' . $control, array('method' => 'edit', 'id' => $v['id'])) . '"><span class="icon_edit" title="修改"></span></a> ';
                if ($v['act'] == 'edit_one')
                    $caozuo .= '<a href="' . U('Google/' . $control, array('method' => 'edit_one', 'id' => $v['id'])) . '"><span class="icon_edit" title="修改"></span></a> ';
                if ($v['act'] == 'del')
                    $caozuo .= '<a href="' . U('Google/' . $control, array('method' => 'del', 'id' => $v['id'])) . '" onclick="javascript:return confirm(\'你确定要删除id为' . $v['id'] . '的数据吗?\')"><span class="icon_delete" title="删除"></span></a>';
                if ($v['act'] == 'copy')
                    $caozuo .= '<a href="' . U('Google/' . $control, array('method' => 'copy', 'id' => $v['id'])) . '"><span class="icon_star" title="复制"></span></a> ';
            }
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
            $str = "<span class=\"{$class0}\" ajax=\"/index.php?m=Home&c=Google&a=index&table={$table}&key={$field}&value=0&id={$id}\">" . $arr[0] . "</span> <span class=\"{$class1}\" ajax=\"/index.php?m=Home&c=Google&a=index&table={$table}&key={$field}&value=1&id={$id}\">" . $arr[1] . "</span> </td>";
        } else {
            $str = "<span class=\"{$class0}\" ajax=\"/index.php?m=Home&c=Google&a=index&table={$table}&key={$field}&value=0&id={$id}\">否</span> <span class=\"{$class1}\" ajax=\"/index.php?m=Home&c=Google&a=index&table={$table}&key={$field}&value=1&id={$id}\">是</span> </td>";
        }
        return $str;
    }

    function index()
    {
        $table = isset($_REQUEST['table']) ? $_REQUEST['table'] : '';
        if (!$table)
            $this->ajaxFailed("请求参数错误", "参数不包含table");

        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if (!$id)
            $this->ajaxFailed("请求参数错误", "参数不包含id");

        $key = isset($_REQUEST['key']) ? $_REQUEST['key'] : '';
        if (!$key)
            $this->ajaxFailed("请求参数错误", "参数不包含key");

        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        if ($value === '')
            $this->ajaxFailed("请求参数错误", "参数不包含value");

        $db = M($table);
        $data = $db->where("id={$id}")->find();
        if (!$data) {
            LogController::e($db->getLastSql());
            $this->ajaxFailed("数据库操作错误", $db->getLastSql());
        }
        $s[$key] = $value;
        $update = $db->where("id=$id")->save($s);
        if ($update === false) {
            $this->ajaxFailed("数据库操作错误", $db->getLastSql());
        } else {
            if ($table == 'google_task_group') {
                $update = M('google_task_config')->where("group_id=$id")->save($s);
                $update === false && $this->ajaxFailed("数据库操作错误", $db->getLastSql());
            }
        }
        $this->ajaxSuccess($db->getLastSql());
    }

}