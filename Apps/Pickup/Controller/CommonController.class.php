<?php
namespace Pickup\Controller;

use Home\Org\Html;
use Think\Controller;

class CommonController extends BaseController
{
    function setAllField()
    {
        $db = M(I('table'));
        $data = array(I('field') => I('value'));
        //dump($data);
        $count = $db->where("id>0")->save($data);
        if ($count)
            success("共修改数据:{$count}条。<br />{$db->getLastSql()}");
        error("修改数据失败。<br />{$db->getLastSql()}");
    }


    /**
     * 加密密码，如果长度等于32，直接返回，否则MD5
     */
    function passwd($pwd)
    {
        if (strlen($pwd) === 32)
            return $pwd;
        return md5($pwd);
    }

    /**
     * 获取ad_company表 和ad_company_d表的二级下拉表单
     */
    function getAdCompanySelect($selectedChild ){
        $parent = getDataFromDb(TABLE_AD_COMPANY , 'name' , 'id');
        $db  = M(TABLE_AD_COMPANY_D);
        $child = $db->select();
        return $this->getRelateSelect('cid' , 'cidd' , $parent , $child , "name" , "id" , "cid" , $selectedChild );
    }
    function getRelateSelect($parent_name , $child_name , $parentData , $childData , $childKeyField , $childValueField , $childRelateField  , $childSelected)
    {
        if($childSelected)
        {
            foreach($childData as $k=>$v)
            {
                if( $v[$childValueField] == $childSelected )
                {
                    $parentSelect = $v[$childRelateField];
                    break;
                }
            }
        }

        $childSelectedData = array();
        foreach($childData as $k=>$v)
        {
            if($parentSelect && $v[$childRelateField] == $parentSelect)
            {
                $childSelectedData[$v[$childKeyField]] = $v[$childValueField];
            }
            $childAllData[$k][] = $v[$childValueField];
            $childAllData[$k][] = $v[$childKeyField];
            $childAllData[$k][] = $v[$childRelateField];
        }

        $html = new \Home\Org\Html();
        $parent_html  = $html->createInput('select' ,$parent_name ,  $parentSelect , $parentData );
        //$child_all_html = $html->createInput('select' , $child_name . "_all" , null  , $childAllData ,'style="display:none"');
        $child_html = $html->createInput('select' , $child_name  ,  $childSelected , $childSelectedData );
        $this->assign('parent',$parent_html);
        $this->assign('child',$child_html);
        $this->assign('data',$childAllData);
        $this->assign('keys',array('parent_name'=>$parent_name,'child_name'=>$child_name  ));
        return $this->fetch('Common:getRelateSelect');
    }


    /**
     * 每天的12点之前返回 YYYY-mm-dd 12
     * 其他时间返回 YYYY-mm-dd 17
     */
    function getAddTime()
    {
        $now =date('H');
        if($now <= 12) // 12点之前
            return date('Y-m-d')." 12";
        return date('Y-m-d')." 17";
    }
    function viewRedis(){
        if(empty($_GET['key']))
            error("未传入Redis Key");
        $key = $_GET['key'];
        $type = empty($_GET['type']) ?  REDIS_TYPE_SET  : $_GET['type'] ;
        switch($type)
        {
            case REDIS_TYPE_SET:
                $re['type'] = "set";
                $re['data'] = getRedis()->get($key);
                $re['key'] = $key;
                break;
            case REDIS_TYPE_HSET:
                $re['type'] = "hSet";
                $re['data'] = getRedis()->hGet($key);
                $re['key'] = $key;
                break;
        }
        echo <<<EOF
        <h1>Redis类型</h1>
        {$re['type']}<br /><hr />
        <h1>Redis键名</h1>
        {$re['key']}<br /><hr />
        <h1>Redis数据</h1>
EOF;
        foreach($re['data'] as $v)
        {
            if($v['end_time'])
            {
                if(time() < strtotime($v['end_time']) )
                    $data[] = $v;
            }
            else
                $data[] = $v;
        }
        dump($data);
    }


    //渠道选择器
    function channelIdSelect($channelIds, $selected=null)
    {
        if($_POST)
            return $this->channelIdSelectSub();

        if($channelIds === null)
            $channelIds = 'all';
        $selectDataAll = getDataFromDbk(TABLE_CHANNEL_MST,'sitename','channel_id');
        if($selected === null)
        {
            $selected = array();
            if($channelIds)
            {
                if(isChannelIdAllSelectedModel($channelIds))
                    $this->assign("allModel",true);
                else
                {
                    if(isChannelIdExceptModel($channelIds))
                    {
                        $this->assign("exceptModel",true);
                        $channelIds = substr($channelIds , 3 );
                    }
                    $selected = explode('|',$channelIds );
                }
            }
        }
        else
        {
            if(isChannelIdAllSelectedModel($selected))
                $this->assign("allModel",true);
            else
            {
                if(isChannelIdExceptModel($selected))
                {
                    $this->assign("exceptModel",true);
                    $selected = substr($selected , 3 );
                }
            }
            $selected = strToArray($selected);
        }

        $html = new \Home\Org\Html();
        $selectMove = $html->createInput(selectmove ,"channel_id" , arrayToStr( $selected ), $selectDataAll , 'size="10"' );
        $this->assign( "selectMove" , $selectMove);
        return $this->fetch('Common:channelIdSelect');
    }

    private function channelIdSelectSub()
    {
        if($_POST['channel_id_all'] == '1')
            return 'all';

        $re = '';
        if($_POST['channel_id_except'] == '1')
            $re = 'no|';

        return $re. implode('|',$_POST['channel_id']);
    }

    public function checkWords()
    {
        if(!hasRole('DATAS2'))    error(ERROR_MSG);
        $words = getRedis()->get('SENSITIVE_WORDS_LIST');
        $this->assign('words', implode('|',$words));
        $this->nav = TableController::createNav(null, array('关键词检测'=>array()));
        $this->main = $this->fetch('Common:checkWord');
        $this->_out();
    }

    function checkUserLock()
    {
        $s = $f = 0;
        $db = M(TABLE_SYSTEM_ADMIN);
        $users = $db->select();
        if($users)
        {
            $time = time();
            foreach($users as $user)
            {
                if($user['lst_logintime'])
                {
                    $diffTime = $time - strtotime(trim($user['lst_logintime']));
                    if($diffTime>=(86400*90) && $user['state']==1)
                    {
                        $temp = $user;
                        $temp['state'] = 2;
                        $db->save($temp) ? $s++ : $f++;
                    }
                }
            }
        }
        echo json_encode(['status'=>'success', 'msg'=>'success lock:'.$s.', fail lock:'.$f]);
        exit;
    }

    function checkUserPwd()
    {
        $db = M(TABLE_SYSTEM_ADMIN);
        $uname = getAdminName();
        $data = $db->where(['uname'=>$uname])->find();
        $cTime = strtotime(date('Y-m-d'));
        if($data['reset_pwd'])
        {
            $diffTime = $cTime - $data['reset_pwd'];
            if($diffTime >= (90*86400))
                return true;
        }
        else
        {
            $startDate = '2016-05-23';
            $diffTime = $cTime - strtotime($startDate);
            if($diffTime>0 && ($diffTime%(90*86400))==0)
                return true;
        }
        return false;
    }
}