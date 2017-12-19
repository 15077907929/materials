<?php
//任务管理2
namespace Home\Controller;
use Home\Org\Html;
use Think\controller;
class Task2Controller extends RoleController{
	
    function createOperate($array,$control) {
        $caozuo = '';
        foreach ($array as $v) {
            if ($v['act']=='edit')
                $caozuo.='<a href="'.U('Task/'.$control,array('method'=>'edit','id'=>$v['id'])).'"><span class="icon_edit" title="修改"></span></a> ';
            if ($v['act']=='edit_one')
                $caozuo.='<a href="'.U('Task/'.$control,array('method'=>'edit_one','id'=>$v['id'])).'"><span class="icon_edit" title="修改"></span></a> ';
            if ($v['act']=='del')
                $caozuo.='<a href="'.U('Task/'.$control,array('method'=>'del','id'=>$v['id'])).'" onclick="javascript:return confirm(\'你确定要删除id为'.$v['id'].'的数据吗?\')"><span class="icon_delete" title="删除"></span></a> ';
            if ($v['act']=='del_one')
                $caozuo.='<a href="'.U('Task/'.$control,array('method'=>'del_one','id'=>$v['id'])).'" onclick="javascript:return confirm(\'你确定要删除id为'.$v['id'].'的数据吗?\')"><span class="icon_delete" title="删除"></span></a> ';
            if ($v['act']=='copy')
                $caozuo.='<a href="'.U('Task/'.$control,array('method'=>'copy','id'=>$v['id'])).'"><span class="icon_star" title="复制"></span></a> ';
        }
        return $caozuo;
    }
	
    function creatAjaxRadio4($table, $field, $id, $value, $array = array()){	//无颜色的任务组按钮切换
        if($value == 0) {
            $class0="ajax_self";
            $class1="ajax_self";
        } else if($value ==1) {
            $class0 = "ajax_self";
            $class1 = "ajax_self";
        }
        if (!empty($array)) {
            $arr = array_flip($array);
            $str="<span class=\"{$class0}\" ajax=\"/index.php?m=Home&c=Ajax&a=index&table={$table}&key={$field}&value=0&id={$id}\">" . $arr[0] . "</span> <span class=\"{$class1}\" ajax=\"/index.php?m=Home&c=Ajax&a=index&table={$table}&key={$field}&value=1&id={$id}\">" . $arr[1] . "</span> </td>";
        } else {
            $str = "<span class=\"{$class0}\" ajax=\"/index.php?m=Home&c=Ajax&a=index&table={$table}&key={$field}&value=0&id={$id}\">否</span> <span class=\"{$class1}\" ajax=\"/index.php?m=Home&c=Ajax&a=index&table={$table}&key={$field}&value=1&id={$id}\">是</span> </td>";
        }
        return $str;
    }
	
