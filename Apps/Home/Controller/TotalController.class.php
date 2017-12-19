<?php
//任务管理
namespace Home\Controller;

use Home\Org\Html;
use Think\controller;

class TotalController extends RoleController{	
    //数据分析->账号任务统计
    function getBackList() {
        if (!hasAsoRole('GBL')) error(ERROR_MSG);
        $method = I('get.method') ? I('get.method') : 'show';
        $db = M('submit_result_info');
        $html = new \Home\Org\Html();

        switch ($method) {
            case 'show':
                $start = $_POST['start'] ? $_POST['start'] : date("Y-m-d")." 00:00:00";
                $end = $_POST['end'] ? $_POST['end'] : date("Y-m-d H:00:00");
                $search_start = strtotime($start);
                $search_end = strtotime($end);
                $task_type = !empty($_POST['task_type']) ? $_POST['task_type'] : 3;
                $task_id = trim($_POST['task_id']);
                $keyword = trim($_POST['keyword']);
                $search_iphone_tag = $_POST['search_iphone_tag'];
                $search_sid_duan = $_POST['search_sid_duan'];
                $tempWhere = ' ';

                if($task_type == 2){
                    if($task_id){
                        $tempWhere = ' AND search_key = ' . $task_id;
                    }else{
                        if($keyword != ''){
                            $tempSql = "SELECT id FROM search_keyword_ip_task WHERE keyword = '{$keyword}'";
                            $tempList = M('search_keyword_ip_task')->query($tempSql);
                            if($tempList){
                                $tempTaskId = '';
                                foreach ($tempList as $val){
                                    if($tempTaskId != ''){
                                        $tempTaskId .= ',';
                                    }
                                    $tempTaskId .= intval($val['id']);
                                }
                                $tempWhere .= " AND search_key IN (" . $tempTaskId . ") ";
                            }
                        }

                        if($search_iphone_tag){
                            $tempSql = "SELECT id FROM search_keyword_ip_task WHERE tag = '{$search_iphone_tag}'";
                            $tempList = M('search_keyword_ip_task')->query($tempSql);
                            if($tempList){
                                $tempTaskId = '';
                                foreach ($tempList as $val){
                                    if($tempTaskId != ''){
                                        $tempTaskId .= ',';
                                    }
                                    $tempTaskId .= intval($val['id']);
                                }
                                $tempWhere .= " AND search_key IN (" . $tempTaskId . ") ";
                            }
                        }
                    }

                    if($search_sid_duan){
                        $tempSql = "SELECT DISTINCT task_id FROM temp_task_log WHERE id > 10000000 AND `type` = 2 AND LEFT(sid,11) = '{$search_sid_duan}' AND `add_time` >= '{$start}' AND `add_time` <= '{$end}'";
                        $tempList = M()->query($tempSql);
                        if($tempList){
                            $tempTaskId = '';
                            foreach ($tempList as $val){
                                if($tempTaskId != ''){
                                    $tempTaskId .= ',';
                                }
                                $tempTaskId .= intval($val['task_id']);
                            }
                            $tempWhere .= " AND search_key IN (" . $tempTaskId . ") AND LEFT(sid,11) = '{$search_sid_duan}' ";
                        }else{
                            $tempWhere .= " AND search_key = 0 AND LEFT(sid,11) = '{$search_sid_duan}' ";
                        }
                    }
                }

                if($tempWhere != ''){
                    $tempWhere .= ' AND id > 6000000 ';
                }else{
                    $tempWhere = ' id > 6000000 ';
                }

                if($task_type == 1){
                    $result_type_arr = array(
                        1 => '绑定成功', 2 => '失败[2]', 3 => '未知[3]', 11 => '账号超时[11]', 12 => '密码超时[12]', 14 => '接受协议超时[14]', 15 => '谷歌服务超时[15]',
                        16 => '选择银行卡超时[16]', 17 => '已经登入[17]', 18 => '重置密码[18]', 22 => '未能成功获取电话号码[22]', 23 => '选择电话地区失败[23]', 24 => '点击验证失败[24]', 25 => '输入验证码失败[25]', 26 => '获取验证码失败[26]', 27 => '找回成功[27]', 31 => '密码错误[31]', 33 => 'FindEmail Error错误界面[33]', 30 => 'Create A Google Account[30]', 51 => '账号跳转Error页面[51]',52 => '账号已被绑定[52]', 53 => '初始化Error错误界面[53]', 50 => '账号超时[50]', -1 => '返回的device_country有误[-1]', -2 => '返回的dInfo为空[-2]',
                    );
                }elseif($task_type == 2 || $task_type == 5){
                    $result_type_arr = array(
                        100 => '成功', 400 => '授权账号任务成功[400]', 21 => '切换国家失败[21]', 101 => '上传go信息失败[101]', 102 => '未知[102]', 104 => '搜索完毕，没有找到[104]', 105 => '等待Accept协议超时[105]', 106 => '打开APP失败[106]',107 => 'ACCESSTASK_NOT_START ACCESSTASK没有启动', 108 => 'ACCESSTASK_FAIL ACCESSTASK写入的文件是Fail', 109 => 'SCRIPT_TIMEOUT 脚本超时', 160 => '查询没有找到[160]', 161 => '查询Item未知错误[161]', 121 => '出现账号超时的策划栏，没有点击到重试按钮[121]', 122 => '点击 Install 按钮失败[122]', 123 => '点击完善用户信息的continue失败[123]', 124 => '在checkskipbtn方法中点击ErrorAccount的continue按钮失败[124]', 125 => '在checkskipbtn方法中 点击skip按钮失败[125]', 126 => '检测是否在Dialog超时[126]', 127 => '检测是否存在Skip按钮超时[127]', 111 => '点击Accept协议之后等待GooglePlay主界面超时[111]', 162 => '启用AccessTask不成功[162]', 110 => 'LISTVIEW 超时[110]', -1 => '返回的device_country有误[-1]', -2 => '返回的dInfo为空[-2]', 120 => '账号sign out[120]', 130 => "Can't  download app 对话框[130]", 131 => '点击 Accept  按钮失败[131]', 311 => '下载gData失败[311]', 511 => '下载gData失败[511]', 128 => '切换国家超时[128]', 132 => 'MoreInfo超时[132]', 134 => 'install 超时[134]', 112 => '点击MoreInfo后listview超时[112]', 186 => 'gData广播出错[186]', 187 => 'gData下载失败[187]', 188 => 'gData下载MD5错误[188]');
                }elseif($task_type == 3){
                    $result_type_arr = array(
                        1 => '绑定成功', 2 => '失败', 27 => '找回成功[27]', 3 => '未知[3]', 11 => '账号超时[11]', 12 => '密码超时[12]', 14 => '接受协议超时[14]', 15 => '谷歌服务超时[15]',
                        16 => '选择银行卡超时[16]', 17 => '已经登入[17]', 18 => '重置密码[18]', 22 => '未能成功获取电话号码[22]', 23 => '选择电话地区失败[23]', 24 => '点击验证失败[24]', 25 => '输入验证码失败[25]', 26 => '获取验证码失败[26]', 28 => '找不到账号[28]', 202 => '失败[202]', 214 => '接受协议超时[214]', 215 => '谷歌服务超时[215]', 216 => '选择银行卡超时[216]', 31 => '密码错误[31]', 33 => 'FindEmail Error错误界面[33]', 30 => 'Create A Google Account[30]', 51 => '账号跳转Error页面[51]', 52 => '账号已被绑定[52]', 53 => '初始化Error错误界面[53]', 50 => '账号超时[50]', -1 => '返回的device_country有误[-1]', -2 => '返回的dInfo为空[-2]',
                    );
                }

                $orderFieldArr = array();
                foreach ($result_type_arr as $key => $val){
                    $orderFieldArr[] = $key;
                }
                $tempSql = "SELECT DISTINCT result_type FROM submit_result_info WHERE task_type = {$task_type} AND id > 6000000";
                $tempList = $db->query($tempSql);
                foreach ($tempList as $val){
                    if(!in_array($val['result_type'], $orderFieldArr)){
                        $orderFieldArr[] = $val['result_type'];
                    }
                }

                $queryTypeWhere = "task_type = {$task_type} AND id > 6000000";
                if($search_start){
                    $queryTypeWhere .= " AND add_time >= {$search_start} ";
                }
                if($search_end){
                    $queryTypeWhere .= " AND add_time <= {$search_end} ";
                }

                $queryTypeListSql = "SELECT DISTINCT result_type FROM submit_result_info WHERE {$queryTypeWhere} GROUP BY result_type ORDER BY FIELD(result_type," . implode(',', $orderFieldArr) . ")";

                $queryTypeList = $db->query($queryTypeListSql);

                if($queryTypeList){
                    $result_type_list = array();
                    foreach ($queryTypeList as $val){
                        $result_type_list['type' . $val['result_type']] = $result_type_arr[$val['result_type']] ? $result_type_arr[$val['result_type']] : 'result_type='.$val['result_type'];
                    }
                }

                $sql = "SELECT add_time,sid,androidid,";
                foreach ($queryTypeList as $val){
                    $sql .= "count(case WHEN result_type = " . $val['result_type'] . " THEN id END) 'type" . $val['result_type'] . "',";
                }
                $sql .= "add_time FROM submit_result_info WHERE id > 6000000 AND task_type = {$task_type} AND add_time >= {$search_start} AND add_time <= {$search_end}";
                if($tempWhere != ""){
                    $sql .= $tempWhere;
                }

                $sql .= " GROUP BY sid ORDER BY ";
                if($task_type == 1){
                    $sql .= "'type1' desc;";
                }elseif($task_type == 2){
                    $sql .= "'type100' desc;";
                }elseif($task_type == 3){
                    $sql .= "'type1' desc;";
                }elseif($task_type == 5){
                    $sql.= "'type400' desc";
                }
                //echo $sql;

                //统计合计
                $result_type_list['all'] = '合计';

                $data = $db->query($sql);

                $total = array();
                foreach ($data as &$v) {
                    $v['add_time'] = getRedis()->get("aso_iphone_heartbeat_time@" . $v['androidid']);
                    foreach ($result_type_list as $resType => $resTypeName){
                        $total[$resType]['count'] += $v[$resType];
                    }
                }


                //这里为了统计合计
                foreach ($data as &$v) {
                    foreach ($result_type_list as $resType => $resTypeName){
                        $total['all']['count'] += $v[$resType];
                    }
                }

                //合计每个手机的总提交数
                foreach ($data as &$v) {
                    foreach ($result_type_list as $resType => $resTypeName){
                        if($resType != 'all'){
                            $v['all'] = $v['all'] + $v[$resType];
                        }
                    }
                }

                if($task_type == 1){
                    foreach ($data as &$v) {
                        $v['rate'] = round($v['type1']/$total['type1']['count'],4) * 100 . "%";
                    }
                }elseif($task_type == 2){
                    foreach ($data as &$v) {
                        $v['rate'] = round($v['type100']/$total['type100']['count'],4) * 100 . "%";
                    }
                }elseif($task_type == 3){
                    foreach ($data as &$v) {
                        $v['rate'] = round($v['type1']/$total['type1']['count'],4) * 100 . "%";
                    }
                }elseif($task_type == 5){
                    foreach ($data as &$v) {
                        $v['rate'] = round($v['type400']/$total['type400']['count'],4) * 100 . "%";
                    }
                }

                foreach ($total as $key=>$val) {
                    $total[$key]['name'] = $result_type_list[$key];
                    $total[$key]['rate'] = round($val['count']/$total['all']['count'],4) * 100 . "%";
                }

                //按时间段成功总数的统计
                if($task_type == 1 || $task_type == 3){

                    //获取绑定成功账号的数量
                    $trueAccountCountSql = "SELECT DISTINCT account_id FROM submit_result_info WHERE task_type = {$task_type} AND add_time >= {$search_start} AND add_time <= {$search_end} AND (result_type = 1 OR result_type = 17)";
                    $trueCountList = $db->query($trueAccountCountSql);
                    $this->assign('success_count', count($trueCountList));

                    //查询找回成功的数量
                    if($task_type == 3){
                        $findAccountCountSql = "SELECT COUNT(*) AS t FROM account_info WHERE is_find = 0 AND `group` = 3 AND id IN (SELECT DISTINCT account_id FROM submit_result_info WHERE task_type = {$task_type} AND add_time >= {$search_start} AND add_time <= {$search_end} AND (result_type = 1 OR result_type = 17 OR result_type > 200))";
                        $findAccountQuery = M('account_info')->query($findAccountCountSql);
                        $this->assign('find_success_count', $findAccountQuery[0]['t']);
                    }

                }elseif($task_type == 2 || $task_type == 5){
                    $success_res_type = 100;
                    if($task_type == 2){
                        $success_res_type = 100;
                    }elseif($task_type == 5){
                        $success_res_type = 400;
                    }

                    //刷任务的统计
                    $successTotalSql = "SELECT count(*) as success_count, search_key FROM submit_result_info WHERE result_type = {$success_res_type} AND task_type = {$task_type} AND search_key > 0 AND add_time >= {$search_start} AND add_time <= {$search_end} " . $tempWhere . " GROUP BY search_key ORDER BY success_count DESC ";
                    $totalList = $db->query($successTotalSql);

                    $submitCountSql = "SELECT search_key FROM submit_result_info WHERE task_type = {$task_type} AND search_key > 0 AND add_time >= {$search_start} AND add_time <= {$search_end} " . $tempWhere . " GROUP BY search_key";
                    $submitCountList = M()->query($submitCountSql);

                    $search_count_data = array();
                    foreach ($submitCountList as $val){
                        $search_count_data[] = intval($val['search_key']);
                    }


                    if($task_type == 2){
                        foreach ($search_count_data as $search_key){
                            $submitTaskIds[] = $search_key;
                        }
                        foreach ($totalList as $val){
                            $successTaskIds[] = $val['search_key'];
                        }

                        $errorTaskIds = array_diff($submitTaskIds,$successTaskIds);
                        if($errorTaskIds){
                            $errorList = array();
                            foreach ($errorTaskIds as $taskId){
                                $errorList[] = array('success_count' => 0, 'search_key' => $taskId);
                            }
                            $this->assign('error_task_list', $errorList);
                        }
                    }


                    if($totalList){
                        $searchKeyIds = array();
                        foreach ($submitCountList as $val){
                            $searchKeyIds[] = intval($val['search_key']);
                        }

                        $total_issued_count = 0;
                        $temp_task_log_sql = "SELECT COUNT(*) AS t, task_id FROM temp_task_log WHERE id > 10000000 AND task_id IN (" . implode(',', $searchKeyIds) . ") AND add_time >= '{$start}' AND add_time <= '{$end}' AND type = 1 GROUP BY task_id";

                        $task_issued_list = M()->query($temp_task_log_sql);
                        if($task_issued_list){
                            $task_issued_data = array();
                            foreach ($task_issued_list as $val){
                                $task_issued_data[$val['task_id']] = $val['t'];
                                $total_issued_count = $total_issued_count + $val['t'];
                            }
                            $this->assign('search_issued_list', $task_issued_data);
                        }


                        $temp_task_log_sql = "SELECT COUNT(*) AS t, task_id FROM temp_task_log WHERE id > 10000000 AND task_id IN (" . implode(',', $searchKeyIds) . ") AND add_time >= '{$start}' AND add_time <= '{$end}' AND type = 2 GROUP BY task_id, account_id";
                        $task_issued_list = M()->query($temp_task_log_sql);

                        if($task_issued_list){
                            $task_issued_data1 = array();
                            foreach ($task_issued_list as $val){
                                $task_issued_data1[$val['task_id']] += 1;
                            }
                            $this->assign('search_submit_list', $task_issued_data1);
                        }


                        $submitCountSql = "SELECT COUNT(*) AS t FROM temp_task_log WHERE id > 10000000 AND task_id IN (" . implode(',', $searchKeyIds) . ") AND add_time >= '{$start}' AND add_time <= '{$end}' AND type = 2 GROUP BY task_id,account_id";
                        $submit_count_list = M()->query($submitCountSql);
                        $submit_count = count($submit_count_list);

                        //获取下发数成功数提交数合计
                        $search_total_list_sum = array();
                        foreach ($totalList as $val) {
                            $search_total_list_sum['success_count'] += $val['success_count'];
                        }
                        $search_total_list_sum['issued'] = $total_issued_count;
                        $search_total_list_sum['submit'] = $submit_count;

                        $search_total_list_sum['success_rate'] = round($search_total_list_sum['success_count']/$search_total_list_sum['issued'],4) * 100 . "%";
                        $search_total_list_sum['submit_rate'] = round($search_total_list_sum['submit']/$search_total_list_sum['issued'],4) * 100 . "%";
                        $this->assign('search_total_list_sum', $search_total_list_sum);


                        //获取各任务的下发评论次数
                        $comment_issued_sql = "SELECT COUNT(*) AS t, task_id FROM temp_task_log WHERE id > 10000000 AND task_id IN (" . implode(',', $searchKeyIds) . ") AND add_time >= '{$start}' AND add_time <= '{$end}' AND type = 1 AND is_comment = 1 GROUP BY task_id";
                        $comment_issued_list = M()->query($comment_issued_sql);

                        if($comment_issued_list){
                            $comment_issued_data = array();
                            foreach ($comment_issued_list as $val){
                                $comment_issued_data[$val['task_id']] = $val['t'];
                            }

                            $this->assign('comment_issued_list', $comment_issued_data);
                        }

                        unset($comment_issued_sql,$comment_issued_list,$comment_issued_data);
                        //各任务评论成功次数
                        $comment_success_sql = "SELECT task_id,account_id FROM temp_task_log WHERE id > 10000000 AND task_id IN (" . implode(',', $searchKeyIds) . ") AND add_time >= '{$start}' AND add_time <= '{$end}' AND type = 2 AND is_comment = 167";

                        $comment_success_list = M()->query($comment_success_sql);
                        if($comment_success_list){
                            $comment_success_data = array();
                            foreach ($comment_success_list as $val){
                                if(!in_array($val['account_id'], $comment_success_data[$val['task_id']])){
                                    $comment_success_data[$val['task_id']][] = $val['account_id'];
                                }
                            }
                            $this->assign('comment_success_list', $comment_success_data);
                            //echo $comment_success_sql;
                            //dump($comment_success_data);
                        }

                        //获取各任务的信息
                        $getSearchList = M('search_keyword_ip_task')->where(array('id' => array('IN', $searchKeyIds)))->getField('id, keyword, package_name, country, comment_rate, comment_type, count, tag, game_name');
                        $this->assign('search_list', $getSearchList);
                        $this->assign('search_total_list', $totalList);

                    }
                }

                //==================按时时间段统计==================
                if(($task_type == 2 || $task_type == 5) && $data){

                    $success_res_type = 100;
                    if($task_type == 2){
                        $success_res_type = 100;
                    }elseif($task_type == 5){
                        $success_res_type = 400;
                    }

                    $maxTimeSql = "SELECT MAX(add_time) AS end,search_key FROM submit_result_info WHERE task_type = {$task_type} AND add_time >= {$search_start} AND add_time <= {$search_end} " . $tempWhere . " GROUP BY search_key";
                    $maxTimeList = $db->query($maxTimeSql);

                    $minTimeSql = "SELECT MIN(add_time) AS start,search_key FROM submit_result_info WHERE task_type = {$task_type} AND add_time >= {$search_start} AND add_time <= {$search_end} " . $tempWhere . " GROUP BY search_key";
                    $minTimeList = $db->query($minTimeSql);

                    $search_task_list = array();
                    foreach ($minTimeList as $val){
                        $search_task_list[$val['search_key']]['start'] = $val['start'];
                    }

                    foreach ($maxTimeList as $val){
                        $search_task_list[$val['search_key']]['end'] = $val['end'];
                    }

                    //获取缓存
                    $redisKey = 'search_task_slot_census@';

                    $taskTimeSlotList = array();
                    foreach ($search_task_list as $taskId => $val){
                        $redisKey .= $taskId;

                        $tempDateI = date('i', $val['start']);
                        if($tempDateI > 0){
                            $val['start'] = strtotime(date("Y-m-d H",$val['start']).":00:00");
                        }

                        for ($i = $val['start']; $i <= $val['end']; $i = $i + 3600){
                            $tempSql = '';
                            $thisEnd = ($i + 3600);
                            if($val['end'] < ($i + 3600)){
                                $thisEnd = $val['end'];
                                $tempSql = 'SELECT COUNT(*) as t FROM submit_result_info WHERE id >= 6000000 AND result_type = ' . $success_res_type . ' AND search_key = ' . $taskId . ' AND add_time >= ' . $i . ' AND add_time <=' . $thisEnd;
                            }else{
                                $tempSql = 'SELECT COUNT(*) as t FROM submit_result_info WHERE id >= 6000000 AND result_type = ' . $success_res_type . ' AND search_key = ' . $taskId . ' AND add_time >= ' . $i . ' AND add_time <' . $thisEnd;
                            }

                            $tempCount = $db->query($tempSql);
                            $taskTimeSlotList[$taskId][] = array(
                                'time' => date('Y-m-d H:i:s', $i),
                                't'    => $tempCount[0]['t'],
                            );

                            //getRedis()->hSet($redisKey, 'temp', $taskTimeSlotList[$taskId]);
                            unset($tempSql);
                        }
                        unset($tempDateI);
                    }


                    $this->assign('search_task_list', $search_task_list);
                    $this->assign('task_slot_list', $taskTimeSlotList);
                }
                //==================按时时间段统计==================
                $this->assign('result_type_list', $result_type_list);
                $this->assign('data', $data);
                $this->assign('total', $total);
                $this->assign('start', $html->createInput('datetime1', 'start',$start));
                $this->assign('end', $html->createInput('datetime1', 'end', $end));
                $this->assign('task_type', $html->createInput('selected', 'task_type',$task_type,C('SEARCHKEYWORDTYPE')));
                $this->assign('get_type', $task_type);
                $this->assign('search_iphone_tag', $html->createInput('select', 'search_iphone_tag', $search_iphone_tag, getIphoneTagList()));//批量修改tag
                $this->assign('keyword', $html->createInput('text', 'keyword', $keyword));
                $this->assign('task_id', $html->createInput('text', 'task_id', trim($_POST['task_id'])));
                $this->assign("search_sid_duan", $html->createInput("select", "search_sid_duan", $search_sid_duan, getIphoneSidList()));
                $this->assign('iphone_tag_list', array_flip(getIphoneTagList()));
                $this->assign("url", U('Total/getBackList', array("method" => "show")));
                $this->nav = array(
                    '找回统计' => array('icon' => 'icon_grid', 'selected' => 1),
                );

                $this->main = $this->fetch('Total:getBackList');
                $this->_out();
                break;
        }
    }

