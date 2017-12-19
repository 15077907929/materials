<?php
use Home\Controller\TableController;

/**
 *  函数库
 */
function getAdminName(){
    return session(\Home\Controller\LoginController::ADMIN_NAME);
}

function getAdminConId(){
    return session(\Home\Controller\LoginController::ADMIN_CON_ID);
}

function getAdminId(){

    return session(\Home\Controller\LoginController::ADMIN_ID);
}

function getAdminLevel(){
    return session(\Home\Controller\LoginController::ADMIN_LEVEL);
}


function getAdminSiteName(){
    return session(\Home\Controller\LoginController::ADMIN_SITE_NAME);
}


function getAdminRole(){
    return strToArray(session(\Home\Controller\LoginController::ADMIN_ROLE));
}

function getAdminAllowChannel(){
    return strToArray(session(\Home\Controller\LoginController::ADMIN_ALLOW_CHANNEL));
}

function getAdminAllowCids(){
    return strToArray(session(\Home\Controller\LoginController::ADMIN_ALLOW_CID));
}

function getAdminAllowArea(){
    return strToArray(session(\Home\Controller\LoginController::ADMIN_ALLOW_AREA));
}

function getAdminAllowAids(){
    return strToArray(session(\Home\Controller\LoginController::ADMIN_ALLOW_AID));
}

function getAdminAllowFields(){
    return strToArray(session(\Home\Controller\LoginController::ADMIN_SHOW_FIELD));
}

function hasChannel($channelId)
{

    if (isAdmin() || isSuperAdmin())
        return true;
    $channelIds=strToArray($channelId);
    $allowChannel=getAdminAllowChannel();
    foreach ($channelIds as $v) {
        if (!in_array($v, $allowChannel))
            return false;
    }
    return true;
}

function hasChannelRole()
{
    $channels=getChannelList();
    return is_array($channels) && count($channels)>0 ;
}

function getAdminAllowGameType()
{
    return strToArray(session(\Home\Controller\LoginController::ADMIN_ALLOW_GAME_TYPE));
}

function getAdminAllowGame()
{
    if(isSuperAdmin() || isAdmin())
        return array_values( getAllGames() );
    return strToArray(session(\Home\Controller\LoginController::ADMIN_ALLOW_GAME));
}

function hasRole($role)
{
    if (isSuperAdmin())
        return ture;
    if (isAdmin() && $role != "all")
        return true;
    if(strpos($role, ','))
    {
        $tempRols=explode(',', $role);
        foreach($tempRols as $v)
            if(in_array($v, getAdminRole()))
                return true;
    }

    return in_array($role, getAdminRole());
}

function hasFunction($role)
{
    return hasRole($role);
}

function isSuperAdmin()
{
    return in_array("all", getAdminRole());
}

function isAdmin()
{
    return in_array("admin", getAdminRole());
}

/**
 * 从系统配置表读取配置
 * @param null $k 配置键名
 * @return array
 */
function getSystemConfig($k=null){
    $db=M(TABLE_SYSTEM_CONFIG);
    if($k===null){
        $data=$db->field('k,v')->where("enable=1")->select();
        return $data;
    }else{
        $data=$db->field('v')->where("enable=1 and k='$k'")->find();
        return $data['v'];
    }
}

/**
 * 将权限转换为文本
 */
function getPowerString($power)
{
    $p=strToArray($power);
    $powers=array_flip( getAllPowers() );
//    debug($powers , "翻转后权限列表");
    foreach($p as $v)
    {
        $re[]=$powers[$v] ? $powers[$v] : $v;
    }
    return arrayToStrTrim($re , " | ");
}

/**
 * 读取 USER_POWER ， 合并为 一维数组
 */
function getAllPowers()
{
    static $re ;
    if($re === null)
    {
        $powers=C('USER_POWER');
        foreach($powers as $v)
        {
            foreach($v as $k2=>$v2)
            {
                $re[$k2]=$v2;
            }
        }
        debug($re , "所有权限列表");
    }
    return $re;
}

/**
 * 通过值获取配置文件的键
 * @param string $conf ：配置文件名称
 * @param string $value ：配置文件的值
 */
function getKeyByValue($conf, $value,$appid=155)
{
    $c=C($conf);
    foreach ($c as $k => $v) {
        if ($v == $value)
            return $k;
    }
    return '';
}

function latelyView($name=null)
{
    $session_key=C('LATELY_VIEW_KEY') ? C('LATELY_VIEW_KEY') : 'lastly_view';
    $lately=session($session_key);
    if ($lately) $lately=unserialize($lately);
    if (!$name)
        return $lately;

    $max=21;
// 	$max=5;
    $url=$_SERVER['REQUEST_URI'];
    $exist=-1;
    foreach ($lately as $k => $v) {
        if ($v['link'] === $url) {
            $exist=$k;
            break;
        }
    }
    if ($exist !== -1)
        unset($lately[$exist]);

    $item=array('name' => $name, 'link' => $url, 'time' => time());
    if ($lately)
        array_unshift($lately, $item);
    else
        $lately[]=$item;

    if (count($lately) > $max)
        array_pop($lately);

//	dump($session_key);
//	dump(serialize($lately));
//	dump(session($session_key));
    session($session_key, serialize($lately));
}


function mdate($time=NULL)
{
    $text='';
    $date=date('Y-m-d H:i', $time);
    $text=friendDate($time);
    return "<span title=\"{$date}\">$text</span>";
}


