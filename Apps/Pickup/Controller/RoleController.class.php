<?php
/**
 * 此类的构造方法是验证后台操作权限，所有需要操作权限的类都继承与此类
 *
 */
namespace Pickup\Controller;
class RoleController extends BaseController
{
    private $table = null;
    private $id = null;
    private $roles = null;

    //private $con;


    function __construct()
    {
        parent::__construct();
        R('Login/isLogin');

        $common = new CommonController();
        if($common->checkUserPwd())
        {
            R('Login/password');
            exit;
        }

        $this->table = isset($_REQUEST['table']) ? $_REQUEST['table'] : null;
        $this->id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
        $this->roles = C('ADMIN_ROLE_CONFIG');

    }

    function role($operate = null, $table = null, $id = null)
    {
        return true;
        $table = strtolower($table);
        $re = $this->checkRole($operate, $table, $id);

        if ($re === true)
            return null;
        if ($re === false) {
            $this->display("Public:role");
            exit;
        }
        return $re;
    }


    function checkRole($operate, $table = null, $id = null) //$method = c,u,r,d
    {
        $admin_role = getAdminRole();
        if (isSuperAdmin($admin_role)) //超级管理员
            return true;

        if (!$table)
            $table = $this->table;
        if (!$id)
            $id = $this->id;

        if (!$operate || !$table)
            return false;

        if (($operate === 'update' || $operate === 'delete') && !$id)
            return false;

        $roles = $this->roles;
        if (!$roles)
            $this->error("未找到配置文件role.php");

        $role = $roles[$admin_role];
        if (!$role)
            return false;


        $table_role = $role[$table];
        if (!$table_role)
            return false;

        $role_field = isset($table_role[$operate]) ? $table_role[$operate] : null;

        if (!$role_field)
            return false;

        if ($role_field === true)
            return true;

        $role_field = TableController::parseLink($role_field);
        $role_field = TableController::parseUrlWhere($role_field);

        return $role_field;
    }

    function myRole() //查看我的权限
    {
        $roles = $this->roles;
        $alltable = $roles['_table'];

        $role_arr = array('读取' => 'read', '添加' => 'create', '修改' => 'update', '删除' => 'delete', '控制' => 'control');
        $role_arr = array_merge(array('表名' => 'table'), $role_arr);
        $attrs = array('table' => array('attr' => 'style="width:150px"'),
            'read' => array('attr' => 'style="width:150px"'),
            'create' => array('attr' => 'style="width:150px"'),
            'update' => array('attr' => 'style="width:150px"'),
            'delete' => array('attr' => 'style="width:150px"'),
            'control' => array('attr' => 'style="width:150px"'),
        );

        $i = 0;
        $allow = '<span class="icon_check icon_circle" title="允许"></span>';
        $part = '<span class="icon_star icon_circle icon_green" title="部分"></span>';
        $deny = '<span class="icon_delete icon_circle icon_red" title="不允许"></span>';

        $html = new \Home\Org\Html();

        $user_role = getAdminRole();
        $allrole = array_flip(C('ADMIN_ROLE'));
        if (isSuperAdmin($user_role)) {
            $get_role = $allrole;
        } else {
            $get_role = array($user_role => $allrole[$user_role]);
        }

        foreach ($get_role as $key => $val) {
            $role = $roles[$key];
            $data = null;
            $i = 0;
            foreach ($alltable as $k => $v) {
                $data[$i]['table'] = $v;
                $j = 0;
                foreach ($role_arr as $k2 => $v2) {
                    if ($j++ === 0)
                        continue;
                    if (isSuperAdmin($key))
                        $data[$i][$v2] = $allow;
                    else if (isSuperAdmin($user_role))
                        $data[$i][$v2] = isset($role[$v][$v2]) ? $role[$v][$v2] === true ? $allow : $part . $role[$v][$v2] : $deny;
                    else
                        $data[$i][$v2] = isset($role[$v][$v2]) ? $role[$v][$v2] === true ? $allow : $part : $deny;
                }
                $i++;
            }
            $html->table($role_arr, $data, $attrs);
            //$this->con['con'] .= TableAction::createNav(null,array('权限'=>array('link'=>'Role/myRole')));
            $this->main .= "<br /><h2>{$val}</h2><hr />";
            $this->main .= $html->html;
        }


        TableController::latelyView("后台权限浏览");
//		$this->display('Public:main');
        $this->_out();

    }


}

?>