    //数据分析->协议任务统计
    function agreementTaskStatistic() {
        if (!hasAsoRole('ATS')) error(ERROR_MSG);
        $method = I('get.method') ? I('get.method') : 'show';
        $db = M('task_result_info');
        $html = new \Home\Org\Html();
        switch ($method) {
            case 'show':
                $start = $_POST['start'] ? $_POST['start'] : date("Y-m-d")." 00:00:00";
                $end = $_POST['end'] ? $_POST['end'] : date("Y-m-d H:i:s");
                $search_start = strtotime($start);
                $search_end = strtotime($end);
                $task_redis = getRedis()->get("protocol_task_list");
                $task_id = trim($_POST['task_id']);
                $keyword = trim($_POST['keyword']);
                //$sql = "SELECT add_time,status,task_id,count(case WHEN `status` = 1 THEN id END) as `count` from task_result_info";
                $sql = "SELECT add_time,status,task_id,count(1) as `count` from task_result_info";
//                $sql = "SELECT add_time,status,task_id";
//                for($i = 1; $i <= 7; $i ++){
//                    $sql .= ",count(case WHEN `status` = {$i} THEN id END) as `count{$i}`";
//                }
//                $sql .= " from task_result_info ";
                $sql .= " where task_id > 0 AND add_time >= {$search_start} AND add_time <= {$search_end}";

                $group_result_where = "where task_id > 0 AND add_time >= {$search_start} AND add_time <= {$search_end}";
                if (!empty($task_id)) {
                    $sql .= " and task_id = {$task_id}";
                    $group_result_where .= " AND task_id = {$task_id}";
                }

                if($keyword != ''){
                    $tempSql = "SELECT id FROM google_task_config WHERE keyword = '{$keyword}'";
                    $tempList = M('google_task_config')->query($tempSql);
                    if($tempList){
                        $tempTaskId = '';
                        foreach ($tempList as $val){
                            if($tempTaskId != ''){
                                $tempTaskId .= ',';
                            }
                            $tempTaskId .= $val['id'];
                        }
                        $sql .= " AND task_id IN (" . $tempTaskId . ") ";
                        $group_result_where .= " AND task_id IN (" . $tempTaskId . ")";
                    }
                }

                //TODO 获取结果类型
//                $queryTypeListSql = "SELECT DISTINCT `status` FROM task_result_info " . $group_result_where . " ORDER BY `status` ASC ";
//                $queryTypeList = $db->query($queryTypeListSql);

                $sql .= " GROUP BY task_id,status ORDER BY status";

                $data = $db->query($sql);

                if($data){
                    $taskIdArr = array();
                    foreach ($data as $val){
                        if(!in_array(intval($val['task_id']), $taskIdArr)){
                            $taskIdArr[] = intval($val['task_id']);
                        }
                    }

                    $task_redis = M('google_task_config')->where(array('id' => array('IN', $taskIdArr)))->getField('id,keyword,package_name,task_type,country');

                    $task_type_list = M('google_task_type')->getField('tid,name');
                    $this->assign('task_type_list', $task_type_list);

                    //TODO 从文件日志中获取下发统计
                    $issued_data = array();
                    foreach ($taskIdArr as $taskId){
                        $task_log_content = file_get_contents('/data/www/deviceinfo/public/protocol_issued_log/task_' . $taskId . '.log');
                        if($task_log_content){
                            $task_log_arr = explode(PHP_EOL, $task_log_content);
                            foreach ($task_log_arr as $value){
                                $value_arr = json_decode($value, TRUE);

                                if(strtotime($value_arr['add_time']) >= $search_start && strtotime($value_arr['add_time']) <= $search_end){
                                    $issued_data[$taskId] += 1; //每个任务的下发量
                                }
                            }
                        }
                    }
                }

                $status_error_list = array(
                    1 => '成功[1]',
                    0 => 'UNKNOWN("Unknown")[0]',
                    2 => 'FAIL("UnknownError")[2]',
                    3 => 'FAIL_400("ErrorCode400")[3]',
                    4 => 'FAIL_500("ErrorCode500")[4]',
                    5 => 'FAIL_403("ErrorInputStream403")[5]',
                    6 => 'FAIL_401("ErrorInputStream401")[6]',
                    7 => 'NETWORK_ERROR("NetworkError")[7]',
                    8 => 'NOT_COMPATIBLE("NotCompatible")(8)',
                    9 => '找不到该包',
                );

                $result = array();
                $total = array();
                $total['all']['name'] = "合计";
                //dump($data);
                foreach ($data as &$v) {
                    $result[$v['task_id']]["task_id"] = $v['task_id'];
                    $result[$v['task_id']]["country"] = $task_redis[$v['task_id']]['country'];
                    $result[$v['task_id']]["task_name"] = $task_redis[$v['task_id']]['keyword'];
                    $result[$v['task_id']]["package_name"] = $task_redis[$v['task_id']]['package_name'];
                    $result[$v['task_id']]["task_type"] = $task_redis[$v['task_id']]['task_type'];
                    $result[$v['task_id']][$v['status']] = $v['count'];
                    $total[$v['status']]['name'] = $status_error_list[$v['status']];
                    $total[$v['status']]['count'] += $v['count'];
                    $total['all']['count'] += $v['count'];
                }

                $census_arr = array();
                foreach ($result as &$v) {
                    $v['0'] = $v['0'] ? $v['0'] : 0;
                    $v['1'] = $v['1'] ? $v['1'] : 0;
                    $v['2'] = $v['2'] ? $v['2'] : 0;
                    $v['3'] = $v['3'] ? $v['3'] : 0;
                    $v['4'] = $v['4'] ? $v['4'] : 0;
                    $v['5'] = $v['5'] ? $v['5'] : 0;
                    $v['6'] = $v['6'] ? $v['6'] : 0;
                    $v['7'] = $v['7'] ? $v['7'] : 0;
                    $v['8'] = $v['8'] ? $v['8'] : 0;
                    $v['9'] = $v['9'] ? $v['9'] : 0;

                    //TODO 每个任务的上报结果总量
                    $v['submit_count'] = $v['1'] + $v['2'] + $v['3'] + $v['4'] + $v['5'] + $v['6'] + $v['7'] + $v['0'] + $v['8'] + $v['9'];
                    //TODO 每个任务的下发量
                    $v['issued_count'] = $issued_data[$v['task_id']];

                    $census_arr['submit_count'] += $v['submit_count'];
                    $census_arr['issued_count'] += $v['issued_count'];
                    $census_arr['success_count'] += $v['1'];

                    $v['rate'] = round($v['1']/$v['submit_count'],4) * 100 . "%";
                }
                foreach ($total as $key=>$val) {
                    $total[$key]['rate'] = round($val['count']/$total['all']['count'],4) * 100 . "%";
                }

                $census_arr['submit_rate'] = round($census_arr['submit_count']/$census_arr['issued_count'], 4) * 100 . '%';
                $census_arr['success_rate'] = round($census_arr['success_count']/$census_arr['issued_count'], 4) * 100 . '%';
                $this->assign('census_data', $census_arr);

                //=====新增统计====
                $tempWhere = " task_id > 0 AND add_time >= {$search_start} AND add_time <= {$search_end} ";
                if (!empty($task_id)) {
                    $tempWhere .= " and task_id = {$task_id}";
                }
                $getMaxTimeSql = "SELECT MAX(add_time) as end,task_id FROM task_result_info WHERE " . $tempWhere . " GROUP BY task_id;";
                $getMinTimeSql = "SELECT MIN(add_time) as start ,task_id FROM task_result_info WHERE " . $tempWhere . " GROUP BY task_id;";
                $getMinTimeList = $db->query($getMinTimeSql);
                $getMaxTimeList = $db->query($getMaxTimeSql);
                $taskList = array();
                foreach ($getMinTimeList as $val){
                    $taskList[$val['task_id']]['start'] = $val['start'];// .'|' . date('Y-m-d H:i:s', $val['start']);
                }
                foreach ($getMaxTimeList as $val){
                    $taskList[$val['task_id']]['end'] = $val['end'];// .'|' . date('Y-m-d H:i:s', $val['end']);
                }
                $taskTimeSlotList = array();
                foreach ($taskList as $taskId => $val){

                    $tempDateI = date('i', $val['start']);
                    if($tempDateI > 0){
                        $val['start'] = strtotime(date("Y-m-d H",$val['start']).":00:00");
                    }

                    for ($i = $val['start']; $i <= $val['end']; $i = $i + 3600){
                        $tempSql = '';
                        $thisEnd = ($i + 3600);
                        if($val['end'] < ($i + 3600)){
                            $thisEnd = $val['end'];
                            $tempSql = 'SELECT COUNT(*) as t FROM task_result_info WHERE status = 1 AND task_id = ' . $taskId . ' AND add_time >= ' . $i . ' AND add_time <=' . $thisEnd;
                        }else{
                            $tempSql = 'SELECT COUNT(*) as t FROM task_result_info WHERE status = 1 AND task_id = ' . $taskId . ' AND add_time >= ' . $i . ' AND add_time <' . $thisEnd;
                        }

                        $tempCount = $db->query($tempSql);
                        $taskTimeSlotList[$taskId][] = array(
                            'time' => date('Y-m-d H:i:s', $i),
                            't'    => $tempCount[0]['t'],
                        );
                        unset($tempSql);
                    }
                    unset($tempDateI);
                }
                $this->assign('task_time_list', $taskList);
                $this->assign('task_slot_list', $taskTimeSlotList);

                //=====新增统计====

                //dump($result);
                $this->assign('result', $result);
                $this->assign('total', $total);
                $this->assign('start', $html->createInput('datetime1', 'start',$start));
                $this->assign('end', $html->createInput('datetime1', 'end',$end));
                $this->assign('task_id', $html->createInput('text', 'task_id',$task_id));
                $this->assign('keyword', $html->createInput('text', 'keyword',$keyword));
                $this->assign("url", U('Total/agreementTaskStatistic', array("method" => "show")));
                $this->nav = array(
                    '协议任务统计' => array('icon' => 'icon_grid', 'selected' => 1),
                );
                $this->main = $this->fetch('Total:agreementTaskStatistic');
                $this->_out();
                break;
        }
    }