function friendDate($time=null)
{
    $text='';
    $date=date('Y-m-d H:i', $time);
    $time=$time === NULL || $time > time() ? time() : intval($time);
    $t=time() - $time; //时间差 （秒）
    $t2=strtotime('today') - $time;
    if ($t == 0)
        $text='1秒前';
    elseif ($t < 60)
        $text=$t . '秒前'; // 一分钟内
    elseif ($t < 60 * 60)
        $text=floor($t / 60) . '分钟前'; //一小时内
    elseif ($t < 60 * 60 * 24)
        $text=floor($t / (60 * 60)) . '小时前'; // 一天内
    elseif ($t < 60 * 60 * 24 * 3)
        $text=floor($t2 / (60 * 60 * 24)) == 0 ? '昨天 ' . date('H:i', $time) : '前天 ' . date('H:i', $time); //昨天和前天
    elseif ($t < 60 * 60 * 24 * 30)
        $text=date('m月d日 H:i', $time); //一个月内
   else{
        $this_year=strtotime(date('Y') . "-01-01");
        if ($time >= $this_year)
            $text=date('m月d日', $time); //一年内
        else
            $text=date('Y年m月d日', $time); //一年以前
    }
    return $text;
}

function friendSecond($second=0)
{
    if (!$second)
        return '';

    if ($second < 1000)
        return "{$second} 毫秒";

    $s=round($second / 1000, 2);
    if ($s > 60) {
        $s=intval($s);
        $m=intval($s / 60);
        return $m . "分" . ($s % 60) . "秒";
    }
    return $s . "秒";

}


function getAdminNameById($id)
{
    if (intval($id) <= 0)
        return '';
    static $users=null;
    if ($users === null) {
        $db=M(TABLE_SYSTEM_ADMIN);
        $list=$db->field('id,sitename')->select();
        foreach ($list as $k => $v)
            $users[$v['id']]=$v['sitename'];
    }

    return isset($users[$id]) ? $users[$id] : '未知';
}

function getLoginNameById($uid, $id)
{
    if (intval($uid) <= 0)
    {
        static $logs=null;
        if($logs === null)
        {
            $info=M(TABLE_SYSTEM_LOG)->field('id,uid')->where('uid=0')->select();
            foreach($info as $l)
                $logs[$l['id']]=$uid;
        }
        return $logs[$id];
    }
    static $users=null;
    if ($users === null) {
        $db=M(TABLE_SYSTEM_ADMIN);
        $list=$db->field('id,uname')->select();
        foreach ($list as $k => $v)
            $users[$v['id']]=$v['uname'];
    }

    return isset($users[$uid]) ? $users[$uid] : '未知';
}

function substrTitle($str, $len)
{
    $str=unhtml($str);
    return '<span title="' . $str . '">' . mySubstr($str, $len) . '</span>';
}


function mySubstr($str, $len)
{
    for ($i=0; $i < $len; $i++) {
        $temp_str=substr($str, 0, 1);
        if (ord($temp_str) > 127) {
            $i++;
            if ($i < $len) {
                $new_str[]=substr($str, 0, 3);
                $str=substr($str, 3);
            }
        }else{
            $new_str[]=substr($str, 0, 1);
            $str=substr($str, 1);
        }
    }
    if (strlen($str) > 0)
        return implode($new_str) . "...";

    return implode($new_str);
}

function unhtml($text)
{
    $text=strip_tags($text);
    return $text;
}

function debug($data, $str=null){
    if(APP_DEBUG === true && isset($_GET['debug'])){
        $info=debug_backtrace();
        $file=$info[0]['file'];
        $line=$info[0]['line'];
        if ($str === null)
            dump($data);
        else{
            echo("<div style=\"background-color:#eee;border:solid 1px #ddd;border-radius:5px;margin-bottom:5px\"><h1>" . $str . "</h1>");
            dump($data);
            echo("</div>");
        }
    }
}

function strToArray($str, $split=null)
{
    if (!is_string($str))
        return array();
    if ($split === null)
        $split=C('DB_SPLIT') === null ? '_' : C('DB_SPLIT');
    $str=trim($str, $split);
    $arr=explode($split, $str);
    foreach ($arr as $k => $v) {
        if (trim($v) !== '')
            $re[]=trim($v);
    }
    return $re;
}

function arrayToStr($arr, $split=null)
{
    if ($split === null)
        $split=C('DB_SPLIT') === null ? ',' : C('DB_SPLIT');
    if (!is_array($arr)) {
        return '';
    }
    foreach ($arr as $k => $v) {
        $arr[$k]=trim($v);
    }
    $arr=array_unique($arr);
    $str=implode($split, $arr);
    if ($str !== '')
        $str=$split . $str . $split;
    return $str;
}

function arrayToStrTrim($arr, $split=null)
{
    if ($split === null)
        $split=C('DB_SPLIT') === null ? ',' : C('DB_SPLIT');
    return trim(arrayToStr($arr), $split);
}

function arrayToStrTrimWrapper($arr , $split=null){
    foreach($arr as $k=>$v){
        $arr[$k]="'{$v}'";
    }
    return arrayToStrTrim($arr , $split);
}

function arrayToStrTrimT($arr, $split=null)
{
    if ($split === null)
        $split=C('DB_SPLIT') === null ? "','" : C('DB_SPLIT');
    return trim(arrayToStr($arr), $split);
}

function gameFilter($data)
{
    $data=array_flip($data);
    $allowGames=array_values(getAllowGames());
    foreach($data as $k=>$v)
    {
        if(!in_array($k ,$allowGames ))
            unset($data[$k]);
    }
    return array_flip($data);
}

/**
 * 从数据库读取所有数据，作为select、checkbox、radio 的 data
 */
