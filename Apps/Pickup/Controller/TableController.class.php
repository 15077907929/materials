<?php
/**
 * 数据表的CURD自动处理类
 *        需要类：LoginController  &&  R('Login/isLogin');
 *
 *        需要函数：success()    error()
 *
 *
 */
namespace Pickup\Controller;

use Think\Controller;

class TableController extends Controller
{
    const MAYBE = 'maybe';

    const ERROR_CONFIG = '操作错误，未找到配置文件 : {?}';
    const ERROR_DATA_UNFIND = '未找到相关数据：{?}';
    const ERROR_POWER = '对不起，您没有足够的权限执行此操作';

    const STRING_SORT = 'sort';
    const STRING_TABLE = 'table';

    private $tableName = null;
    private $tableConfig = null;
    private $methodConfig = null;
    private $method = null;

    function __construct($tableName = null, $method = null)
    {
        parent::__construct();
        header("Content-type:text/html;charset=utf-8");
        R('Login/isLogin');

        if (!$tableName)
            $this->tableName = empty($_REQUEST['table']) ? '' : $_REQUEST['table'];

        if ($method)
            $this->method = $method;
        else
            $this->method = empty($_REQUEST['method']) ? 'show' : $_REQUEST['method'];


        if ($this->tableName)
            $this->_curd();

    }

    public function _empty()
    {
//		exit('您执行空操作');
    }

    public static function getTableName($must = false)
    {
        $tableName = empty($_REQUEST[self::STRING_TABLE]) ? '' : $_REQUEST[self::STRING_TABLE];
        if ($must)
            self::isTable($tableName);
        return $tableName;
    }

    private function _curd(){
        $this->tableConfig = C($this->tableName);
        if (!$this->tableConfig)
            error(parseArg(self::ERROR_CONFIG, $this->tableName));
        $this->methodConfig = C($this->tableName . '.' . $this->method);
        if ($this->methodConfig && is_string($this->methodConfig)) //配置内容为字符串，直接作为函数执行
        {
            self::parseFunc($this->methodConfig);
            success();
        }
        $method = '_' . $this->method;
        $this->_out($this->tableName, $method);
    }

    function _out($table = null, $method = null, $navs = null)
    {
        if ($method === '_show') {
            $con['search'] = self::createSearch($table);
        }
		
        $con['nav'] = self::createNav($table, $navs);
        $con['table'] = $table;

        $html = self::$method($table);
        $con['main'] = $html['con'];
        if (isset($html['pager'])) {
            $con['pager'] = '<div class="pager">' . $html['pager'] . '</div>';
        }

        if ($method == '_show')
            $con['output'] = self::outputData($table, $html['where']);
		// echo '<pre>';
// print_r($con);exit;
        $this->assign('title', self::latelyView());
        $this->assign('con', $con);
        $this->display('Public:main');
    }

    private static function outputData($table, $where)
    {
        $conf = self::readConfigByRole($table, 'output');
        if (empty($conf))
            return false;
        $base64Where = empty($where) ? "" : base64_encode($where);
        $checkArr = array('table' => $table, 'where' => $base64Where, 'uid' => getAdminId());
        $verify = self::getCheckMd5($checkArr);
        $outputUrl = U('Table/index', array('method' => 'outputData', 'table' => $table, 'where' => $base64Where, 'verify' => $verify));
        return $outputUrl;


    }

    private static function getCheckMd5($arr)
    {
        $arr['private'] = 'zhoutao';
        $checkString = http_build_query($arr);
        return md5($checkString);
    }

    public function _outputData()
    {
        $table = $_GET['table'];
        $where = $_GET['where'];
        $where = empty($where) ? null : base64_decode($where);
        $verify = $_GET['verify'];
        if (empty($table) || empty($verify))
            error("导出失败，传入参数有误！");
        $checkArr = array('table' => $table, 'where' => $_GET['where'], 'uid' => getAdminId());
        if ($verify != self::getCheckMd5($checkArr))
            error("导出失败，条件验证错误");
        $db = self::getDb($table);
        $config = self::readConfigByRole($table, 'output');

        $limit = 9;
        if (isset($config['_limit'])) {
            $limit = $config['_limit'];
            unset($config['_limit']);
        }

        $fieldsFunc = array();
        if (in_array('*', $config))
            $fields = '*';
        else
            foreach ($config as $k => $v) {
                if (strpos($k, '_') === 0)
                    continue;
                if (is_numeric($k))
                    $fields[] = $v;
                else {
                    $fields[] = $k;
                    if (!empty($v['func']))
                        $fieldsFunc[$k] = $v['func'];
                }
            }
        if (!empty($limit)) {
            $count = $db->where($where)->count();
            if ($count == 0)
                error("您请求导出的数据共有{0}条！");
            if ($count > $limit)
                error("您请求导出的数据共{$count}条，最多允许导出{$limit}条数据！");
        }

        $data = $db->field($fields)->where($where)->select();

        if (!empty($fieldsFunc)) {
            foreach ($data as $k => $v) {
                foreach ($fieldsFunc as $k2 => $v2) {
                    $v[$k2] = self::parseFunc($v2, $v[$k2], $data[$k]);
                    $data[$k] = $v;
                }
            }
        }

        $keys = array_keys($data[0]);
        $fieldsConfig = array_reverse(self::readConfigField($table));

        foreach ($keys as $v)
            $excelHeaderLine[$v] = empty($fieldsConfig[$v]) ? $v : $fieldsConfig[$v];

        import('@.Org.WriteExcel');
        $excel = new \WriteExcel();
        $excel->setMutilArray(array('0' => $excelHeaderLine)); //写首行数据
        $excel->setMutilArray($data, 'A', 2);
        $excel->saveAndDownload(C('BASE_DIR') . C('img.data2excel'));

    }

//	function _out($table = null ,$method = null,$navs = null)
//	{
//		if($method==='_show')
//		{
//			$con['search'] .=  self::createSearch($table);
//		}
//		$con['nav'] .= self::createNav($table,$navs);
//		$con['table'] =$table;
//
//		$html = self::$method($table);
//		$con['con'] .= $html['con'];
//
//		$con['pager'] = $html['pager'];
//
//		$con['title'] = self::latelyView();
//		$this->assign('con',$con);
//		$this->display('Public:main_old');
//		exit;
//	}

    static private function getHtml()
    {
//		import('@.Org.Html');
        return new \Home\Org\Html();

    }


    static private function _show($table = null)
    {

        $method = 'show';
        self::isTable($table);
        $config = self::readConfigByRole($table, $method);

        if (!$config)
            error(parseArg(self::ERROR_CONFIG, $table . '.' . $method));

//		if(is_array($config['_control']))
//			$config = array_merge($config,array('control'=>$control));

        $prefix = $suffix = '';
        if (isset($config['_prefix'])) {
            $prefix = self::parseFunc($config['_prefix']);
            unset($config['_prefix']);
        }
        if (isset($config['_suffix'])) {
            $suffix = $config['_suffix'];
            unset($config['_suffix']);
        }

        $re = self::readData($table, $config);
        $data = $re['data'];

        if (!empty($suffix)) {
            $data = self::parseFunc($suffix, $data);
        }

        $return['where'] = $re['where'];
        $return['pager'] = $re['pager'];

        //解析group
        $group = null;
        if (isset($_REQUEST['group']))
            $group = $_REQUEST['group'];

        //解析field
        $data_field = '*';
        if (isset($_REQUEST['field']))
            $data_field = $_REQUEST['field'];

        $toggle = array();
        if (!$group) //未分组的情况
        {
            //增加操作项目
            $result = self::parseShow($table, $data, $config);
            debug($result, 'parseShow');
            $data = $result['data'];
            $toggle = $result['toggle'];
            $fields = $result['fields'];
            $attrs = $result['attrs'];
        } else //分组的feild解析
        {
            $field = self::readConfigField($table);
            $data_field = explode(',', $data_field);
            foreach ($data_field as $v) {
                $fields[$field[$v]] = $v;
            }
        }
        $is_all = array();
        $is_all['table'] = $config["_all"] == true ? $table : false;
        $html = self::getHtml();
        $html->table($fields, $data, isset($attrs) ? $attrs : null, $toggle, $is_all);
        $return['con'] = $prefix . $html->html;
        return $return;

    }

