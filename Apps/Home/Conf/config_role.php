<?php
/**用户权限配置
 *
 *        '_table' 列出所有表名，以便生成 “我的权限” 调用
 *
 *  '1' 指用户role类型，参照config里面的ADMIN_RULE填写
 *  然后'admin'是指表明，接下来create ,update ,read, delete,control是指（ 增、改、查、删、控制） 权限,
 *  如果未配置 create ,update ,read, delete,control中的一项，表明该项该用户没有权限
 *
 * [id]eq[$getAdminId$] 会调用TableAction::parseLink来解析
 */

return array(
    'ADMIN_ROLE_CONFIG' =>
        array(
            '_table' => array('admin', 'system_log'),
            '1' => array(
                'system_admin' => array(
                    'update' => '[id]eq[$getAdminId$]',
                    'read' => '[id]eq[$getAdminId$]'),
                'system_log' => array(
                    'read' => '[uname]eq[$getAdminName$]',
                    'control' => '[uname]eq[$getAdminName$]',
                ),
            ),


            '2' => array(
                'system_admin' => array(
                    'update' => '[id]eq[$getAdminId$]',
                    'read' => '[id]eq[$getAdminId$]'),
                'system_log' => array(
                    'read' => '[uname]eq[$getAdminName$]',
                    'control' => '[uname]eq[$getAdminName$]',
                ),
            ),
        ),
);
?>