function getDataFromDbK($table, $key_field, $val_field, $where=null, $url_where=true, $concat=true)
{
    $table=M($table);
    if ($where != null) {
        if ($url_where)
            $where=\Home\Controller\TableController::parseUrlWhere($where);
        $data=$table->field(array($key_field, $val_field))->where($where)->select();
    }else{
        $data=$table->field(array($key_field, $val_field))->select();
    }
    foreach ($data as $k => $v) {
//        if ($v[$val_field] >= 1000000) {
//            $key=$v[$key_field] . " " . intval($v[$val_field]);
//        }else{
        if($concat)
            $key=intval($v[$val_field]) . " " . $v[$key_field];
        else
            $key=$v[$key_field];
//        }
        $re[$key]=$v[$val_field];
    }
    asort($re);
    return $re;
}

function getAllGames()
{
    static $allGame ;
    if($allGame === null)
        $allGame=getDataFromDbK('ad_game','name','gid');
    return $allGame;
}

function getAllowExtGames()
{
    $allGame=array_flip( getAllGames() );
    $allowGame=getAdminAllowGame();
    if($_GET['name'] == 1)
    {
        dump($allowGame);
        dump($allGame);

    }

    $re=array();
    foreach($allowGame as $v)
        $re[$allGame[$v]]=$v;
    return $re;

}

/**
 * 通过ID获取广告公司名称
 */
function getAdCompanyNameById($id)
{
    $data=null;
    if($data === null)
    {
        $table=M(TABLE_AD_COMPANY);
        $list=$table->field("id , name")->select();
        foreach($list as $k=>$v)
        {
            $data[$v['id']]=$v['name'];
        }
    }
    return $data[$id];
}

/**
 * 从数组库获取数据并分组，返回数据作为select、checkbox、radio 的 data
 */
function getFieldGroup($table, $field)
{
    $table=M($table);
    $data=$table->field($field)->group($field)->select();
    foreach ($data as $v) {
        $re[$field]=$v[$field];
    }
    return $re;
}


/**
 * 带过期时间的文件缓存 或 REDIS缓存
 * 以文件进行缓存，且另外缓存一个过期时间
 */
function _F($key, $cookie=null, $expire=null)
{
    if (!$key)
        return null;
    $key_expire=$key . '_expire';
    $time=time();
    //获取缓存
    if ($cookie === null) {
        $expire_time=F($key_expire);
        if (!$expire_time) //找不到缓存过期时间，return null
        {
            debug("{$key} 缓存时间未找到!");
            return null;
        }else//找到缓存过期时间
        {
            debug("当前时间：$time " . "，缓存过期时间：" . $expire_time, "缓存已过期");
            if ($time > $expire_time) //缓存已过期
            {
                debug("{$key} 缓存过期!");
                return null;
            }else{
                debug("{$key} 读取缓存!");
                return F($key);
            }

        }
    }

    //开始缓存数据
    $expire=$expire ? $expire : 1200; //默认20分钟
    debug($cookie, "{$key} 缓存数据!");
    F($key, $cookie); //缓存数据
    F($key_expire, $time + $expire); //写入缓存过期时间
}


function parseArg($str='')
{
    $args=func_get_args();
    array_shift($args); //移除第一个参数
    if (count($args) > 0) {
        while (($index=strpos($str, '{?}')) !== false) {
            $str=substr_replace($str, array_shift($args), $index, 3);
        }
    }
    return $str;
}

function byteConvert($bytes)
{
    $s=array('B', 'Kb', 'MB', 'GB', 'TB', 'PB');
    $e=floor(log($bytes) / log(1024));

    return sprintf('%.2f ' . $s[$e], ($bytes / pow(1024, floor($e))));
}

function microtimeConvert($microtime)
{
    return round($microtime / 1000, 2) . "秒";
}

function success($mes="操作成功", $url=null, $ajax=null)
{
    $controller=A('Home/Base');
    $controller->success($mes, $url, $ajax);
    exit;
}

function error($mes=null, $url=null, $ajax=null)
{
    $controller=A('Home/Base');
    $controller->error($mes, $url, $ajax);
    exit;
}

function endWith($str, $char='/')
{
    $str=trimr($str, $char);
    return $str . $char;
}

function getExpireTime($expire)
{
    $exp=isset($_REQUEST[$expire]) ? intval($_REQUEST[$expire]) : 0;
    return time() + $exp;

}


function checkIdUnique($tag, $value)
{
    if ($tag === null)
        return null;
    $table='ids';
    $field='tid';
    $key=$table . $tag . $field;
    static $static_ids=null;
    if ($static_ids[$key] === null) {
        $db=M($table);
        $temp=$db->field($field)->where("tag='{$tag}'")->select();
        $static_ids[$key]=array();
        foreach ($temp as $v) {
            $static_ids[$key][]=$v[$field];
        }
// 		dump("只读取一次");
    }
    if (in_array($value, $static_ids[$key]))
        return null;

    $static_ids[$key][]=$value;
    return $value;


}

function getIdByTag($tag, $detail_table, $limit)
{
    $field='tid';
    $sql="select * from ids where tag='tag' left join {$detail_table} on {$detail_table}.tid=ids.tid having ids.tid=null ";
    $db=M($detail_table);
    $data=$db->query($sql);
    foreach ($data as $v) {

    }
}

function getPowerCheckbox($field, $data , $super=0)
{
    if($super && !isSuperAdmin())
        return '';
    $power=C('USER_POWER');
    $html=new \Home\Org\Html();
    $re='';
    foreach ($power as $k => $v) {
        $re .= "<B>{$k}</B>";
        $re .= $html->createInput('checkbox', $field, $data, $v);
//        $re .="<hr />";
    }
    return $re;
}