    static private function _sort($table = null)
    {
        //提交排序结果
        if (!empty($_POST)) {
            $table = self::getTableName();
            $config = self::readConfigByRole($table, self::STRING_SORT);
            if (empty($config['_field']))
                error("排序配置文件错误，缺少必须的排序字段");

            $db = M($table);
            $count = count($_POST['id']);
            foreach ($_POST['id'] as $v) {
                $s[$config['_field']] = $count--;
                $db->where("id={$v}")->save($s);
            }

            if (!empty($config['_suffix']))
                self::parseFunc($config['_suffix']);

            success();
        }

        //显示排序页面
        self::isTable($table);
        $config = self::readConfigByRole($table, self::STRING_SORT);

        if (!$config)
            error(parseArg(self::ERROR_CONFIG, $table . '.' . self::STRING_SORT));

        $config['_pagesize'] = 3;
        $re = self::readData($table, $config, self::STRING_SORT);
        $data = $re['data'];
        $return['where'] = $re['where'];
        //$return['pager'] = $re['pager'];

        $toggle = $fields = array();
        //增加操作项目
        $result = self::parseShow($table, $data, $config);
        debug($result, 'parseShow');
        $data = $result['data'];
        $fields = $result['fields'];
        $attrs = $result['attrs'];

        $html = self::getHtmlClass();
        $return['con'] = $html->sortTable($fields, $data, isset($attrs) ? $attrs : null);
        return $return;
    }

    static private function getHtmlClass()
    {
//		import('@.Org.Html');
        return new \Home\Org\Html();
    }

    public static function readConfigField($table)
    {
        return C($table . '.field');
    }

    public static function readConfigByRole($table, $method = 'show')
    {
        if (isSuperAdmin()) //读取super
        {
            $conf = C($table . ".{$method}=super");
            if ($conf)
                return $conf;
        }

        $allConf = C($table);
        unset($allConf["{$method}=super"]); //删除超级管理员的配置文件
        foreach ($allConf as $k => $v) {
            if (strpos($k, $method) === 0) //以method开头的配置
            {
                $role = str_replace($method . '=', '', $k); //读取到相应的role
                if (hasRole($role))
                    return $v;
            }
        }

        if (isset($allConf["{$method}=all"]))
            return $allConf["{$method}=all"];

    }


    public static function getDb($table)
    {
        $connect_db = C($table . '.db');
        if ($connect_db) {
            if (is_array($connect_db) && $connect_db['func']) {
                $db = M($table, "", self::parseFunc($connect_db['func']));
            } else
                $db = M($table, "", $connect_db);
        } else
            $db = M($table);
        return $db;
    }


    static private function _add($table) //添加或修改
    {
        self::isTable($table);
        $method = 'add';
        $id = isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $edit_model = false;
        if ($id) {
            $edit_model = true;
            $method = 'edit';
        }

        $db = self::getDb($table);
        $field = self::readConfigField($table);
        $config = self::readConfigByRole($table, 'data');


        if (isset($config['_where'])) {
            $allowids = self::getAllowIds($table, self::parseStringOrFunc($config['_where']));
            if ($edit_model && !in_array($id, $allowids)) {
                error(self::ERROR_POWER);
            }
            unset($config['_where']);
        }

        if (isset($config['_add'])) //添加模式
        {
            if (!$config['_add'] && !$edit_model)
                error(self::ERROR_POWER);
            unset($config['_add']);
        }

        if (isset($config['_edit'])) //修改模式验证权限
        {
            if (!$config['_edit'] && $edit_model)
                error(self::ERROR_POWER);
            unset($config['_edit']);
        }

        $notice = C($table . '.notice');
        $check = self::readConfigByRole($table, 'datasub');

        if (!$config)
            error(parseArg(self::ERROR_CONFIG, $table . '.' . $method));

        $config = self::configFilter($config, $method);

        $check_key = $input_key = null;
        foreach ($config as $k => $v) {
            $key = $k;
            if (is_string($v))
                $key = $v;
            if ($v['type'] == 'file' && $method == 'edit') //上传文件在修改时不需要验证
                continue;

            $input_key[] = $key;
        }

        foreach ($check as $k => $v) {
            $key = $k;
            if (is_string($v))
                $key = $v;
            if (isset($v['value']) && $v['value'] == self::MAYBE)
                continue;

            if (in_array($key, $input_key)) {
                $check_key[] = $key;
// 				$check_name[] = ;
            }
        }


        //需js验证的表单name
        $check_html = '<input type="hidden" id="check_html" value="' . implode('|', $check_key) . '"/>';

        $da = null;
        if ($id) {
            $wh = "id=$id";
            $da = $db->where($wh)->find();
            if (!$da)
                error(parseArg(self::ERROR_DATA_UNFIND, $table . "[id={$id}]"));
        } else {
            $wh = self::readRole("create", null);
        }

        $html = self::getHtml();

        if ($id)
            $data[] = $html->createInput('hidden', 'editid', $id); //如果是修改就创建一个hidden存放id

        if ($config && !is_array($config)) {
            $t = self::getDb($table);
            $config = $t->getDbFields();
        }

        foreach ($config as $k => $v) {
            if (is_string($v)) {
                $k = $v;
                $v = array('type' => 'text');
            } else if ($v['type'] == null) {
                $v['type'] = 'text';
            }


            if (isset($v['data'])) {
                if (is_string($v['data'])) {
                    $source = self::parseFunc($v['data']);
                } else {
                    $source = $v['data'];
                }
            }


            if (isset($v['def']) && $v['def'] !== null) {
                if ($da[$k] === null) {
                    if (strpos($v['def'], '$') === 0) {
                        $v['def'] = substr($v['def'], 1);
                        $v['def'] = $_REQUEST[$v['def']];
                    }

                    $da[$k] = $v['def'];
                }
            }

            $field_name = $k;
            if (is_string($field[$k])) {
                $field_name = $field[$k];
            } else if (is_array($field[$k])) {
                $field_name = $field[$k]['name'];
            }

            if (isset($v['func'])) {
                $data[$field_name] = self::parseFunc($v['func'], $da[$k]);
            } else {
                $data[$field_name] = $html->createInput($v['type'], $k, $da[$k], isset($source) ? $source : null, isset($v['attr']) ? $v['attr'] : null);
            }
            //增加提示语句，提示语句从表的配置文件中的‘notice’读取
            if (isset($notice[$k]) && $notice[$k]) {
                $data[$field_name] .= ' <span class="icon_alert"></span><span> ' . $notice[$k] . '</span>';
            }

        }


        foreach ($_GET as $k => $v) {
            $data[] .= $html->createInput('hidden', $k, $v);
        }

        if ($edit_model) {
            $data[] .= $html->createInput('hidden', 'isedit', '1'); //增加一个hidden，以确认是修改模式
        }
        $data[] .= $html->createInput('hidden', 'redirect', $_SERVER['HTTP_REFERER']);

        $submit_string = $edit_model ? "修改" : "添加";
        $submit_icon_class = $edit_model ? "icon_edit" : "icon_text";
        $data[] = $html->createInput('submit', 'submit', $submit_string) . '<div class="' . $submit_icon_class . ' icon_transparent"></div>';

        $html->ul($data);
        $html->form(U('Table/index', "table={$table}&method=sub"));

// 		$con['title'] = C("$table.name") . " >>  {$submit_string} ";


        $return['con'] = $html->html;
        $return['con'] .= $check_html;

        return $return;
    }

    static private function _copy($table) //添加或修改
    {
        self::isTable($table);
        $method = 'copy';
        $db = self::getDbByConfig($table);
        $copyConfig = self::readConfigByRole($table, $method);

        $id = $_GET['id'];
        if (empty($id))
            error("未找到要复制的对象的ID");

        $data = $db->find($id);
        foreach ($copyConfig as $k => $v) {
            if (is_string($v))
                $data[$k] = $v;
            else if (!empty($v['func'])) {
                $data[$k] = self::parseFunc($v['func'], $data[$k]);
            }
        }

        unset($data['id']);
        $db->add($data) ? success() : error("复制失败，请联系管理员！");
    }

    public static function getDbByConfig($table)
    {
        $t = C($table . ".db");
        if ($t) {
            $conf = $t['func'];
            $c = explode($conf, '=');
            $db = M($table, null, $c[0] . '(' . $c[1] . ')');
        } else
            $db = M($table);
        return $db;
    }

    static public function getAllowIds($table, $where)
    {
        $db = self::getDb($table);
        $data = $db->field("id")->where($where)->select();
        foreach ($data as $v) {
            $re[] = $v['id'];
        }
        return $re;
    }


    //配置过滤器
    static private function configFilter($config, $method)
    {
        if (is_string($config))
            return $config;
        //根据当前方法是add或是edit过滤
        foreach ($config as $k => $v) {
            if (is_array($v) && isset($v['when']) && $v['when'] != $method)
                unset($config[$k]);
        }
        return $config;
    }