    //数据分析->打号统计
    function accountInfoList() {
        if (!hasAsoRole('AIL')) error(ERROR_MSG);
        $method = I('get.method') ? I('get.method') : 'show';
        $db = M('account_info');
        $html = new \Home\Org\Html();
        switch ($method) {
            case 'show':
                $start = $_POST['start'] ? $_POST['start'] : date("Y-m-d")." 00:00:00";
                $end = $_POST['end'] ? $_POST['end'] : date("Y-m-d H:i:s");
                $sql = "SELECT count(1) as count,machine_name from account_info where `group` = 2 AND creat_time >= '{$start}' AND creat_time <= '{$end}' GROUP BY machine_name";
                $data = $db->query($sql);
                $total = array();
                foreach ($data as &$v) {
                    $total['machine_count'] += 1;
                    $total['count'] += $v['count'];
                }
                $this->assign('data', $data);
                $this->assign('total', $total);
                $this->assign('start', $html->createInput('datetime1', 'start',$start));
                $this->assign('end', $html->createInput('datetime1', 'end',$end));
                $this->assign("url", U('Total/accountInfoList', array("method" => "show")));
                $this->nav = array(
                    '打号统计' => array('icon' => 'icon_grid', 'selected' => 1),
                );
                $this->main = $this->fetch('Total:accountInfoList');
                $this->_out();
                break;
        }
    }