function getPower($field)
{
    $power=C('USER_POWER');
    $re='';
    static $result=null;
    if ($result == null) {
        foreach ($power as $v) {
            foreach ($v as $key => $value) {
                $result[$value]=$key;
            }
        }
    }
    $data=explode(",", $field);
    $str='';
    foreach ($data as $t) {
        if (isset($result[$t]))
            $str .= '【' . $result[$t] . "】,";
    }
    return substr($str, 0, -1);
}

function getChannelNamesById($channelIds)
{
    $channelId=strToArray($channelIds);
    foreach ($channelId as $v) {
        $re[]=getChannelNameById($v);
    }
    return arrayToStrTrim($re);
}


function getUserId($uid)
{
    static $data=null;
    if ($data === null) {
        $db=M(TABLE_SYSTEM_ADMIN);
        $datas=$db->field("id,sitename")->select();
        $data=array();
        foreach ($datas as $v) {
            $data[$v['id']]=$v['sitename'];
        }
    }
    return isset($data[$uid]) ? $data[$uid] : "未知帐号";
}


function getTableKeyValue($table,$key,$value,$def)
{
    static $data=null;
    if ($data === null) {
        $db=M($table);
        $datas=$db->field("$key,$value")->select();
        $data=array();
        foreach ($datas as $v) {
            $data[$v[$key]]=$v[$value];
        }
    }
    return isset($data[$def]) ? $data[$def] : "无";
}

function yestoday($type)
{
    return $type . "='" . date("Y-m-d", strtotime("-1 day")) . "'";
}

/**
 * 获取所有组管理员
 * @return null
 */
function getGroupMaster()
{
    $db=M(TABLE_SYSTEM_ADMIN);
    static $re=null;
    if ($re === null) {
        $data=$db->where("conid=4 or conid=6")->select();
        foreach ($data as $v) {
            $re[$v['sitename']]=$v['id'];
        }
    }
    return $re;
}

function zero($str)
{
    return (string)$str === '0' ? '' : $str;
}

/**
 * 根据组id获取组名称
 */
function getGroupName($id)
{
    $groups=null;
    if ($groups === null) {
        $db=M(TABLE_AD_LOGIN_CONF);
        $data=$db->field("id,title")->select();
        foreach ($data as $v) {
            $groups[$v['id']]=$v['title'];
        }
    }
    return $groups[$id];
}

function getAjaxtextUrl($p, $p2, $key)
{
    $url=U($p, $p2);
    if (strpos($url, '?') !== false)
        return $url . "&{$key}=";
    return $url . "?{$key}=";
}

function passwd($str)
{
    return md5($str);
}

//添加渠道时自动添加账号
function autoAddUser($name)
{
    if(!trim($name))
        return '';
    $db=M(TABLE_SYSTEM_ADMIN);
    $data['uname']=$name;
    if ($db->where("uname='{$name}'")->find())
        error("账号添加失败，用户名已存在");
    $data['sitename']=I("sitename", "");
    $data['channel_id']=getCurrentChannelId();
    $pwd=trim(I("upass"));
    $data['upass']=passwd($pwd ? $pwd : '123456');
    $data['state']=1;
    $data['registertime']=date("Y-m-d H:i:s");
    $data['lst_logintime']=date("Y-m-d H:i:s");
    $data['paruid']=I("cuid");
    $data['conid']=1;
    $data['allowtype']='001';
    $re=$db->add($data);
    if (!$re)
        error("账号添加失败，用户名已存在");
    return $name;
}

function excelTime($days)
{
    $days -= 25569;
    return  $days*24*3600;
}

function arrToStr($arr)
{
    $len=count($arr);
    if($len == 1)
        return $arr[0];
   elseif($len > 1)
        return implode(',', $arr);
}

function getRedis($conf=null){
    static $redis ;
    if($redis === null){
        import('@.Org.MyRedis');
        $redis=MyRedis::getInstance($conf);
    }
    return $redis;
}

function saveTable2Redis($table , $key , $saveType, $whereArgs=null){
    $db=M($table);
    $time_now=date('Y-m-d H:i:s', time());
    $where='';
    if($whereArgs)
        $where="$whereArgs >= '$time_now'";
    $data=$db->order("sort desc")->select();
    if(!$data)
        $data=$db->select();
    switch($saveType)
    {
        case REDIS_TYPE_SET:
            $re=getRedis()->set($key , $data);
            break;
        case REDIS_TYPE_HSET:
            getRedis()->hDel($key);
            foreach($data as $k=>$v)
            {
                $re=getRedis()->hSet($key,$v['id'],$v);
            }
            break;
    }
}

function saveTable2RedisSS($table , $key , $whereArgs=null){
    $db=M($table);
    $time_now=date('Y-m-d H:i:s', time());
    $where='';
    if($whereArgs)
        $where="$whereArgs >= '$time_now'";
    $data=$db->order("sort desc")->select();
    if(!$data)
        $data=$db->select();
    $result=array();
    foreach($data as $temp){
        $result[$temp['app_id']][]=$temp;
    }
    getRedis()->del($key);
    getRedis()->set($key,$result);
}

function xx($n)
{
    return $n*100 ."%";
}

function getExit($code)
{
    $config=C('EXIT');
    $config=array_flip($config);
    return $config[$code];
}

function donwButton($fname, $path)
{

    $config=C('img.'.$path);
    if(is_string($config))
        $dir=$config;
    else
        $dir=$config['path'];

    if(empty($fname))
        $btn="";
    else
    {
        $url=U('File/downFile', array('filename'=>$dir.$fname));
        $btn="<a href='$url'>文件下载</a>";
    }
    return $btn;
}