    static private function _sub($table) //添加或修改的提交
    {
        self::isTable($table);
        $method = 'add';

//        if($table == 'system_admin')
//        {
//            dump($_REQUEST);
//        exit;
//    }

        $edit_model = $_REQUEST['isedit'] == 1 ? true : false; //修改模式  //判断是否是修改模式
        $id = is_numeric($_REQUEST['editid']) ? $_REQUEST['editid'] : 0;

        if ($edit_model) {
            $method = 'edit';
        }

        $db = self::getDb($table);
        if ($edit_model) //修改模式
        {
            $where = "id=$id";
            $where = self::readRole("update", $where);
            $find_data = $db->where($where)->find();
            if (!$find_data)
                error(parseArg(self::ERROR_DATA_UNFIND, $table . "[where={$where}]"));
        } else {
            $where = self::readRole("create", null);
        }


        $config = self::readConfigByRole($table, 'datasub');
        if (isset($config['_prefix'])) {
            self::parseFunc($config['_prefix']);
            unset($config['_prefix']);
        }

        $field = C("$table.field");

        $config = self::configFilter($config, $method);
        debug($config);
        $checkData = true;
        if (!$config) //未找到datasub配置文件的情况下
        {
            $allow = C($table . ".data");
            $checkData = false; //无需检查数据
        }

        if (!$config && !$allow)
            error('未找到配置文件');

        //如果config是字符串，那么直接把字符串当做函数去解析执行
        if (is_string($config)) {
            self::parseFunc($config);
            success();
        }

        /** 如果config 包含_prefix ,执行前缀函数 ,前缀函数中通过设置$_REQUEST[?] 的值，使之加入数据库
         *  如：要获取上传的文件（字段[ icon ]）的MD5值，可以在前缀函数中进行上传操作
         * ，并设置 $_REQUEST['md5'] = ??? , $_REQUEST['icon'] = ???
         */
        if (isset($config['_prefix'])) {
            self::parseFunc($config['_prefix']);
            unset($config['_prefix']);
        }

        $suffix = false;
        if (isset($config['_suffix'])) {
            $suffix = $config['_suffix'];
            unset($config['_suffix']);
        }

        if (!$config) {
            $t = self::getDb($table);
            $config = $t->getDbFields(); //读取所有字段
        }

        foreach ($config as $k => $v) {
            if (is_string($v)) {
                $k = $v;
            }

            $s[$k] = $_REQUEST[$k];
            if (is_array($v) && $v['func'] != null) {
                $s[$k] = self::parseFunc($v['func'], $s[$k]);
            }

            if (is_array($v) && $v['def'] != null) {
                if ($s[$k] == null)
                    $s[$k] = $v['def'];
            }

        }

        if ($checkData) {
            foreach ($s as $k => $v) {

                if ($config[$k]['value'] === 'maybe') //maybe的时候
                {
                    if ($v === null)
                        $s[$k] = '';
                    continue;
                }


                if ($v === '' || $v === null) {
                    error("[" . $field[$k] . "]不得为空！");
                }
            }
        }

        $log_table = C($table . '.log');
        if ($log_table) {
            $log_data = $s;
            if ($edit_model)
                $log_data['o_id'] = $id;
            $log_data['o_method'] = $method;
            $log_data['o_time'] = time();
        }

        if ($edit_model) {
            //$db->where("id=$id")->save($s) ? '' : error("错误：" . $db->getLastSql());
            $db->where("id=$id")->save($s) ? '' : error("修改失败.");
        } else {
//            $db->add($s) ? '' : error("错误：" . $db->getLastSql());
            $lastId = $db->add($s);
            if (!$lastId)
                error("添加失败.");
            if ($log_data)
                $log_data['o_id'] = $lastId;
        }

        if ($log_data)
            M($log_table)->add($log_data);

        if ($suffix) {
            self::parseFunc($suffix);
        }

        $redirect = !empty($_POST['redirect']) ? $_POST['redirect'] : U(null, 'table=' . $table . '&method=show');

        success('操作成功', $redirect);

    }

    static private function _del($table)
    {
        self::isTable($table);
        $id = is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : 0;

//		$config = C($table.'.del');
        $config = self::readConfigByRole($table, 'del');
        if (!$config)
            error('未找到配置文件');

        $suffix = false;
        if (is_array($config) && isset($config['_suffix'])) {
            $suffix = $config['_suffix'];
            $config = true;
        }

        if ($config !== true)
            error("配置文件中设置了不允许删除");

        if (!$id)
            error('未传入ID值');

        $db = self::getDb($table);
        $wh = "id=$id";
        $wh = self::readRole("delete", $wh);
        $data = $db->where($wh)->find();
        if (!$data)
            error("未找到数据");

        $log_table = C($table . '.log');
        if ($log_table) {
            $log_data = $data;
            if ($log_data['id'])
                unset($log_data['id']);
            $log_data['o_id'] = $id;
            $log_data['o_method'] = 'del';
            $log_data['o_time'] = time();
            M($log_table)->add($log_data);
        }

        $db->where("id=$id")->delete() ? '' : error("错误：" . $db->getLastSql());
        if ($suffix)
            self::parseFunc($suffix);
        success("操作成功");
    }


    static private function _delAll($table)
    {
        self::isTable($table);
        $checkids = is_array($_REQUEST['checkids']) ? $_REQUEST['checkids'] : array();
        if (!empty($checkids)) {
            foreach ($checkids['id'] as $id) {
                //		$config = C($table.'.del');
                $config = self::readConfigByRole($table, 'del');
                if (!$config)
                    error('未找到配置文件');

                $suffix = false;
                if (is_array($config) && isset($config['_suffix'])) {
                    $suffix = $config['_suffix'];
                    $config = true;
                }

                if ($config !== true)
                    error("配置文件中设置了不允许删除");

                if (!$id)
                    error('未传入ID值');

                $db = self::getDb($table);
                $wh = "id=$id";
                $wh = self::readRole("delete", $wh);
                $data = $db->where($wh)->find();
                if (!$data)
                    error("未找到数据");

                $log_table = C($table . '.log');
                if ($log_table) {
                    $log_data = $data;
                    if ($log_data['id'])
                        unset($log_data['id']);
                    $log_data['o_id'] = $id;
                    $log_data['o_method'] = 'del';
                    $log_data['o_time'] = time();
                    M($log_table)->add($log_data);
                }
                $db->where("id=$id")->delete() ? '' : error("错误：" . $db->getLastSql());
                if ($suffix)
                    self::parseFunc($suffix);
            }
        }

        success("操作成功");
    }


    static private function _detail($table)
    {
        self::isTable($table);
        $config = C($table . '.detail');
        $field = C($table . '.field');
        if (!$config)
            $config = C($table . '.show');
        else {
            $show_config = C($table . '.show');
            foreach ($config as $k => $v) {
                if (is_string($v)) {
                    unset($config[$k]);
                    $config[$v] = $v;
                }
            }

            foreach ($show_config as $k => $v) {
                if (is_string($v)) {
                    unset($show_config[$k]);
                    $show_config[$v] = $v;
                }
            }
            $config = merge($show_config, $config);
        }

        if (!$config) error($table . '表的配置文件【detail 或者 show】 错误，请修改！');

        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $db = self::getDb($table);
        $wh = "id=$id";
        $wh = self::readRole("read", $wh);
        $data = $db->where($wh)->find();

        if (!$data) error("ID错误");

        $datas = self::parseShow($table, array($data), $config);
        $list = $datas['data'][0];

        $html = self::getHtml();
        $html->twoColumnTable($datas['fields'], $list);


        $return['con'] = $html->html;


        if (is_array($config) && isset ($config['_with'])) {
            if (isset($config['_with']['where'])) {
                $link = self::parseLink($config['_with']['where'], null, null, array("id" => $_REQUEST['id']));
                self::setGlobalWhere($config['_with']['table'], $link);
            }
            $with_re = self::_show($config['_with']['table']);
            $return['con'] .= "<br /><hr />" . $with_re['con'];
            $return['pager'] = $with_re['pager'];
        }
        return $return;
    }