    /**
     * 网络请求统计
     */
    function getTempLog(){
        if (!hasAsoRole('GTL')) error(ERROR_MSG);
        $method = I('get.method') ? I('get.method') : 'show';
        $html = new \Home\Org\Html();
        switch ($method) {
            case 'show':
                $start = $_POST['start'] ? $_POST['start'] : date("Y-m-d")." 00:00:00";
                $end = $_POST['end'] ? $_POST['end'] : date("Y-m-d H:i:s");

                $tmpSql = "SELECT DISTINCT task_id FROM temp_task_log WHERE add_time >= '{$start}' AND '{$end}' >= `add_time`";
                $tmpList = M('temp_task_log')->query($tmpSql);
                if($tmpList){
                    $taskIds = array();
                    foreach ($tmpList as $val){
                        $taskIds[] = intval($val['task_id']);
                    }

                    $sql = "SELECT id,tag FROM search_keyword_ip_task WHERE id IN (" . implode(',', $taskIds) . ")";
                    $taskList = M('search_keyword_ip_task')->query($sql);
                    if($taskList){
                        $tagIds = $taskIds = array();
                        foreach ($taskList as $val){
                            $tagIds[] = intval($val['tag']);
                            $taskIds[] = intval($val['id']);
                        }
                        $this->assign('list', $taskList);

                        $tagList = M('iphone_tag_mst')->query("SELECT * FROM iphone_tag_mst WHERE tid IN (" . implode(',', $tagIds) . ")");
                        $tagArr = array();
                        foreach ($tagList as $val){
                            $tagArr[$val['tid']] = $val['name'];
                        }
                        $this->assign('tag_list', $tagArr);

                        $issuedSql = "SELECT COUNT(*) AS t, task_id FROM temp_task_log WHERE task_id IN (" . implode(',', $taskIds) . ") AND type = 1 AND type = 1 AND add_time >='{$start}' AND add_time <= '{$end}' GROUP BY task_id";
                        $issuedRs = M('temp_task_log')->query($issuedSql);

                        $reportSql = "SELECT COUNT(*) AS t, task_id FROM temp_task_log WHERE task_id IN (" . implode(',', $taskIds) . ") AND type = 2 AND add_time >='{$start}' AND add_time <= '{$end}' GROUP BY task_id;";
                        $reportRs = M('temp_task_log')->query($reportSql);

                        $reportSuccessSql = "SELECT COUNT(*) AS t, task_id FROM temp_task_log WHERE task_id IN (" . implode(',', $taskIds) . ") AND type = 2 AND result_type = 100 AND add_time >='{$start}' AND add_time <= '{$end}' GROUP BY task_id;";
                        $reportSuccessRs = M('temp_task_log')->query($reportSuccessSql);

                        $taskData = array();
                        foreach ($issuedRs as $val){
                            $taskData[$val['task_id']]['issued'] = $val['t'] ? $val['t'] : 0;
                        }
                        foreach ($reportRs as $val){
                            $taskData[$val['task_id']]['report'] = $val['t'] ? $val['t'] : 0;
                        }
                        foreach ($reportSuccessRs as $val){
                            $taskData[$val['task_id']]['success'] = $val['t'] ? $val['t'] : 0;
                        }
                    }
                }

                $this->assign('data_list', $taskData);

                $this->assign('start', $html->createInput('datetime1', 'start',$start));
                $this->assign('end', $html->createInput('datetime1', 'end',$end));
                $this->nav = array(
                    '网络请求统计' => array('icon' => 'icon_grid', 'selected' => 1),
                );
                $this->main = $this->fetch('Total:getTempLog');
                $this->_out();
                break;
        }
    }