function getMime($file)
{
    return mime_content_type($file);
}

function monthData($addMonth=1, $start='2014-01'){
    if($addMonth > 0 )
        $end= date('Y-m' , strtotime("+{$addMonth} month"))  ;
   elseif($addMonth < 0 )
        $end= date('Y-m' , strtotime("{$addMonth} month"))  ;
    else
        $end=date('Y-m');

    $re=monthDiff($start , $end);
    $ree=array();
    foreach($re as $k=>$v){
        $ree[$v]=$v;
    }
    return array_reverse($ree);
}

function monthDiff($start , $end){
    list($syear,$smonth)=explode('-',$start);
    list($eyear,$emonth)=explode('-',$end);

    $re=array();
    for($i=$syear ; $i<=$eyear ; $i++)
    {
        if($i != $syear && $i != $eyear)
        {
            $sm=1;
            $em=12;
        }
       elseif($i == $syear && $i != $eyear)
        {
            $sm=$smonth;
            $em=$i < $eyear ? '12' : date("m")-1;
        }
       elseif($i == $syear && $i == $eyear){
            $sm=$smonth;
            $em=$emonth;
        }
        else
        {
            $sm=1;
            $em=$emonth;
        }
        for($j=$sm ; $j<= $em ;$j++ )
        {
            $m= strlen($j) == 1 ? "0".$j : $j;
            $re[]=$i . "-" .$m;
        }
    }
    return $re;
}


function red($str){
    return '<span style="color:red">' . $str . '</span>';
}


/**
 * 多维数组排序
 * @param array $arr 二维数组
 * @param string $key  排序的键
 * @param integer $sortType 排序方式
 * @return array
 */
function mutilSort(array &$arr,$key,$sortType=SORT_ASC)
{
    foreach($arr as $v)
    {
        $keys[]=$v[$key];
    }
    array_multisort($keys,$sortType,$arr);
    return $arr;

}

function getYesterday()
{
    $day=date('Y-m-d', strtotime('-1 day'));
    return $day;
}

function getWeekDay($ws=1)
{
    $week=date('w', strtotime(date('Y-m-d')));
    $stm=$week==1 ? $ws : $ws+1;
    $sts=$ws;
    $lm=date("Y-m-d",strtotime("-$stm Mon"));
    $ls=date("Y-m-d",strtotime("-$sts Sun"));
    $date[]=$lm;
    $date[]=$ls;
    return $date;
}

function getMonth($ym)
{
    $firstday=$ym.'-01';
    $lastday=date('Y-m-d', strtotime("$firstday +1 month -1 day"));
    return array($firstday, $lastday);
}

function getMonthDays($time1, $time2)
{
    $ft=strtotime($time1);
    $lt=strtotime($time2);
    for($i=$ft; $i<=$lt; $i+=86400)
        $days[]=date('Y-m-d', $i);
    return $days;
}

function getYearMonths($time1, $time2)//'2015-01','2015-03'
{
    $year1=substr($time1, 0, 4);
    $year2=substr($time2, 0, 4);
    $mon1=intval(substr($time1, 5));
    $mon2=intval(substr($time2, 5));
    $months=array();
    if($year1 == $year2)
    {
        for($i=$mon1; $i<=$mon2; $i++)
        {
            if(strlen($i) < 2)
                $months[]=$year1.'-0'.$i;
            else
                $months[]=$year1.'-'.$i;
        }
    }
    else
    {
        for($i=$mon1; $i<=12; $i++)
        {
            if(strlen($i) < 2)
                $months[]=$year1.'-0'.$i;
            else
                $months[]=$year1.'-'.$i;
        }
        for($j=1; $j<=$mon2; $j++)
        {
            if(strlen($j) < 2)
                $months[]=$year2.'-0'.$j;
            else
                $months[]=$year2.'-'.$j;
        }
    }
    return $months;
}

function getSectionDays($day1, $day2)//根据起始日期获取该时间段内连续日期
{
    $t1=strtotime($day1);
    $t2=strtotime($day2);
    for($i=$t1; $i<=$t2; $i+=86400)
        $arr[]=date('Y-m-d', $i);
    return $arr;
}

function parseChannelToStr($channels)
{
    $restr='';
    $channels=arrayToStrTrim($channels);
    $channelArr=explode(',', $channels);
    foreach($channelArr as $v)
        $restr .= '"'.$v.'",';
    $re=trim($restr, ',');
    return $re;
}

function arrayToString($array, $limiter=true)
{
    $str='';
    foreach($array as $v)
        $str .= "'$v',";
    $str=trim($str, ',');
    if(!$limiter)
        $str=trim($str, "'");
    return $str;
}

function fillArray($len, $fill)
{
    $array=array();
    for($i=0; $i<$len; $i++)
        $array[]=$fill;
    return $array;
}

function transTime($seconds)
{
    $str='';
    if($seconds <= 60)
        $str .= intval($seconds).' 秒';
    else
    {
        $min=intval($seconds / 60);
        $sec=intval($seconds % 60);
        $str .= $min.' 分 '.$sec.' 秒';
    }
    return $str;
}

function mySub($str, $limiter, $count)//类似mysql的 substring_index()
{
    $re='';
    $arr=explode($limiter, $str);
    for($i=0; $i<$count; $i++)
        $re .= $arr[$i].$limiter;
    $re=trim($re, $limiter);
    return $re;
}

function getCidByChannel($channel, $cidArr)
{
    foreach($cidArr as $cid=>$channels)
        if(in_array($channel, strToArray($channels)))
            return $cid;
    return $channel;
}

