<?php
/**
 * @name BoxModel
 * @desc 游戏盒子Model类
 * @author FangAolin
 */
class BoxModel {

    protected $redis;
    protected $config;

    public function __construct()
    {
        $this->redis = JoyCache::getInstance();
        $this->config = new Yaf_Config_Ini(CONFIG_INI, 'product');
    }

    /**
     * 得到新的游戏
     */
    public function getGame($app)
    {
        $sql = "SELECT * FROM `box_game` WHERE apps like '%".trim($app)."%' ORDER BY `sort` DESC ";
        $res = JoyDb::query($sql);
        if ($res){
            $newGame = array();
            $indexGame = array();
            $baseUrl = $this->config->wechat->imgBase;
            foreach ($res as $row){
                if ($row['nav_type'] == 1){
                    $row['code_img'] = 'null';
                }else{
                    $row['app_id'] = 'null';
                    $row['path'] = 'null';
                }
                if (!$row['tag'])
                    $row['tag'] = 'null';
                $row['icon_url'] = $baseUrl.$row['icon_url'];
                if (!$row['app_id']){
                    $row['app_id'] = 'null';
                }

                if ($row['is_new'] == 1)
                    $newGame[] = $row;
                $indexGame[$row['game_type']][] = $row;
            }
            return array('new'=>$newGame,'index'=>$indexGame);
        }else
            return false;
    }

    public function getGameType($app)
    {
        $sql = "SELECT cate_id,cate_name FROM box_category where cate_apps like '%{$app}%'";
        $res = JoyDb::query($sql);
        if ($res){
            return $res;
        }else
            return false;
    }




}
