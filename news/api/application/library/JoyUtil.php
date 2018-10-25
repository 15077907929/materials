<?php

class JoyUtil
{

    const ACCOUNT_SUO_KEY = "ASO_IOS_ACCOUNT_SUO";
    const ACTIVATE_KEY = "ASO_IOS_ACCOUNT_ACTIVATE";
    const ACTIVATE_GID_KEY = "ASO_IOS_ACCOUNT_ACTIVATE_GID";
    const ADDRESS_INFO_KEY = "ASO_IOS_ACCOUNT_ADDRESS_INFO";
    const ACTIVATE_KEY_TEST = "ASO_IOS_ACCOUNT_ACTIVATE_TEST";
    const ACCOUNT_SUO_KEY_TEST = "ASO_IOS_ACCOUNT_SUO_TEST";
    const ACCOUNT_KEY_TEST_ID = "ASO_IOS_ACCOUNT_ACTIVATE_TEST_ID";

    /*
     * 获得访问者IP
     */
    public static function getIp()
    {
        if (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("REMOTE_ADDR")) {
            $ip = getenv("REMOTE_ADDR");
        } else if (isset($_COOKIE['Real_IP'])) {
            $ip = $_COOKIE['Real_IP'];
        } else if (getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**获取网络类型
     * @param $net_type
     * @return string
     */
    public static function netType($net_type)
    {
        switch ($net_type) {
            case '1':
                $netType = 'WIFI+VPN';
                break;
            case '2':
                $netType = 'WIFI+3G';
                break;
            case '3':
                $netType = 'WIFI+3G+VPN';
                break;
            case '4':
                $netType = 'ALL_WIFI';
                break;
            case '5':
                $netType = 'ALL_WIFI_FAST';
                break;
            case '6':
                $netType = 'ALL_WIFI_0';
                break;
            case '7':
                $netType = 'ALL_VPN';
                break;
            default:
                $netType = 'ALL_WIFI';
                break;
        }
        return $netType;
    }


    public static function getAppleIdPTest($sid)
    {
        $key = self::ACTIVATE_KEY_TEST;
        $cache = JoyCache::getInstance();
        $data = $cache->spop($key);
        if (!$data) {
            $keysuo = $cache->get(self::ACCOUNT_SUO_KEY_TEST);
            if (!$keysuo) {
                $cache->set(self::ACCOUNT_SUO_KEY_TEST, 1, 20);//加锁
                $lastId = $cache->get(self::ACCOUNT_KEY_TEST_ID);
                $lastId = $lastId ? $lastId : 0;
                $sql = "select id,email,apple_pwd,last_name,first_name,province,province_idx,city,postal,street1,street2,street3,activate_client  from apple_id_product where apple_state=1  and id>$lastId limit 5000";
                $list = JoyDb::query($sql, "aso_ios_account");
                foreach ($list as $t) {
                    $address = (isset($t["city"]) && $t["city"]) ? array() : JoyUtil::getAddressInfo();
                    $temp["email"] = trim($t["email"]);
                    $temp["id"] = $t["id"];
                    $temp["apple_pwd"] = trim($t["apple_pwd"]);
                    $temp["last_name"] = $t["last_name"] ? trim($t["last_name"]) : '衡';
                    $temp["first_name"] = $t["first_name"] ? trim($t["first_name"]) : '衡狄';
                    $temp["city"] = $t["city"] ? trim($t["city"]) : trim($address["city"]);
                    $temp["postal"] = $t["postal"] ? intval($t["postal"]) : intval($address['postal']);
                    $temp["street1"] = $t["street1"] ? trim($t["street1"]) : trim($address['street1']);
                    $temp["street2"] = $t["street2"] ? trim($t["street2"]) : trim($address['street2']);
                    $temp["street3"] = $t["street3"] ? trim($t["street3"]) : trim($address['street3']);
                    $temp["phone"] = (isset($t["phone_num"]) && $t["phone_num"]) ? trim($t["phone_num"]) : ("1" . rand(3, 5) . rand(0, 8) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9));
                    $temp["province"] = $t["province_idx"] ? intval($t["province_idx"]) : intval($address["province_idx"]);
                    $temp["provinces"] = $t["province"] ? trim($t["province"]) : trim($address["province"]);
                    $temp['spattern_id'] = self::getSpatternId();
                    $cache->sAdd($key, $temp);
                }
                $cache->set(self::ACCOUNT_KEY_TEST_ID, $temp["id"]);
                $cache->delete(self::ACCOUNT_SUO_KEY_TEST);//删除锁
                $data = $cache->spop($key);
                return $data;
            } else {
                return null;
            }
        } else {
            return $data;
        }
    }


    /**
     * 取账号信息加到redis中
     */
    public static function getAppleIdP($sid)
    {
        $cache = JoyCache::getInstance();
        $gid = $cache->hGet(self::ACTIVATE_GID_KEY, $sid);
        if ($gid === false) {
            $gid = $cache->hGet(self::ACTIVATE_GID_KEY, "def");
        }
        $key = self::ACTIVATE_KEY . $gid;
        $data = $cache->spop($key);
<<<<<<< .mine
        if (!$data || $cache->scard($key) < 19000) { //数据为空，则重新加载一些数据到redis
            if (LockRedis::getLock($cache, self::ACCOUNT_SUO_KEY . date('H:i'), 60)) {
                $sql = "select id,email,apple_pwd,last_name,first_name,province,province_idx,city,postal,street1,street2,street3,activate_client  from apple_id_product where apple_state =0 and  fetch_time is null and saled_datetime is null  and group_id='{$gid}' order by id  limit 90000";
=======
        if (!$data || $cache->scard($key) < 2000) { //数据为空，则重新加载一些数据到redis
            if (LockRedis::getLock($cache, self::ACCOUNT_SUO_KEY . date('H'), 120)) {
                set_time_limit(0);
                $sql = "select id,email,apple_pwd,last_name,first_name,province,province_idx,city,postal,street1,street2,street3,activate_client  from apple_id_product where apple_state =0 and  fetch_time is null and saled_datetime is null  and group_id='{$gid}' order by id  limit 50000";
>>>>>>> .r48822
                $data = JoyDb::query($sql, "aso_ios_account");
<<<<<<< .mine
                //$cache->lPush('getAppleIdP_debug', $sql);
                //$cache->lPush('getAppleIdP_debug', count($data));

                if (count($data) < 2000) {
                    $day = date("Y-m-d H:i:s", time() - 3600);
                    $sql = "select id,email,apple_pwd,last_name,first_name,province,province_idx,city,postal,street1,street2,street3,activate_client  from apple_id_product where apple_state in (0,2,6)  and  fetch_time< '{$day}' and saled_datetime is null and group_id='{$gid}'  limit 90000";
=======
                //$cache->lPush('getAppleIdP_debug', $sql);
                //$cache->lPush('getAppleIdP_debug', count($data));

                if (count($data) < 1000) {
                    $day = date("Y-m-d H:i:s", time() - 3600);
                    $sql = "select id,email,apple_pwd,last_name,first_name,province,province_idx,city,postal,street1,street2,street3,activate_client  from apple_id_product where apple_state in (0,2,6)  and  fetch_time< '{$day}' and saled_datetime is null and group_id='{$gid}'  limit 50000";
>>>>>>> .r48822
                    $data = JoyDb::query($sql, "aso_ios_account");
<<<<<<< .mine
                    //$cache->lPush('getAppleIdP_debug', $sql);
                    //$cache->lPush('getAppleIdP_debug', count($data));
=======
                    $cache->lPush('getAppleIdP_debug', $sql);
                    $cache->lPush('getAppleIdP_debug', count($data));
>>>>>>> .r48822
                }
                if (count($data) < 2000) {
                    $day = date("Y-m-d H:i:s", time() - 3600);
<<<<<<< .mine
                    $sql = "select id,email,apple_pwd,last_name,first_name,province,province_idx,city,postal,street1,street2,street3,activate_client  from apple_id_product where apple_state in (0,2,6) and  fetch_time< '{$day}' and saled_datetime is null  limit 90000";
=======
                    $sql = "select id,email,apple_pwd,last_name,first_name,province,province_idx,city,postal,street1,street2,street3,activate_client  from apple_id_product where apple_state in (0,2,6) and  fetch_time< '{$day}' and saled_datetime is null  limit 50000";
>>>>>>> .r48822
                    $data = JoyDb::query($sql, "aso_ios_account");
<<<<<<< .mine
                    //$cache->lPush('getAppleIdP_debug', $sql);
                    //$cache->lPush('getAppleIdP_debug', count($data));
=======
                    $cache->lPush('getAppleIdP_debug', $sql);
                    $cache->lPush('getAppleIdP_debug', count($data));
>>>>>>> .r48822
                }
                if ($data) {
                    foreach ($data as $t) {
                        $temp = array();
                        $address = (isset($t["city"]) && $t["city"]) ? array() : JoyUtil::getAddressInfo();
                        $temp["email"] = trim($t["email"]);
                        $temp["id"] = $t["id"];
                        $temp["apple_pwd"] = trim($t["apple_pwd"]);
                        $temp["last_name"] = $t["last_name"] ? trim($t["last_name"]) : self::addName();
                        $temp["first_name"] = $t["first_name"] ? trim($t["first_name"]) : $temp["last_name"] . self::addName();
                        $temp["city"] = $t["city"] ? trim($t["city"]) : trim($address["city"]);
                        $temp["postal"] = $t["postal"] ? intval($t["postal"]) : intval($address['postal']);
                        $temp["street1"] = $t["street1"] ? trim($t["street1"]) : trim($address['street1']);
                        $temp["street2"] = $t["street2"] ? trim($t["street2"]) : trim($address['street2']);
                        $temp["street3"] = $t["street3"] ? trim($t["street3"]) : trim($address['street3']);
                        $temp["phone"] = (isset($t["phone_num"]) && $t["phone_num"]) ? trim($t["phone_num"]) : ("1" . rand(3, 5) . rand(0, 8) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9));
                        $temp["province"] = $t["province_idx"] ? intval($t["province_idx"]) : intval($address["province_idx"]);
                        $temp["provinces"] = $t["province"] ? trim($t["province"]) : trim($address["province"]);
                        $temp['spattern_id'] = self::getSpatternId();
                        $ids[] = $t["id"];
                        $cache->sadd($key, $temp);
                    }
<<<<<<< .mine
                    $cache->lPush('getAppleIdP_debug', date('Y-m-dH:i') . ':result=>' . $cache->scard($key));
=======
                    unset($data);
                    $cache->lPush('getAppleIdP_debug', date('Y-m-dH:i') . ':result=>' . $cache->scard($key));
>>>>>>> .r48822
                    $time = date("Y-m-d H:i:s");
                    $id_list = implode(",", $ids);
                    $sql = "update apple_id_product set fetch_time='$time' where id in ($id_list) ";
                    //$cache->lPush('getAppleIdP_debug', $sql);
                    JoyDb::query($sql, "aso_ios_account");
                    $cache->delete(self::ACCOUNT_SUO_KEY . date('H:i'));//删除锁
                    $data = $cache->spop($key);
                    return $data;
                } else {
                    $cache->incr('weixin_send_times' . date('YmdH'), 1);
                    $cache->setExpireTime('weixin_send_times' . date('YmdH'), 86400);
                    $times = $cache->get('weixin_send_times' . date('YmdH'));
                    if ($times <= 3) {
                        self::sendMessage('组ID：' . $gid . ',客户端：' . $sid . '没有任务！北京链接地址：http://regid.hiwechats.com/Appletask/gettask  本公司链接地址： http://regid.hiwechats.com/Mercury?s=eyJzaWQiOiIxOTIuMTY4LjYuMTciLCJ0eXBlIjoyLCJwYXlsb2FkIjoiIiwiZGV2aWNlSWQiOiJmNmY1YzgzNmQ5MzI1YTAzZmYxOTY3YTU2YzY0MWMxMCJ9');
                    }
                    return null;
                }
            }
        }
        return $data;


    }

    public function addName()
    {
        $name = "赵钱孙李周吴郑王冯陈楮卫蒋沈韩杨朱秦尤许何吕施张孔曹严华金魏陶姜戚谢邹喻柏水窦章云苏潘葛奚范彭郎鲁韦昌马苗凤花方俞任袁柳酆鲍史唐费廉岑薛雷贺倪汤滕殷罗毕郝邬安常乐于时傅皮卞齐康伍余元卜顾孟平黄和穆萧尹姚邵湛汪祁毛禹狄米贝明臧计伏成戴谈宋茅庞熊纪舒屈项祝董梁杜阮蓝闽席季麻强贾路娄危江童颜郭梅盛林刁锺徐丘骆高夏蔡田樊胡凌霍虞万支柯昝管卢莫经房裘缪干解应宗丁宣贲邓郁单杭洪包诸左石崔吉钮龚程嵇邢滑裴陆荣翁荀羊於惠甄麹家封芮羿储靳汲邴糜松井段富巫乌焦巴弓牧隗山谷车侯宓蓬全郗班仰秋仲伊宫宁仇栾暴甘斜厉戎祖武符刘景詹束龙叶幸司韶郜黎蓟薄印宿白怀蒲邰从鄂索咸籍赖卓蔺屠蒙池乔阴郁胥能苍双闻莘党翟谭贡劳逄姬申扶堵冉宰郦雍郤璩桑桂濮牛寿通边扈燕冀郏浦尚农温别庄晏柴瞿阎充慕连茹习宦艾鱼容向古易慎戈廖庾终暨居衡步都耿满弘匡国文寇广禄阙东欧殳沃利蔚越夔隆师巩厍聂晁勾敖融冷訾辛阚那简饶空曾毋沙乜养鞠须丰巢关蒯相查后荆红游竺权逑盖益桓公";
        preg_match_all("/./us", $name, $match);
        $r = array_rand($match[0]);
        return $match[0][$r];
    }


    /**
     * 取地址信息加到redis中
     */
    public function getAddressInfo()
    {
        $cache = JoyCache::getInstance();
        $address = $cache->spop(self::ADDRESS_INFO_KEY);
        if (!$address) {
            $sql = "SELECT province,province_idx,city,postal,street1 FROM address_info";
            $data = JoyDb::query($sql, "aso_ios_account");
            if ($data) {
                foreach ($data as $t) {
                    $temp = array();
                    $temp["province"] = $t["province"];
                    $temp["province_idx"] = $t["province_idx"];
                    $temp["city"] = $t["city"];
                    $temp["postal"] = $t["postal"];
                    $temp["street1"] = $t["street1"];
                    $cache->sadd(self::ADDRESS_INFO_KEY, $temp);
                }
            }
            $address = $cache->spop(self::ADDRESS_INFO_KEY);
        }
        $add = array("号", "栋", "单元");
        $n1 = rand(0, 2);
        $n2 = rand(10, 2000);
        $n3 = rand(1, 15);
        $n4 = rand(1, 6);
        $address["street2"] = $address["street1"] . $n2 . $add[$n1];
        $address["street3"] = $n3 . "0" . $n4 . "室";
        $address["phone"] = ("1" . rand(3, 5) . rand(0, 8) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9));
        return $address;
    }

    private function sendMessage($content)
    {
        $user = "hujiajia|wushaoliang";
        $now = date('H:i:s');
        $content = $now . " [(杭州服务器)获取任务预警]\n\n" . $content;
        $send = 'http://union_letang.joymeng.com/index.php?m=Home&c=SendMessage&a=sendTextMessage&admin=lt&';
        $send = $send . 'user=' . $user . '&content=' . urlencode($content);
        @file_get_contents($send);
    }


    private function getSpatternId()
    {
        $array = array(0, 1, 2, 3, 4, 5, 6);
        shuffle($array);
        return intval(implode("", $array));
    }

    /*
 * 获得访问者IP
 */
    public static function getClientIp()
    {
        if (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (isset($_COOKIE['SERVER_ADDR'])) {
            $ip = $_COOKIE['SERVER_ADDR'];
        } else if (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } else if (getenv("Real_IP")) {
            $ip = getenv("Real_IP");
        }
        return $ip;
    }

    public static function getSvrIp()
    {
        return gethostbyname($_SERVER["SERVER_NAME"]);
    }

    public static function getAddressNew($ip = 0)
    {

        static $ipLocation;
        if ($ipLocation === null) {
            require_once("IpLocation.class.php");
            $ipLocation = new IpLocation();
        }

        if (!$ip) {
            $ip = self::getClientIp();
        }
        $data = $ipLocation->getLocation($ip);
        print_r($data);
        $iccid = JoyManager::getRequest("iccid", NULL);
        echo $iccid;
        if ($iccid) {
            $city = ICCID::getCityByICCID($iccid);
            print_r($city);
            if (!strstr($data['country'], $city)) {
                $data['country'] = $city;
            }
        }
        return $data;
    }


    public static function getCityByPhone($mobile)
    {
        $ch = curl_init();
        $header = array("apikey:b4243466dc9222d0813a6db087388eab",);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $url = 'http://apis.baidu.com/apistore/mobilenumber/mobilenumber?phone=' . $mobile;
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);
        $result = json_decode($res, true);
        print_r($result);
        if (isset($result['retData'])) {
            $city = $result['retData']['province'] . $result['retData']['city'];
            return $city;
        }
        return $res;

    }

    public static function getAddress($ip = 0)
    {

        $ct = self::getCityByIccid();
        if ($ct) {
            $city = array('country' => $ct);
            return $city;
        }

        static $ipLocation;
        if ($ipLocation === null) {
            require_once("IpLocation.class.php");
            $ipLocation = new IpLocation();
        }

        if (!$ip) {
            $ip = self::getClientIp();
        }
        $city = $ipLocation->getLocation($ip);
//        if ($city['country'] == "中国"){
//        	$data = file_get_contents("http://test.ip138.com/query/?ip=$ip");
//        	$data = json_decode($data,true);
//        	$data['ret'] == "ok"? $city['country'] = $data['data'][1].$data['data'][2]:"";
//        }
        return $city;
    }

    public static function getExactAddress($param)
    {
        if (!is_array($param)) return '';
        //基站 43153409 9447    102388490 9534   84714261 20989
        $requireData['cell_id'] = $param['cellId'];
        $requireData['lac'] = $param['lac'];
        $requireData['mcc'] = 460;
        $requireData['mnc'] = $param['sId'] ? $param['sId'] : 0;
        $requireData['signalstrength'] = -60;
        $requestdataArr['celltowers'][] = $requireData;
        $requestdataArr['mnctype'] = 'gsm';
        $url = 'http://api.haoservice.com/api/viplbs?requestdata=' . json_encode($requestdataArr) . '&type=0&key=2ca42247b71e4b9b888f618527dfee5c';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 执行HTTP请求
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);
        $returnInfo = json_decode($res, true);
        if ($returnInfo['location']['ErrCode'] == 0) {
            //生成基站缓存信息以及存储基站数据缓存信息
            $city = $returnInfo['location']['address']['region'] . $returnInfo['location']['address']['city'];
            if ($city) return $city;
        }

        //根据手机号取地址(省份)
        $cache = JoyCacheLTUN::getInstance();
        $keyc = "game_city_phone_all";
        $tel = substr($param['phone'], 0, 7);
        $city = $cache->hGet($keyc, $tel);
        if ($city) return $city;

//        根据IMSI取地址(省份)  460029569009251 460079055153801 460078560515213 460022797015410
        $key_imsi = "gameIdList_All_IMSI_CITY";
        $imsi = substr($param['imsi'], 3, 8);
        $city = $cache->hGet($key_imsi, $imsi);
        if ($city) return $city;

        //iccid
        $ct = self::getCityByIccid();
        if ($ct) {
            return $ct;
        }

        //ip
        $ip = $param['ip'];
        static $ipLocation;
        if ($ipLocation === null) {
            require_once("IpLocation.class.php");
            $ipLocation = new IpLocation();
        }

        if (!$ip) {
            $ip = self::getClientIp();
        }
        $city = $ipLocation->getLocation($ip);
        return $city['country'];
    }


    public static function getAddressNews($ip = 0)
    {
        static $ipLocation;
        if ($ipLocation === null) {
            require_once("IpLocation.class.php");
            $ipLocation = new IpLocation();
        }
        if (!$ip) {
            $ip = self::getClientIp();
        }
        $city = $ipLocation->getLocation($ip);
        $ct = self::getCityByIccid();
        return $city['country'] . $ct;
    }


    public static function getCityByIccid()
    {
        $iccid = isset($_REQUEST['iccid']) ? $_REQUEST['iccid'] : 0;
        if ($iccid) {
            $op = substr($iccid, 0, 6);
            if ($op == 898600 || $op == 898602) {//移动
                $city = array("01" => '北京', "02" => '天津', "03" => '河北', "04" => '山西', "05" => '内蒙古', "06" => '辽宁', "07" => '吉林',
                    "08" => '黑龙江', "09" => '上海', "10" => '江苏', "11" => '浙江', "12" => '安徽', "13" => '福建', "14" => '江西', "15" => '山东',
                    "16" => '河南', "17" => '湖北', "18" => '湖南', "19" => '广东', "20" => '广西', "21" => '海南', "22" => '四川', "23" => '贵州', "24" => '云南',
                    "25" => '西藏', "26" => '陕西', "27" => '甘肃', "28" => '青海', "29" => '宁夏', "30" => '新疆', "31" => '重庆');
                $pi = substr($iccid, 8, 2);
                if (isset($city[$pi])) {
                    return $city[$pi];
                } else  return null;
            }
            if ($op == 898601 || $op == 898609) {//中国联通
                return null;
            }
            if ($op == 898603 || $op == 898606) {//中国电信
                $pi = substr($iccid, 9, 3);
                $city = JoyCache::getInstance()->get("GAME_ICCID_LIST");
                if (isset($city[$pi])) return $city[$pi];
                else  return null;
            }
        }
        return null;
    }


    /**
     * 取得系统时间
     * @param $showInt 1|0 13位，精确至毫秒|String
     * @return unknown_type
     */
    public static function getSysTime($showInt = false)
    {
        if ($showInt) {
            $rs = microtime(1);
            return intval($rs * 1000);
        }
        $now = date("Y-m-d H:i:s");
        return $now;
    }

    /**
     * 取得规定格式的时间。
     * @param $int_time
     * @return string
     */
    public static function getTime($int_time)
    {
        return date("Y-m-d H:i:s", $int_time);
    }

    /**
     * 两个时间的天数差。
     * @param $date1
     * @param $date2 null 表示今天
     * @return int 天数
     */
    public static function getDateDiff($date1, $date2 = null)
    {
        $date1 = strtotime(date("Y-m-d", strtotime($date1)));
        if (!$date2) {
            $date2 = strtotime(date("Y-m-d"));
        } else {
            $date2 = strtotime(date("Y-m-d", strtotime($date2)));
        }
        return round(abs($date1 - $date2) / 86400);
    }

    /**
     * 两个时间(整型)的天数差。
     * @param $int_date1 秒
     * @param $int_date2 秒
     * @return unknown_type
     */
    public static function getDayDiff($int_date1, $int_date2 = null)
    {
        $int_date1 = strtotime(date("Y-m-d", $int_date1));
        if (!$int_date2) {
            $int_date2 = strtotime(date("Y-m-d"));
        } else {
            $int_date2 = strtotime(date("Y-m-d", $int_date2));
        }
        return round(abs($int_date1 - $int_date2) / 86400);
    }

    /**
     * 两个时间的时差.
     * @param $time1
     * @param $time2 null 表示今天凌晨
     * @return unknown_type
     */
    public static function getTimeDiff($time1, $time2 = null)
    {
        if (!$time2) {
            $time2 = "0:0";
        }
        return strtotime($time1) - strtotime($time2);
    }

    /**
     * 当前时刻是不是在所规定的区间
     * @param unknown_type $begin_time
     * @param unknown_type $end_time
     */
    public static function timeAmong($begin_time, $end_time)
    {
        $int_now = time();
        if ($int_now > strtotime($begin_time)
            && $int_now < strtotime($end_time)
        ) {
            return true;
        }
        return false;
    }

    /**
     * 按要求格式化时间 （今天和昨天显示文字）
     * @param $int_time
     */
    public static function formatTime_need($int_time)
    {
        $t = self::getDayDiff($int_time);
        if ($t == 0) {
            return '今天 ' . date("H:i:s", $int_time);
        }
        if ($t == 1) {
            return '昨天 ' . date("H:i:s", $int_time);
        }
        return self::getTime($int_time);
    }

    /**
     * 获取当天的开始和结束时间戳
     */
    public static function getBegainAndEndOfDay()
    {
        $year = date("Y");
        $month = date("m");
        $day = date("d");
        $dayBegin = mktime(0, 0, 0, $month, $day, $year);//当天开始时间戳
        $dayEnd = mktime(23, 59, 59, $month, $day, $year);//当天结束时间戳
        return array($dayBegin, $dayEnd);
    }

    /**
     * 返回一个概率数组的索引
     * @param $prob_array 概率数组。该数组的索引通常都有特定的含义。
     * @return int
     */
    public static function getKeyByProbArray($prob_array, $max = 100)
    {
        $rand = rand(1, $max);
        $min = 1;
        foreach ($prob_array as $key => $e) {
            if ($rand >= $min && $rand < ($max = $min + $e)) {
                return $key;
            }
            $min = $max;
        }
    }

    /**
     * 获得关联数组中某个属性=$id的数量
     * @param  $array 数组
     * @param  $attr 属性
     * @param  $id  数值
     */
    public static function getNumArray($array, $attr, $id)
    {
        $total = 0;
        foreach ($array as $m) {
            if ($m[$attr] == $id) {
                $total++;
            }
        }
        return $total;
    }

    /**
     * 从一个数组中随机取出指定数量的元素。
     * @param array $input
     * @param $num
     * @return array
     */
    public static function getRandArrayElements(array $input, $num = 1)
    {
        $num > ($len = count($input)) && $num = $len;
        $keys = array_rand($input, $num);
        if ($num == 1) {
            return array($keys => $input[$keys]);
        }
        foreach ($keys as $e) {
            $output[$e] = $input[$e];
        }
        return $output;
    }

    public static function getRandArrayElementsNo(array $input, $num = 1)
    {
        $len = count($input);
        $num > $len ? $num = $len : '';
        if ($num < 0) {
            return;
        }
        $keys = array_rand($input, $num);
        if ($num == 1) {
            return array($keys => $input[$keys]);
        }
        foreach ($keys as $e) {
            $output[] = $input[$e];
        }
        return $output;
    }

    /**
     * 从一个数组中随机取出单个元素，并返回该元素的值(不关注下标，默认返回单个元素)。
     * @param array $arr
     * @return elements  or array
     */
    public static function getRandMemberByArray(array $input, $num = 1)
    {
        $num > ($len = count($input)) && $num = $len;
        $keys = array_rand($input, $num);
        if ($num == 1) {
            return $input[$keys];
        }
        foreach ($keys as $e) {
            $output[] = $input[$e];
        }
        return $output;
    }

    /**
     * 概率
     * @param $num 分子值
     * @param $type 0表示百分制，1表示千分制
     * @return boolean
     */
    public static function prob($num, $type = 0)
    {
        if ($type == 0) {
            if (rand(1, 100) <= $num)
                return true;
        } else if ($type == 1) {
            if (rand(1, 1000) <= $num)
                return true;
        }
        return false;
    }

    /**
     * 概率
     * @param $decimal
     * @return boolean
     */
    public static function probility($decimal)
    {
        $num = $decimal * 10000;
        if (rand(1, 10000) <= $num) {
            return true;
        }
        return false;
    }

    //public static function json_encode($value) {
    //	return json_encode($value);
    //}

    //public static function json_decode($json) {
    //	return json_decode($json, true);
    //}

    public static function serialize($value)
    {
        return igbinary_serialize($value);
    }

    public static function unserialize($value)
    {
        return igbinary_unserialize($value);
    }

    /**
     * 数组取反
     * @param $array
     * @return array
     */
    public static function array_negative($array)
    {
        foreach ($array as &$e) {
            $e = -$e;
        }
        return $array;
    }

    public static function explode($delimiter, $str)
    {
        if (!$str) {
            return null;
        }
        return explode($delimiter, $str);
    }

    /**
     * 产生随机字符
     * @param $length
     * @return string
     */
    public static function random_str($length)
    {
        if ($length > 0) {
            $str = '0123456789abcdefghijklmnopqrstuvwxyz';
            $tmp = '';
            for ($i = 0; $i < $length; $i++) {
                $r = rand(0, strlen($str) - 1);
                $tmp .= $str[$r];
            }
            return $tmp;
        }
    }


    public static function random_hex($length)
    {
        if ($length > 0) {
            $str = '0123456789abcdef';
            $tmp = '';
            for ($i = 0; $i < $length; $i++) {
                $r = rand(0, strlen($str) - 1);
                $tmp .= $str[$r];
            }
            return $tmp;
        }
    }

    /**
     * 格式化时间
     * @param $old_time
     * @return string
     */
    public static function format_time($old_time)
    {
        $curr = self::getSysTime(true);
        $old_time = strtotime($old_time);
        $str = '';
        $time = ($curr - $old_time) / 3600;
        if ($time > 24) {
            $str = date('m月d日 H:i', $old_time);
        } else {
            $str = date('H:i', $old_time);
        }
        return $str;
    }

    /**
     *
     * @return unknown_type
     */
    public static function send_mail()
    {

    }

    /**
     * 根据时间的先后顺序排序数组
     * @param $array1
     * @param $array2
     * @return array
     */
    public static function cmp_array($array1, $array2)
    {
        $array = array_merge($array1, $array2);
        for ($i = 0; $i < count($array); $i++) {
            for ($j = $i + 1; $j < count($array); $j++) {
                if ($array [$i] ['send_time'] < $array [$j] ['send_time']) {
                    $tmp = $array [$j];
                    $array [$j] = $array [$i];
                    $array [$i] = $tmp;

                }
            }
        }
        return $array;
    }

    public static function outWeek($array)
    {
        $weekarray = array("日", "一", "二", "三", "四", "五", "六");
        $string = "周";
        foreach ($array as $temp) {
            $string .= $weekarray[$temp] . ",";
        }
        return substr($string, 0, -1);
    }

    /**
     * 过滤敏感字符
     * @param $str
     * @return string | false
     */
    public static function filter_str($str)
    {
        include_once 'str.php';
        foreach ($arr as $e) {
            if (@eregi($e, $str)) {
                return $e;
            }
        }
        return false;
    }

    /**
     * 删除给定
     * @param $needle
     * @param $arr
     * @return unknown_type
     */
    public static function array_remove($needle, array &$arr)
    {
        foreach ($arr as $key => $e) {
            if ($e == $needle) {
                unset($arr[$key]);
            }
        }
    }

    /**
     * 随机一个不等于$exclude的数字
     * @param int $min
     * @param int $max
     * @param int $exclude [$min, $max]
     */
    public static function rand($min, $max, $exclude = 0)
    {
        /*
         if (!$exclude
         || $exclude < $min
         || $exclude > $max
         || $min > $max) {
            return rand($min, $max);
            }
            if (self::prob(50)) {
            return rand($min, $exclude - 1);
            }
            return rand($exclude + 1, $max);
            */
        if (!$exclude
            || $exclude < $min
            || $exclude > $max
        ) {
            return rand($min, $max);
        }
        if ($exclude == $min) {
            return rand($min + 1, $max);
        }
        if ($exclude == $max) {
            return rand($min, $max - 1);
        }
        if (self::prob(50)) {
            return rand($min, $exclude - 1);
        }
        return rand($exclude + 1, $max);
    }

    /**
     * 二维数组排序，类似于 order by ...
     * @param array $ArrayData
     * @param $KeyName 例如 $KeyName 值为  "id","SORT_ASC","SORT_STRING","name","SORT_ASC"....     *
     *
     * 排序顺序标志：
     * SORT_ASC - 按照上升顺序排序
     * SORT_DESC - 按照下降顺序排序
     * 排序类型标志：
     * SORT_REGULAR - 将项目按照通常方法比较
     * SORT_NUMERIC - 将项目按照数值比较
     * SORT_STRING - 将项目按照字符串比较
     */
    public static function multisortArray($ArrayData, $KeyName)
    {
        if (!is_array($ArrayData)) {
            return $ArrayData;
        }
        // Get args number.
        $ArgCount = func_num_args();
        // Get keys to sort by and put them to SortRule array.
        for ($I = 1; $I < $ArgCount; $I++) {
            $Arg = func_get_arg($I);
            if (substr($Arg, 0, 5) != 'SORT_') {
                $KeyNameList[] = $Arg;
                $SortRule[] = '$' . $Arg;
            } else {
                $SortRule[] = $Arg;
            }
        }
        // Get the values according to the keys and put them to array.
        foreach ($ArrayData AS $Key => $Info) {
            foreach ($KeyNameList AS $KeyName) {
                ${$KeyName}[$Key] = $Info[$KeyName];
            }
        }
        // Create the eval string and eval it.
        $EvalString = 'array_multisort(' . join(",", $SortRule) . ',$ArrayData);';
        eval ($EvalString);
        return $ArrayData;
    }

    /**
     * "hello_kitty" -> "Hello_Kitty"
     */
    public static function ucwords_all($str)
    {
        $str_ar = explode('_', $str);
        foreach ($str_ar as &$e) {
            $e = ucwords($e);
        }
        $str = implode('_', $str_ar);
        return $str;
    }

    /**
     * 取得目录下所有文件
     * @param String $dir
     * @param String $extension ex: xml or js etc.
     */
    public static function files($dir, $extension = null)
    {
        $files = array();
        if (!is_dir($dir)) {
            return $files;
        }
        $handle = opendir($dir);
        if ($handle) {
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..') {
                    $filename = $dir . "/" . $file;
                    if (is_file($filename)) {
                        if ($extension) {
                            if (pathinfo($filename, PATHINFO_EXTENSION) == $extension) {
                                $files[] = $filename;
                            }
                        } else {
                            $files[] = $filename;
                        }
                    } else {
                        $files = array_merge($files, self::files($filename, $extension));
                    }
                }
            }
            closedir($handle);
        }
        return $files;
    }

    /**
     *
     * Enter description here ...
     * @param unknown_type $file
     */
    public static function file_extension($file)
    {
        return pathinfo($file, PATHINFO_EXTENSION);
    }

    //这个星期的星期一
    // @$timestamp ，某个星期的某一个时间戳，默认为当前时间
    // @is_return_timestamp ,是否返回时间戳，否则返回时间格式
    public static function this_monday($form = 'Ymd')
    {
        $week = date('w');
        return date($form, strtotime('+' . 1 - $week . ' days'));

    }

    //这个星期的星期天
    // @$timestamp ，某个星期的某一个时间戳，默认为当前时间
    // @is_return_timestamp ,是否返回时间戳，否则返回时间格式
    public static function this_sunday($form = 'Ymd')
    {
        $week = date('w');
        return date($form, strtotime('+' . 7 - $week . ' days'));
    }

    public static function this_friday($form = 'Ymd')
    {
        $week = date('w');
        return date($form, strtotime('+' . 5 - $week . ' days'));
    }


    /**
     * Passport 加密函数
     *
     * @param                string                等待加密的原字串
     * @param                string                私有密匙(用于解密和加密)
     *
     * @return        string                原字串经过私有密匙加密后的结果
     */
    public static function passport_encrypt($txt, $key)
    {

        // 使用随机数发生器产生 0~32000 的值并 MD5()
        $encrypt_key = md5(rand(0, 32000));
        // 变量初始化
        $ctr = 0;
        $tmp = '';

        // for 循环，$i 为从 0 开始，到小于 $txt 字串长度的整数
        for ($i = 0; $i < strlen($txt); $i++) {
            // 如果 $ctr = $encrypt_key 的长度，则 $ctr 清零
            $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
            // $tmp 字串在末尾增加两位，其第一位内容为 $encrypt_key 的第 $ctr 位，
            // 第二位内容为 $txt 的第 $i 位与 $encrypt_key 的 $ctr 位取异或。然后 $ctr = $ctr + 1

            $tmp .= $encrypt_key[$ctr] . ($txt[$i] ^ $encrypt_key[$ctr++]);
        }

        // 返回结果，结果为 passport_key() 函数返回值的 base65 编码结果
        return base64_encode(self::passport_key($tmp, $key));

    }

    /**
     * Passport 解密函数
     *
     * @param                string                加密后的字串
     * @param                string                私有密匙(用于解密和加密)
     *
     * @return        string                字串经过私有密匙解密后的结果
     */
    public static function passport_decrypt($txt, $key)
    {

        // $txt 的结果为加密后的字串经过 base64 解码，然后与私有密匙一起，
        // 经过 passport_key() 函数处理后的返回值
        $txt = self::passport_key(base64_decode($txt), $key);

        // 变量初始化
        $tmp = '';
        // for 循环，$i 为从 0 开始，到小于 $txt 字串长度的整数
        for ($i = 0; $i < strlen($txt); $i++) {
            // $tmp 字串在末尾增加一位，其内容为 $txt 的第 $i 位，
            // 与 $txt 的第 $i + 1 位取异或。然后 $i = $i + 1
            $tmp .= $txt[$i] ^ $txt[++$i];
        }

        // 返回 $tmp 的值作为结果
        return $tmp;

    }

    /**
     * Passport 密匙处理函数
     *
     * @param                string                待加密或待解密的字串
     * @param                string                私有密匙(用于解密和加密)
     *
     * @return        string                处理后的密匙
     */
    public static function passport_key($txt, $encrypt_key)
    {
        $encrypt_key = md5($encrypt_key);
        $ctr = 0;
        $tmp = '';
        for ($i = 0; $i < strlen($txt); $i++) {
            $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
            $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
        }
        return $tmp;
    }

    public static function decodeScore($txt, $key)
    {
        $txt = base64_decode($txt);
        $md5 = md5($key);
        $result = str_replace($md5, "", $txt);
        return $result;
    }

    public static function encodeScore($txt, $key)
    {
        $md5 = md5($key);
        $txt = $md5 . $txt;
        return base64_encode($txt);
    }

    public static function utf8Substr($str, $from, $len)
    {
        return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $from . '}' .
            '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $len . '}).*#s',
            '$1', $str);
    }

    public static function dataformat($num)
    {
        $hour = floor($num / 3600);
        $minute = floor(($num - 3600 * $hour) / 60);
        $second = floor((($num - 3600 * $hour) - 60 * $minute) % 60);
        return $hour . '时' . $minute . '分' . $second . '秒';
    }

    function rad($d)
    {
        return $d * 3.1415926535898 / 180.0;
    }

    public static function GetDistance($lat1, $lng1, $lat2, $lng2)
    {
        $EARTH_RADIUS = 6378137; //米
        $radLat1 = self::rad($lat1);
        //echo $radLat1;
        $radLat2 = self::rad($lat2);
        $a = $radLat1 - $radLat2;
        $b = self::rad($lng1) - self::rad($lng2);
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) +
                cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        $s = $s * $EARTH_RADIUS;
        $s = round($s * 10000) / 10000;
        return $s;
    }

}