function startWith($str, $start)//判断字符串$str 是否以 字符或字符串$start开头
{
    $pos=strpos($str, $start);
    if($pos===0)
        return true;
    else
        return false;
}
function endsWith($str, $end)
{
    $len=strlen($str);
    if($len < strlen($end))
        return false;
    else
    {
        $end_str=substr($str, $len-strlen($end));
        if($end_str == $end)
            return true;
        else
            return false;
    }
}

function findCidByChannel($channel, $all_cid)
{
    foreach($all_cid as $cid=>$v)
    {
        $temp=strToArray(trim($v,','));
        if(in_array($channel, $temp))
            return $cid;
    }
    return null;
}

function isWeekend($time)
{
    if(!startWith($time, '20'))
        return false;
    if(strlen($time) != 10)
        return false;
    $w=date('w', strtotime($time));
    if($w==0 || $w==6)
        return true;
    return false;
}

function parseCurd($method)
{
    $conf=array_flip(C('CURD'));
    return $conf[$method];
}

function sendMail($reciever, $content, $attach, $path, $name)//接收者，内容，附件名称，主题
{
    import('@.Org.PHPMailer.PHPMailer');
    $mail=new \PHPMailer();
    $mail->IsSMTP();
    $mail->Host='smtp.163.com';//'mail.joymeng.com';
    $mail->Port=25;
    $mail->SMTPAuth=true;
    $mail->Username='happyjoy9001@163.com';//'joysender@joymeng.com';//
    $mail->Password='Lt123456';//'abc,123';//
    $mail->From='happyjoy9001@163.com';//'joysender@joymeng.com';
    $mail->FromName='乐堂单机运营部';
    $mail->AddAddress($reciever);
    $mail->CharSet='utf-8';
    $mail->Subject=$name.'-'.date('Y-m-d', strtotime('-1 day'));
    $mail->Body=$content;
    if($attach)
        $mail->AddAttachment($path.$attach, $attach);
    $result=$mail->Send();
    return $result;
}

//获取该月份的第一天和最后一天    2016-04 => ['2016-04-01','2016-04-30']
function getFlOfMonth($time)
{
    $start=$time.'-01';
    $end=date('Y-m-d', strtotime("$start +1 month -1 day"));
    return [$start, $end];
}

function isBusiness()
{
    $db=M(TABLE_SYSTEM_ADMIN);
    $uname=getAdminName();
    $info=$db->where(['uname'=>$uname])->find();
    if($info['conid'] == 4)
        return true;
    return false;
}

function isChannelOperate()
{
    $db=M(TABLE_SYSTEM_ADMIN);
    $uname=getAdminName();
    $info=$db->where(['uname'=>$uname])->find();
    if($info['conid'] == 22)
        return true;
    return false;
}

function isDataGroup()
{
    $db=M(TABLE_SYSTEM_ADMIN);
    $uname=getAdminName();
    $info=$db->where(['uname'=>$uname])->find();
    if($info['conid'] == 17)
        return true;
    return false;
}

function getLocationByIp($ip)
{
    $re=$ip.' : 未知';
    if ($ip == "218.104.71.178" || $ip == "60.173.241.76") {
        $re=$ip." : 中国安徽合肥";
    }else{
        $url="http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=".$ip;
        $result=file_get_contents($url);
        if($result)
        {
            $data=json_decode(substr($result, 21, strlen($result)-22), true);
            $re=$ip.' : '.$data['country'].$data['province'].$data['city'];
        }
    }
    return $re;
}

function arrayMultiSort($arr, $keys, $type='asc') {
    $keysvalue=$new_array=array();
    foreach ($arr as $k => $v){
        $keysvalue[$k]=$v[$keys];
    }
    $type == 'asc' ? asort($keysvalue) : arsort($keysvalue);
    reset($keysvalue);
    foreach ($keysvalue as $k => $v) {
        $new_array[$k]=$arr[$k];
    }
    return $new_array;
}

function parseYn($val)
{
    $conf=array_flip(C('YESORNO'));
    return $conf[$val];
}

function roundChannelArpu($arpu,$number=2){
    if($arpu > 0)
        echo number_format($arpu,$number);
    else
        echo $arpu;
}

function getSortStatusById($id)
{
    $conf=array_flip(C('SORTSTATUS'));
    return $conf[$id];
}

function getClientStatusById($id)
{
    $conf=array_flip(C('CLIENTSTATUS'));
    return $conf[$id];
}

function getTaskTypeById($id)
{
    $conf=array_flip(C('TASKTYPE'));
    if ($conf[$id] == '测试') {
        $conf[$id]="<span>".$conf[$id]."</span>";
    }elseif ($conf[$id] == '正常') {
        $conf[$id]="<span style='color:green'>".$conf[$id]."</span>";
    }elseif ($conf[$id] == '高质量') {
        $conf[$id]="<span style='color:red'>".$conf[$id]."</span>";
    }
    return $conf[$id];
}

function getFinishTask($id) {
    $time=date('Ymd');
    $tmp=getRedis()->get('aso_api_task_game_keyword_success_weight' . $time . $id);
    return $tmp;
}

function getToday()
{
    return date('Y-m-d' );
}

function delDirAndFile($dirName)
{
    if ($handle=opendir($dirName)) {
        while (false !== ($item=readdir($handle))) {
            if ($item != "." && $item != "..") {
                if (is_dir("$dirName/$item")) {
                    delDirAndFile("$dirName/$item");
                }else{
                    if (unlink("$dirName/$item"))
                        echo "成功删除缓存文件： $dirName/$item<br />";
                }
            }
        }
        closedir($handle);
        // if( rmdir( $dirName ) )echo “成功删除目录： $dirName<br />n”;
    }
}

