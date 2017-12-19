<?php
//日志表
namespace Home\Controller;
class LogController extends BaseController
{
    public static function i($info, $tag = 0, $name='')
    {
        self::systemLog($info, $tag, 1, $name);
    }

    public static function e($info, $tag = 0, $name='')
    {
        self::systemLog($info, $tag, 0, $name);
    }

    /*
     * $tag 标签  C("LOG_TAG")  默认：0,系统错误
     * $success  1：成功信息  2：错误信息
     * $info string 信息内容
     */

    private static function systemLog($info, $tag, $success, $name)
    {
        $s['info'] = $info;
        $s['runtime'] = getRuntime();
        $s['uid'] = getAdminId() ? getAdminId() : $name;
        $s['module'] = MODULE_NAME;
        $s['action'] = ACTION_NAME;
        $s['tag'] = getKeyByValue('LOG_TAG', (string)$tag);
        $s['success'] = $success;
        $s['create_time'] = time();
        $s['ip'] = get_client_ip();
        $s['login_url'] = $_SERVER['SERVER_NAME'];
        $db = M(TABLE_SYSTEM_LOG);
        $db->add($s);
    }

    static function getAllTag()
    {
        $db = M(TABLE_SYSTEM_LOG);
        $data = $db->field("tag")->group("tag")->select();
        foreach ($data as $v) {
            if (trim($v['tag']) !== '')
                $re[$v['tag']] = $v['tag'];
        }
        return $re;
    }

    static function getIpData()
    {
        $company = ['60.173.241.76','61.190.89.191','218.104.71.178'];
        $data['公司IP'] = arrayToString($company);
        return $data;
    }
}

?>