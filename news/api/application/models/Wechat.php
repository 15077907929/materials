<?php
/**
 * @name WechatModel
 * @desc 用户数据交换Model类
 * @author FangAolin
 */
class WechatModel {

    protected $redis;
    protected $config;

    public function __construct()
    {
        $this->redis = JoyCache::getInstance();
        $this->config = new Yaf_Config_Ini(CONFIG_INI, 'product');
    }

    /**
     * 通过code换取token
     * @param $code
     * @return string
     */
    public function getOpenId($code)
    {
        //先在配置文件中读
        $uri = $this->config->wechat->openid;
        $urlData['appid'] = $this->config->app->appid;
        $urlData['secret'] = $this->config->app->secret;
        $urlData['js_code'] = $code;
        $urlData['grant_type'] = 'authorization_code';
        $response = JoyCurl::curl_get_request($uri,$urlData);
        if ($response) {
            $responseValue = json_decode($response,true);
            if (isset($responseValue['session_key'])){
                $token = $this->getTokenByOpenid($response);
                return $token;
            }
        }
        return false;
    }


    /**
     * 获取TOKEN
     * @param $code
     * @param $appName
     * @return bool|string
     */
    public function getToken($code,$appName)
    {
        //先在配置文件中读
        $uri = $this->config->wechat->openid;
        $urlData['appid'] = trim($appName);
        $urlData['secret'] = $this->config->$appName;
        $urlData['js_code'] = $code;
        $urlData['grant_type'] = 'authorization_code';
        $response = JoyCurl::curl_get_request($uri,$urlData);
        if ($response) {
            $responseValue = json_decode($response,true);
            if (isset($responseValue['session_key'])){
                $token = $this->getTokenByOpenid($response);
                return $token;
            }
        }
        return false;
    }


    /**
     * 保存TOKEN
     * @param $response
     * @return string
     */
    protected function getTokenByOpenid($response)
    {
        $value = json_decode($response,true);
        $common = new Common();
        $token = $common->getToken($value['openid']);
        $prefix = $this->config->prefix->token;
        $this->redis->set($prefix.$token,$response,$this->config->time->session);
        return $token;
    }


    /**
     * 验证
     * @param $token
     * @return bool
     */
    public function varification($token)
    {
        $prefix = $this->config->prefix->token;
        $isExpire = $this->redis->exists($prefix.$token);
        if (!$isExpire){
            return false;
        }else
            return true;
    }


    /**
     * 得到跳转信息
     * 附属应用ID
     * @param $appid
     * 跳转信息
     * @return array|bool
     */
    public function getJumpInfo($appid)
    {
        $sql = "SELECT jump_app_id,path FROM wechat_app_jump where is_jump = 1 and app_id = '{$appid}'";
        $result = JoyDb::query($sql);
        return $result;
    }
    
}