//比较版本大小
function compareVersion($version1, $version2)
{
    $val=0;
    if ($version1 == $version2) {
        return 0;
    }
    if (empty($version1)) {
        $val=-1;
    }elseif (empty($version2)) {
        $val=1;
    }elseif (strpos($version2, $version1) !== false) {
        $val=-1;
    }elseif (strpos($version1, $version2) !== false) {
        $val=1;
    }else{
        $arr1=explode(".", $version1);
        $arr2=explode(".", $version2);
        $len=count($arr1);
        $len2=count($arr2);
        $len=$len < $len2 ? $len : $len2;
        for ($index=0; $index < $len; $index++) {
            if (intval($arr1[$index]) < intval($arr2[$index])) {
                return -1;
            }
            if (intval($arr1[$index]) > intval($arr2[$index])) {
                return 1;
            }
        }
    }
    return $val;
}

function getAosRole(){
    return strToArray(session(\Home\Controller\LoginController::ASO_ROLE));
}

function getAdminVpsGroupId()
{
    return session(\Home\Controller\LoginController::ADMIN_VPS_GROUP_ID);
}

function hasAsoRole($role)
{
    if (in_array("all", getAosRole()))
        return ture;
    if(strpos($role, ','))
    {
        $tempRols=explode(',', $role);
        foreach($tempRols as $v)
            if(in_array($v, getAosRole()))
                return true;
    }
    return in_array($role, getAosRole());
}

function getVpnNameList()
{
    $cache['禁用']=-1;
    $cache['随机分配']=0;
    $cache['固定VPN']="vpn";
    return $cache;
}

//客户端任务数
function getClientTask($cid)
{
    if (empty($cid)) {
        return "no clientid";
    }
    $key="aso_api_task_client_waiter@" . $cid;
    $tmp=getRedis()->get($key);
    return $tmp;
}

function getAsoTypeById($id)
{
    $arr=C('ASOTYPE');
    $tmp=array_flip($arr);
    return $tmp[$id];
}

//获得评星名称
function getRateNameById($id){
    $arr=C('RATE');
    $tmp=array_flip($arr);
    return $tmp[$id];
}

function getTimeConfig()
{
    $db=M("time_config");
    $data=$db->order("start asc")->select();
    foreach($data as $v){
        $cache[$v['name']]=$v['start']."-".$v['end'];
    }
    return $cache;
}

function getTaskStatusById($id)
{
    $arr=C('TASKSTATUS');
    return $arr[$id]."[".$id."]";
}

function getVpnConnectStatusById($id)
{
    $arr=C('VPNCONSTATUS');
    return $arr[$id]."[".$id."]";
}

function getTaskUpdateTimeByTime($start)
{
    $db=M("time_config");
    $data=$db->select();
    $cache=array();
    foreach($data as $v){
        if (!empty($v['update'])) {
            $cache[$v['start'].":00"]=$v['update'].":00";
        }
    }
    $start_arr=explode(" ",$start);
    $update_time=!empty($cache[$start_arr[1]]) ? $start_arr[0]." ".$cache[$start_arr[1]] : "";
    return $update_time;
}

function getNowTime() {
    return date("Y-m-d H:i:s");
}

function getCountConfig()
{
    $db=M("count_config");
    $data=$db->select();
    foreach($data as $v){
        $cache[$v['name']]=$v['count'];
    }
    return $cache;
}

function getTaskCountNameByCount($count)
{
    $db=M("count_config");
    $data=$db->where("count='{$count}'")->find();
    if (!empty($data)) {
        return $data['name'];
    }else{
        return red('未知');
    }
}

function getIphoneNetTypeById($type)
{
    $conf=array_flip(C('IPHONENETTYPE'));
    return $conf[$type];
}

function getAccountTypeByType($type)
{
    $conf=array_flip(C('ACCOUNTTYPE'));
    return $conf[$type];
}

function getTaskModelById($id)
{
    $conf=array_flip(C('TASKMODEL'));
    return $conf[$id];
}

function getIphoneSidList()
{
    $db=M("iphone_mst");
    $data=$db->query("select DISTINCT substring_index(sid, '.', 3) from iphone_mst order by sid");
    foreach($data as $v){
        foreach ($v as $val) {
            if (!empty($val)) {
                $key=$val.".";
                $cache[$key]=$key;
            }
        }
    }
    return $cache;
}

function getIphoneAuthById($id)
{
    $conf=array_flip(C('IPHONEAUTH'));
    if ($id == 0) {
        return "<span style='color:red'>".$conf[$id]."</span>";
    }elseif ($id == 1) {
        return "<span style='color:green'>".$conf[$id]."</span>";
    }
    return $conf[$id];
}

function getCpList()
{
    $data=M("google_cp_config")->select();
    foreach($data as $v){
        $cache[$v['name']]=$v['name'];
    }
    return $cache;
}

function getGkwList(){
    return array('不抓取关键字'=>'0','抓取关键字'=>'1');
}

function getGameList($type=1) {
    $db=M("google_app_config");
    $data=$db->where('status=1')->select();
    foreach($data as $v){
        if ($type == 1) {
            $cache[$v['game_name'] . '(' . $v['package_name'] . ')']=$v['package_name'];
        }elseif ($type == 2) {
            $cache[$v['game_name'] . '(' . $v['package_name'] . ')']=$v['id']."##".$v['game_name']."##".$v['package_name'];
        }elseif ($type == 3) {
            $cache[$v['game_name'] . '(' . $v['package_name'] . ')']=$v['id']."##".$v['package_name'];
        }else{
            $cache[$v['package_name']]=$v['game_name'] . '(' . $v['package_name'] . ')';
        }
    }
    return $cache;
}

