<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;

use Think\Controller;

class BaseController extends Controller
{
    protected $nav = ''; //分配到模板页的html
    protected $serach = ''; //分配到模板页的html
    protected $main = ''; //分配到模板页的html
    protected $pager = ''; //分配到模板页的html

    private $topNavigation = array();
    private $leftNavigation = array();
    private $leftNavigationSelect = array();

    function __construct()
    {
        parent::__construct();
        header("Content-type:text/html;charset=utf-8");
        debug($_SESSION);
        $this->readConfigFromDb();
        $this->getNavigation();

    }


    private function getNavigation()
    {
        static $assigned = false;
        if (!$assigned) {
            $nav = C('NAVIGATION');
            foreach ($nav as $k => $v) //获取用户权限内所有的导航  左侧导航
            {
                foreach ($v as $k2 => $v2) {

                    //未设置权限，所有人都有权限 ,设置了权限，就验证权限
                    if (!isset($v2['power']) || ( hasAsoRole($v2['power'])) )
                    {
                        //未设置验证方法  或者  设置了方法，切方法返回值为true
                        if( !isset($v2['func']) || $v2['func']() )
                        {
                            $link = $v2['link'];
                            $this->leftNavigation[$k][$k2]['link'] = TableController::createLink($link);

                            $t1 = explode('?', trim($link, '/'));
                            $t2 = explode('/', $t1[0]);
                            $this->leftNavigation[$k][$k2]['c'] = strtolower($t2[0]); //CONTROLLER_NAME  ,控制器名
                            $this->leftNavigation[$k][$k2]['a'] = $t2[1] ? strtolower($t2[1]) : 'index'; //ACTION_NAME  ，方法名
                            $this->leftNavigation[$k][$k2]['p'] = $t1[1] ? $t1[1] : ''; //参数列表
                            if($v2['parent'])
                                $this->leftNavigation[$k][$k2]['parent'] = $v2['parent'];
                        }
                    }
                }
            }
            foreach ($this->leftNavigation as $k => $v) //获取所有顶部导航
            {
                $link = $v[$k]['link'];
                if ($this->topNavigation[$k] === null) {
                    $temp = array_shift($v);
                    $link = $temp['link'];
                }
                $this->topNavigation[$k]['link'] = $link;
            }

            $this->findSelectedNavigation(); //标记当前选中的

            debug($this->topNavigation, "Top navgation");
            debug($this->leftNavigation, "Left navgation");
            $this->filterUnvalidNavigation(); //过滤无效的左边导航
            $this->assign("topNav", $this->topNavigation);
            $this->assign("leftNav", $this->leftNavigationSelect);
            debug($this->topNavigation, "Top navgation");
            debug($this->leftNavigation, "Left navgation");
            debug($this->leftNavigationSelect, "Left navgationSelected");
            $assigned = true;
        }

    }

    private function findSelectedNavigation()
    {
        $c = strtolower(CONTROLLER_NAME);
        $a = strtolower(ACTION_NAME);
        $p = strtolower( html_entity_decode(  I('server.QUERY_STRING') ));
        $urltable = I('get.table');

        foreach ($this->leftNavigation as $k => $v) {
            foreach ($v as $k2 => $v2) {

                if($v2['c'] == $c && $v2['a'] == $a  )
                {
//                    debug("m=home&c={$v2['c']}&a={$v2['a']}&" . $v2['p'] );
//                    debug($p);
                    $rep = str_replace( "m=home&c={$v2['c']}&a={$v2['a']}&" . $v2['p'] , '' , $p) ;
//                    debug($rep);
//                    debug($v2);
                    if(( $rep == "" || strpos($rep , "&") === 0))
                    {
                        $this->leftNavigation[$k][$k2]['selected'] = true;
                        $this->topNavigation[$k]['selected'] = true;
                        return;
                    }

                }
            }
        }


        //如果遍历一遍都未找到 ,那么元素的第一个作为默认选中项
        foreach ($this->leftNavigation as $k => $v) {
            foreach ($v as $k2 => $v2) {
                if($v2['c'] == $c && $v2['a'] == $a && ( ($v2['p'] == "" || strpos($p, $v2['p']) !== false) ) )
                {
                    $this->leftNavigation[$k][$k2]['selected'] = true;
                    $this->topNavigation[$k]['selected'] = true;
                    return;
                }
            }
        }

        //dump('遍历一遍都未找到 ,那么元素的第一个作为默认选中项');
//        $keys = array_keys($this->topNavigation);
//        $this->topNavigation[$keys[0]]['selected'] = true;
//        $keys2 = array_keys($this->leftNavigation[$keys[0]]);
//        $this->leftNavigation[$keys[0]][$keys2[0]]['selected'] = true;

    }

    protected  function getFristNavigation()
    {
        foreach($this->leftNavigation as $k=>$v)
        {
            foreach($v as $v2)
            {
                    return $v2['link'];
            }
        }
    }

    /**
     *过滤不属于当前顶部选中的navgation
     */
    private function filterUnvalidNavigation()
    {
        $find = null;
        foreach ($this->topNavigation as $k => $v) {
            if ($v['selected'] == true) {
                $find = $k;
                break;
            }
        }
        $t = $this->leftNavigation;
        $this->leftNavigationSelect = $t[$find];
    }

    /**
     * 从系统配置表读取配置
     */
    private function readConfigFromDb()
    {
        static $readed = false;
        if (!$readed) {
            $data = getSystemConfig();
            debug($data, "从数据库读取的配置文件");
            $conf = array();
            foreach ($data as $v) {

                $t = isJson($v['v']) ? json_encode($v['v']) : $v['v'];
                C($v['k'], $t);
                debug($t, "数据库读取配置：{$v['k']}");
            }
        }
        $readed = true;
    }

    function _out()
    {
//		$this->con['nav'] = TableAction::createNav($table,$navs);
//    	
        if ($this->nav)
            $con['nav'] = $this->nav;
        if ($this->search)
            $con['search'] = $this->search;
        if ($this->main)
            $con['main'] = $this->main;
        if ($this->pager)
            $con['pager'] = $this->pager;
        $this->assign('con', $con);
        $this->display("Public:main");


        exit;

    }

    function success($mes = null, $url = null, $ajax = null)
    {
        parent::success($mes, $url, $ajax);
    }

    function error($mes = null, $url = null, $ajax = null)
    {
        parent::error($mes, $url, $ajax);
    }

    protected function ajaxSuccess($data = null, $info = "操作成功")
    {
        $json['status'] = 1;
        $json['info'] = $info;
        $json['data'] = $data;
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function ajaxFailed($info = "操作失败")
    {
        $json['status'] = 0;
        $json['info'] = $info;
        $json['data'] = null;
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        exit;
    }

    function __destruct()
    {
        //dump (getRuntime()) ;
    }


}