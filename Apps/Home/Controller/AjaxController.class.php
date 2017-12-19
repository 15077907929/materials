<?php
namespace Home\Controller;

use Think\controller;

class AjaxController extends Controller
{

    function __construct()
    {
        parent::__construct();
        header("Content-type:text/html;charset=utf-8");
        $login = R('Login/isLogin', array(false));
        if (!$login)
            $this->ajaxFailed("登录失败！", '用户未登录');

        if (!IS_AJAX)
            $this->ajaxFailed("非ajax请求！", '非ajax请求');
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
        if ($table != "google_task_group") {
            $update = $db->where("id=$id")->save($s);
            if (!$update)
                $this->ajaxFailed("数据库操作错误", $db->getLastSql());
        }

        if ($table == "iphone_mst") {
            $data = $db->where("id=$id")->find();
            getRedis()->set("google_api_iphone_info@" . $data['deviceid'], $data);
            $this->ajaxSuccess($db->getLastSql());
        } else if ($table == "google_task_group") {
            $datas = M('google_task_config')->where("groupid=$id")->select();
            foreach ($datas as $val) {
                $s[$key] = $value;
                $val[$key] = $value;
                M('google_task_config')->where("id=".$val['id'])->save($s);
            }
            //修改所在组状态
            $ids_str = "";
            $success_count = 0;
            $total_count = 0;
            $datas2 = M('google_task_config')->field("id,status")->where("groupid=" . $id)->select();
            foreach ($datas2 as $val) {
                $ids_str .= $val['id'].",";
                if ($val['status'] == 1) {
                    $success_count++;
                }
                $total_count++;
            }
            $ids_str = trim($ids_str,",");
            $arr1['ids'] = $ids_str;
            $arr1['status_success'] = $success_count."/".$total_count;
            if ($success_count == $total_count) {
                $arr1['status'] = 1;
            } else if ($success_count == 0) {
                $arr1['status'] = 0;
            }
            M('google_task_group')->where("id=".$id)->save($arr1);
            $this->ajaxSuccess($db->getLastSql());
        } else if ($table == "google_task_config") {
            $datas = $db->where("id=$id")->find();
            //修改所在组状态
            $ids_str = "";
            $success_count = 0;
            $total_count = 0;
            $datas2 = M('google_task_config')->field("id,status")->where("groupid=" . $datas['groupid'])->select();
            foreach ($datas2 as $val) {
                $ids_str .= $val['id'].",";
                if ($val['status'] == 1) {
                    $success_count++;
                }
                $total_count++;
            }
            $ids_str = trim($ids_str,",");
            $arr1['ids'] = $ids_str;
            $arr1['status_success'] = $success_count."/".$total_count;
            if ($success_count == $total_count) {
                $arr1['status'] = 1;
            } else if ($success_count == 0) {
                $arr1['status'] = 0;
            }
            M('google_task_group')->where("id=".$datas['groupid'])->save($arr1);
            $this->ajaxSuccess($db->getLastSql());
        } else if ($table == "agreement_mst") {
            $data = $db->where("id=$id")->find();
            getRedis()->set("agreement_task_info@" . $data['sid'], $data);
            $this->ajaxSuccess($db->getLastSql());
        } else if ($table == "vpn_mst") {
            $data = $db->where("id=$id")->find();
            getRedis()->set("google_vpn_detail_id@" . $data['id'], $data);
            $files = getUrlData(C('APIURL')."/client/loadvpn");
            $this->ajaxSuccess($db->getLastSql());
        } else if ($table == "proxy_server_mst") {
            $data = $db->where("id=$id")->find();
            //修改iphone的redis
//            if ($data['status'] == 0) {
//                if($data['device_type'] == 1){
//                    $iphone_data = M('iphone_mst')->where("proxy_server_id = {$id}")->select();
//                    $arr1['proxy_server_id'] = 0;
//                    M('iphone_mst')->where("proxy_server_id = {$id}")->save($arr1);
//                    foreach ($iphone_data as $val) {
//                        $val['proxy_server_id'] = 0;
//                        getRedis()->set("google_api_iphone_info@" . $val['deviceid'], $val);
//                    }
//                }else{
//                    $agree_data = M('agreement_mst')->where("proxy_server_id = {$id}")->select();
//                    $arr1['proxy_server_id'] = 0;
//                    M('agreement_mst')->where("proxy_server_id = {$id}")->save($arr1);
//                    foreach ($agree_data as $val) {
//                        $val['proxy_server_id'] = 0;
//                        getRedis()->set("agreement_task_info@" . $val['sid'], $val);
//                    }
//                }
//            } else if ($data['status'] == 1) {
//                $ip_str = "";
//                for ($i=$data['sid_part_start'];$i<=$data['sid_part_end'];$i++) {
//                    $ip_str .= ($ip_str != "") ? ",'".$data['sid_part'].$i."'" : "'".$data['sid_part'].$i."'";
//                }
//
//                if($data['device_type'] == 1){
//                    //TODO 手机设备修改
//                    $iphone_data = M('iphone_mst')->where("sid in ($ip_str)")->select();
//                    $arr1['proxy_server_id'] = $data['id'];
//                    M('iphone_mst')->where("sid in ($ip_str)")->save($arr1);
//                    foreach ($iphone_data as $val) {
//                        $val['proxy_server_id'] = $data['id'];
//                        getRedis()->set("google_api_iphone_info@" . $val['deviceid'], $val);
//                    }
//                }else{
//                    //TODO 协议打号设备修改
//                    $agree_data = M('agreement_mst')->where("sid in ($ip_str)")->select();
//                    $arr1['proxy_server_id'] = $data['id'];
//                    M('agreement_mst')->where("sid in ($ip_str)")->save($arr1);
//                    foreach ($agree_data as $val) {
//                        $val['proxy_server_id'] = $data['id'];
//                        getRedis()->set("agreement_task_info@" . $val['sid'], $val);
//                    }
//                }
//            }

            //TODO 先留着
//            getRedis()->del("proxy_server_info@".$data['sid_part']."@".$data['sid_part_start']."@".$data['sid_part_end']);
//            getRedis()->set("proxy_server_info@" . $data['id'], $data);
//
//            //TODO 将所有启用的代理服务器
//            $result_arr = M('proxy_server_mst')->where('status=1')->select();
//            foreach ($result_arr as $val){
//                $ip_str = '';
//                for ($i=$val['sid_part_start'];$i<=$val['sid_part_end'];$i++) {
//                    $ip_str = $val['sid_part'] . $i;
//                    getRedis()->hSet('proxy_server_ip_list', $ip_str, $val['id']);
//                }
//            }
            $this->ajaxSuccess($db->getLastSql());
        } else {
            $this->ajaxSuccess($db->getLastSql());
        }
    }