    static private function createBaseNav($table)
    {
        $method = isset($_REQUEST['method']) ? $_REQUEST['method'] : 'show';
        $id = isset($_REQUEST['id']) && intval($_REQUEST['id']) ? $_REQUEST['id'] : 0;

        $navs = array();
        if (self::readConfigByRole($table, 'show')) {
            $navs['所有']['link'] = "table={$table}";
            $navs['所有']['icon'] = "icon_grid";
            //$list = array('所有'=>array('link'=>"table={$table}&method=show",'icon'=>'class="icon_grid icon_image_black icon_transparent"'),);
        }
        if ($conf = self::readConfigByRole($table, "data")) {
            if (isset($conf['_add']) && !$conf['_add']) {

            } else {
                $conf = self::configFilter($conf, 'add');
                if (is_string($conf) || count($conf) > 0) {
                    $navs['添加']['link'] = "table={$table}&method=add";
                    $navs['添加']['icon'] = "icon_add";
                }
            }
//			$list['添加'] = array('link'=>"table={$table}&method=add",'icon'=>'class="icon_add icon_image_black icon_transparent"');
        }
        if ($id && $method == 'add' && self::readConfigByRole($table, "data")) {
            $navs['修改']['link'] = "table={$table}&method=add&id={$id}";
            $navs['修改']['icon'] = "icon_edit";
//			$list['修改'] = array('link'=>"table={$table}&method=add&id={$id}",'icon'=>'class="icon_edit icon_image_black icon_transparent"');
        }

        $sortConf = self::readConfigByRole($table, "sort");
        if (!empty($sortConf)) {
            $navs['排序']['link'] = "table={$table}&method=sort";
            $navs['排序']['icon'] = "icon_bar";
        }

        if ($method == 'detail') {
            $navs['详细']['link'] = "table={$table}&method=detail&id={$_REQUEST['id']}";
            $navs['详细']['icon'] = "icon_bar";
//			$list['详细'] = array('link'=>"table={$table}&method=detail&id={$_REQUEST['id']}",'icon'=>'class="icon_bar icon_transparent"');
        }
// 		$fields = C("$table.field");
// 		if(isset($fields['status']))
// 			$list['审核'] = array('link'=>"table={$table}&method=status",'icon'=>'class="icon_gear icon_image_black icon_transparent"');
// 		if(isset($fields['enable']))
// 			$list['显示'] = array('link'=>"table={$table}&method=enable",'icon'=>'class="icon_gear icon_image_black icon_transparent"');
        /*
        $control = C("$table.control");
        if($control)
            $list['控制'] = array('link'=>"table={$table}&method=control",'icon'=>'class="icon_gear icon_image_black icon_transparent"');
        */

        return $navs;
    }

    static public function getDefaultTab()
    {
        $re['link'] = '';
        $re['icon'] = 'icon_search';
        $re['selected'] = 1;
        return $re;
    }

    static public function createNav($table = null, $other_navs = null)
    {
        if ($table === null)
            $table = isset($_REQUEST['table']) ? $_REQUEST['table'] : '';

        if ($table)
            $base_nav = self::createBaseNav($table); //读取基本的导航栏

        $tabs_config = C("$table.tab"); //读取配置文件中tab的配置
        $tabs = null;

        $funcTab = array();
        if (isset($tabs_config['func'])) {
            $funcTab = self::parseFunc($tabs_config['func']);
            unset($tabs_config['func']);
        }

        $tabs_config = merge($tabs_config, $funcTab);
        foreach ($tabs_config as $k => $v) {
            if (!isset($v['link']))
                continue;
            $tabs[$k] = $v;
        }

        $list = merge($base_nav, $tabs, $other_navs); //混合所有tab选项

        $def_icon = "icon_search"; //默认ICON
        if (empty($list)) //nav为空的时候
        {
            //$re =  '<div class="nav"><span><div ' .$def_icon.'></div>当前</span></div>';
            return self::getDefaultTab();
        }

        foreach ($list as $k => $v) {
            $list[$k]['link'] = self::createLink(self::parseLink($v['link']));
            if (!empty($v['link_target']))
                $list[$k]['target'] = $v['link_target'];
            $list[$k]['icon'] = isset($v['icon']) ? $v['icon'] : $def_icon;
            $list[$k]['selected'] = 0;
        }


        //当前url的解析
//		dump($_SERVER);
//		$url = parse_url($_SERVER['REQUEST_URI'] );
//		$param = array();
//		if($url['query'])
//			parse_str($url['query'],$param);
//		dump($param);
        //dump($list);

        $param = $_GET;
        $find = '';
        foreach ($list as $k => $v) {
            if ($_SERVER['REQUEST_URI'] == $v['link']) {
                $find = $k;
                break;
            }

            $this_param = array();
            $this_url = parse_url($v['link']);
//			dump(pathinfo($v['link']));
//			dump($this_url);
            parse_str($this_url['query'], $this_param);
//			dump($param);
//			dump($this_param);
            $diff = array_diff($param, $this_param);
            if (isset($diff['p']))
                unset($diff['p']);

//			echo '<hr />';
//			dump($diff);
//			dump($param);
//			dump($this_param);
            if (count($diff) === 0) {
                $find = $k;
                break;
            } else if (count($diff) == 1) {
                if (isset($diff['method']) && $diff['method'] == 'show') {
                    $find = $k;
                    break;
                }
            }

        }
        if ($find)
            $list[$find]['selected'] = 1;
        else {
            $list['查询']['icon'] = $def_icon;
            $list['查询']['selected'] = 1;
        }

        return $list;


        if ($_SERVER['QUERY_STRING'])
            $query_paras = explode('&', $_SERVER['QUERY_STRING']);
        foreach ($query_paras as $k => $v) {
            if (preg_match('/^method=.+$/', $v))
                $find = 1;
            if (preg_match('/^p=.+$/', $v))
                unset($query_paras[$k]);
        }
        if (!$find) $query_paras[] = 'method=show';

        $selected_find = 0;
        $search = self::getGlobalWhere($table);

        if (!empty($search))
            $selected_find = 1;


        foreach ($list as $k => $v) {
            $v['link'] = self::createLink(self::parseLink($v['link']));
            if (strpos($v['link'], '?') !== false) {
                $parse = parse_url($v['link']);
                $link_paras = explode('&', $parse['query']);
            }

            $find = 0;

            foreach ($link_paras as $v2) {
                if (preg_match('/^method=.+$/', $v2)) {
                    $find = 1;
                    break;
                }
            }
            if (!$find) $link_paras[] = 'method=show';

            if (isset($v['icon']))
                $icon = $v['icon']; //读取的ICON
            else
                $icon = $def_icon; //默认ICON

            $spanicon = str_replace('icon_image_black', '', $icon); //去除icon_image_black就是spanicon


            if ($selected_find === 0 && $link_paras != null && count(array_diff($link_paras, $query_paras)) == 0 && count(array_diff($query_paras, $link_paras)) == 0) {
                $navs .= "<span><div {$spanicon}></div>$k</span>";
            } else {
                $target = '';
                if (isset($v['link_target']))
                    $target = "target=\"{$v['link_target']}\"";
                $attr = isset($v['attr']) ? $attr = $v['attr'] : "";
                $navs .= "<a href=\"" . $v['link'] . "\"  {$target} {$attr}><div {$icon}></div>{$k}</a>";
            }
        }


        if ($selected_find == 1)
            $navs .= '<span><div class="icon_search icon_transparent"></div>查询</span>';


        if (strpos($navs, '<span>') === false && $_REQUEST['where']) {
            $where = $_REQUEST['where'];
//			$navs.="<span>查询{$where}</span>";
            $navs .= "<span>查询</span>";
        }

        if (strpos($navs, '<span>') === false)
            $navs .= '<span><div ' . $def_icon . '></div>当前</span>';

        $re = '<div class="nav">' . $navs . '</div>';

        return $re;
    }


    /**
     * 支持格式
     * 'func'=>'Classname|methodname=arg1,agr2,ar3{,},arg4,...'
     */
    static function parseFunc($func, $data = null, $allData = null)
    {
        if (preg_match('/@(.+)@/', $func, $preg))
            $func = str_replace('@' . $preg[1] . '@', $allData[$preg[1]], $func);


        $temp = '{abcdedcba}'; //临时转换的内容
        $func = str_replace("\,", $temp, $func); //将\转换为临时内容，等会分割后再转换回来

        $func_arr = explode('&', $func);
        foreach ($func_arr as $func) {

            if (strstr($func, '|')) //针对格式（Data|get_da）
            {
                $func = explode('|', $func);
                if (count($func) != 2)
                    exit('函数解析错误！' . $func);
                $m = ucfirst($func[0]);

                $a = $func[1];
                $m = A($m);
                $data = self::parseFunction($a, $data, $m, $temp);
            } else {
                $data = self::parseFunction($func, $data, null, $temp);
            }
        }
        return $data;
    }

    /**
     * 针对格式（date=Y-m-d H:i:s,###）
     * @param  $func string 函数名称(系统函数，自定义函数，类方法)：date  md5  img
     * @param  $data string 数据,本身数据 ：如果函数名称包含###，则自动替换为$data
     * @param $class object  一个实例化的类对象，如： new CommonAction
     */