    //数据分析->真机任务计划评估
    function taskPlan()
    {
        if (!hasAsoRole('TASKPS')) error(ERROR_MSG);
        $method = $_GET['method'] ? $_GET['method'] : 'show';
        $db = M('search_keyword_ip_task');
        $tag_list = getIphoneTagList(2);
        switch ($method) {
            case 'show':
                $date = $_POST['date'] ? $_POST['date'] : date("Y-m-d");
                $start_time = $date . " 00:00:00";
                $end_time = $date . " 23:59:59";
                $now = time();
                $result = array();
                //$data = $db->query("select id,tag,start,end,count from search_keyword_ip_task where start <='{$end_time}' and end >= '{$start_time}' and status=1 and tag in (2, 3, 33, 34, 35, 36, 38, 37, 32)");
                $data = $db->query("select id,tag,start,end,count from search_keyword_ip_task where start <='{$end_time}' and end >= '{$start_time}' and status=1 AND tag != 40");
                foreach ($data as $val) {
                    $tag = $tag_list[$val['tag']];
                    $time_cut = ceil((strtotime($val['end'])-strtotime($val['start']))/3600);
                    $plan_count = round($val['count']/$time_cut);
                    for($i=0;$i<24;$i++) {
                        if ($i < 10) {
                            $start_cut = $date." 0".$i.":00:00";
                            $end_cut = $date." 0".$i.":59:59";
                            $redis_key = "google_aso_hour_census@".$val['id']."#".date("YmdH",strtotime($start_cut));
                        } else {
                            $start_cut = $date." ".$i.":00:00";
                            $end_cut = $date." ".$i.":59:59";
                            $redis_key = "google_aso_hour_census@".$val['id']."#".date("YmdH",strtotime($start_cut));
                        }
                        $result[$start_cut]['timecut'] = $start_cut;
                        $status_array = getRedis()->hGet($redis_key);
                        if (strtotime($val['start']) <= strtotime($end_cut) && strtotime($val['end']) >= strtotime($start_cut)) {
                            $result[$start_cut]['count']['合计'] += $plan_count;
                            $result[$start_cut]['count'][$tag] += $plan_count;
                            if (strtotime($start_cut) > $now) {
                                $result[$start_cut]['exception'] = 'exceptionB';
                            } else if (strtotime($end_cut) < $now) {
                                $result[$start_cut]['exception'] = 'exception';
                            } else {
                                $result[$start_cut]['exception'] = '';
                            }
                            if (!empty($status_array)) {
                                foreach ($status_array as $status_key=>$status_val) {
                                    $task_status = explode("@",$status_key);
                                    $task_status = $task_status[1];
                                    if ($task_status == 100) {
                                        $result[$start_cut]['success_count']['合计'] += $status_val;
                                        $result[$start_cut]['success_count'][$tag] += $status_val;
                                    } else {
                                        $result[$start_cut]['error_count']['合计']['合计'] += $status_val;
                                        $result[$start_cut]['error_count']['合计'][$task_status] += $status_val;
                                        $result[$start_cut]['error_count'][$tag]['合计'] += $status_val;
                                        $result[$start_cut]['error_count'][$tag][$task_status] += $status_val;
                                    }
                                }
                            }
                            $send_array = getRedis()->hGet("google_task_issued@".$val['id']);
                            if (!empty($send_array)) {
                                foreach ($send_array as $time_key=>$send_val) {
                                    $new_time_key = substr($time_key,0,4)."-".substr($time_key,4,2)."-".substr($time_key,6,2)." ".substr($time_key,8,2).":00:00";
                                    if ($new_time_key == $start_cut) {
                                        $result[$start_cut]['send_count']['合计'] += $send_val;
                                        $result[$start_cut]['send_count'][$tag] += $send_val;
                                    }
                                }
                            }
                        }
                    }
                }
                $true_result = array();
                foreach ($result as $key => $val) {
                    $true_result[$key]['exception'] = $val['exception'];
                    $true_result[$key]['timecut'] = $val['timecut'];
                    foreach ($val['count'] as $key1=>$val1) {
                        $true_result[$key]['count'] .= $key1."：".$val1."<br/>";
                    }
                    foreach ($val['success_count'] as $key1=>$val1) {
                        $true_result[$key]['success_count'] .= $key1."：".$val1."<br/>";
                    }
                    foreach ($val['send_count'] as $key1=>$val1) {
                        $true_result[$key]['send_count'] .= $key1."：".$val1."<br/>";
                    }
                    foreach ($val['error_count'] as $key1=>$val1) {
                        $true_result[$key]['error_count'] .= $key1."：";
                        foreach ($val1 as $key2=>$val2) {
                            if($key2 == "合计") {
                                $true_result[$key]['error_count'] .= $val2."<br/>";
                            }
                        }
                    }
                }
                $html = new \Home\Org\Html();
                $this->assign("result", $true_result);
                $this->assign("date", $html->createInput("date", "date", $date));
                $this->assign("url",U('Total/taskPlan',array("method"=>"show")));
                $this->nav = array(
                    '真机任务计划评估' => array('icon' => 'icon_search', 'selected' => 1),
                );
                $this->main = $this->fetch('Total:taskPlan');
                $this->_out();
                break;
        }
    }

    /**
     * TODO 协议计划评估
     */
    function proTaskPlan(){
        if (!hasAsoRole('PTASKP')) error(ERROR_MSG);
        $method = I('get.method') ? I('get.method') : 'show';
        $db = M('google_task_config');
        $html = new \Home\Org\Html();
        switch ($method) {
            case 'show':



                $date = $_POST['date'] ? $_POST['date'] : date("Y-m-d");
                $start_time = $date . " 00:00:00";
                $end_time = $date . " 23:59:59";
                $result = array();
                $now = time();
                $result = array();
                $data = $db->query("select id,start,end,count from google_task_config where start <='{$end_time}' and end >= '{$start_time}' and status=1");
                foreach ($data as $val) {
                    //单个任务每小时的计划数
                    $time_cut = ceil((strtotime($val['end'])-strtotime($val['start']))/3600);
                    $plan_count = round($val['count']/$time_cut);

                    for ($i = 0; $i < 24; $i++) {
                        if ($i < 10) {
                            $start_cut = $date . " 0" . $i . ":00:00";
                            $end_cut = $date . " 0" . $i . ":59:59";
                            $redis_key = "pro_task_hour_census@{$val['id']}#" . date("YmdH", strtotime($start_cut));
                        } else {
                            $start_cut = $date . " " . $i . ":00:00";
                            $end_cut = $date . " " . $i . ":59:59";
                            $redis_key = "pro_task_hour_census@{$val['id']}#" . date("YmdH", strtotime($start_cut));;
                        }
                        $result[$start_cut]['timecut'] = $start_cut;
                        $status_array = getRedis()->hGet($redis_key);
                        if (strtotime($val['start']) <= strtotime($end_cut) && strtotime($val['end']) >= strtotime($start_cut)) {
                            $result[$start_cut]['count']['合计'] += $plan_count;
                            if(strtotime($start_cut) <= $now && strtotime($end_cut) > $now){
                                $result[$start_cut]['exception'] = 'exception';
                            }else{
                                if (strtotime($start_cut) > $now) {
                                    $result[$start_cut]['exception'] = 'exceptionB';
                                }else{
                                    $result[$start_cut]['exception'] = '';
                                }
                            }

                            if (!empty($status_array)) {
                                foreach ($status_array as $status_key => $status_val) {
                                    $task_status = explode("@", $status_key);
                                    $task_status = $task_status[1];
                                    if ($task_status == 1) {
                                        $result[$start_cut]['success_count']['合计'] += $status_val;
                                    } else {
                                        $result[$start_cut]['error_count']['合计']['合计'] += $status_val;
                                    }
                                }
                            }
                            $send_array = getRedis()->hGet("pro_task_issued@" . $val['id']);
                            if (!empty($send_array)) {
                                foreach ($send_array as $time_key => $send_val) {
                                    $new_time_key = substr($time_key, 0, 4) . "-" . substr($time_key, 4, 2) . "-" . substr($time_key, 6, 2) . " " . substr($time_key, 8, 2) . ":00:00";
                                    if ($new_time_key == $start_cut) {
                                        $result[$start_cut]['send_count']['合计'] += $send_val;
                                    }
                                }
                            }
                        }
                    }
                }

                $true_result = array();
                foreach ($result as $key => $val) {
                    if($val['count']['合计'] > $val['success_count']['合计']){
                        $true_result[$key]['is_complete'] = 'style="color:red;"';
                    }
                    $true_result[$key]['exception'] = $val['exception'];
                    $true_result[$key]['timecut'] = $val['timecut'];
                    foreach ($val['count'] as $key1=>$val1) {
                        $true_result[$key]['count'] .= $key1."：".$val1."<br/>";
                    }
                    foreach ($val['success_count'] as $key1=>$val1) {
                        $true_result[$key]['success_count'] .= $key1."：".$val1."<br/>";
                    }
                    foreach ($val['send_count'] as $key1=>$val1) {
                        $true_result[$key]['send_count'] .= $key1."：".$val1."<br/>";
                    }
                    foreach ($val['error_count'] as $key1=>$val1) {
                        $true_result[$key]['error_count'] .= $key1."：";
                        foreach ($val1 as $key2=>$val2) {
                            if($key2 == "合计") {
                                $true_result[$key]['error_count'] .= $val2."<br/>";
                            }
                        }
                    }
                }
                $html = new \Home\Org\Html();
                $this->assign("result", $true_result);


                //TODO 统计上一天的协议肉鸡ip和用户量
                $last_date = date('Y-m-d', strtotime('-1 day', strtotime($date)));
                $get_pro_ip_data = getRedis()->get("pro_ip_total_data#{$last_date}");
                if($get_pro_ip_data){
                    $this->assign('dork_list', $get_pro_ip_data);
                    $this->assign('dork_date', $last_date);
                }else{
                    $dork_sql = "SELECT COUNT(DISTINCT ip) AS ip_count, COUNT(DISTINCT android_id) AS android_id_count FROM pro_ip_mst WHERE add_time >= '{$last_date}' AND add_time < '{$date}'";
                    $dork_data = M()->query($dork_sql);
                    if($dork_data){
                        getRedis()->set("pro_ip_total_data#{$last_date}", $dork_data, 86400);
                        $this->assign('dork_list', $dork_data);
                        $this->assign('dork_date', $last_date);
                    }
                }



                $this->assign("date", $html->createInput("date", "date", $date));
                $this->assign("url",U('Total/proTaskPlan',array("method"=>"show")));
                $this->nav = array(
                    '协议任务计划评估' => array('icon' => 'icon_search', 'selected' => 1),
                );
                $this->main = $this->fetch('Total:proTaskPlan');
                $this->_out();
                break;
        }
    }

    /**
     * TODO 协议肉鸡统计
     */
    function proDorkCensus(){
        if (!hasAsoRole('PTASKP')) error(ERROR_MSG);
        $method = I('get.method') ? I('get.method') : 'show';
        $db = M('google_task_config');
        $html = new \Home\Org\Html();
        switch ($method) {
            case 'show':
                $date = $_POST['date'] ? $_POST['date'] : date("Y-m-d", strtotime('-1 day'));

                $true_result = array();

                $html = new \Home\Org\Html();
                $this->assign("result", $true_result);
                $this->assign("date", $html->createInput("date", "date", $date));
                $this->assign("url",U('Total/proTaskPlan',array("method"=>"show")));
                $this->nav = array(
                    '协议ip用户量统计' => array('icon' => 'icon_search', 'selected' => 1),
                );
                $this->main = $this->fetch('Total:proTaskPlan');
                $this->_out();
                break;
        }

    }

    /**
     * TODO 亚马逊IP重复度统计
     */
    function awsIpCensus(){

    }