function getTaskTypeList($type=1) {
    $db=M("google_task_type");
    $data=$db->order('tid asc')->select();
    foreach($data as $v){
        if ($type == 1) {
            $cache[$v['tid'] . '-' . $v['name']]=$v['tid'];
        }else{
            $cache[$v['tid']]=$v['tid'] . '-' . $v['name'];
        }
    }
    return $cache;
}

function getCountryLanguage($type=1) {
    $db=M("country_mst");
    $data=$db->select();
    foreach ($data as $v) {
        if ($type == 1) {
            $cache[$v['name'] . '#' . $v['language']]=$v['short_name'] . '#' . $v['language'];
        } elseif($type == 2){
            $cache[$v['name'] . '#' . $v['language']]=$v['language'];
        }else {
            $cache[$v['short_name'] . '#' . $v['language']]=$v['name'] . '#' . $v['language'];
        }
    }
    return $cache;
}

function getCountryList(){
    $db=M("country_mst");
    $data=$db->select();
    foreach ($data as $v) {
        $cache[$v['name'] . '#' . $v['language']]=$v['short_name'];
    }
    return $cache;
}

function getOnlyCountryList(){
    $db=M("country_mst");
    $data=$db->select();
    foreach ($data as $v) {
        $cache[$v['name']]=$v['short_name'];
    }
    return $cache;
}


function getIphoneIpList() {
    $db=M("iphone_mst");
    $data=$db->select();
    foreach ($data as $v) {
        $cache[$v['sid']]=$v['sid'];
    }
    return $cache;
}

function getIphoneTagList($type=1) {
    $data=M("iphone_tag_mst")->select();
    foreach ($data as $v) {
        if ($type == 1) {
            $cache[$v['tid'] . ' ' . $v['name']]=$v['tid'];
        }elseif ($type == 2) {
            $cache[$v['tid']]=$v['name'];
        }
    }
    return $cache;
}

function getTaskTagList($type=1) {
    $data=M("task_tag_mst")->select();
    foreach ($data as $v) {
        if ($type == 1) {
            $cache[$v['tid'] . ' ' . $v['name']]=$v['tid'];
        }elseif ($type == 2) {
            $cache[$v['tid']]=$v['name'];
        }
    }
    return $cache;
}

function getAgreementSidList() {
    $db=M("agreement_mst");
    $data=$db->query("select DISTINCT substring_index(sid, '.', 3) from agreement_mst order by sid");
    foreach($data as $v){
        foreach ($v as $val) {
            if (!empty($val)) {
                $key=$val.".";
                $cache[$key]=$key;
            }
        }
    }
    return $cache;
}

function getVpnGroupList($type=1) {
    $db=M("vpn_mst_group", null, C("DB_ASO_DATA"));
    $data=$db->select();
    foreach($data as $v){
        if ($type == 1) {
            $cache[$v['name']]=$v['id'];
        }elseif ($type == 2) {
            $cache[$v['id']]=$v['name'];
        }
    }
    return $cache;
}

function getUrlData($url)
{
    $useragent='Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36';
    $ch=curl_init($url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 600);
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    $res=curl_exec($ch);
    $status=curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($status == '200' || $status='302') {
        return $res;
    }else{
        return '';
    }
}

function exchange2($data){
    if (empty($data)) {
        return '';
    }
    $result='';
    $index=strlen($data);
    for ($pos=0; $pos < $index; $pos += 2) {
        $result .= $data[$pos + 1];
        $result .= $data[$pos];
    }
    if ($pos == $index) {
        $result .= $data[$pos];
    }
    return $result;
}

/**
 * 1. 先将所有的','替换为'='； 所有的'-'替换为'+'；所有的'_'替换为'/'；
 * 2. decodeDes(decodebase64(奇偶对调(数据)), 'UlKd!s@q2WxthVrn')
 * @param $str
 */
function decodeDesStr($str){
    //1、 先将所有的','替换为'='； 所有的'-'替换为'+'；所有的'_'替换为'/'；
    //echo '加密数据：' . $str . '<br />';
    $str=str_replace(',','=', $str);
    $str=str_replace('-','+', $str);
    $str=str_replace('_','/', $str);
    //echo '替换后的：' . $str . '<br />';
    //echo '对调完的：' . exchange2($str) . '<br />';
    return base64_decode(exchange2($str));

}

function getSuccessTask($id) {
    $result=getRedis()->get('search_task_success_id_' . $id);
    $result=intval($result);
    return $result;
}

function getSumTask($id) {
    $result=getRedis()->get('search_keyword_issued_task_id_' . $id);
    $result=intval($result);
    return $result;
}

function getDynamicTagList($type=1) {
    $db=M("dynamic_tag_mst", null, C("DB_ASO_DATA"));
    $data=$db->select();
    foreach($data as $v){
        if ($type == 1) {
            $cache[$v['tag_name']]=$v['tid'];
        }elseif ($type == 2) {
            $cache[$v['tid']]=$v['tag_name'];
        }
    }
    return $cache;
}

function getDynamicTypeKeyList($type=1) {
    $db=M("dynamic_type_mst", null, C("DB_ASO_DATA"));
    $data=$db->select();
    foreach($data as $v){
        if ($type == 1) {
            $cache[$v['type_name']]=$v['tid']."_".$v['type_key'];
        }elseif ($type == 2) {
            $cache[$v['type_key']]=$v['type_name'];
        }
    }
    return $cache;
}