    private static function parseFunction($func, $data = null, $class = null, $temp) //
    {
        $func = explode('=', $func);
        if (count($func) == 1) {
            if ($class !== null) {
                return $class->$func[0]();
            } else {
                return $func[0]();
            }
        } else if (count($func) == 2) {
            $arg_str = $func[1];
            $args = explode(',', $arg_str);
            foreach ($args as $k => $v) {
                if ($v === '###')
                    $args[$k] = $data;
                if (strpos($v, "$.") === 0) //$.开始
                {
                    $temp = explode('.', $v);
                    if (count($temp) == 3) {
                        switch (strtolower($temp[1])) {
                            case 'get':
                                $args[$k] = $_GET[$temp[2]];
                                break;
                            case 'post':
                                $args[$k] = $_POST[$temp[2]];
                                break;
                            default:
                                break;
                        }
                    }
                }
                if (strpos($args[$k], $temp) !== false)
                    $args[$k] = str_replace($temp, ',', $args[$k]);
            }

            if ($class === null) {
                switch (count($args)) {
                    case 1:
                        return $func[0]($args[0]);
                    case 2:
                        return $func[0]($args[0], $args[1]);
                    case 3:
                        return $func[0]($args[0], $args[1], $args[2]);
                    case 4:
                        return $func[0]($args[0], $args[1], $args[2], $args[3]);
                    case 5:
                        return $func[0]($args[0], $args[1], $args[2], $args[3], $args[4]);
                    case 6:
                        return $func[0]($args[0], $args[1], $args[2], $args[3], $args[4], $args[5]);
                    case 7:
                        return $func[0]($args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6]);
                    case 8:
                        return $func[0]($args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7]);
                    case 9:
                        return $func[0]($args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8]);
                    case 10:
                        return $func[0]($args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8], $args[9]);
                }
            } else {
                switch (count($args)) {
                    case 1:
                        return $class->$func[0]($args[0]);
                    case 2:
                        return $class->$func[0]($args[0], $args[1]);
                    case 3:
                        return $class->$func[0]($args[0], $args[1], $args[2]);
                    case 4:
                        return $class->$func[0]($args[0], $args[1], $args[2], $args[3]);
                    case 5:
                        return $class->$func[0]($args[0], $args[1], $args[2], $args[3], $args[4]);
                    case 6:
                        return $class->$func[0]($args[0], $args[1], $args[2], $args[3], $args[4], $args[5]);
                    case 7:
                        return $class->$func[0]($args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6]);
                    case 8:
                        return $class->$func[0]($args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7]);
                    case 9:
                        return $class->$func[0]($args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8]);
                    case 10:
                        return $class->$func[0]($args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8], $args[9]);
                }
            }
        } else {
            exit('函数解析错误！' . $func);
        }

    }


    static private function parseStringToSign($str) //将字符串转换为符号
    {
        switch ($str) {
            case 'eq':
                return '=';
            case 'in' :
                return 'in';
            case 'neq':
                return '!=';
            case 'gt':
                return '>';
            case 'lt':
                return '<';
            case 'egt':
                return '>=';
            case 'elt':
                return '<=';
            case 'like':
                return 'like';
            case 'not in':
                return 'not in';
        }
        return '';
    }

    static private function parseSignToChinese($str) //将符号转换为中文
    {
        switch ($str) {
            case '=':
                return '等于';
            case '!=':
                return '不等于';
            case '>':
                return '大于';
            case '<':
                return '小于';
            case '>=':
                return '大于等于';
            case '<=':
                return '小于等于';
            case 'like':
                return '包含';
            case 'in' :
                return "属于";
            case 'not in':
                return '不属于';
        }
        return '';
    }


    static function parseLink($link, $olddata = '', $newdata = '', $allData = '') //解析link
    {
        if (!$link) return '';

        if (strpos($link, '!!!') !== false) //包含！！！的link，在值被函数转化之前生成链接
        {
            $link = str_replace("!!!", $olddata, $link);
        }

        if (strpos($link, '@@@') !== false) //包含@@@ 的link，@@@被转换为 主键id字段
        {
            $link = str_replace("@@@", $allData['id'], $link);
        }
        if (strpos($link, '###') !== false) //包含### 的link，在值被函数转化之后生成链接
        {
            $link = str_replace("###", $newdata, $link);
        }

        if (preg_match('/@(.+)@/', $link, $preg)) {
            $link = str_replace('@' . $preg[1] . '@', $allData[$preg[1]], $link);
        }
        $link = str_replace(' ', '%20', $link);
        return $link;
    }

    /**
     *   根据传过来的link 生成完整的url
     *
     *  模式1：  table=log_login&where=[uname]eq[###]  生成：__URL__?table=log_login&where=[uname]eq[###]
     *  模式2:      http 或者 www开始， 直接返回
     *        http://v.youku.com/v_show/id_###.html  生成： http://v.youku.com/v_show/id_###.html
     *  模式3：  “/”开始，
     *        /Operate/move?id=@@@   生成 __APP__/Operate/move?id=@@@
     */
    static public function createLink($link) //
    {
        //模式2 ,http开始：绝对url
        if (strpos($link, 'http://') === 0 || strpos($link, 'www.') === 0)
            return $link;

        if (strpos($link, '/') === 0) {
            $t = explode('?', trim($link, '/'));
            return U($t[0], $t[1]);
        }
        //模式1
        return U('', $link);
    }

    static function latelyView($str = '')
    {
        if ($str) {
            latelyView("$str");
            return "$str";

        }

        if (get_called_class() != __CLASS__) {
            $str = "管理后台";
            latelyView("$str");
            $result = "$str";
            return $result;
        }


        $table = $_REQUEST['table'];
        $method = isset($_REQUEST['method']) ? $_REQUEST['method'] : 'show';
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $table_name = C($table . '.name') ? C($table . '.name') : $table;
        $where = isset($_REQUEST['where']) ? $_REQUEST['where'] : '';

        $method_name = '';
        switch ($method) {
            case 'add':
                if ($id)
                    $method_name = "修改";
                else
                    $method_name = "添加";
                break;
            case 'detail':
                $method_name = "详细";
                break;
            case 'show':
                if ($where)
                    $method_name = "查询";
                else
                    $method_name = "所有";
                break;
            case 'status':
                $method_name = "审核";
                break;
            case 'enable':
                $method_name = "显示";
                break;
            default :
                $method_name = "";
        }

        if ($table_name && $method_name)
            latelyView("{$table_name} -> {$method_name}");

        return "{$table_name} -> {$method_name}";
    }


    //TODO _toggle的处理
    static private function readData($table, $config, $method = 'read')
    {
        $db = self::getDb($table);

        if (in_array('*', $config))
            $field = '*';
        else
            foreach ($config as $k => $v) {
                if (strpos($k, '_') === 0) //下划线开始的都过滤掉，不属于field的范围
                    continue;


                if (is_string($v))
                    $k = $v;

                $field[] = $k;
            }
        //解析field
        if (isset($_REQUEST['field']))
            $data_field = $_REQUEST['field'];
        else
            $data_field = $field;
        //解析_control中的field
        if (isset($config['_control'])) {
            foreach ($config['_control'] as $k => $v) {
                //  $data_field[] = $k;
                array_push($data_field, $k);
            }
        }
        //解析group
        $group = null;
        if (isset($_REQUEST['group']))
            $group = $_REQUEST['group'];

        //解析order
        $order = null;
        if (isset($_REQUEST['order']))
            $order = $_REQUEST['order'];
        if (!$order)
            $order = isset($config['_order']) ? self::parseStringOrFunc($config['_order']) : 'id desc';

        //解析pagesize
        $pagesize = null;
        if (isset($_REQUEST['pagesize']))
            $pagesize = $_REQUEST['pagesize'];
//        dump($config);
        if (!$pagesize) {
            if (isset($config['_pagesize'])) //解析pagesize
                $pagesize = $config['_pagesize'];
        }
//		dump($pagesize);
        if (!$pagesize)
            $pagesize = C('PAGESIZE') ? C('PAGESIZE') : 200; //读取默认配置的 PAGESIZE

        //解析config里where,此处的where是绝对的，搜索的时候也会带上，用以限制用户的操作范围
        $conf_where = self::getConfWhere($table);
        $conf_where = $conf_where ? $conf_where : array();

        //解析config里面的默认where，此where只会在show页面默认配置时读取
        $conf_def_where = self::getConfDefWhere($table);
        $def_where = $conf_def_where ? $conf_def_where : array();

        //解析url里的where
        $url_where = self::parseUrlWhere();

        //解析global里的where
        $global_where = self::parseUrlWhere(self::getGlobalWhere($table));
        if ($global_where) //如果是搜索的话 那么删除默认where里的where
        {
            //unset($_GET['p']);
            $def_where = array();
            $url_where = array();
        }

        $wh = implode(' and ', merge($conf_where, $def_where, $url_where, $global_where));
        $wh = self::readRole($method, $wh);
        $wh = !empty($wh) ? $wh : null;

        //根据order pagesize where 获取 data
        if ($pagesize) {
            if ($group) {

                $groups = $db->where($wh)->group($group)->select();
                $count = count($groups);
            } else {
                $count = $db->where($wh)->count();
            }


            $parameter = self::getGlobalWhere($table) ? merge($_GET, array('where' => self::getGlobalWhere($table))) : '';
            $page = new \Home\Org\Page($count, $pagesize, $parameter);

            if ($group)
                $data = $db->field($data_field)->where($wh)->group($group)->limit($page->firstRow, $page->listRows)->select();
            else
                $data = $db->field($data_field)->where($wh)->order($order)->limit($page->firstRow, $page->listRows)->select();

            debug($db->getLastSql(), "Select Sql");
            debug($data, "Select Sql Result");
            $pager = $page->show();
        } else {
            $data = $db->field($data_field)->where($wh)->group($group)->order($order)->select();
        }


        if (isset($config['_with'])) {
            foreach ($data as $k => $v) {
                if (isset($config['_with']['where'])) {
                    $link = self::parseLink($config['_with']['where'], null, null, $v);
                    self::deleteGlobalWhere($config['_with']['table']);
                    self::setGlobalWhere($config['_with']['table'], $link);
                }
                $with = self::_show($config['_with']['table']);
                $data[$k]['_with'] = $with['con'];
            }
        }

        $result['pager'] = $pager;
        $result['data'] = $data;
        $result['where'] = $wh;
        return $result;
    }

    public static function getConfWhere($table, $method = 'show')
    {
        $config = self::readConfigByRole($table, $method);
        $conf_where = isset($config['_where']) ? self::parseStringOrFunc($config['_where']) : null;
        return $conf_where;

    }

    public static function getConfDefWhere($table)
    {
        $config = self::readConfigByRole($table, 'show');
        $conf_where = isset($config['_def_where']) ? self::parseStringOrFunc($config['_def_where']) : null;
        return $conf_where;

    }

    private static function parseStringOrFunc($str)
    {
        if (is_array($str)) {
            if (isset($str['func']))
                return self::parseFunc($str['func']);
            return '';
        } else if (is_string($str)) {
            if (strpos($str, 'func://') === 0)
                return self::parseFunc(substr($str, 7));

            $preg_str = '/\$(.+)\$/sU';
            while (preg_match($preg_str, $str, $preg)) //$$之间的内容将被parseFunc
            {
                $temp = self::parseFunc($preg[1]);
                $str = preg_replace($preg_str, $temp, $str, 1);
            }
            return $str;
        }


    }

    private static function parseShow($table, $data, $config)
    {
//		$table = $this->table;
        $field = C($table . '.field');

        $method = isset($_REQUEST['method']) ? $_REQUEST['method'] : 'show';

        foreach ($data as $k => $v) {
            $temp = self::readConfigByRole($table, 'datasub');
            if ($temp != null) {
                $conf = self::configFilter($temp, 'edit');
                if (is_string($conf) || count($conf) > 0) {
                    $link = U(null, "table={$table}&method=add&id={$v['id']}");
                    $data[$k]['caozuo1'] = '<a href="' . $link . '"><span class="icon_edit" title="修改"></span></a>';
                }
            }
            if (self::readConfigByRole($table, 'del') != null) {
                $link = U(null, "table={$table}&method=del&id={$v['id']}");
                $data[$k]['caozuo2'] = '<a href="' . $link . '"  onclick="javascript:return confirm(\'你确定要删除么？\')"><span class="icon_delete" title="删除"></span></a>';
            }

            if (self::isShowToggle($table)) {
                $data[$k]['caozuo4'] = '<a><span class="icon_down toggle_btn" title="显示"></span></a>';
            }

            if (self::readConfigByRole($table, 'detail') != null) {
                $detail_link = U(null, "table={$table}&method=detail&id={$v['id']}");
                $data[$k]['caozuo3'] = '<a href="' . $detail_link . '"><span class="icon_bar" title="详细"></span></a>';
            }

            $copyConfig = self::readConfigByRole($table, 'copy');
            if (!empty($copyConfig)) {
                $link = U(null, "table={$table}&method=copy&id={$v['id']}");
                $data[$k]['caozuo5'] = '<a href="' . $link . '"  onclick="javascript:return confirm(\'你确定要复制么？\')"><span class="icon_star" title="复制"></span></a>';
            }

            $n = 5;
            $operate = self::readConfigByRole($table, 'operate');;
            if (is_array($operate)) {
                foreach ($operate as $k2 => $v2) {
                    if (is_array($v2)) {
                        if ($v2['link']) {
                            $v2['link'] = self::parseLink($v2['link'], null, null, $v);
                            $v2['link'] = self::createLink($v2['link']);
                        }
                        if ($v2['aso']) {
                            $v2['aso'] = self::parseLink($v2['aso'], null, null, $v);
                        }
                        $link_icon = isset($v2['icon']) ? 'class="' . $v2['icon'] . '"' : 'class="icon_add"';
                        $link_name = isset($v2['name']) ? $v2['name'] : '';
                        $link_target = isset($v2['link_target']) ? ' target="' . $v2['link_target'] . '"' : "";
                        $link_attr = isset($v2['attr']) ? $v2['attr'] : '';
                        $link_aso = isset($v2['aso']) ? $v2['aso'] : '';
                        if ($v2['link'])
                            $data[$k]['caozuo' . $n++] = '<a href="' . $v2['link'] . '" ' . $link_attr . ' ' . $link_target . ' ' . $link_aso . '><span ' . $link_icon . ' title="' . $k2 . '"></span>' . $link_name . '</a>';
                        else
                            $data[$k]['caozuo' . $n++] = '<span ' . $link_icon . ' ' . $link_aso . ' title="' . $k2 . '"></span>' . $link_name;

                    }
                }
            }

            //from jungle 2016/06/30  批量删除
            if ($config['_all']) {
                $first_field = key($v);
                $data[$k][$first_field] = "<label><input type='checkbox' class='checkids' name='checkids[" . $first_field . "][]' value='" . $v[$first_field] . "' />&nbsp;" . $v[$first_field] . "</label>";
            }
        }

        $control_keys = array();
        if (isset ($config['_control'])) {
            $controls = $config['_control'];
            foreach ($controls as $key => $val) {
                $config[] = $key . "_control";
                $control_keys[] = $key;

                if (is_array($val['data']))
                    $control_data = $val;
                else
                    $control_data = self::parseFunc($val['data']);


                foreach ($data as $k => $v) {
                    $data[$k][$key . "_control"] = '';
                    foreach ($control_data as $control_k => $control_v) {
                        if ((string)$control_v === (string)$v[$key])
                            $class = " ajax_sel";
                        else
                            $class = "";

                        $ajax_href = U('Ajax/index',
                            array('table' => $table, 'key' => $key, 'value' => $control_v, 'id' => $v['id'])
                        );
                        $data[$k][$key . "_control"] .= "<span class=\"ajax{$class}\" ajax=\"{$ajax_href}\">{$control_k}</span> ";
                    }
                }
            }
        }

        $editkeys = array();
        foreach ($config as $k => $v) {
            if (is_array($v) && isset($v['type']) && $v['type'] == 'edit') //该列可以修改
            {
                foreach ($data as $k2 => $v2) {
                    $ajax_url = U('Ajax/index',
                        array('table' => $table, 'key' => $k, 'id' => $v2['id'])
                    );
                    $data[$k2][$k] = "<input type=\"text\" value=\"{$v2[$k]}\" data=\"{$v2[$k]}\" class=\"ajax_field\" ajax=\"{$ajax_url}\"/>";
                }
            }
        }


        $old_data = $data; //保留一个未被函数解析的data数据
        //解析config
        debug($config, "parseshow");
        foreach ($config as $k => $v) {
            $f = null;
            if (is_string($v))
                $k = $v;

            if (strpos($k, '|')) //字段合并的情况,合并字段暂不能支持style等情况
            {
                $keys = explode('|', $k);
                foreach ($keys as $v2) {
                    $field_name = isset($field[$v2]) ? $field[$v2] : '';

                    if (is_array($field[$v2])) {
                        $field_name = $field[$v2]['name'];
                        $field_attr = isset($field[$v2]['attr']) ? $field[$v2]['attr'] . ' ' : '';
                    }

                    $f['name'] .= $field_name ? $field_name . " / " : null;
                    $f['attr'] .= isset($field_attr) ? $field_attr : '';
                }
                $f['name'] = trim($f['name']);
                if (substr($f['name'], "-1") == '/')
                    $f['name'] = substr($f['name'], 0, -1);
            } else {
                $f = isset($field[$k]) ? $field[$k] : null;

                if ($f === null && strpos($k, "_control") !== false) //有的字段加了control
                {
                    $temp_k = str_replace('_control', '', $k);
                    $f = isset($field[$temp_k]) ? $field[$temp_k] : null;
                }
            }

            if ($f === null)
                continue;

            if (is_array($f)) {
                $fields[$f['name']] = $k;
                $attrs[$k]['attr'] = isset($f['attr']) ? $f['attr'] : null;
            } else {
                $fields[$f] = $k;
            }

            if (is_array($v)) {
                if (isset($v['attr'])) {
                    $attrs[$k]['attr2'] = $v['attr'];
                }

                if (isset($v['func'])) //函数解析
                {
                    foreach ($data as $k2 => $v2) {
                        $data[$k2][$k] = self::parseFunc($v['func'], $data[$k2][$k], $data[$k2]);
                    }
                }

                if (isset($v['link'])) {
                    foreach ($data as $k2 => $v2) {
                        $link = self::parseLink($v['link'], $old_data[$k2][$k], $data[$k2][$k], $data[$k2]);
                        $link = self::createLink($link);
                        if (isset($v['link_target']))
                            $target = "target=\"{$v['link_target']}\"";
                        $data[$k2][$k] = "<a href=\"{$link}\" {$target}>{$v2[$k]}</a>";
                    }
                }

                if (isset($v['type']) && $v['type'] == 'toggle') // toggle处理
                {
                    foreach ($data as $k2 => $v2) {
                        $toggle[$k2][$k] = $data[$k2][$k];
                        unset($data[$k2][$k]);
                    }
                }
            }
        }


        $flip_fields = array_flip($fields);

        foreach ($data[0] as $k => $v) //对最简单配置的支持
        {
            if (!isset($flip_fields[$k]) && !in_array($k, $control_keys) && !preg_match('/^caozuo\d$/', $k))
                $fields[$k] = $k;
        }

        $fields['操作'] = 'caozuo1|caozuo2|caozuo3|caozuo4|caozuo5|caozuo6|caozuo7|caozuo8|caozuo9';

        $result['fields'] = $fields;
        $result['data'] = $data;
        $result['toggle'] = $toggle ? $toggle : array();
        $result['attrs'] = $attrs;
        return $result;
    }

    static function isShowToggle($table)
    {
        $conf = self::readConfigByRole($table, 'show');
        foreach ($conf as $k => $v) {
            if (is_array($v) && isset($v['type']) && $v['type'] == 'toggle')
                return true;
        }
        return false;
    }

    static function createSearch($table = null , $config = null)
    {
        if(!empty($config))
            $search = $config;
        else
            $search = self::readConfigByRole($table, 'search');
        if (!$search) return '';

        $html = self::getHtml();
        $re = '<div id="search">';
        $i = $find = 0;
        $search_item = array();

        //判断是否是post请求
        $search_key = I('post.search_key', '');

        foreach ($search as $k => $v) {
            if ($search_key === (string)$i) //找到查询的类型
            {
                $class = " selected";
                $find = 1;
            } else {
                $find = 0;
                $class = "";
            }

            $re .= '<div class="item' . $class . '">' . $k . ':';
            $ul = '<ul>';
            foreach ($v as $k2 => $v2) {
                $li = '<li>';

                $input_type = isset($v2['type']) ? $v2['type'] : 'text';
                $input_name = $v2['name'];

                $input_data = null;
                if (isset($v2['data'])) {
                    if (is_string($v2['data']))
                        $input_data = self::parseFunc($v2['data']);
                    else if (is_array($v2['data']))
                        $input_data = $v2['data'];
                }
                if ($find) {
                    $field_name = preg_replace('/(.+)(__\d$)/', '$1', $input_name);
                    $input_post_data = I('post.' . $input_name, '');
                    $sign_post_data = I('post.' . $input_name . '_sign', '');

                    if ($input_post_data != '' && $sign_post_data != '') {
                        if (isset($v2['func'])) {

                            $sub_post_data = self::parseFunc($v2['func'], $input_post_data);

                            $search_item[] = "[{$field_name}]{$sign_post_data}[{$sub_post_data}]";
                        } else
                            $search_item[] = "[{$field_name}]{$sign_post_data}[{$input_post_data}]";
                    }
                } else if(!isset($_GET['p']) || $_GET['p'] == 1){
                    $tempDef = isset($v2['def']) ? $v2['def'] : null;
                    if(!empty($tempDef['func']))
                        $tempDef = self::parseFunc($tempDef['func']);
                    $input_post_data = $tempDef;
                    $sign_post_data = isset($v2['sign']) ? $v2['sign'] : 'eq';

                    if ($input_post_data != '' && $sign_post_data != '') {
                        $field_name = strpos($v2['name'], '_') ? (substr($v2['name'], 0, strpos($v2['name'], '_'))) : $v2['name'];
                        if (isset($v2['func'])) {


                            $sub_post_data = self::parseFunc($v2['func'], $input_post_data);



                            $search_item[] = "[{$field_name}]{$sign_post_data}[{$sub_post_data}]";
                        } else
                            $search_item[] = "[{$field_name}]{$sign_post_data}[{$input_post_data}]";

                    }
                }

                $sign_def = isset($v2['sign_def']) ? $v2['sign_def'] : null;
                $sign = isset($v2['sign']) ? $v2['sign'] : 'eq';
                $signs = explode('|', $sign);
                $sign_data = null;
                foreach ($signs as $key => $val) {
                    $sign_key = self::parseSignToChinese(self::parseStringToSign($val));
                    if ($sign_key)
                        $sign_data[$sign_key] = $val;
                }

                if (count($sign_data) > 1)
                    $li .= $k2 . "" . $html->createInput('select', $input_name . "_sign", $sign_post_data ? $sign_post_data : $sign_def, $sign_data);
                else
                    $li .= $k2 . "" . $html->createInput('hidden', $input_name . "_sign", $sign_data[$sign_key]);

                $li .= $html->createInput($input_type, $input_name, $input_post_data, $input_data);
                $li .= "</li>";
                $ul .= $li;
            }


            $ul .= $html->createInput('hidden', 'search_key', $i);
            $ul .= $html->createInput('submit', 'search', '查询');
            if($class) //当前选中状态
            {
                $ul .= '&nbsp;&nbsp;<a href="'.$_SERVER['REQUEST_URI'].'">取消</a>&nbsp;&nbsp;';
                //$data =

            }
            $ul .= "</ul>";
            $ul = $html->createForm($ul, __SELF__);
            $re .= $ul . "</div>";
            $i++;
        }

        $re .= "</div>";

        $search_str = '';
        if (count($search_item) > 0)
            $search_str = implode('|', $search_item);

        self::setGlobalWhere($table, $search_str);

        return $re;
    }

    static function setGlobalWhere($table, $where)
    {
        $GLOBALS[$table][] = $where;
    }

    static function deleteGlobalWhere($table)
    {
        unset($GLOBALS[$table]);
    }

    static function getGlobalWhere($table = null)
    {
        if ($table === null)
            $table = $_GET['table'];
        if (is_array($GLOBALS[$table]) && count($GLOBALS[$table]) > 0)
            return implode('|', $GLOBALS[$table]);
        return null;
    }

    static function createSearch1($table = null, $config = null)
    {
        if (!empty($config))
            $search = $config;
        else
            $search = self::readConfigByRole($table, 'search');
        if (!$search) return '';

        $html = self::getHtml();
        $re = '<div id="search">';
        $i = $find = 0;
        $search_item = array();
        $search_item1 = array();

        //判断是否是post请求
        $search_key = I('get.search_key', '');

        foreach ($search as $k => $v) {
            if ($search_key === (string)$i) //找到查询的类型
            {
                $class = " selected";
                $find = 1;
            } else {
                $find = 0;
                $class = "";
            }

            $re .= '<div class="item' . $class . '">' . $k . ':';
            $ul = '<ul>';
            foreach ($v as $k2 => $v2) {
                $li = '<li>';

                $input_type = isset($v2['type']) ? $v2['type'] : 'text';
                $input_name = $v2['name'];

                $input_data = null;
                if (isset($v2['data'])) {
                    if (is_string($v2['data']))
                        $input_data = self::parseFunc($v2['data']);
                    else if (is_array($v2['data']))
                        $input_data = $v2['data'];
                }
                if (!empty($_GET['search'])) {
                    $field_name = preg_replace('/(.+)(__\d$)/', '$1', $input_name);
                    $input_post_data = I('get.' . $input_name, '');
                    $sign_post_data = I('get.' . $input_name . '_sign', '');

                    if ($input_post_data != '' && $sign_post_data != '') {
                        if (isset($v2['func'])) {
                            $sub_post_data = self::parseFunc($v2['func'], $input_post_data);
                            if ($field_name != "order_field" && $field_name != "order_order") {
                                $search_item1[] = "[{$field_name}]{$sign_post_data}[{$sub_post_data}]";
                            }
                            $search_item[] = "[{$field_name}]{$sign_post_data}[{$sub_post_data}]";
                        } else {
                            if (is_array($input_post_data)) {
                                $input_post_data = implode(",", $input_post_data);
                            }
                            if ($field_name != "order_field" && $field_name != "order_order") {
                                $search_item1[] = "[{$field_name}]{$sign_post_data}[{$input_post_data}]";
                            }
                            $search_item[] = "[{$field_name}]{$sign_post_data}[{$input_post_data}]";
                        }
                    }
//                } else if (!isset($_GET['p'])) {
//                    $tempDef = isset($v2['def']) ? $v2['def'] : null;
//                    if (!empty($tempDef['func']))
//                        $tempDef = self::parseFunc($tempDef['func']);
//                    $input_post_data = $tempDef;
//                    $sign_post_data = isset($v2['sign']) ? $v2['sign'] : 'eq';
//
//                    if ($input_post_data != '' && $sign_post_data != '') {
//                        $field_name = strpos($v2['name'], '_') ? (substr($v2['name'], 0, strpos($v2['name'], '_'))) : $v2['name'];
//                        if (isset($v2['func'])) {
//                            $sub_post_data = self::parseFunc($v2['func'], $input_post_data);
//                            if ($field_name != "order_field" && $field_name != "order_order") {
//                                $search_item1[] = "[{$field_name}]{$sign_post_data}[{$sub_post_data}]";
//                            }
//                            $search_item[] = "[{$field_name}]{$sign_post_data}[{$sub_post_data}]";
//                        } else {
//                            if (is_array($input_post_data)) {
//                                $input_post_data = implode(",", $input_post_data);
//                            }
//                            if ($field_name != "order_field" && $field_name != "order_order") {
//                                $search_item1[] = "[{$field_name}]{$sign_post_data}[{$input_post_data}]";
//                            }
//                            $search_item[] = "[{$field_name}]{$sign_post_data}[{$input_post_data}]";
//                        }
//                    }
                } else if (!empty($_SESSION[$table])) {
                    $input_post_data = "";
                    $sign_post_data = "";
                    $input_sign = isset($v2['sign']) ? $v2['sign'] : 'text';
                    $field_name = strpos($v2['name'], '_') ? (substr($v2['name'], 0, strpos($v2['name'], '_'))) : $v2['name'];
                    $where = explode("|", $_SESSION[$table][0]); //解析方式：[attr]eq[3]
                    foreach ($where as $k => $v) {
                        $preg_str = '/^\[(.+)\](.+)\[(.+)\]$/i';
                        if (trim($v)) {
                            $preg = null;
                            preg_match($preg_str, $v, $preg);
                            if (count($preg) == 4) {
                                if ($preg[2] == $input_sign && $preg[1] == $field_name) {
                                    $input_post_data = $preg[3];
                                    $sign_post_data = $preg[2];
                                }
                            }
                        }
                    }
                    if ($input_post_data != '' && $sign_post_data != '') {
                        if (isset($v2['func'])) {
                            $sub_post_data = self::parseFunc($v2['func'], $input_post_data);
                            if ($field_name != "order_field" && $field_name != "order_order") {
                                $search_item1[] = "[{$field_name}]{$sign_post_data}[{$sub_post_data}]";
                            }
                            $search_item[] = "[{$field_name}]{$sign_post_data}[{$sub_post_data}]";
                        } else {
                            if (is_array($input_post_data)) {
                                $input_post_data = implode(",", $input_post_data);
                            }
                            if ($field_name != "order_field" && $field_name != "order_order") {
                                $search_item1[] = "[{$field_name}]{$sign_post_data}[{$input_post_data}]";
                            }
                            $search_item[] = "[{$field_name}]{$sign_post_data}[{$input_post_data}]";
                        }
                    }
                }

                $sign_def = isset($v2['sign_def']) ? $v2['sign_def'] : null;
                $sign = isset($v2['sign']) ? $v2['sign'] : 'eq';
                $signs = explode('|', $sign);
                $sign_data = null;
                foreach ($signs as $key => $val) {
                    $sign_key = self::parseSignToChinese(self::parseStringToSign($val));
                    if ($sign_key)
                        $sign_data[$sign_key] = $val;
                }

                if (count($sign_data) > 1)
                    $li .= $k2 . "" . $html->createInput('select', $input_name . "_sign", $sign_post_data ? $sign_post_data : $sign_def, $sign_data);
                else
                    $li .= $k2 . "" . $html->createInput('hidden', $input_name . "_sign", $sign_data[$sign_key]);

                $li .= $html->createInput($input_type, $input_name, $input_post_data, $input_data);
                $li .= "</li>";
                $ul .= $li;
            }


            $ul .= $html->createInput('hidden', 'search_key', $i);
            $ul .= $html->createInput('submit', 'search', '查询');
            if ($class) //当前选中状态
            {
                $request_arr = explode("&",$_SERVER['REQUEST_URI']);
                $new_request_str = $request_arr[0]."&".$request_arr[1]."&".$request_arr[2];
                $ul .= '&nbsp;&nbsp;<a href="' . $new_request_str . '" class="deleteSearchSession" attr="'.$table.'">取消</a>&nbsp;&nbsp;';
                //$data =

            }
            $ul .= "</ul>";
            $ul = $html->createForm($ul, __SELF__,"clientget");
            $re .= $ul . "</div>";
            $i++;
        }

        $re .= "</div>";

        $search_str = '';
        if (count($search_item1) > 0)
            $search_str = implode('|', $search_item1);

        self::deleteGlobalWhere1($table);
        self::setGlobalWhere1($table, $search_str);

        return $re;
    }

    static function setGlobalWhere1($table, $where)
    {
        $_SESSION[$table][] = $where;
    }

    static function deleteGlobalWhere1($table)
    {
//        if ($table == 'client_mst') {
                unset($_SESSION[$table]);
//        }
    }

    static function getGlobalWhere1($table = null)
    {
        if ($table === null)
            $table = $_GET['table'];
        if (is_array($_SESSION[$table]) && count($_SESSION[$table]) > 0)
            return implode('|', $_SESSION[$table]);
        return null;
    }


    static function readRole($method, $wh, $table = null, $id = null)
    {
        $role_where = R("Role/role", array($method, $table, $id)); //解析角色权限
        return implode(' and ', merge($role_where, $wh));
    }

    static function parseUrlWhere($where = null)
    {
        $url_where = '';

        //解析url里的where
        if (!$where)
            $where = isset($_REQUEST['where']) ? trim($_REQUEST['where']) : '';

        if ($where) //带有where的显示
        {
            debug($where, '待解析的WHERE');
            $preg_str = '/\$(.+)\$/sU';
            while (preg_match($preg_str, $where, $preg)) //$$之间的内容将被parseFunc
            {
                $temp = self::parseFunc($preg[1]);
                $where = preg_replace($preg_str, $temp, $where, 1);
            }

            $where = explode("|", $where); //解析方式：[attr]eq[3]
            foreach ($where as $k => $v) {
                $preg_str = '/^\[(.+)\](.+)\[(.+)\]$/i';
                if (trim($v)) {
                    $preg = null;
                    $re = preg_match($preg_str, $v, $preg);

                    if (count($preg) == 4) {
                        $sign = self::parseStringToSign($preg[2]);
                        if ($sign) {
                            if ($sign == 'like') {
                                $url_where .= "`{$preg[1]}` {$sign} '%{$preg[3]}%' and ";
                            } else if ($sign == 'in' || $sign == 'not in') {
                                $url_where .= "`{$preg[1]}` {$sign} ({$preg[3]}) and ";
                            } else
                                $url_where .= "`{$preg[1]}` {$sign} '{$preg[3]}' and ";
                        }
                    }
                }
            }
            $url_where = trim($url_where);

            if (substr($url_where, -3) == 'and')
                $url_where = substr($url_where, 0, -3);
        }
        return $url_where;
    }

    static private function isTable($table)
    {
        if (!$table)
            error("未找到table");
    }

    //TODO 实现部分字段的默认名称
    static private function defaultFieldName()
    {
        $arr = array(
            'id' => 'ID',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'create_time' => '创建时间',
            'ip' => 'IP',
            'runtime' => '运行时间',
            'info' => '说明',
        );
        return $arr;
    }
}