    function keywordCatchThree() {
        $keywords = $_POST['keyword'] ? $_POST['keyword'] : "WORD ZEN: Connect letters to words";
        $url2 = "https://api3.app.apptweak.com/api/google/keywords/stats?api_key=ZomNfrKhkWE23sfq92ECTQfEeNLMtLebLBqiHXMk&country=us&language=us&device=google&keywords=".$keywords;
        $ch = curl_init();
        // 设置浏览器的特定header
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Host: app.apptweak.com",
            "Connection: keep-alive",
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
            "Upgrade-Insecure-Requests: 1",
            "Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3",
            "Cookie:_ga=GA1.3.1825302949.1509947994; _gid=GA1.3.2093756332.1509947994; mp_mixpanel__c=0; last_seen=1509947996176; __ar_v4=O6PAVQAXOBABNFHH4XWNFX%3A20171106%3A47%7C2A2Z4DRHZFCVHPK3E2BEC6%3A20171106%3A47%7C7QNDLYOCPJFYHMPLKZT63T%3A20171106%3A47; intercom-session-621c9ae4ca235ec165a469548fc6694b0c80f5e8=SS9ZUGtpMEFIYnZjNm5UL2VTNVZqeDRuemZBMWp5cVk5Z0NibzhTc2xuOU8xREZNQkV4NHQ2YWhxNmd3TUF5ZC0tOEZxV3VuZEI3Ri9WWGxnOUV0eGxSUT09--9880809c473b93d2c8a9eebe999bb73281008266; _apptweak_session=BAh7CUkiD3Nlc3Npb25faWQGOgZFVEkiJTFiNjcxYThkYmY3Nzg0MjRkNDJlMDdlNGZiMGNjYjQ0BjsAVEkiE3VzZXJfcmV0dXJuX3RvBjsAVCIGL0kiGXdhcmRlbi51c2VyLnVzZXIua2V5BjsAVFsHWwZpAqriSSIiJDJhJDEwJDl2Q3NjRTM2S1loWVZqOU11U3hlcmUGOwBUSSIQX2NzcmZfdG9rZW4GOwBGSSIxSkM4VGpGcERiUW1GR0tBUGIxUFVnNytueFpKZklvbnd1eXpLalZ5bjRmQT0GOwBG--a6c13e053a8e8a8280db22308bfc521114fe385a; country_code=us; _hjIncludedInSample=1; mp_145b4be9639b426d9fed9cd9e423a8f0_mixpanel=%7B%22distinct_id%22%3A%2058026%2C%22%24initial_referrer%22%3A%20%22https%3A%2F%2Fapp.apptweak.com%2Fusers%2Fsign_in%22%2C%22%24initial_referring_domain%22%3A%20%22app.apptweak.com%22%2C%22__mps%22%3A%20%7B%7D%2C%22__mpso%22%3A%20%7B%7D%2C%22__mpa%22%3A%20%7B%7D%2C%22__mpu%22%3A%20%7B%7D%2C%22__mpap%22%3A%20%5B%5D%2C%22%24search_engine%22%3A%20%22google%22%7D",
        ));
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0');
        curl_setopt($ch, CURLOPT_REFERER,"https://app.apptweak.com/");
        curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate, sdch");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url2);
        curl_setopt($ch, CURLOPT_TIMEOUT,120);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//302redirect
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $html = curl_exec($ch);
        curl_close($ch);

        $arr=json_decode($html);

        $object=$arr[0];
        $keyword=$object->keyword;
        $kei=round($object->kei);
        $competition=round($object->competition);
        $volume=round($object->volume);
        $results=$object->results;
        echo 'keyword:'.$keyword.' | kei:'.$kei.' | competition:'.$competition.' | results: '.$results.' | volume:'.$volume.'<br/><br/>';
    }
	
	function getKeywords(){
		if (!hasAsoRole('XZCX')) error(ERROR_MSG);
		$method = I('get.method') ? I('get.method') : 'show';
		$html = new \Home\Org\Html();
        switch ($method) {
            case 'show':
                $start = $_POST['start'] ? $_POST['start'] : date("Y-m-d 00:00:00");
                $end = $_POST['end'] ? $_POST['end'] : date("Y-m-d H:i:s");
				$start = date('Y-m-d',time($start));
				$end = date('Y-m-d',time($end));
				$package_name = trim($_POST['package_name']);
                $this->nav = array(
                    '新增查询页面' => array('icon' => 'icon_grid', 'selected' => 1),
                );
				
				$result_arr=array();
				$sort_num=1;
				
				$query='select id from get_google_word where package_name=\''.$package_name.'\' limit 1';	//此处判断报名是否已经采集过了，采集过的则不采集
				$res=mysql_query($query);
				$num=mysql_num_rows($res);
				if($num==0){
					
					//采集第一页并获得数据总页数
					$ch=curl_init();
					$url='http://appmanta.com/ASOWeb/appword/findappword.do';
					$curlPost='country=usa&device=1&sdate='.$start.'&edate='.$end.'&appid='.$package_name.'&uid=AAAA&page=1&sort=asc&col=pos&pagesize=100&timezone=-480&isGoogle=yes';
					curl_setopt($ch,CURLOPT_URL,$url);
					curl_setopt($ch,CURLOPT_POST,1);
					curl_setopt($ch,CURLOPT_POSTFIELDS,$curlPost);
					curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
					curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); 
					$content=curl_exec($ch);
					curl_close($ch);
					$object=json_decode($content);
					$arrlist=$object->list;
					if($arrlist){
						foreach($arrlist as $key=>$val){
							$val->sort_num=$sort_num++;
							$result_arr[]=$val;
								$query='insert into get_google_word set ranking='.$val->ranking.',count='.$val->count.',word=\''.$val->word.'\',change_num='.$val->change.',package_name=\''.$package_name.'\'';
								if(!mysql_query($query)){
									//echo $query;
									//echo 'insert db error!';
									//exit;	
								}
							
						}
					}

					//计算ajax页面的总页数
					$totalpages=$object->totalPages;
					$nums=ceil($totalpages/100);

					//分页采集(剩余的页面)
					for($i=2;$i<=$nums;$i++){
						$ch2=curl_init();
						$url3='http://appmanta.com/ASOWeb/appword/findappword.do';
						$curlPost='country=usa&device=1&sdate='.$start.'&edate='.$start.'&appid='.$package_name.'&uid=AAAA&page='.$i.'&sort=asc&col=pos&pagesize=100&timezone=-480&isGoogle=yes';
						curl_setopt($ch2,CURLOPT_URL,$url3);
						curl_setopt($ch2,CURLOPT_POST,1);
						curl_setopt($ch2,CURLOPT_POSTFIELDS,$curlPost);
						curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
						curl_setopt($ch2, CURLOPT_ENCODING, 'gzip'); 
						$content2=curl_exec($ch2);
						curl_close($ch2);
						
						$object=json_decode($content2);
						$arrlist=$object->list;
						if($arrlist){
							foreach($arrlist as $key=>$val){
								$val->sort_num=$sort_num++;
								$result_arr[]=$val;				
								$query='insert into get_google_word set ranking='.$val->ranking.',count='.$val->count.',word=\''.$val->word.'\',change_num='.$val->change.',package_name=\''.$package_name.'\'';
								if(!mysql_query($query)){
									//echo 'insert db error!';
									//exit;	
								}								
							}
						}	
					}
				}else{
					$query='select * from get_google_word where package_name=\''.$package_name.'\'';
					$res=mysql_query($query);
					while($row=mysql_fetch_object($res)){
						$row->sort_num=$sort_num++;
						$row->change=$row->change_num;
						$result_arr[]=$row;
					}
				}
				$result_arr["package_name"]=$package_name;
				$this->assign("result_arr", $result_arr);
                $this->assign('start', $html->createInput('datetime1', 'start',$start));
                $this->assign('end', $html->createInput('datetime1', 'end',$end));		
				$this->assign('package_name', $html->createInput('text', 'package_name', $package_name));
                $this->main = $this->fetch('Total:getKeywords');
                $this->_out();
                break;
				
			case 'detail':
				$keyword = I('get.keyword');
				$package_name = I('get.package_name');
				$this->nav = array(
                    '新增查询详细页面' => array('icon' => 'icon_grid', 'selected' => 1),
                );
				
				$query='select * from get_google_word_detail where package_name=\''.$package_name.'\' and keyword=\''.$keyword.'\'';	//此处判断数据是否已经采集过了，采集过的数据则不插入
				$res=mysql_query($query);
				$num=mysql_num_rows($res);
				if($num==0){
					//采集信息，把采集到的数据存入数据库表				
					set_time_limit(0);
					error_reporting(0);
					$url="https://app.apptweak.com/users/sign_in";  

					//获取登录页面的cookie值，模拟登录时需要用到
					$ch=curl_init();	//初始化
					curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
					curl_setopt($ch, CURLOPT_HEADER, 1);
					curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);	//对认证证书来源的检查，0表示阻止对证书的合法性的检查。这个选项是必须的，对https协议来说的
					curl_setopt($ch,CURLOPT_URL,$url);  //设置请求地址
					curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);	//关闭直接输出
					$content=curl_exec($ch);	//触发请求 
					if (curl_errno($ch)) {    
						echo 'Errno'.curl_error($ch);  
					} 
					curl_close($ch);	//关闭curl，释放资源
					preg_match('/Set-Cookie:(.+);/iU', $content, $re);
					$cookie=$re[1];	//获取到登录前的cookie值，头信息里面需要用到	

					//匹配获得登录表单内的信息
					preg_match_all("/value=\"[^\"]*\"/i",$content,$matches);
					$post='utf8='.trim(substr($matches[0][0],6),'"').'&authenticity_token='.trim(substr($matches[0][1],6),'"').'&user[email]=letangjacquie@gmail.com&user[password]=lt@147258369.&user[remember_me]=0&commit=Log in';

					//登录
					$ch = curl_init();	//初始化
					curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
					curl_setopt($ch,CURLOPT_HEADER, 1);
					curl_setopt($ch,CURLOPT_URL,$url);  //设置请求地址
					curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);	//对认证证书来源的检查，0表示阻止对证书的合法性的检查。这个选项是必须的，对https协议来说的
					curl_setopt($ch,CURLOPT_POST,1);	//使用post提交数据
					curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);	//关闭直接输出  
					curl_setopt($ch,CURLOPT_POSTFIELDS,$post);	//设置 post提交的数据
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(				
						"Host:app.apptweak.com",
						"User-Agent:Mozilla/5.0 (Windows NT 6.1; W…) Gecko/20100101 Firefox/56.0",
						"Accept:text/html,application/xhtml+xm…plication/xml;q=0.9,*/*;q=0.8",
						"Accept-Language:zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3",
						"Accept-Encoding:gzip, deflate, br",
						"Content-Type:application/x-www-form-urlencoded",
						"Referer:https://app.apptweak.com/users/sign_in",
						"Cookie:".$cookie,
						"Connection:keep-alive",
						"Upgrade-Insecure-Requests:1",
					));
					$content=curl_exec($ch);	//触发请求 
					if (curl_errno($ch)) {    
						echo 'Errno:'.curl_error($ch);  
					} 
					curl_close($ch);	//关闭curl，释放资源
					preg_match('/Set-Cookie:(.+);/iU', $content, $re);
					$cookie=$re[1];	//获取到cookie值，用于保持登录状态用的

					$keyword=str_replace(' ','+',$keyword);
					$url = "https://api3.app.apptweak.com/api/google/keywords/stats?api_key=ZomNfrKhkWE23sfq92ECTQfEeNLMtLebLBqiHXMk&country=us&language=us&device=google&keywords=".$keyword;   
					$ch = curl_init();
					// 设置浏览器的特定header
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						"Host: app.apptweak.com",
						"Connection: keep-alive",
						"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
						"Upgrade-Insecure-Requests: 1",
						"Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3",
						"Cookie:".$cookie,
						));
					curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0');
					curl_setopt($ch, CURLOPT_REFERER,"https://app.apptweak.com/");
					curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate, sdch");
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_TIMEOUT,120);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//302redirect
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
					$html = curl_exec($ch);
					curl_close($ch);
					
					$arr=json_decode($html);
					$object=$arr[0];

					$keyword=$object->keyword;
					$kei=round($object->kei);
					$competition=round($object->competition);
					$volume=round($object->volume);
					$results=$object->results;	
					
					$query='insert into get_google_word_detail set keyword=\''.$keyword.'\',kei='.$kei.',competition='.$competition.',results='.$results.',volume='.$volume.',package_name=\''.$package_name.'\'';
					if(!mysql_query($query)){
						
					}	
					if(count($object)==0){
						$result_arr['msg']='网络繁忙，没有查询到结果,刷新重试一次';
					}
				}else{
					$object=mysql_fetch_object($res);
				}
				$this->assign("result_arr", $result_arr);
				$this->assign("result_obj", $object);
				$this->main = $this->fetch('Total:getKeywords_detail');
                $this->_out();
				break;
		}
	}

	function appfigures(){
		if (!hasAsoRole('APPF')) error(ERROR_MSG);
		$html = new \Home\Org\Html();
		$this->nav = array(
			'appfigures' => array('icon' => 'icon_grid', 'selected' => 1),
		);
		$query='select * from appfigures_user';
		$res=mysql_query($query);
		while($row=mysql_fetch_array($res)){
			if($row['status']==1){
				$row['status']='ok';
			}
			$user_arr[]=$row;
		}
		if($_GET['action']=='delete'){
			$query='delete from appfigures_user where id='.$_GET['id'];
			if(mysql_query($query)){
				header('location:http://36.7.151.221:8086/index.php?m=Home&c=Total&a=appfigures');
			}
		}
		if($_GET['action']=='add'){
			$user_name=trim($_POST['user_name']);
			$password=trim($_POST['password']);
			if($user_name==''||$password==''){
				echo '用户名或密码不能为空';
				exit;
			}
			$query='insert into appfigures_user set user_name=\''.$user_name.'\',password=\''.$password.'\'';
			if(mysql_query($query)){
				$msg='数据插入成功！';
			}else{
				$msg='数据插入失败！';
			}
			header('location:http://36.7.151.221:8086/index.php?m=Home&c=Total&a=appfigures');
		}
		
		$this->assign('user_name', $html->createInput('text', 'user_name',$user_name));		
		$this->assign('password', $html->createInput('text', 'password', $password));
		$this->assign("msg", $msg);
		$this->assign("user_arr", $user_arr);
		$this->main = $this->fetch('Total:appfigures');
		$this->_out();
	}
	function appfigures_graph(){		
		if (!hasAsoRole('APPFT')) error(ERROR_MSG);
		$html = new \Home\Org\Html();
		$this->nav = array(
			'appfigures_graph' => array('icon' => 'icon_grid', 'selected' => 1),
		);
		
		$country='';
		foreach($_POST['country'] as $key=>$val){
			$country.='\''.$val.'\',';
		}
		$country=trim($country,',');
		
		$start=$_POST['start'];
		$start=strtotime($start.' 00:00:00');
		$end=$_POST['end'];
		$end=strtotime($end.' 00:00:00');
		$package_name=$_POST['package_name'];
		$game_id=$_POST['game_id'];
		if($game_id!=''){
			$query='select package_name from google_app_config where game_id='.$game_id.' limit 1';
			$res=mysql_query($query);
			$row=mysql_fetch_array($res);
			$package_name=$row['package_name'];
		}
		$query='select distinct billboard from appfigures where country in('.$country.') and add_time >='.$start.' and add_time<'.$end.' and package_name=\''.$package_name.'\'';
		$res=mysql_query($query);
		$dates='';
		while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
			$bangdan_arr[]=$row;
		}
		$dates='';
		$dates_stamp='';
		foreach($_POST['country'] as $k=>$v){
			foreach($bangdan_arr as $key=>$value){		
				$query='select * from appfigures where billboard=\''.$value['billboard'].'\' and country=\''.$v.'\' and add_time >='.$start.' and add_time<'.$end.' and package_name=\''.$package_name.'\'';
				$res=mysql_query($query);
				$dates_temp='';
				$dates_temp_stamp='';
				while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
					$dates_temp_stamp.='\''.$row['add_time'].'\',';
					$row['add_time']=date('m/d H:i',$row['add_time']);
					$result_arr[$v][$value['billboard']][]=$row;
					$data[$key][]=$row['rank'];
					$dates_temp.='\''.$row['add_time'].'\',';
				}
				//echo 'dates_temp:'.$dates_temp.'<br/>dates:'.$dates.'<br/><br/>';
				if(strlen($dates)<=strlen($dates_temp)){
					$dates=$dates_temp;
				}					
				if(strlen($dates_stamp)<=strlen($dates_temp_stamp)){
					$dates_stamp=$dates_temp_stamp;
				}			
			}
		}
		$dates=trim($dates,',');
		$series='';
		$i=1;
		foreach($result_arr as $key=>$value){
			foreach($value as $k=>$v){
				foreach($v as $sub_k=>$sub_v){
					$sub_v['sort_num']=$i;
					$result_arr_format[]=$sub_v;
					$i++;
				}
			}
		}
		foreach($result_arr as $key=>$value){
			foreach($value as $k=>$v){
				$rankdata='';
				foreach($v as $sub_k=>$sub_v){
					if($sub_v['rank']==-1){
						$sub_v['rank']='\'\'';
					}
					$rankdata.=$sub_v['rank'].',';
				}
				$rankdata=trim($rankdata,',');
				$series.='{
					name: \''.$key.'--'.$k.'\',
					marker: {
						symbol: \'square\'
					},
					yAxis: 1,
					data: ['.$rankdata.']
				}'.',';	
			}				
		}
		$dates_arr=explode(',',$dates_stamp);
		