    public function editIncome()
    {
        $key = $_GET['key'];
        $keys = explode('|', $key);
        if (count($keys) != 5)
            $this->ajaxFailed("参数错误:" . $key);

        if (!hasRole("editincome"))
            $this->ajaxFailed("没有权限");

        $db = M('umpay_app_order_change', '', C('DB_DATAFEE'));

        $sql = "REPLACE INTO `umpay_app_order_change` (channelId , gameId , addtime , opName , val , auto )  VALUE( '{$keys[0]}',  '{$keys[1]}', '{$keys[2]}', '{$keys[3]}', '{$keys[4]}', 0 )";
        $re = $db->query($sql);

        if ($re !== false)
            $this->ajaxSuccess($db->getLastSql());

        $this->ajaxFailed("操作错误", $sql);
    }

    public function checkIncome()
    {
        $key = $_GET['key'];
        list($opName, $time, $app_id, $val) = explode('|', $key);
        if (!hasRole("editAndDel"))
            $this->ajaxFailed("没有权限");

        $db = M(TABLE_UMPAY_ORDER_BANQU_EDIT, '', C('DB_DATAFEE'));
        $data = array();
        $data[$opName] = $val;
        $re = $db->where("app_id={$app_id} and time='$time'")->data($data)->save();
        if ($re !== false)
            $this->ajaxSuccess($db->getLastSql());

        $this->ajaxFailed("操作错误");
    }

    function channelRate()
    {
        $channelId = I('get.channelId');
        $value = I('get.value');
        $gid = I('get.gid');

        $sql = "REPLACE INTO rechange_rate_channel(`channelId`,`rate`,`gameId`) value( '$channelId', $value,'$gid')";

        $db = M("rechange_rate_channel");
        $re = $db->query($sql);
        if ($re === false) $this->ajaxFailed($sql);
        $this->ajaxSuccess($sql);
    }

    function copyRightRate()
    {
        $channelId = I('get.channelId');
        $gid = I('get.gid');
        $value = I('get.value');

        $sql = "REPLACE INTO rechange_rate_log(`channelId`,`gameId`,`rate`) value( '$channelId','$gid', $value)";
        $db = M("rechange_rate_log");
        $re = $db->query($sql);
        if ($re === false) $this->ajaxFailed($sql);
        $this->ajaxSuccess($sql);
    }

    /**
     * 修改渠道广告位记录
     */
    function editChannelAd()
    {
        $s['cid'] = I('get.cid');
        $s['cidd'] = I('get.cidd');
        $s['addtime'] = str_replace("+", " ", I('get.adddate'));
        $s['value'] = I('get.data');
        $s['gid'] = I('get.gid');
        $db = M(TABLE_AD_COMPANY_ORDER);
        $data = $db->field('id')->where("cid={$s['cid']} and cidd={$s['cidd']} and gid={$s['gid']} and addtime='" . $s['addtime'] . "'")->find();
        //$this->ajaxFailed($db->getLastSql());
        if ($data['id'])
            $db->where("id={$data['id']}")->save($s) ? $this->ajaxSuccess("修改数据成功！") : $this->ajaxFailed("修改失败");
        else
            $db->add($s) ? $this->ajaxSuccess("添加数据成功！") : $this->ajaxFailed("添加失败");

    }

    private function ajaxFailed($client_info, $error_log = '')
    {
        $json['status'] = 0;
        $json['info'] = $client_info;
        $json['data'] = null;

        if ($_REQUEST['table'] != TABLE_SYSTEM_LOG)
            LogController::e($client_info . ':' . $error_log, 2);

        echo json_encode($json);
        exit;
    }

    protected function ajaxSuccess($sql, $value = null, $clientId = null, $clientName = null)
    {
        $json['status'] = 1;
        $json['info'] = '操作成功';
        $json['data'] = null;
        $json['value'] = $value;
        $json['clientId'] = $clientId;
        $json['clientName'] = $clientName;
        if ($_REQUEST['table'] != TABLE_SYSTEM_LOG)
            LogController::i($sql, 2);

        echo json_encode($json);
        exit;
    }
}

?>
