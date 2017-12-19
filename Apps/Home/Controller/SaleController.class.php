<?php
namespace Home\Controller;
use Home\Org\Html;
use Think\controller;

class SaleController extends RoleController{
    static $filepath = '/data/www/googlemanager/Uploads/sales/';
    static $haiwai_group = array(
        'yangshuqin'=>'杨书琴','guoxiaoqian'=>'郭晓茜','mayuan'=>'马媛','shiying'=>'石影','lijuan'=>'李娟'
    );
    static $guonei_group = array(
        'shenxiancai'=>'沈先财'
    );
    function createOperate($array, $control){
        $caozuo = '';
        foreach ($array as $v) {
            if ($v['act'] == 'edit')
                $caozuo .= '<a href="' . U('Sale/' . $control, array('method' => 'edit', 'id' => $v['id'])) . '"><span class="icon_edit" title="修改"></span></a> ';
            if ($v['act'] == 'del')
                $caozuo .= '<a href="' . U('Sale/' . $control, array('method' => 'del', 'id' => $v['id'])) . '" onclick="javascript:return confirm(\'你确定要删除id为' . $v['id'] . '的数据吗?\')"><span class="icon_delete" title="删除"></span></a>';
            if ($v['act'] == 'copy')
                $caozuo .= '<a href="' . U('Sale/' . $control, array('method' => 'copy', 'id' => $v['id'])) . '"><span class="icon_star" title="复制"></span></a> ';
        }
        return $caozuo;
    }