    function taskManager(){	//评论数大于0
	// echo 'test'.C('TMPL_ENGINE_TYPE','Smarty');
        if(!hasAsoRole('GTASKS,GTASKO,GTASKO1')) error(ERROR_MSG);
        $html=new \Home\Org\Html();
        $method=I('get.method') ? I('get.method') : 'show';
        $db=M('google_task_config');
        $group_db=M('google_task_group');
        $tag_list=getTaskTagList(2);
        $country_table_tmp=M("country_table_mst")->select();
        $country_table_tmp_list=array();
        foreach($country_table_tmp as $val){
            $country_table_tmp_list[$val['table_name']]=$val['table_name'];
        }  
        $comment_group_data=M('account_comment_log')->select();	//获得评论组
        foreach($comment_group_data as $val){
            $comment_group_list[$val['title']]=$val['id'];
        }
        switch($method){
            case 'show':
                $tableName='google_task_group';
                $task_status_list=array(
                    '不限'=>0,
                    '正在执行'=>1,
                    '已完成'=>2,
                    '未执行'=>3,
                );
                $tast_status=$_GET['task_status'];
                $this->assign('task_status',$tast_status);
                unset($_GET['task_status'],$_GET['task_status_sign']);

                $admin_name=getAdminName();
                if($admin_name=="汪涛"){
                    $cp_list=array("耿明游戏"=>"耿明游戏");
                }else{
                    $cp_list=getCpList();
                }
                $searchArr=array(
                    '搜索'=>array(
                        'TAG'=>array('name'=>'tag','type'=>'select','data'=>getTaskTagList()),
                        'CP'=>array('name'=>'cp','type'=>'select','data'=>getCpList()),
                        '游戏'=>array('name'=>'package_name','type'=>'select','data'=>getGameList()),
                        '任务类型'=>array('name'=>'task_type','type'=>'select','data'=>getTaskTypeList()),
                        '任务标题'=>array('name'=>'task_name','type'=>'text'),
                        '包名'=>array('name'=>'package_name','type'=>'text'),
                        '任务状态：'=>array('name'=>'task_status','type'=>'select','data'=> $task_status_list),
                    )
                );
                $searchHtml=TableController::createSearch1($tableName,$searchArr);
                $wh=IphoneController::getWhereConfig($tableName);
                if($tast_status==1){
                    $tmp_task_sql="SELECT `groupid` FROM google_task_config WHERE `start` <= '". date('Y-m-d H:i:s'). "' AND '". date('Y-m-d H:i:s'). "' <= `end` AND `status`=1";
                }elseif($tast_status==2){
                    $tmp_task_sql="SELECT `groupid` FROM google_task_config WHERE '". date('Y-m-d H:i:s'). "' > `end` AND `status`=1";
                }elseif($tast_status==3){
                    $tmp_task_sql="SELECT `groupid` FROM google_task_config WHERE '". date('Y-m-d H:i:s'). "' > `start` AND `status`=1";
                }
                if($tast_status){
                    $tmp_task_list=M()->query($tmp_task_sql);
                    if($tmp_task_list){
                        $temp_group_ids=array();
                        foreach($tmp_task_list as $val){
                            $temp_group_ids[]=intval($val['groupid']);
                        }
                        $temp_where=" id IN(". implode(',',$temp_group_ids). ")";
                        unset($temp_group_ids);
                    }else{
                        $temp_where=" 1=0 ";
                    }
                    unset($tmp_task_list);
                }
                if($admin_name=="汪涛"){
                    if($wh != ''){
                        $wh.= " AND ";
                    }
                    $wh.= "cp='耿明游戏'";
                }
                if($temp_where != ''){
                    if($wh != ''){
                        $wh.= ' AND ';
                    }
                    $wh.= $temp_where;
                }
				if($wh=='')
					$wh.='comment_rate>0';
				else
					$wh.='and comment_rate>0';

                $count=$group_db->where($wh)->count();
                $pagesize=300;
                $parameter=TableController::getGlobalWhere($tableName) ? merge($_GET,array('where'=>TableController::getGlobalWhere($tableName))) : '';
                $page=new \Home\Org\Page($count,$pagesize,$parameter);
                $data=$group_db->where($wh)->order('id desc')->limit($page->firstRow,$page->listRows)->select();
                $pager=$page->show();
                $this->pager='<div class="pager">'. $pager. '</div>';
                $task_type_list=getTaskTypeList(2);
                $get_game_list=getGameList(4);
                $country_language_list=getCountryLanguage(2);
                $now_time=time();
                foreach($data as $key=>&$v){
                    $v['task_type']=$task_type_list[$v['task_type']];
                    $v['tag']=$tag_list[$v['tag']];
                    $old_package_name=$v['package_name'];
                    $v['package_name']=$get_game_list[$v['package_name']];
                    $v['country']=$country_language_list[$v['country']. '#'. $v['language']];
                    if(strtotime($v['group_start']) <= $now_time && strtotime($v['group_end']) >= $now_time){
                        $v['group_start']="<span style='color:red'>". $v['group_start']. "</span>";
                        $v['group_end']="<span style='color:red'>". $v['group_end']. "</span>";
                    }else if(strtotime($v['group_start']) > $now_time){
                        $v['group_start']="<span style='color:blue'>". $v['group_start']. "</span>";
                        $v['group_end']="<span style='color:blue'>". $v['group_end']. "</span>";
                    }else if(strtotime($v['group_end']) < $now_time){
                        $v['group_start']="<span style='color:orange'>". $v['group_start']. "</span>";
                        $v['group_end']="<span style='color:orange'>". $v['group_end']. "</span>";
                    }else{
                        $v['group_start']=$v['group_start'];
                        $v['group_end']=$v['group_end'];
                    }
                    
                    $task_ids=explode(',',$v['ids']);	//TODO 处理子任务id获取任务的下发数 提交数 成功数
                    $get_total_count=M()->query("SELECT SUM(count) AS t FROM google_task_config WHERE id IN({$v['ids']})");
                    $v['total_count']=$get_total_count[0]['t'];
                    foreach($task_ids as $config_task_id){
                        $v['issued_nums'] += getRedis()->get("protocol_issue_task_id_{$config_task_id}");    //下发数
                        $v['success_nums'] += getRedis()->get("app_task_success_nums_id_{$config_task_id}"); //成功数
                        $v['rate_success'] += getRedis()->get("pro_task_comment_success#{$config_task_id}");  //评论成功数
                        $hTaskAll=getRedis()->hGet("google_pro_task@{$config_task_id}");
                        if($hTaskAll){
                            $totalNums=0;
                            foreach($hTaskAll as $resKey=>$count){
                                $totalNums += $count;
                            }
                            $v['submit_nums'] += $totalNums;
                        }
                    }

                    $v['exception']='';
                    if(!empty($v['status_success'])){
                        $status_success_arr=explode("/",$v['status_success']);
                        if($status_success_arr[0]==$status_success_arr[1]){
                            $v['exception']='vpnException2';
                        }
                    }
                    if(!hasAsoRole('GTASKO1')){
                        $v['status']=parseYn($v['status']);
                    }else{
                        $v['status']=$this->creatAjaxRadio4("google_task_group","status",$v['id'],$v['status']);
                    }
                    if(!hasAsoRole('GTASKO')){
                        $v['caozuo']=$this->createOperate(array(
                            array('act'=>'edit','id'=>$v['id']),
                        ),"taskManager");
                        $v['zhankai']="";
                        $v['link']="";
                    }else{
                        $v['caozuo']=$this->createOperate(array(
                            array('act'=>'del','id'=>$v['id']),
                        ),"taskManager");
                        $v['zhankai']="<span class=\"open_group success_log_field\" attr='{$v['id']}'>展开</span>";
                        $v['link']="<a href='https://www.appannie.com/apps/google-play/app/{$old_package_name}/app-ranking' target='_blank'>跳转</a>";
                    }
                }
                $this->assign('data',$data);
                if(!hasAsoRole('GTASKO')){
                    $this->nav=array(
                        '组任务管理'=>array('icon'=>'icon_grid','selected'=>1),
                    );
                }else{
                    $this->nav=array(
                        '组任务管理'=>array('icon'=>'icon_grid','selected'=>1),
                        '添加组任务'=>array('link'=>'/index.php?m=Home&c=Task&a=taskManager&method=add','icon'=>'icon_add'),
                        '批量添加'=>array('link'=>'/index.php?m=Home&c=Task&a=taskManager&method=import','icon'=>'icon_add'),
                    );
                }
                $this->main=$searchHtml. $this->fetch('Task:taskManager');
                $this->_out();
                break;
            case 'add':
                if(!hasAsoRole('GTASKO')) error(ERROR_MSG);
                if($_POST){
                    if(empty($_POST['package_name'])){
                        error('未选择包名');
                    }
                    $count=$_POST['count'];
                    $start=$_POST['start'];
                    $end=$_POST['end'];
                    $keyword=$_POST['keyword'];
                    $is_average=$_POST['is_average'];
                    $comment_start_id=$_POST['comment_start_id'];
                    $arr['cp']=$_POST['cp'];
                    $package_name_arr=explode("##",$_POST['package_name']);
                    $arr['package_name']=$package_name_arr[2];
                    $arr['game_id']=$package_name_arr[0];
                    $arr['task_name']=trim($_POST['task_name']);
                    $arr['task_type']=$_POST['task_type'];
                    $country_language=explode('#',$_POST['country']);
                    $arr['country']=trim($country_language[0]);
                    $arr['language']=trim($country_language[1]);
                    if($_POST['language']){
                        $language_arr=explode('#',$_POST['language']);
                        $arr['language']=trim($language_arr[1]);
                    }

                    $arr['table_name']=trim($_POST['table_name']);
                    $arr['tag']=$_POST['tag'];
                    $arr['score']=trim($_POST['score']);
                    $arr['comment_rate']=trim($_POST['comment_rate']);
                    $arr['star']=trim($_POST['star']);
                    $arr['comment_detail']=trim($_POST['comment_detail']);
                    $arr['comment_type']=intval($_POST['comment_type']);
                    $arr['remark']=trim($_POST['remark']);
                    $arr['add_time']=date("Y-m-d H:i:s");
                    $arr['admin_name']=getAdminName();
                    $arr['operate_type']="新增";
                    $update=$group_db->add($arr);
                    $s=$e=0;
                    if($update){
                        foreach($keyword as $key=>$val){
                            $arr1=$arr;
                            $val=trim($val);
                            $val=str_replace("，",",",$val);
                            $keyword_sub_arr=explode(",",$val);
                            $arr1['count']=$count[$key];
                            $arr1['start']=$start[$key];
                            $arr1['end']=$end[$key];
                            $arr1['groupid']=$update;
                            $arr1['is_average']=$is_average[$key];
                            $arr1['comment_start_id']=$comment_start_id[$key];
                            foreach($keyword_sub_arr as $val1){
                                $val1=trim($val1);
                                $arr1['keyword']=$val1;
                                $update1=$db->add($arr1);
                                if($update1){
                                    $s++;
                                }else{
                                    $e++;
                                }
                            }
                        }
                        $ids_str="";
                        $success_count=0;
                        $total_count=0;
                        $group_count=0;
                        $start="";
                        $end="";
                        $datas2=$db->field("id,status,keyword,count,start,end")->where("groupid=". $update)->order("start")->select();
                        foreach($datas2 as $val){
                            if(strtotime($start) > strtotime($val['start']) || $start==""){
                                $start=$val['start'];
                            }
                            if(strtotime($end) < strtotime($val['end']) || $end==""){
                                $end=$val['end'];
                            }
                            $group_count += $val['count'];
                            $ids_str.= $val['id']. ",";
                            if($val['status']==1){
                                $success_count++;
                            }
                            $total_count++;
                        }
                        $ids_str=trim($ids_str,",");
                        $arr1['ids']=$ids_str;
                        $arr1['group_count']=$group_count;
                        $arr1['group_start']=$start;
                        $arr1['group_end']=$end;
                        $arr1['status_success']=$success_count. "/". $total_count;
                        $group_db->where("id=". $update)->save($arr1);
                        success('添加组成功'. $s. '个,失败'. $e. '个',U('Task/taskManager'));
                    }else{
                        error('添加组失败');
                    }
                }
                $this->assign('cp',$html->createInput('select','cp',null,getCpList()));
                $this->assign('package_name',$html->createInput('selected','package_name',null,getGameList(2)));
                $this->assign('task_name',$html->createInput('text','task_name'));
                $this->assign('task_type',$html->createInput('selected','task_type',null,getTaskTypeList()));
                $this->assign('country',$html->createInput('selected','country',null,getCountryLanguage()));
                $this->assign('language',$html->createInput('selected','language',null,getCountryLanguage()));
                $this->assign('table_name',$html->createInput('select','table_name',null,$country_table_tmp_list));
                $this->assign('tag',$html->createInput('selected','tag',null,getTaskTagList()));
                $this->assign('score',$html->createInput('text','score'));
                $this->assign('remark',$html->createInput('textarea','remark'));
                $this->assign('count',$html->createInput('text','count[]',null,null,"style='width:75px'"));
                $this->assign('start',$html->createInput('text','start[]',date("Y-m-d 16:00:00")));
                $this->assign('end',$html->createInput('text','end[]',date("Y-m-d 15:59:00",time()+86400)));
                $this->assign('is_average',$html->createInput('selected','is_average[]',null,C('YESORNO')));
                $this->assign('keyword',$html->createInput('textarea','keyword[]',null,null,array('cols'=>'40','rows'=>'1')));
                $this->assign('comment_rate',$html->createInput('text','comment_rate'));
                $this->assign('comment_type',$html->createInput('selected','comment_type',null,C('COMMENTTYPE')));
                $this->assign('star',$html->createInput('textarea','star'));
                $this->assign('comment_detail',$html->createInput('textarea','comment_detail'));
                $this->assign('comment_start_id',$html->createInput('select','comment_start_id[]',null,$comment_group_list));

                $this->nav=array(
                    '组任务管理'=>array('link'=>'/index.php?m=Home&c=Task&a=taskManager&method=show','icon'=>'icon_grid'),
                    '添加组任务'=>array('icon'=>'icon_add','selected'=>1),
                    '批量添加'=>array('link'=>'/index.php?m=Home&c=Task&a=taskManager&method=import','icon'=>'icon_add'),
                );
                $this->main=$this->fetch('Task:taskManager_add');
                $this->_out();
                break;
            case 'edit_one':
                if(!hasAsoRole('GTASKO')) error(ERROR_MSG);
                if($_POST){
                    if(empty($_POST['package_name'])){
                        error('未选择包名');
                    }
                    if(empty($_POST['count'])){
                        error('未填写次数');
                    }
                    $arr['cp']=$_POST['cp'];
                    $package_name_arr=explode("##",$_POST['package_name']);
                    $arr['package_name']=$package_name_arr[1];
                    $arr['game_id']=$package_name_arr[0];
                    $arr['task_name']=trim($_POST['task_name']);
                    $arr['task_type']=trim($_POST['task_type']);
                    $country_language=explode('#',$_POST['country']);
                    $arr['country']=trim($country_language[0]);
                    $arr['language']=trim($_POST['language']);
                    $arr['table_name']=trim($_POST['table_name']);
                    $arr['tag']=$_POST['tag'];
                    $arr['remark']=trim($_POST['remark']);
                    $arr['keyword']=trim($_POST['keyword']);
                    $arr['count']=trim($_POST['count']);
                    $arr['start']=trim($_POST['start']);
                    $arr['end']=trim($_POST['end']);
                    $arr['is_average']=$_POST['is_average'];
                    $arr['comment_rate']=$_POST['comment_rate'];
                    $arr['comment_type']=$_POST['comment_type'];
                    $arr['star']=$_POST['star'];
                    $arr['comment_detail']=$_POST['comment_detail'];
                    $arr['comment_start_id']=$_POST['comment_start_id'];
                    $arr['score']=trim($_POST['score']);
                    $arr['update_time']=date("Y-m-d H:i:s");
                    $arr['admin_name']=getAdminName();
                    $arr['operate_type']="修改单条";
                    $id=I('post.id');
                    $update=$db->where("id=$id")->save($arr);
                    if($update){
                        $datas=$db->where("id=". $id)->find();
                        //修改所在组状态
                        $ids_str="";
                        $group_count=0;
                        $datas2=$db->where("groupid=". $datas['groupid'])->select();
                        if(count($datas2)==1){
                            $arr1['group_start']=$datas2[0]['start'];
                            $arr1['group_end']=$datas2[0]['end'];
                            $arr1['package_name']=$datas2[0]['package_name'];
                            $arr1['cp']=$datas2[0]['cp'];
                            $arr1['game_id']=$datas2[0]['game_id'];
                            $arr1['task_name']=$datas2[0]['task_name'];
                            $arr1['task_type']=$datas2[0]['task_type'];
                            $arr1['country']=$datas2[0]['country'];
                            $arr1['language']=$datas2[0]['language'];
                            $arr1['table_name']=$datas2[0]['table_name'];
                            $arr1['tag']=$datas2[0]['tag'];
                            $arr1['remark']=$datas2[0]['remark'];
                            $arr1['keyword']=$datas2[0]['keyword'];
                            $arr1['score']=$datas2[0]['score'];
                            $arr1['admin_name']=$datas2[0]['admin_name'];
                            $arr1['operate_type']=$datas2[0]['operate_type'];
                            $arr1['ids']=$datas2[0]['id'];
                            $arr1['group_count']=$datas2[0]['count'];
                            $group_db->where("id=". $datas['groupid'])->save($arr1);
                        }else{
                            foreach($datas2 as $val){
                                $group_count += $val['count'];
                                $ids_str.= $val['id']. ",";
                            }
                            $ids_str=trim($ids_str,",");
                            $arr1['ids']=$ids_str;
                            $arr1['group_count']=$group_count;
                            $group_db->where("id=". $datas['groupid'])->save($arr1);
                        }
                        success('修改成功',U('Task/taskManager'));
                    }else{
                        error('修改失败');
                    }
                }
                $id=I('id');
                $this->assign('id',$id);
                $data=$db->where("id=$id")->find();
                $this->assign('cp',$html->createInput('select','cp',$data['cp'],getCpList()));
                $this->assign('package_name',$html->createInput('selected','package_name',$data['game_id'].'##'.$data['package_name'],getGameList(3)));
                $this->assign('task_name',$html->createInput('text','task_name',$data['task_name']));
                $this->assign('task_type',$html->createInput('selected','task_type',$data['task_type'],getTaskTypeList()));
                $this->assign('country',$html->createInput('select','country',$data['country'],getOnlyCountryList()));
                $this->assign('language',$html->createInput('selected','language',$data['language'],getCountryLanguage(2)));
                $this->assign('table_name',$html->createInput('select','table_name',$data['table_name'],$country_table_tmp_list));
                $this->assign('tag',$html->createInput('selected','tag',$data['tag'],getTaskTagList()));
                $this->assign('remark',$html->createInput('textarea','remark',$data['remark']));
                $this->assign('keyword',$html->createInput('text','keyword',$data['keyword']));
                $this->assign('count',$html->createInput('text','count',$data['count']));
                $this->assign('start',$html->createInput('datetime1','start',$data['start']));
                $this->assign('end',$html->createInput('datetime1','end',$data['end']));
                $this->assign('score',$html->createInput('text','score',$data['score']));
                $this->assign('is_average',$html->createInput('selected','is_average',$data['is_average'],C('YESORNO')));
                $this->assign('comment_rate',$html->createInput('text','comment_rate',$data['comment_rate']));
                $this->assign('comment_type',$html->createInput('selected','comment_type',$data['comment_type'],C('COMMENTTYPE')));
                $this->assign('star',$html->createInput('textarea','star',$data['star']));
                $this->assign('comment_detail',$html->createInput('textarea','comment_detail',$data['comment_detail']));
                $this->assign('comment_start_id',$html->createInput('select','comment_start_id',$data['comment_start_id'],$comment_group_list));
                $this->nav=array(
                    '组任务管理'=>array('link'=>'/index.php?m=Home&c=Task&a=taskManager&method=show','icon'=>'icon_grid'),
                    '添加组任务'=>array('link'=>'/index.php?m=Home&c=Task&a=taskManager&method=add','icon'=>'icon_add'),
                    '批量添加'=>array('link'=>'/index.php?m=Home&c=Task&a=taskManager&method=import','icon'=>'icon_add'),
                    '修改单条'=>array('icon'=>'icon_edit','selected'=>1),
                );
                $this->main=$this->fetch('Task:taskManager_edit_one');
                $this->_out();
                break;
            case 'del':
                if(!hasAsoRole('GTASKO')) error(ERROR_MSG);
                $id=I('id');
                $data=$db->where("status > 0 and groupid ={$id}")->find();
                if(!empty($data)){
                    error('操作失败,有子任务正在进行中');
                }else{
                    $db->query("delete from google_task_config where groupid={$id}");
                    $group_db->query("delete from google_task_group where id={$id}");
                    success('删除成功',U('Task/taskManager'));
                }
                break;
            case 'del_one':
                if(!hasAsoRole('GTASKO')) error(ERROR_MSG);
                $id=I('id');
                $data=$db->where("id ={$id}")->find();
                if($data['status'] > 0){
                    error('操作失败,该任务正在进行中');
                }else{
                    $db->query("delete from google_task_config where id={$id}");
                    //修改所在组状态
                    $ids_str="";
                    $group_count=0;
                    $success_count=0;
                    $total_count=0;
                    $datas2=$db->field("id,count,status")->where("groupid=". $data['groupid'])->select();
                    if(!empty($datas2)){
                        foreach($datas2 as $val){
                            $group_count += $val['count'];
                            $ids_str.= $val['id']. ",";
                            if($val['status']==1){
                                $success_count++;
                            }
                            $total_count++;
                        }
                        $ids_str=trim($ids_str,",");
                        $arr1['ids']=$ids_str;
                        $arr1['group_count']=$group_count;
                        $arr1['status_success']=$success_count."/".$total_count;
                        if($success_count==$total_count){
                            $arr1['status']=1;
                        }else if($success_count==0){
                            $arr1['status']=0;
                        }
                        $group_db->where("id=". $data['groupid'])->save($arr1);
                    }else{
                        $group_db->query("delete from google_task_group where id={$data['groupid']}");
                    }
                    success('修改成功',U('Task/taskManager'));
                }
                break;
            case 'import':
                if($_FILES){
                    if(isset($_FILES['efile']))
                   {
                        $file=$_FILES['efile'];
                        if($file['error']===0)
                       {
                            import('@.Org.ReadExcel');
                            $reader=new \ReadExcel();
                            $data=$reader->readstr($file['tmp_name'],substr($file['name'],strrpos($file['name'],'.')+1),'A',1,'C');
                            if(!empty($data))
                           {
                                $get_country_language=getCountryLanguage();
                                $yes_or_no=C('YESORNO');
                                $pacakge_data=M("google_app_config")->select();
                                foreach($pacakge_data as $v){
                                    $package_name_list[$v['package_name']]=$v['id']."##".$v['game_name']."##".$v['package_name'];
                                }
                                $s=$e=$gs=$ge=0;
                                foreach($data as $v)
                               {
                                    if(!trim($v['0'])){
                                        continue;
                                    }
                                    $arr['tag']=trim($v['0']);
                                    $arr['cp']=trim($v['1']);
                                    $package_name_arr=explode("##",$package_name_list[$v['2']]);
                                    $arr['package_name']=$package_name_arr[2];
                                    $arr['game_id']=$package_name_arr[0];
                                    $arr['task_name']=trim($v['3']);
                                    $arr['task_type']=trim($v['4']);
                                    $country_language=explode('#',$get_country_language[$v['5']]);
                                    $arr['country']=trim($country_language[0]);
                                    $arr['language']=trim($country_language[1]);
                                    if($v['19']){
                                        $language_arr=explode('#',$get_country_language[$v['19']]);
                                        $arr['language']=$language_arr[1];
                                    }
                                    $arr['table_name']=trim($v['6']);
                                    $arr['score']=trim($v['7']);
                                    $arr['comment_rate']=trim($v['8']);
                                    $arr['comment_type']=trim($v['9']);
                                    $arr['star']=trim($v['10']);
                                    $arr['comment_detail']=trim($v['11']);
                                    $arr['remark']=trim($v['12']);
                                    $arr['add_time']=date("Y-m-d H:i:s");
                                    $arr['admin_name']=getAdminName();
                                    $arr['operate_type']="批量新增";
                                    $arr1=$arr;
                                    $arr['group_count']=trim($v['13']);
                                    $arr['group_start']=date("Y-m-d H:i:s",strtotime(trim($v['14'])));
                                    $arr['group_end']=date("Y-m-d H:i:s",strtotime(trim($v['15'])));
                                    $update=$group_db->add($arr);
                                    if($update){
                                        $arr1['count']=trim($v['13']);
                                        $arr1['start']=date("Y-m-d H:i:s",strtotime(trim($v['14'])));
                                        $arr1['end']=date("Y-m-d H:i:s",strtotime(trim($v['15'])));
                                        $arr1['keyword']=trim($v['16']);
                                        $arr1['is_average']=$yes_or_no[trim($v['17'])];
                                        $arr1['comment_start_id']=$comment_group_list[trim($v['18'])];
                                        $arr1['groupid']=$update;
                                        $update1=$db->add($arr1);
                                        if($update1){
                                            $s++;
                                        }else{
                                            echo $db->getDbError();exit;
                                            $e++;
                                        }
                                        $ids_str="";
                                        $success_count=0;
                                        $total_count=0;
                                        $group_count=0;
                                        $start="";
                                        $end="";
                                        $datas2=$db->field("id,status,keyword,count,start,end")->where("groupid=". $update)->order("start")->select();
                                        foreach($datas2 as $val3){
                                            if(strtotime($start) > strtotime($val3['start']) || $start==""){
                                                $start=$val3['start'];
                                            }
                                            if(strtotime($end) < strtotime($val3['end']) || $end==""){
                                                $end=$val3['end'];
                                            }
                                            $group_count += $val3['count'];
                                            $ids_str.= $val3['id']. ",";
                                            if($val3['status']==1){
                                                $success_count++;
                                            }
                                            $total_count++;
                                        }
                                        $ids_str=trim($ids_str,",");
                                        $arr3['ids']=$ids_str;
                                        $arr3['group_count']=$group_count;
                                        $arr3['group_start']=$start;
                                        $arr3['group_end']=$end;
                                        $arr3['status_success']=$success_count. "/". $total_count;
                                        $group_db->where("id=". $update)->save($arr3);
                                        $gs++;
                                    }else{
                                        $ge++;
                                    }
                                }
                                success("生成任务 成功{$s}条，失败{$e}条",U('Task/taskManager'));
                            }
                            else
                                error('上传文件为空');
                        }
                        else
                            error('文件上传失败，请重新上传');
                    }
                }
                $this->assign('efile',$html->createInput('file','efile'));//文件
                $this->nav=array(
                    '组任务管理'=>array('link'=>'/index.php?m=Home&c=Task&a=taskManager&method=show','icon'=>'icon_grid'),
                    '添加组任务'=>array('link'=>'/index.php?m=Home&c=Task&a=taskManager&method=add','icon'=>'icon_add'),
                    '批量添加'=>array('icon'=>'icon_edit','selected'=>1),
                );
                $this->main=$this->fetch('Task:taskManager_import');
                $this->_out();
                break;
        }
    }
		
	    
    function oneTaskManager(){	//任务管理->单条任务查看	//评论数大于0
        if(!hasAsoRole('OTMS')) error(ERROR_MSG);
        $method=I('get.method') ? I('get.method') : 'show';
        $db=M('google_task_config');
        $tag_list=getTaskTagList(2);
        switch($method){
            case 'show':
                $task_status_list=array(
                    '不限'=>0,
                    '正在执行'=>1,
                    '已完成'=>2,
                    '未执行'=>3,
                );

                $tast_status=$_GET['task_status'];
                $this->assign('task_status',$tast_status);
                unset($_GET['task_status'],$_GET['task_status_sign']);

                $tableName='google_task_config';
                $admin_name=getAdminName();
                if($admin_name=="汪涛"){
                    $cp_list=array("耿明游戏"=>"耿明游戏");
                }else{
                    $cp_list=getCpList();
                }
                $searchArr=array(
                    '搜索'=>array(
                        'TAG'=>array('name'=>'tag','type'=>'select','data'=>getTaskTagList()),
                        'CP'=>array('name'=>'cp','type'=>'select','data'=>getCpList()),
                        '游戏'=>array('name'=>'package_name','type'=>'text'),
                        '账号国家：'=>array('name'=>'country','type'=>'select','data'=>getCountryList()),
                        '任务类型'=>array('name'=>'task_type','type'=>'select','data'=>getTaskTypeList()),
                        '任务标题'=>array('name'=>'task_name','type'=>'text'),
                        '开始时间'=>array('name'=>'end','type'=>'datetime1','sign'=>'egt'),
                        '结束时间'=>array('name'=>'start','type'=>'datetime1','sign'=>'elt'),
                        '任务状态：'=>array('name'=>'task_status','type'=>'select','data'=> $task_status_list),
                    )
                );
                $searchHtml=TableController::createSearch1($tableName,$searchArr);
                $wh=IphoneController::getWhereConfig($tableName);
                if($admin_name=="汪涛"){
                    if($wh != ''){
                        $wh.= " AND ";
                    }
                    $wh.= "cp='耿明游戏'";
                }

                if($tast_status==1){
                    $temp_where=" status=1 AND `start` <= '". date('Y-m-d H:i:s'). "' AND '". date('Y-m-d H:i:s'). "' <= `end`";
                }elseif($tast_status==2){
                    $temp_where=" status=1 AND '". date('Y-m-d H:i:s'). "' > `end`";
                }elseif($tast_status==3){
                    $temp_where=" status=1 AND `start` > '". date('Y-m-d H:i:s'). "'";
                }

                if($temp_where != ''){
                    if($wh != ''){
                        $wh.= ' AND ';
                    }
                    $wh.= $temp_where;
                }
				if($wh=='')
					$wh.='comment_rate>0';
				else
					$wh.='and comment_rate>0';
                $count=$db->where($wh)->count();
                $pagesize=null;
                $parameter=TableController::getGlobalWhere($tableName) ? merge($_GET,array('where'=>TableController::getGlobalWhere($tableName))) : '';
                $page=new \Home\Org\Page($count,$pagesize,$parameter);
                $data=$db->where($wh)->order('id desc')->limit($page->firstRow,$page->listRows)->select();
                $pager=$page->show();
                $this->pager='<div class="pager">'. $pager. '</div>';
                $task_type_list=getTaskTypeList(2);
                $get_game_list=getGameList(1);
                $get_game_list1=array_flip($get_game_list);
                $country_language_list=getCountryLanguage(2);
                $now_time=time();
                $total_data=array();
                foreach($data as $key=>&$v){
                    $v['tag']=$tag_list[$v['tag']];
                    $v['task_type']=$task_type_list[$v['task_type']];
                    $v['package_name']=$get_game_list1[$v['package_name']];
                    if(strtotime($v['start']) <= $now_time && strtotime($v['end']) >= $now_time){
                        $v['start']="<span style='color:red'>". $v['start']. "</span>";
                        $v['end']="<span style='color:red'>". $v['end']. "</span>";
                    }else if(strtotime($v['start']) > $now_time){
                        $v['start']="<span style='color:blue'>". $v['start']. "</span>";
                        $v['end']="<span style='color:blue'>". $v['end']. "</span>";
                    }else if(strtotime($v['end']) < $now_time){
                        $v['start']="<span style='color:orange'>". $v['start']. "</span>";
                        $v['end']="<span style='color:orange'>". $v['end']. "</span>";
                    }else{
                        $v['start']=$v['start'];
                        $v['end']=$v['end'];
                    }
                    $v['country']=$country_language_list[$v['country']. '#'. $v['language']];
                    $v['game_id']=$v['game_id'];
                    $v['is_average']=parseYn($v['is_average']);

                    $get_all=getRedis()->hGet("google_pro_task@{$v['id']}");
                    $total_submit=0;
                    foreach($get_all as $val){
                        $total_submit += $val;
                    }

                    $v['total_submit']=$total_submit;
                    $v['issued']=intval(getRedis()->get("protocol_issue_task_id_{$v['id']}"));
                    $v['success']=intval(getRedis()->get("app_task_success_nums_id_{$v['id']}"));
                    if($v['comment_rate']){
                        $v['rate_success']=getRedis()->get("pro_task_comment_success#{$v['id']}");
                    }

                    if(!hasAsoRole('GTASKO')){
                        $v['caozuo']="";
                        $v['status']=parseYn($v['status']);
                    }else{
                        $v['status']=IphoneController::creatAjaxRadio2("google_task_config","status",$v['id'],$v['status']);
                        if(!hasAsoRole('GTASKO1')){
                            $v['caozuo']=$this->createOperate(array(
                                array('act'=>'edit_one','id'=>$v['id']),
                                array('act'=>'del_one','id'=>$v['id']),
                            ),"taskManager");
                        }else{
                            $v['caozuo']=$this->createOperate(array(
                                array('act'=>'edit_one','id'=>$v['id']),
                                array('act'=>'del_one','id'=>$v['id']),
                            ),"taskManager");
                        }
                    }

                    $total_data['count'] += $v['count'];
                    $total_data['issued_num'] += $v['issued'];
                    $total_data['submit_nums'] += $v['total_submit'];
                    $total_data['success_nums'] += $v['success'];
                    $total_data['submit_rate']=(round($total_data['submit_nums']/$total_data['issued_num'],3)*100)."%";
                    $total_data['success_rate']=(round($total_data['success_nums']/$total_data['issued_num'],3)*100)."%";

                }
                file_put_contents(FileController::$filepath.'FileoneTaskManager-'.getAdminName().'.txt',serialize($data));
                $this->assign('data',$data);
                $this->assign('total',$total_data);
                $this->nav=array(
                    '单条任务查看'=>array('icon'=>'icon_grid','selected'=>1),
                );
                $this->main=$searchHtml. $this->fetch('Task:oneTaskManager');
                $this->_out();
                break;
        }
    }
}