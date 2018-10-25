<?php
/**
 * @name ArticleModel
 * @desc 获取文章Model类
 * @author FangAolin
 */
class ArticleModel {

    protected $redis;
    protected $config;

    public function __construct()
    {
        $this->redis = JoyCache::getInstance();
        $this->config = new Yaf_Config_Ini(CONFIG_INI, 'product');
    }


    /**
     * 得到文章标题信息
     * @param $appid
     * @param int $count
     * @param int $page
     * @return array|bool
     */
    public function getTitle($appid, $count= 6 , $page= 1 )
    {
        $page = $page-1;
        $start = $page * $count;
        $start = intval($start);
        $count = intval($count);
        $querySql = "SELECT art_id,art_tit,art_img,art_cate FROM `".trim($appid)."` where art_status=2 order by `art_order`,`art_addtime` desc limit {$start},{$count}";
        $res = JoyDb::query($querySql);
        return $res;
    }

    /**
     * 随机位置得到文章标题信息
     * @param $appid
     * @param int $count
     * @return array|bool
     */
    public function getRand($appid, $count= 6)
    {
        $count = intval($count);
        $querySql = "SELECT art_id,art_tit,art_img,art_cate FROM `".trim($appid)."` where art_status=2 ORDER BY RAND() LIMIT {$count}";
        $res = JoyDb::query($querySql);
        return $res;
    }


    /**
     * 随机得到同类推荐文章
     * @param $appid
     * @param $cate
     * @param int $count
     * @return array|bool
     */
    public function getRandomRecommended($appid,$cate,$count = 6)
    {
        $count = intval($count);
        $cate = intval($cate);
        $querySql = "SELECT art_id,art_tit,art_img,art_cate,DATE_FORMAT(art_addtime,'%Y-%m-%d') as art_addtime FROM `".trim($appid)."` where art_status=2 and art_cate= {$cate} ORDER BY RAND() LIMIT {$count}";
        $res = JoyDb::query($querySql);
        return $res;
    }


    /**
     * 得到文章内容
     * @param $appid
     * @param $articleID
     * @return array|bool
     */
    public function getArticle($appid,$articleID)
    {
        $sql = "SELECT *,DATE_FORMAT(art_addtime,'%Y-%m-%d') as art_addtime FROM `".trim($appid)."` where `art_id` = ? order by `art_addtime` ";
        $res = JoyDb::query($sql,array(trim($articleID)));
        $res[0]['art_content'] = $this->filterPictures($res[0]['art_content']);
        return $res;
    }


    /**
     * 将文本中相对路径换成绝对路径
     * @param $content
     * @return mixed
     */
    public function filterPictures($content)
    {
        $content = str_replace("data-src",'src',$content);
        $content = htmlspecialchars_decode($content);
        preg_match_all('/<img [^\>]*src="([^\']*)"[^\']*\/>/iU',$content, $content_img_arr);
        $content_img_arr=$content_img_arr[1];
        $content_img_arr = array_unique($content_img_arr);
        foreach ($content_img_arr as $row){
            $content = str_replace($row,$this->config->wechat->imgBase.'/'.$row,$content);
        }
        $content = str_replace("http://newsadmin.hmset.comhttp://newsadmin.hmset.com","http://newsadmin.hmset.com",$content);
        $content = str_replace("http://newsadmin.hmset.comhttp","http",$content);
        $content = str_replace("=\"/uploads","=\"http://newsadmin.hmset.com/uploads",$content);
        $content = str_replace("<section>","",$content);
        $content = str_replace("</section>","",$content);
        $content = str_replace("line-height","marker-mid",$content);
        $content = str_replace("em","px",$content);
        $content = str_replace("&amp;nbsp;"," ",$content);
        $content = str_replace("宋体","'SimSun'",$content);
        $content = str_replace("微软雅黑","'Microsoft YaHei'",$content);
        return $content;
    }


    /**
     * 得到热版文章
     * @param $appid
     * @param int $count
     * @param int $page
     * @return array|bool
     */
    public function getHotArticle($appid, $count= 6 , $page= 1 )
    {
        $page = $page-1;
        $start = $page * $count;
        $start = intval($start);
        $count = intval($count);
        $querySql = "SELECT art_id,art_tit,art_img,art_cate FROM `".trim($appid)."` WHERE `art_cate`=23 order by `art_addtime`,`art_view` desc limit {$start},{$count}";
        $res = JoyDb::query($querySql);
        return $res;
    }


}