    function creatAjaxRadio2($table, $field, $id, $value, $array = array()){
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

    //财务管理->订单详情
    function asoBillList() {
        if (!hasAsoRole('ABLO,ABLSALL')) error(ERROR_MSG);
        $method = $_GET['method'] ? $_GET['method'] : 'show';
        $db = M('aso_bill_mst', null, C('DB_ASO_DATA'));
        $sale_bill_type_list = array_flip(C('SALEBILLTYPE'));
        $bill_status_list = array_flip(C('BILLSTATUS'));
        $money_type_list = array_flip(C('SALEMONEYTYPE'));
        $collection_data = M('collection_list', null, C('DB_ASO_DATA'))->select();
        foreach ($collection_data as $val) {
            $collection_list1[$val['id']] = $val['name']."<br>".$val['info']."<br>".$val['number'];
            $collection_list[$val['name']] = $val['id'];
        }
        $html = new \Home\Org\Html();
        switch ($method) {
            case 'show':
                $start_time = $_POST['start_time'] ? $_POST['start_time'] : "2017-09-01";
                $end_time = $_POST['end_time'] ? $_POST['end_time'] : date("Y-m-d");
                $id = $_POST['id'];
                $package_name = $_POST['package_name'];

                //获得当前用户权限
                $admin_name = getAdminName();
                $admin_haiwai_array = self::$haiwai_group;
                $admin_guonei_array = self::$guonei_group;
                $join_business_merge = array_merge($admin_haiwai_array,$admin_guonei_array);
                foreach ($join_business_merge as $val) {
                    $join_business_list[$val] = $val;
                }
                if (!hasAsoRole('ABLSALL')) {
                    $join_business_list = array();
                    if (array_key_exists($admin_name,$admin_haiwai_array)) {
                        foreach ($admin_haiwai_array as $val) {
                            $join_business_list[$val] = $val;
                        }
                        $join_business_list[$admin_haiwai_array[$admin_name]] = $admin_haiwai_array[$admin_name];
                        $join_business = $admin_haiwai_array[$admin_name];
                    } else if (array_key_exists($admin_name,$admin_guonei_array)) {
                        foreach ($admin_guonei_array as $val) {
                            $join_business_list[$val] = $val;
                        }
                        $join_business_list[$admin_guonei_array[$admin_name]] = $admin_guonei_array[$admin_name];
                        $join_business = $admin_guonei_array[$admin_name];
                    }
                } else {
                    if (array_key_exists($admin_name,$admin_haiwai_array)) {
                        $join_business_list = array();
                        foreach ($admin_haiwai_array as $val) {
                            $join_business_list[$val] = $val;
                        }
                        $join_business_list[$admin_haiwai_array[$admin_name]] = $admin_haiwai_array[$admin_name];
                        $join_business = $admin_haiwai_array[$admin_name];
                    } else if (array_key_exists($admin_name,$admin_guonei_array)) {
                        $join_business_list = array();
                        foreach ($admin_guonei_array as $val) {
                            $join_business_list[$val] = $val;
                        }
                        $join_business_list[$admin_guonei_array[$admin_name]] = $admin_guonei_array[$admin_name];
                        $join_business = $admin_guonei_array[$admin_name];
                    }
                }
                if (!empty($_POST['join_business'])) {
                    $join_business = $_POST['join_business'];
                }

                $bill_status = $_POST['bill_status'];
                $is_finish = $_POST['is_finish'];
                $where = "time>='{$start_time}' and time <='{$end_time}'";
                if (!empty($id)) {
                    $where .= " and id = '{$id}'";
                }
                if (!empty($package_name)) {
                    $where .= " and package_name = '{$package_name}'";
                }
                if (!empty($join_business)) {
                    $where .= " and join_business = '{$join_business}'";
                }
                if (!empty($bill_status)) {
                    $where .= " and bill_status = '{$bill_status}'";
                }
                if ($_POST['is_finish'] != "") {
                    $where .= " and is_finish = '{$_POST['is_finish']}'";
                }
                $data = $db->where($where)->order("id desc")->select();
                $total = array();
                $money_total = array();
                foreach ($data as &$v) {
                    $v['exception'] = '';
                    if ($v['bill_status'] == 2) {
                        $v['exception'] = 'exceptionC';
                    }
                    if ($v['is_finish'] == 1) {
                        $v['exception'] = 'exceptionB';
                    }
                    $v['id'] = $v['id'];
                    $v['join_business'] = $v['join_business'];
                    $v['game_name'] = $v['game_name'];
                    $v['package_name'] = $v['package_name'];
                    $v['appannieUrl'] = 'https://www.appannie.com/apps/google-play/app/' . $v['package_name'] . '/keywords/?countries=' . $v['country'] . '&device=&start_date=' . date('Y-m-d',strtotime($v['start_date'])-7*86400) . '&end_date=' . date('Y-m-d', time() - 2*86400);
                    $v['time'] = $v['time'];
                    $v['send_time'] = $v['send_time'];
                    $v['send_time_end'] = $v['send_time_end'];
                    $v['sale_bill_type'] = $sale_bill_type_list[$v['sale_bill_type']];
                    $v['bill_detail'] = $v['bill_detail'];
                    $v['cpi_count'] = $v['cpi_count'];
                    $total['cpi_count'] += $v['cpi_count'];
                    $v['bill_amount'] = $v['bill_amount'];
                    $v['bill_true_amount'] = $v['bill_true_amount'];
                    $v['money_type'] = $money_type_list[$v['money_type']];
                    if ($v['bill_status'] == 1 || $v['bill_status'] == 3) {
                        $money_total[$v['money_type']]['bill_true_amount'] += $v['bill_amount'];
                        $money_total[$v['money_type']]['money_type'] = $v['money_type'];
                        if ($v['is_finish'] == 1) {
                            $money_total[$v['money_type']]['finish_true_amount'] += $v['bill_true_amount'];
                        }
                    }
                    $v['bill_status'] = $bill_status_list[$v['bill_status']];
                    $v['collection_id'] = $collection_list1[$v['collection_id']];
                    $v['is_finish_import'] = parseYn($v['isfinish']);
                    $v['is_finish'] = $this->creatAjaxRadio2("aso_bill_mst", "is_finish", $v['id'], $v['is_finish']);
                    $v['file_name'] = "<span class='picture icon_add' attr='{$v["id"]}' style='cursor: pointer'></span>";
                    $v['balance_detail'] = "<span class='history icon_add' attr='{$v["id"]}_{$v["time"]}_{$v["join_business"]}_{$v["game_id"]}' did='{$v["id"]}' dtime='{$v["time"]}' djoin_business='{$v["join_business"]}' style='cursor: pointer'></span>";
                    $v['caozuo'] = $this->createOperate(array(
                        array('act' => 'edit', 'id' => $v['id']),
                        array('act' => 'del', 'id' => $v['id']),
                    ), "asoBillList");
                }
                foreach ($money_total as $key => $val) {
                    $money_total[$key]['finish_true_amout_rate'] = round($val['finish_true_amount']/$val['bill_true_amount'],4) * 100 . "%";
                }
                file_put_contents(FileController::$filepath.'FileasoBillList-'.getAdminName().'.txt', serialize($data));
                $add_button = "<span class=\"add_pop_bill ajax\">添加</span>";
                $this->assign("add_button",$add_button);
                $this->nav = array(
                    '订单详情' => array('icon' => 'icon_grid', 'selected' => 1),
                    '添加' => array('link' => '/index.php?m=Home&c=Sale&a=asoBillList&method=add', 'icon' => 'icon_add'),
                );
                $this->assign("result",$data);
                $this->assign("total",$total);
                $this->assign("money_total",$money_total);

                $this->assign("start_time",$html->createInput("date","start_time",$start_time));
                $this->assign("end_time",$html->createInput("date","end_time",$end_time));
                $this->assign("package_name",$html->createInput("text","package_name",$package_name));
                $this->assign("join_business",$html->createInput("select","join_business",$join_business,$join_business_list));
                $this->assign("bill_status",$html->createInput("select","bill_status",$bill_status,C('BILLSTATUS')));
                $this->assign("is_finish",$html->createInput("select","is_finish",$is_finish,C('YESORNO')));
                $this->assign("id",$html->createInput("text","id",$id));

                $balance_add = "<div>";
                $balance_add .= "<span>".$html->createInput("text","balance_time[]",date('Y-m-d'))."</span>";
                $balance_add .= "<span>".$html->createInput("selected","balance_type[]",'1',C('ASOBALANCETYPE'))."</span>";
                $balance_add .= "<span>".$html->createInput("text","balance_money[]")."</span>";
                $balance_add .= "<span>".$html->createInput("selected","money_type[]",'1',C('SALEMONEYTYPE'))."</span>";
                $balance_add .= "<span>".$html->createInput("selected","balance_paytype[]",'1',C('ASOPAYTYPE'))."</span>";
                $balance_add .= "<span>".$html->createInput("textarea","balance_paydetail[]",null,null,"rows='2' cols='27'")."</span>";
                $balance_add .= "<span class=\"balance_one_del icon_delete\" style=\"cursor: pointer\"></span>";
                $balance_add .= "</div>";
                $this->assign("balance_add",$balance_add);
                $this->assign("url",U('Sale/asoBillList',array("method"=>"show")));
                $this->main = $this->fetch('Sale:asoBillList');
                $this->_out();
                break;
            case 'add':
                if ($_POST) {
                    if (empty($_POST['package_name'])) {
                        error('未选择包名');
                    }
                    $country_language = explode('#', $_POST['country']);
                    $arr['country'] = trim($country_language[0]);
                    $arr['language'] = trim($country_language[1]);
                    $package_name_arr = explode("##",$_POST['package_name']);
                    $arr['game_id'] = $package_name_arr[0];
                    $arr['game_name'] = $package_name_arr[1];
                    $arr['package_name'] = $package_name_arr[2];
                    $arr['join_business'] = trim($_POST['join_business']);//对接商务
                    $arr['time'] = $_POST['time'];//下单时间
                    $arr['send_time'] = $_POST['send_time'];//投放时间开始
                    $arr['send_time_end'] = $_POST['send_time_end'];//投放时间结束
                    $arr['sale_bill_type'] = $_POST['sale_bill_type'];//订单类型
                    $arr['bill_detail'] = $_POST['bill_detail'];//任务描述
                    $arr['cpi_count'] = $_POST['cpi_count'];//CPI值
                    $arr['bill_amount'] = $_POST['bill_amount'];//订单总额
                    $arr['money_type'] = $_POST['money_type'];//货币种类
                    $arr['bill_product'] = $_POST['bill_product'];//订单预付款
                    $arr['bill_true_amount'] = $_POST['bill_true_amount'];//订单实际收款
                    $arr['bill_status'] = $_POST['bill_status'];//订单完成情况
                    $arr['is_finish'] = $_POST['is_finish'];//是否结清
                    $arr['collection_id'] = $_POST['collection_id'];//是否结清
                    $arr['add_time'] = date("Y-m-d H:i:s");//入库时间
                    if ($_FILES) {
                        //上传文件
                        if (isset($_FILES['efile1'])) {
                            $file1 = $_FILES['efile1'];
                            $new_name = date("YmdHis")."_".$file1['name'];
                            if ($file1['error'] === 0) {
                                $path = self::$filepath;
                                move_uploaded_file($file1['tmp_name'], $path . $new_name);
                                $arr['file_name1'] = $new_name;;
                            }
                        }
                        if (isset($_FILES['efile2'])) {
                            $file2 = $_FILES['efile2'];
                            $new_name = date("YmdHis")."_".$file2['name'];
                            if ($file2['error'] === 0) {
                                $path = self::$filepath;
                                move_uploaded_file($file2['tmp_name'], $path . $new_name);
                                $arr['file_name2'] = $new_name;;
                            }
                        }
                        if (isset($_FILES['efile3'])) {
                            $file3 = $_FILES['efile3'];
                            $new_name = date("YmdHis")."_".$file3['name'];
                            if ($file3['error'] === 0) {
                                $path = self::$filepath;
                                move_uploaded_file($file3['tmp_name'], $path . $new_name);
                                $arr['file_name3'] = $new_name;;
                            }
                        }
                    }
                    $update = $db->add($arr);
                    if ($update) {
                        success('添加成功', U('Sale/asoBillList'));
                    } else {
                        error('添加失败');
                    }
                }
                $this->assign('join_business', $html->createInput('text', 'join_business'));
                $this->assign('country', $html->createInput('selected', 'country', null, getCountryLanguage()));
                $this->assign('cp', $html->createInput('select', 'cp', null, getCpList()));
                $this->assign('package_name', $html->createInput('select', 'package_name', null, getGameList(2)));
                $this->assign('time', $html->createInput('date', 'time',date("Y-m-d")));
                $this->assign('send_time', $html->createInput('date', 'send_time',date("Y-m-d",time()+86400)));
                $this->assign('send_time_end', $html->createInput('date', 'send_time_end',date("Y-m-d",time()+86400*7)));
                $this->assign('sale_bill_type', $html->createInput('select', 'sale_bill_type','1',C('SALEBILLTYPE')));
                $this->assign('bill_detail', $html->createInput('textarea', 'bill_detail'));
                $this->assign('cpi_count', $html->createInput('text', 'cpi_count'));
                $this->assign('bill_amount', $html->createInput('text', 'bill_amount'));
                $this->assign('money_type', $html->createInput('select', 'money_type','1',C('SALEMONEYTYPE')));
                $this->assign('bill_product', $html->createInput('text', 'bill_product'));
                $this->assign('bill_true_amount', $html->createInput('text', 'bill_true_amount'));
                $this->assign('bill_status', $html->createInput('radio', 'bill_status', 1, C('BILLSTATUS')));
                $this->assign('is_finish', $html->createInput('radio', 'is_finish', 0, C('YESORNO')));
                $this->assign('collection_id', $html->createInput('select', 'collection_id',null,$collection_list));
                $this->assign('efile1', $html->createInput('file', 'efile1'));//文件
                $this->assign('efile2', $html->createInput('file', 'efile2'));//文件
                $this->assign('efile3', $html->createInput('file', 'efile3'));//文件
                $this->nav = array(
                    '订单详情' => array('link' => '/index.php?m=Home&c=Sale&a=asoBillList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('Sale:asoBillList_add');
                $this->_out();
                break;
            case 'edit':
                if ($_POST) {
                    if (empty($_POST['package_name'])) {
                        error('未选择包名');
                    }
                    $id = I('post.id');
                    $country_language = explode('#', $_POST['country']);
                    $arr['country'] = trim($country_language[0]);
                    $arr['language'] = trim($country_language[1]);
                    $package_name_arr = explode("##",$_POST['package_name']);
                    $arr['game_id'] = $package_name_arr[0];
                    $arr['game_name'] = $package_name_arr[1];
                    $arr['package_name'] = $package_name_arr[2];
                    $arr['join_business'] = trim($_POST['join_business']);//对接商务
                    $arr['time'] = $_POST['time'];//下单时间
                    $arr['send_time'] = $_POST['send_time'];//投放时间开始
                    $arr['send_time_end'] = $_POST['send_time_end'];//投放时间结束
                    $arr['sale_bill_type'] = $_POST['sale_bill_type'];//订单类型
                    $arr['bill_detail'] = $_POST['bill_detail'];//任务描述
                    $arr['cpi_count'] = $_POST['cpi_count'];//cpi值
                    $arr['bill_amount'] = $_POST['bill_amount'];//订单总额
                    $arr['money_type'] = $_POST['money_type'];//货币种类
                    $arr['bill_product'] = $_POST['bill_product'];//订单预付款
                    $arr['bill_true_amount'] = $_POST['bill_true_amount'];//订单实际收款
                    $arr['bill_status'] = $_POST['bill_status'];//订单完成情况
                    $arr['is_finish'] = $_POST['is_finish'];//是否结清
                    $arr['collection_id'] = $_POST['collection_id'];//是否结清
                    $arr['update_time'] = date("Y-m-d H:i:s");//是否结清
                    if ($_FILES) {
                        //上传文件
                        if (isset($_FILES['efile1'])) {
                            $file1 = $_FILES['efile1'];
                            $new_name = date("YmdHis")."_".$file1['name'];
                            if ($file1['error'] === 0) {
                                $path = self::$filepath;
                                move_uploaded_file($file1['tmp_name'], $path . $new_name);
                                $arr['file_name1'] = $new_name;;
                            }
                        }
                        if (isset($_FILES['efile2'])) {
                            $file2 = $_FILES['efile2'];
                            $new_name = date("YmdHis")."_".$file2['name'];
                            if ($file2['error'] === 0) {
                                $path = self::$filepath;
                                move_uploaded_file($file2['tmp_name'], $path . $new_name);
                                $arr['file_name2'] = $new_name;;
                            }
                        }
                        if (isset($_FILES['efile3'])) {
                            $file3 = $_FILES['efile3'];
                            $new_name = date("YmdHis")."_".$file3['name'];
                            if ($file3['error'] === 0) {
                                $path = self::$filepath;
                                move_uploaded_file($file3['tmp_name'], $path . $new_name);
                                $arr['file_name3'] = $new_name;;
                            }
                        }
                    }
                    $update = $db->where("id=$id")->save($arr);
                    if ($update) {
                        success('添加成功', U('Sale/asoBillList'));
                    } else {
                        error('添加失败');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $package_name_old = $data['game_id']."##".$data['game_name']."##".$data['package_name'];
                $this->assign('id', $id);
                $this->assign('join_business', $html->createInput('text', 'join_business',$data['join_business']));
                $this->assign('cp', $html->createInput('select', 'cp',null, getCpList()));
                $this->assign('country', $html->createInput('selected', 'country', $data['country'].'#'.$data['language'], getCountryLanguage()));
                $this->assign('package_name', $html->createInput('select', 'package_name',$package_name_old, getGameList(2)));
                $this->assign('time', $html->createInput('date', 'time',$data['time']));
                $this->assign('send_time', $html->createInput('date', 'send_time',$data['send_time']));
                $this->assign('send_time_end', $html->createInput('date', 'send_time_end',$data['send_time_end']));
                $this->assign('sale_bill_type', $html->createInput('select', 'sale_bill_type',$data['sale_bill_type'],C('SALEBILLTYPE')));
                $this->assign('bill_detail', $html->createInput('textarea', 'bill_detail',$data['bill_detail']));
                $this->assign('cpi_count', $html->createInput('text', 'cpi_count',$data['cpi_count']));
                $this->assign('bill_amount', $html->createInput('text', 'bill_amount',$data['bill_amount']));
                $this->assign('money_type', $html->createInput('select', 'money_type',$data['money_type'],C('SALEMONEYTYPE')));
                $this->assign('bill_product', $html->createInput('text', 'bill_product',$data['bill_product']));
                $this->assign('bill_true_amount', $html->createInput('text', 'bill_true_amount',$data['bill_true_amount']));
                $this->assign('bill_status', $html->createInput('radio', 'bill_status',$data['bill_status'], C('BILLSTATUS')));
                $this->assign('is_finish', $html->createInput('radio', 'is_finish',$data['is_finish'], C('YESORNO')));
                $this->assign('collection_id', $html->createInput('select', 'collection_id',$data['collection_id'],$collection_list));
                $this->assign('efile1', $html->createInput('file', 'efile1'));//文件
                $this->assign('efile2', $html->createInput('file', 'efile2'));//文件
                $this->assign('efile3', $html->createInput('file', 'efile3'));//文件
                $this->assign('file_name1', "<img src='/Uploads/sales/{$data['file_name1']}'>");
                $this->assign('file_name2', "<img src='/Uploads/sales/{$data['file_name2']}'>");
                $this->assign('file_name3', "<img src='/Uploads/sales/{$data['file_name3']}'>");
                $this->nav = array(
                    '订单详情' => array('link' => '/index.php?m=Home&c=Sale&a=asoBillList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Sale&a=asoBillList&method=add','icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Sale:asoBillList_edit');
                $this->_out();
                break;
            case 'del':
                if (!hasAsoRole('ABLUD,ABLSO')) error(ERROR_MSG);
                $id = I('id');
                $update = $db->where("id=$id")->delete();
                if ($update) {
                    M('aso_balance_detail_mst', null, C('DB_ASO_DATA'))->where("bill_id=$id")->delete();
                    M('aso_balance_keyword_mst', null, C('DB_ASO_DATA'))->where("bill_id=$id")->delete();
                    success('删除成功', U('Sale/asoBillList'));
                } else {
                    error('删除失败');
                }
                break;
            case 'picture':
                if (!hasAsoRole('ABLUD,ABLSO')) {
                    echo "没有权限";exit;
                }
                $id = I('datas');
                $data = $db->where("id=$id")->find();
                if (!$data['file_name1'] && !$data['file_name2'] && !$data['file_name3']) {
                    $str = "没有数据";
                } else {
                    $str = "";
                    $str .= "<img src='/Uploads/sales/{$data['file_name1']}'><br>";
                    $str .= "<img src='/Uploads/sales/{$data['file_name2']}'><br>";
                    $str .= "<img src='/Uploads/sales/{$data['file_name3']}'><br>";
                }
                echo $str;exit;
                break;
        }
    }

    function getBalanceDetailList() {
        if (!hasAsoRole('ABLO')) {
            echo "没有权限";exit;
        }
        $datas = I("datas");
        $type = I("type");
        $datas_arr = explode("_",$datas);
        if ($type == "show") {
            $db = M('aso_balance_detail_mst', null, C('DB_ASO_DATA'));
            $html = new \Home\Org\Html();
            $data = $db->where("bill_id={$datas_arr[0]} and game_id='{$datas_arr[3]}'")->select();
            $str = "<table><tr><th>时间</th><th>类型</th><th>金额</th><th>货币种类</th><th>收支类型</th><th>收支详情</th><th>操作</th></tr>";
            foreach ($data as $val) {
                $str .= "<tr>";
                $str .= "<td>".$html->createInput("text","balance_time",$val['time'],null,"style=\"width:75px\"")."</td>";
                $str .= "<td>".$html->createInput("selected","balance_type",$val['type'],C('ASOBALANCETYPE'))."</td>";
                $str .= "<td>".$html->createInput("text","balance_money",$val['money'],null,"style=\"width:100px\"")."</td>";
                $str .= "<td>".$html->createInput("selected","money_type",$val['money_type'],C('SALEMONEYTYPE'))."</td>";
                $str .= "<td>".$html->createInput("selected","balance_paytype",$val['pay_type'],C('ASOPAYTYPE'))."</td>";
                $str .= "<td>".$html->createInput("textarea","balance_paydetail",$val['pay_detail'])."</td>";
                $str .= "<td><span class='balance_edit icon_edit' attr=\"{$val['id']}\" style='cursor: pointer'></span><span class='balance_del icon_delete' attr=\"{$val['id']}\" style='cursor: pointer'></span></td>";
            }
            $str .= "</table>";
            echo $str;exit;
        }
    }

    //批量修改aso_balance_detail
    function BalanceDetailEdit()
    {
        if (!hasAsoRole('ABLO')) {
            echo "没有权限";exit;
        }
        $type = I('get.type');
        if ($type == 'add') {
            $balance_time = I('post.balance_time');
            $balance_type = I('post.balance_type');
            $balance_money = I('post.balance_money');
            $money_type = I('post.money_type');
            $balance_paytype = I('post.balance_paytype');
            $balance_paydetail = I('post.balance_paydetail');
            $datas = I('post.datas');
            $datas_arr = explode("_",$datas);
            $balance_time_arr = explode(",",$balance_time);
            $balance_type_arr = explode(",",$balance_type);
            $balance_money_arr = explode(",",$balance_money);
            $money_type_arr = explode(",",$money_type);
            $balance_paytype_arr = explode(",",$balance_paytype);
            $balance_paydetail_arr = explode(",",$balance_paydetail);
            $bill_data = M('aso_bill_mst', null, C('DB_ASO_DATA'))->where("id=".$datas_arr[0])->find();
            $db = M('aso_balance_detail_mst', null, C('DB_ASO_DATA'));
            $arr['bill_time'] = $bill_data['time'];
            $arr['bill_id'] = $bill_data['id'];
            $arr['game_id'] = $bill_data['game_id'];
            $arr['game_name'] = $bill_data['game_name'];
            $arr['package_name'] = $bill_data['package_name'];
            $arr['join_business'] = $bill_data['join_business'];
            $arr['add_time'] = date("Y-m-d H:i:s");
            $s=$t=0;
            foreach ($balance_time_arr as $key => $val) {
                $arr['time'] = date("Y-m-d H:i:s",strtotime($val));
                $arr['type'] = $balance_type_arr[$key];
                $arr['money'] = $balance_money_arr[$key];
                $arr['money_type'] = $money_type_arr[$key];
                $arr['pay_type'] = $balance_paytype_arr[$key];
                $arr['pay_detail'] = $balance_paydetail_arr[$key];
                $update = $db->add($arr);
                if ($update) {
                    $s++;
                } else {
                    $t++;
                }
            }
            echo "添加成功{$s}条，失败{$t}条";exit;
        } else if ($type == 'edit') {
            $balance_time = I('post.balance_time');
            $balance_type = I('post.balance_type');
            $balance_money = I('post.balance_money');
            $money_type = I('post.money_type');
            $balance_payment = I('post.balance_payment');
            $balance_paytype = I('post.balance_paytype');
            $balance_paydetail = I('post.balance_paydetail');
            $datas = I('post.datas');
            $datas_arr = explode("_",$datas);
            $bill_data = M('aso_bill_mst', null, C('DB_ASO_DATA'))->where("id=".$datas_arr[0])->find();
            $db = M('aso_balance_detail_mst', null, C('DB_ASO_DATA'));
            $balance_id = I('post.balance_id');
            $arr['bill_time'] = $bill_data['time'];
            $arr['bill_id'] = $bill_data['id'];
            $arr['game_id'] = $bill_data['game_id'];
            $arr['game_name'] = $bill_data['game_name'];
            $arr['package_name'] = $bill_data['package_name'];
            $arr['join_business'] = $bill_data['join_business'];
            $arr['time'] = $balance_time;
            $arr['type'] = $balance_type;
            $arr['money'] = $balance_money;
            $arr['money_type'] = $money_type;
            $arr['payment'] = $balance_payment;
            $arr['pay_type'] = $balance_paytype;
            $arr['pay_detail'] = $balance_paydetail;
            $update = $db->where("id=".$balance_id)->save($arr);
            if ($update) {
                echo "修改成功";exit;
            } else {
                echo "修改失败";exit;
            }
        } else if ($type == 'del') {
            $balance_id = I('post.balance_id');
            $update = M('aso_balance_detail_mst', null, C('DB_ASO_DATA'))->where("id=".$balance_id)->delete();
            if ($update) {
                echo "删除成功";exit;
            } else {
                echo "删除失败";exit;
            }
        }
    }

    //销售管理->订单打款详情
    function balanceDetailList() {
        if (!hasAsoRole('BDLO,BDLSALL')) error(ERROR_MSG);
        $db = M('aso_balance_detail_mst', null, C('DB_ASO_DATA'));
        $start_time = I('start_time') ? I('start_time') : date("Y-m-d",time()-86400*7);
        $end_time = I('end_time') ? I('end_time') : date("Y-m-d");

        //获得当前用户权限
        $admin_name = getAdminName();
        $admin_haiwai_array = self::$haiwai_group;
        $admin_guonei_array = self::$guonei_group;
        $join_business_merge = array_merge($admin_haiwai_array,$admin_guonei_array);
        foreach ($join_business_merge as $val) {
            $join_business_list[$val] = $val;
        }
        if (!hasAsoRole('ABLSALL')) {
            $join_business_list = array();
            if (array_key_exists($admin_name,$admin_haiwai_array)) {
                foreach ($admin_haiwai_array as $val) {
                    $join_business_list[$val] = $val;
                }
                $join_business_list[$admin_haiwai_array[$admin_name]] = $admin_haiwai_array[$admin_name];
                $join_business = $admin_haiwai_array[$admin_name];
            } else if (array_key_exists($admin_name,$admin_guonei_array)) {
                foreach ($admin_guonei_array as $val) {
                    $join_business_list[$val] = $val;
                }
                $join_business_list[$admin_guonei_array[$admin_name]] = $admin_guonei_array[$admin_name];
                $join_business = $admin_guonei_array[$admin_name];
            }
        } else {
            if (array_key_exists($admin_name,$admin_haiwai_array)) {
                $join_business_list = array();
                foreach ($admin_haiwai_array as $val) {
                    $join_business_list[$val] = $val;
                }
                $join_business_list[$admin_haiwai_array[$admin_name]] = $admin_haiwai_array[$admin_name];
                $join_business = $admin_haiwai_array[$admin_name];
            } else if (array_key_exists($admin_name,$admin_guonei_array)) {
                $join_business_list = array();
                foreach ($admin_guonei_array as $val) {
                    $join_business_list[$val] = $val;
                }
                $join_business_list[$admin_guonei_array[$admin_name]] = $admin_guonei_array[$admin_name];
                $join_business = $admin_guonei_array[$admin_name];
            }
        }
        if ($_POST['join_business']) {
            $join_business = $_POST['join_business'];
        }

        $where = "time>='{$start_time}' and time <='{$end_time}'";
        if ($join_business != "") {
            $where .= " and join_business = '{$join_business}'";
        }
        $data = $db->where($where)->order("id asc")->select();
        $balance_type_list = array_flip(C('ASOBALANCETYPE'));
        $money_type_list = array_flip(C('SALEMONEYTYPE'));
        $pay_type_list = array_flip(C('ASOPAYTYPE'));
        foreach ($data as &$v) {
            $v['type'] = $balance_type_list[$v['type']];
            $v['money_type'] = $money_type_list[$v['money_type']];
            $v['pay_type'] = $pay_type_list[$v['pay_type']];
        }
        $html = new \Home\Org\Html();
        $this->assign("result",$data);
        $this->assign("join_business",$html->createInput("select","join_business",$join_business,$join_business_list));
        $this->assign("start_time",$html->createInput("date","start_time",$start_time));
        $this->assign("end_time",$html->createInput("date","end_time",$end_time));
        $this->assign("url",U('Sale/balanceDetailList'));
        $con['nav'] = TableController::createNav(null , array("订单打款详情"=>array() ) );
        $con['main'] = $this->fetch('Sale/balanceDetailList');
        $this->assign("con" , $con);
        $this->display('Public:main');
    }

    //销售管理->收款信息配置
    function collectionList() {
        if (!hasAsoRole('CLO')) error(ERROR_MSG);
        $db = M('collection_list', null, C('DB_ASO_DATA'));
        $method = $_GET['method'] ? $_GET['method'] : 'show';
        $html = new \Home\Org\Html();
        switch ($method) {
            case 'show':
                $where = "";
                $data = $db->where($where)->order("id desc")->select();
                foreach ($data as &$v) {
                    $v['caozuo'] = $this->createOperate(array(
                        array('act' => 'edit', 'id' => $v['id']),
                        array('act' => 'del', 'id' => $v['id']),
                    ), "collectionList");
                }
                $this->assign("result",$data);
                $this->assign("url",U('Sale/collectionList'));
                $this->nav = array(
                    '收款信息配置' => array('icon' => 'icon_grid', 'selected' => 1),
                    '添加' => array('link' => '/index.php?m=Home&c=Sale&a=collectionList&method=add', 'icon' => 'icon_add'),
                );
                $this->main = $this->fetch('Sale:collectionList');
                $this->_out();
                break;
            case 'add':
                if ($_POST) {
                    if (empty($_POST['name']) || empty($_POST['info']) || empty($_POST['number'])) {
                        error('信息不能为空');
                    }
                    $arr['name'] = trim($_POST['name']);//姓名
                    $arr['info'] = trim($_POST['info']);//相关信息
                    $arr['number'] = trim($_POST['number']);//卡号
                    $arr['add_time'] = date("Y-m-d H:i:s");//入库时间
                    $update = $db->add($arr);
                    if ($update) {
                        success('添加成功', U('Sale/collectionList'));
                    } else {
                        error('添加失败');
                    }
                }
                $this->assign('name', $html->createInput('text', 'name'));
                $this->assign('info', $html->createInput('textarea', 'info'));
                $this->assign('number', $html->createInput('textarea', 'number'));
                $this->nav = array(
                    '收款信息配置' => array('link' => '/index.php?m=Home&c=Sale&a=collectionList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('icon' => 'icon_add', 'selected' => 1),
                );
                $this->main = $this->fetch('Sale:collectionList_add');
                $this->_out();
                break;
            case 'edit':
                if ($_POST) {
                    if (empty($_POST['name']) || empty($_POST['info']) || empty($_POST['number'])) {
                        error('信息不能为空');
                    }
                    $id = I('post.id');
                    $arr['name'] = trim($_POST['name']);//姓名
                    $arr['info'] = trim($_POST['info']);//相关信息
                    $arr['number'] = trim($_POST['number']);//卡号
                    $arr['update_time'] = date("Y-m-d H:i:s");//修改时间
                    $update = $db->where("id=$id")->save($arr);
                    if ($update) {
                        success('添加成功', U('Sale/collectionList'));
                    } else {
                        error('添加失败');
                    }
                }
                $id = I('id');
                $data = $db->where("id=$id")->find();
                $this->assign('id', $id);
                $this->assign('name', $html->createInput('text', 'name',$data['name']));
                $this->assign('info', $html->createInput('textarea', 'info',$data['info']));
                $this->assign('number', $html->createInput('textarea', 'number',$data['number']));
                $this->nav = array(
                    '收款信息配置' => array('link' => '/index.php?m=Home&c=Sale&a=collectionList&method=show', 'icon' => 'icon_grid'),
                    '添加' => array('link' => '/index.php?m=Home&c=Sale&a=collectionList&method=add','icon' => 'icon_add'),
                    '修改' => array('icon' => 'icon_edit', 'selected' => 1),
                );
                $this->main = $this->fetch('Sale:collectionList_edit');
                $this->_out();
                break;
            case 'del':
                $id = I('id');
                $update = $db->where("id=$id")->delete();
                if ($update) {
                    success('删除成功', U('Sale/collectionList'));
                } else {
                    error('删除失败');
                }
                break;
        }
    }
}