//获取曲线图中成功数量，按国家分组
foreach($_POST['country'] as $key=>$value){
	$success_str='';
	foreach($dates_arr as $k=>$v){
		if($v!=''){
			$query='select * from google_package_total where package_name=\''.$package_name.'\' and task_type=1 and country=\''.$value.'\' and date_name>=\''.date("Y-m-d H:i:s",trim($v,"'")).'\' and date_name<\''.date("Y-m-d H:i:s",(strtotime(date("Y-m-d H:i:s",(trim($v,"'"))).'+1hour'))).'\'';
			$res=mysql_query($query);
			$success=0;
			while($row=mysql_fetch_array($res)){
				$success=$success+$row['success'];
			}
			if($success==0){
				$success='\'\'';
			}
			$success_str=$success_str.$success.',';
		}
	}
	$series.='{
		name: \''.$value.'--成功数\',
		marker: {
			symbol: \'diamond\'
		},
		data: ['.$success_str.']
	}'.',';	
	$success_str=trim($success_str,',');
}
		$series=trim($series,',');
		$query='select * from country_mst';
		$res=mysql_query($query);
		$country='<br/>';
		$i=1;
		if(empty($_POST['country'])){
			while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
				$country_arr[]=$row;
				if(in_array($row['short_name'],$_POST['country'])){
					if($i%9==0){
						$country.='<input checked name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' <br/>';
					}else{
						$country.='<input checked name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' ';
					}
				}else{
					if($i%9==0){
						$country.='<input checked name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' <br/>';
					}else{
						$country.='<input checked name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' ';
					}
				}
				$i++;
			}			
		}else{
			while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
				$country_arr[]=$row;
				if(in_array($row['short_name'],$_POST['country'])){
					if($i%9==0){
						$country.='<input checked name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' <br/>';
					}else{
						$country.='<input checked name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' ';
					}
				}else{
					if($i%9==0){
						$country.='<input name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' <br/>';
					}else{
						$country.='<input name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' ';
					}
				}
				$i++;
			}
		}
		foreach($bangdan_arr as $key=>$val){
			$bangdan_arr_format[]=$val['billboard'];
		}
		$this->assign('country', $country);	
		$this->assign('bangdan_arr_format', $bangdan_arr_format);			
		$this->assign("start", $html->createInput("date", "start", $start));
		$this->assign("end", $html->createInput("date", "end", $end));
		$this->assign('package_name', $html->createInput('text', 'package_name', $package_name));
		$this->assign('game_id', $html->createInput('text', 'game_id', $game_id));
		$this->assign("dates", $dates);
		$this->assign("series", $series);
		$this->assign("result_arr", $result_arr);
		$this->assign("result_arr_format", $result_arr_format);
		$this->main = $this->fetch('Total:appfigures_graph');
		$this->_out();
	}

	function appfigures_graph_S(){		
		if (!hasAsoRole('APPFTS')) error(ERROR_MSG);
		$html = new \Home\Org\Html();
		$this->nav = array(
			'appfigures_graph_S' => array('icon' => 'icon_grid', 'selected' => 1),
		);
		
		$country='';
		foreach($_POST['country'] as $key=>$val){
			$country.='\''.$val.'\',';
		}
		$country=trim($country,',');
		
		$start=$_POST['start'];
		$start=strtotime($start.' 00:00:00');
		$end=$_POST['end'];
		$end=strtotime($end.' 00:00:00');
		$package_name=$_POST['package_name'];
		$game_id=$_POST['game_id'];
		if($game_id!=''){
			$query='select package_name from google_app_config where game_id='.$game_id.' limit 1';
			$res=mysql_query($query);
			$row=mysql_fetch_array($res);
			$package_name=$row['package_name'];
		}
	
		//获取横轴坐标点数
		$dates_arr[]=date('Y-m-d H:i:s',$start);
		$num_hours=(($end-$start)/3600)-1;
		for($i=0;$i<$num_hours;$i++){
			$dates_arr[]=date('Y-m-d H:i:s',strtotime($dates_arr[count($dates_arr)-1].'+60min'));
		}
		// echo '<pre>';
		// print_r($dates_arr);
		// echo '<pre>';
		$dates='';
		foreach($dates_arr as $key=>$value){
			$dates.='\''.date('m/d H:i',strtotime($value)).'\',';
		}
		$dates=trim($dates,',');
	
		//获取曲线图中成功数量，按国家分组
		$series='';
		$i=1;
		foreach($_POST['country'] as $key=>$value){
			$success_str='';
			foreach($dates_arr as $k=>$v){
				if($v!=''){
					$query='select * from google_package_total where package_name=\''.$package_name.'\' and task_type=1 and country=\''.$value.'\' and date_name>=\''.$v.'\' and date_name<\''.date("Y-m-d H:i:s",strtotime($v.'+1hour')).'\'';
					$res=mysql_query($query);
					$success=0;
					while($row=mysql_fetch_array($res)){
						$row['sort_num']=$i;
						$i++;
						if($row['task_type']==1){
							$row['task_type']='真机成功数';
						}elseif($row['task_type']==2){
							$row['task_type']='协议成功数';
						}
						$result_arr_format[]=$row;
						$success=$success+$row['success'];
					}
					if($success==0){
						$success='\'\'';
					}
					$success_str=$success_str.$success.',';
				}
			}
			$success_str=trim($success_str,',');
			$series.='{
				name: \''.$value.'--真机成功数\',
				marker: {
					symbol: \'diamond\'
				},
				data: ['.$success_str.']
			}'.',';	
		}		
		// echo '<pre>';
		// print_r($result_arr_format);exit;
		foreach($_POST['country'] as $key=>$value){
			$success_str='';
			foreach($dates_arr as $k=>$v){
				if($v!=''){
					$query='select * from google_package_total where package_name=\''.$package_name.'\' and task_type=2 and country=\''.$value.'\' and date_name>=\''.$v.'\' and date_name<\''.date("Y-m-d H:i:s",strtotime($v.'+1hour')).'\'';
					$res=mysql_query($query);
					$success=0;
					while($row=mysql_fetch_array($res)){
						$row['sort_num']=$i;
						$i++;
						if($row['task_type']==1){
							$row['task_type']='真机成功数';
						}elseif($row['task_type']==2){
							$row['task_type']='协议成功数';
						}
						$result_arr_format[]=$row;
						$success=$success+$row['success'];
					}
					if($success==0){
						$success='\'\'';
					}
					$success_str=$success_str.$success.',';
				}
			}
			$success_str=trim($success_str,',');
			$series.='{
				name: \''.$value.'--协议成功数\',
				marker: {
					symbol: \'diamond\'
				},
				data: ['.$success_str.']
			}'.',';	
		}
		$series=trim($series,',');
		
		//国家
		$query='select * from country_mst';
		$res=mysql_query($query);
		$country='<br/>';
		$i=1;
		if(empty($_POST['country'])){
			while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
				$country_arr[]=$row;
				if(in_array($row['short_name'],$_POST['country'])){
					if($i%9==0){
						$country.='<input checked name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' <br/>';
					}else{
						$country.='<input checked name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' ';
					}
				}else{
					if($i%9==0){
						$country.='<input checked name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' <br/>';
					}else{
						$country.='<input checked name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' ';
					}
				}
				$i++;
			}			
		}else{
			while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
				$country_arr[]=$row;
				if(in_array($row['short_name'],$_POST['country'])){
					if($i%9==0){
						$country.='<input checked name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' <br/>';
					}else{
						$country.='<input checked name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' ';
					}
				}else{
					if($i%9==0){
						$country.='<input name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' <br/>';
					}else{
						$country.='<input name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' ';
					}
				}
				$i++;
			}
		}
		
		$this->assign('country', $country);			
		$this->assign("start", $html->createInput("date", "start", $start));
		$this->assign("end", $html->createInput("date", "end", $end));
		$this->assign('package_name', $html->createInput('text', 'package_name', $package_name));
		$this->assign('game_id', $html->createInput('text', 'game_id', $game_id));
		$this->assign("dates", $dates);
		$this->assign("series", $series);
		$this->assign("result_arr_format", $result_arr_format);
		$this->main = $this->fetch('Total:appfigures_graph_S');
		$this->_out();
	}

	function appfigures_T(){		
		if (!hasAsoRole('CGST')) error(ERROR_MSG);
		$html = new \Home\Org\Html();
		$this->nav = array(
			'appfigures_T' => array('icon' => 'icon_grid', 'selected' => 1),
		);
		
		$country='';
		foreach($_POST['country'] as $key=>$val){
			$country.='\''.$val.'\',';
		}
		$country=trim($country,',');
		
		$start=$_POST['start'];
		$start=strtotime($start.' 00:00:00');
		$end=$_POST['end'];
		$end=strtotime($end.' 00:00:00');
		$package_name=$_POST['package_name'];
		$game_id=$_POST['game_id'];
		if($game_id!=''){
			$query='select package_name from google_app_config where game_id='.$game_id.' limit 1';
			$res=mysql_query($query);
			$row=mysql_fetch_array($res);
			$package_name=$row['package_name'];
		}
	
		//获取横轴坐标点数
		$dates_arr[]=date('Y-m-d H:i:s',$start);
		$num_hours=(($end-$start)/(3600*24))-1;
		for($i=0;$i<$num_hours;$i++){
			$dates_arr[]=date('Y-m-d H:i:s',strtotime($dates_arr[count($dates_arr)-1].'+1day'));
		}
		// echo '<pre>';
		// print_r($dates_arr);
		// echo '<pre>';
		$dates='';
		foreach($dates_arr as $key=>$value){
			$dates.='\''.date('m/d H:i',strtotime($value)).'\',';
		}
		$dates=trim($dates,',');
	
		//获取曲线图中成功数量，按国家分组
		$series='';
		$i=1;
		foreach($_POST['country'] as $key=>$value){
			$success_str='';
			foreach($dates_arr as $k=>$v){
				if($v!=''){
					$query='select * from google_package_total where package_name=\''.$package_name.'\' and task_type=1 and country=\''.$value.'\' and date_name>=\''.$v.'\' and date_name<\''.date("Y-m-d H:i:s",strtotime($v.'+1day')).'\'';
					$res=mysql_query($query);
					$success=0;
					while($row=mysql_fetch_array($res)){
						$success=$success+$row['success'];		
					}
					$result_arr_format[]=array('sort_num'=>$i,'date'=>date('Y-m-d',strtotime($v)),'package_name'=>$package_name,'country'=>$value,'success'=>$success,'task_type'=>'真机成功数');
					$i++;
				}
			}	
		}
		
		foreach($_POST['country'] as $key=>$value){
			$success_str='';
			foreach($dates_arr as $k=>$v){
				if($v!=''){
					$query='select * from google_package_total where package_name=\''.$package_name.'\' and task_type=2 and country=\''.$value.'\' and date_name>=\''.$v.'\' and date_name<\''.date("Y-m-d H:i:s",strtotime($v.'+1day')).'\'';
					//echo $query.'<br/>';
					$res=mysql_query($query);
					$success=0;
					while($row=mysql_fetch_array($res)){
						$success=$success+$row['success'];	
					}
					$result_arr_format[]=array('sort_num'=>$i,'date'=>date('Y-m-d',strtotime($v)),'package_name'=>$package_name,'country'=>$value,'success'=>$success,'task_type'=>'协议成功数');
					$i++;
				}
			}	
		}
		
		//国家
		$query='select * from country_mst';
		$res=mysql_query($query);
		$country='<br/>';
		$i=1;
		if(empty($_POST['country'])){
			while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
				$country_arr[]=$row;
				if(in_array($row['short_name'],$_POST['country'])){
					if($i%9==0){
						$country.='<input checked name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' <br/>';
					}else{
						$country.='<input checked name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' ';
					}
				}else{
					if($i%9==0){
						$country.='<input checked name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' <br/>';
					}else{
						$country.='<input checked name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' ';
					}
				}
				$i++;
			}			
		}else{
			while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
				$country_arr[]=$row;
				if(in_array($row['short_name'],$_POST['country'])){
					if($i%9==0){
						$country.='<input checked name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' <br/>';
					}else{
						$country.='<input checked name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' ';
					}
				}else{
					if($i%9==0){
						$country.='<input name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' <br/>';
					}else{
						$country.='<input name=\'country[]\' type=\'checkbox\' value=\''.$row['short_name'].'\'/>'.$row['short_name'].' ';
					}
				}
				$i++;
			}
		}
		
		$this->assign('country', $country);			
		$this->assign("start", $html->createInput("date", "start", $start));
		$this->assign("end", $html->createInput("date", "end", $end));
		$this->assign('package_name', $html->createInput('text', 'package_name', $package_name));
		$this->assign('game_id', $html->createInput('text', 'game_id', $game_id));
		$this->assign("dates", $dates);
		$this->assign("series", $series);
		$this->assign("result_arr_format", $result_arr_format);
		$this->main = $this->fetch('Total:appfigures_T');
		$this->_out();
	}
	
}