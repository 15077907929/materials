<?php
//数据表配置文件
/**
 *  配置说明：
 *  只允许超级管理员读取的： show=super   ||   data=super ||  datasub=super
 *  允许有某个权限的人读取的： show=viewP  ||    show=viewP || show=viewP
 *  允许所有人读取的： show=all    || data=all  || datasub=all
 */

return array(
    'system_admin' => array(
        'name' => '用户表',
        'field' => array('id' => 'ID', 'uname' => '登录账号', 'upass' => '密码',
            'level' => '账号级别',
            'sitename' => '公司名称', 'channel_id' => '渠道ID',
            'state' => '状态', 'registertime' => '注册时间', 'lst_logintime' => '最后登录时间',
            'paruid' => '所属管理员',
            'conid' => '用户权限组', 'allowuids' => '允许查看渠道',
            'allowtype' => '允许游戏类型',
            'allowgame' => '附加游戏',
            'allowarea' => '地区选择',
            'allowaids' => '运营商数据',
            'power' => '附加权限',
            'show_field' => '运营商可查看列'
        ),

        'show=DATAZ4' => array(
            'id', 'uname', 'sitename', 'channel_id' => array('func' => 'zero=###'),
            'level' => array('func' => 'getKeyByValue=CHANNEL_LEVEL,###'),
            'registertime', 'lst_logintime',
            'conid' => array('func' => 'getGroupName=###'),
            'paruid' => array('func' => 'getAdminNameById=###'),
            'allowarea',
            'allowuids' => array('attr' => 'style="width:150px"', 'func' => 'substrTitle=###,30'),
            'allowaids' => array('attr' => 'style="width:150px"', 'func' => 'substrTitle=###,30'),
            'allowtype',
            'allowgame',
            'power' => array('func' => 'getPowerString=###'),
            '_control' => array(
                'state' => array('data' => 'C=ADMIN_STATUS'),
            ),
        ),

        //超级管理员
        'show' => array(
            'id', 'uname', 'sitename', 'channel_id' => array('func' => 'zero=###'),
            'level' => array('func' => 'getKeyByValue=CHANNEL_LEVEL,###'),
            'registertime', 'lst_logintime',
            'conid' => array('func' => 'getGroupName=###'),
            'allowarea',
            'allowuids' => array('attr' => 'style="width:150px"', 'func' => 'substrTitle=###,30'),
            'allowaids' => array('attr' => 'style="width:150px"', 'func' => 'substrTitle=###,30'),
            'allowtype', 'allowgame',
            'paruid' => array('func' => 'getAdminNameById=@@@'),
            'power' => array('func' => 'getPowerString=###'),
            'show_field',
            '_control' => array(
                'state' => array('data' => 'C=ADMIN_STATUS'),
            ),
        ),

        //超级管理员
        'data' => array(
            'uname', 'upass', 'sitename', 'channel_id',
            'state' => array('type' => 'select', 'data' => 'C=ADMIN_STATUS', 'def' => '1'),
            'level' => array('type' => 'select', 'data' => 'C=CHANNEL_LEVEL', 'def' => '1'),
            'conid' => array('type' => 'select', 'data' => 'getDataFromDb=ad_login_conf,title,id', 'def' => '1'),
            'paruid' => array('type' => 'select', 'data' => 'getGroupMaster'),
            'allowarea' => array('type' => 'selectmove', 'data' => array('南区' => '南区', '北区' => '北区', '中区' => '中区', '运营商' => '运营商'), 'attr' => 'size=12'),
            'allowuids' => array('type' => 'selectmove', 'data' => 'getDataFromDbK=channel_mst,sitename,channel_id', 'attr' => 'size=12'),
            'allowaids' => array('type' => 'selectmove', 'data' => 'getDataFromDbK=company_mst,short_name,id', 'attr' => 'size=12'),
            'allowtype' => array('type' => 'checkbox', 'data' => 'C=GAME_TYPE'),
            'allowgame' => array('type' => 'selectmove', 'data' => 'getAllGames', 'attr' => 'size=12'),
            'show_field' => array('type' => 'checkbox', 'data' => 'C=COMPANY_MONEY_FIELDS'),
            'power' => array('func' => 'getPowerCheckbox=power,###,1'),
        ),

        'datasub' => array(
            'uname',
            'upass' => array('func' => 'Common|passwd=###'), 'sitename',
            'channel_id' => array('value' => 'maybe'), 'state',
            'level' => array('value' => 'maybe'),
            'conid',
            'allowtype' => array('func' => 'arrayToStr=###', 'value' => 'maybe'),
            'allowgame' => array('func' => 'arrayToStr=###', 'value' => 'maybe'),
            'show_field' => array('func' => 'arrayToStr=###', 'value' => 'maybe'),
            'paruid' => array('value' => 'maybe'),
            'allowarea' => array('func' => 'arrayToStr=###', 'value' => 'maybe'),
            'allowuids' => array('func' => 'arrayToStr=###', 'value' => 'maybe'),
            'allowaids' => array('func' => 'arrayToStr=###', 'value' => 'maybe'),
            'registertime' => array('func' => 'date=Y-m-d H:i:s', 'when' => 'add'),
            'power' => array('func' => 'arrayToStr=###', 'value' => 'maybe'),
            'reset_pwd' => array('func' => 'time', 'when' => 'add'),
        ),

        'data=DATAZ4' => array(
            'uname', 'upass', 'sitename', 'channel_id',
            'state' => array('type' => 'select', 'data' => 'C=ADMIN_STATUS', 'def' => '1'),
            'level' => array('type' => 'select', 'data' => 'C=CHANNEL_LEVEL', 'def' => '1'),
            'paruid' => array('type' => 'select', 'data' => 'getGroupMaster'),
            'allowarea' => array('type' => 'selectmove', 'data' => array('南区' => '南区', '北区' => '北区', '中区' => '中区', '运营商' => '运营商'), 'attr' => 'size=12'),
            'allowuids' => array('type' => 'selectmove', 'data' => 'getDataFromDbK=channel_mst,sitename,channel_id', 'attr' => 'size=12'),
            'allowaids' => array('type' => 'selectmove', 'data' => 'getDataFromDbK=company_mst,short_name,id', 'attr' => 'size=12'),
            'allowtype' => array('type' => 'checkbox', 'data' => 'C=GAME_TYPE'),
            'allowgame' => array('type' => 'selectmove', 'data' => 'getAllGames', 'attr' => 'size=12'),
            'show_field' => array('type' => 'checkbox', 'data' => 'C=COMPANY_MONEY_FIELDS'),
        ),

        'datasub=DATAZ4' => array(
            'uname',
            'upass' => array('func' => 'Common|passwd=###'), 'sitename',
            'channel_id' => array('value' => 'maybe'), 'state',
            'level' => array('value' => 'maybe'),
            'allowtype' => array('func' => 'arrayToStr=###', 'value' => 'maybe'),
            'allowgame' => array('func' => 'arrayToStr=###', 'value' => 'maybe'),
            'show_field' => array('func' => 'arrayToStr=###', 'value' => 'maybe'),
            'paruid' => array('value' => 'maybe'),
            'allowarea' => array('func' => 'arrayToStr=###', 'value' => 'maybe'),
            'allowuids' => array('func' => 'arrayToStr=###', 'value' => 'maybe'),
            'allowaids' => array('func' => 'arrayToStr=###', 'value' => 'maybe'),
            'registertime' => array('func' => 'date=Y-m-d H:i:s', 'when' => 'add'),
            'reset_pwd' => array('func' => 'time', 'when' => 'add'),
        ),
        'del=eddAcc' => true,
        'search=mAcc' => array(
            '搜索' => array(
                '账号' => array('name' => 'uname', 'sign' => 'like'),
                '渠道ID' => array('name' => 'channel_id', 'sign' => 'like'),
                '账号级别' => array('name' => 'level', 'type' => 'select', 'data' => 'C=CHANNEL_LEVEL'),
                '公司' => array('name' => 'sitename', 'sign' => 'like'),
                '权限组' => array('name' => 'conid', 'type' => 'select', 'data' => 'getDataFromDb=ad_login_conf,title,id'),
                '附加权限' => array('name' => 'power', 'sign' => 'like'),
            )
        ),
    ),

    'system_log' => array(
        'name' => '系统日志',
        'field' => array('id' => 'ID', 'tag' => '标签', 'success' => '执行结果', 'module' => '模块', 'action' => '动作', 'info' => '说明', 'runtime' => '运行时间',
            'create_time' => '创建时间', 'isread' => '读取状态', 'uid' => '用户', 'ip' => 'IP', 'login_url' => '登录地址'),
        'show' => array('id', 'tag',
            'success' => array('func' => 'getKeyByValue=LOG_LOGIN_SUCCESS,###'),
            'module', 'action', 'uid' => array('func' => 'getLoginNameById=###,@id@'),
            'ip' => array('func' => 'getLocationByIp=###'),
            'info' => array('type' => 'toggle'),
            'runtime' => array('func' => 'friendSecond=###'), 'create_time' => array('func' => 'mdate=###'),
            '_control' => array('isread' => array('data' => 'C=LOG_SYSTEM_READ')),
            'login_url',
        ),
        'tab' => array(
            '未读' => array('link' => 'table=system_log&where=[isread]eq[0]', 'icon' => 'icon_message'),
            '已读' => array('link' => 'table=system_log&where=[isread]eq[1]', 'icon' => 'icon_message'),
            '今天' => array('link' => 'table=system_log&where=[create_time]gt[$strtotime=today$]', 'icon' => 'icon_add'),
            '昨天' => array('link' => 'table=system_log&where=[create_time]gt[$strtotime=today -1day$]|[create_time]lt[$strtotime=today$]'),
            '最近一周' => array('link' => 'table=system_log&where=[create_time]gt[$strtotime=today - 7day$]'),
            '统计' => array('link' => 'table=system_log&group=uid&field=count(uid),uid'),
            '标记已读' => array('link' => '/Common/setAllField?table=system_log&field=isread&value=1'),
        ),
        'search' => array(
            '搜索' => array(
                'I D' => array('name' => 'id', 'sign' => 'eq|gt|lt', 'sign_def' => 'gt'),
                '标签' => array('name' => 'tag', 'type' => 'select', 'data' => 'Log|getAllTag'),
                'IP' => array('name' => 'ip', 'type' => 'select', 'data' => 'Log|getIpData', 'sign' => 'in|not in'),
            ),
        ),
    ),

    'system_config' => array(
        'name' => '系统配置',
        'field' => array('id' => 'ID', 'k' => '配置项', 'v' => '配置值', 'digest' => '说明', 'enable' => '开启', 'create_time' => '创建时间', 'update_time' => '最后修改'),
        'show' => array('id', 'k', 'v', 'digest' => array('type' => 'toggle'),
            '_control' => array(
                'enable' => array('data' => 'C=YESORNO')
            ),
            'create_time' => array('func' => 'mdate=###'), 'update_time' => array('func' => 'mdate=###'),),
        'data' => array('k', 'v', 'digest' => array('type' => 'textarea')),
        'datasub' => array('k', 'v', 'digest', 'create_time' => array('func' => 'time', 'when' => 'add'), 'update_time' => array('func' => 'time')),
        'del' => true,
    ),

    'iphone_model' => array(
        'name' => '手机模式管理',
        'field' => array(
            'id' => 'ID',
            'mid' => '编号',
            'name' => '名称',
        ),
        'show=IMO' => array(
            'id', 'mid', 'name'
        ),
        'data=IMO' => array(
            'mid', 'name'
        ),
        'datasub=IMO' => array(
            'mid', 'name'
        ),
        'del=IMO' => true,
    ),

    'country_mst' => array(
        'name' => '国家管理',
        'field' => array(
            'id' => 'ID',
            'name' => '国家名',
            'short_name' => '简写',
            'language' => '语言',
        ),
        'show=CIL' => array(
            'id', 'name', 'short_name', 'language'
        ),
        'data=CIL' => array(
            'name', 'short_name', 'language'
        ),
        'datasub=CIL' => array(
            'name', 'short_name', 'language'
        ),
        'del=CIL' => true,
    ),

    'google_cp_config' => array(
        'name' => 'CP管理',
        'field' => array(
            'id' => 'ID',
            'cid' => '编号',
            'name' => '名称',
        ),
        'show=GCPO' => array(
            'id', 'cid', 'name'
        ),
        'data=GCPO' => array(
            'cid', 'name'
        ),
        'datasub=GCPO' => array(
            'cid', 'name'
        ),
        'del=GCPO' => true,
    ),

    'google_task_type' => array(
        'name' => '任务类型管理',
        'field' => array(
            'id' => 'ID',
            'tid' => '编号',
            'name' => '类型',
        ),
        'show=GTT' => array(
            'id', 'tid', 'name'
        ),
        'data=GTT' => array(
            'tid', 'name'
        ),
        'datasub=GTT' => array(
            'tid', 'name'
        ),
        'del=GTT' => true,
    ),

    'iphone_tag_mst' => array(
        'name' => '手机TAG管理',
        'field' => array(
            'id' => 'ID',
            'tid' => '编号',
            'name' => '名称',
        ),
        'show=IMO' => array(
            'id', 'tid', 'name'
        ),
        'data=IMO' => array(
            'tid', 'name'
        ),
        'datasub=IMO' => array(
            'tid', 'name'
        ),
        'del=IMO' => true,
    ),

    'task_tag_mst' => array(
        'name' => '任务TAG管理',
        'field' => array(
            'id' => 'ID',
            'tid' => '编号',
            'name' => '名称',
        ),
        'show=TTMO' => array(
            'id', 'tid', 'name'
        ),
        'data=TTMO' => array(
            'tid', 'name'
        ),
        'datasub=TTMO' => array(
            'tid', 'name'
        ),
        'del=TTMO' => true,
    ),

    'vpn_mst_group' => array(
        'db' => array('func' => 'C=DB_ASO_DATA'),
        'name' => 'VPN组管理',
        'field' => array(
            'id' => 'ID',
            'name' => 'VPN组名称',
        ),
        'show=VPNG0' => array(
            'id', 'name'
        ),
        'data=VPNG0' => array(
            'name'
        ),
        'datasub=VPNG0' => array(
            'name'
        ),
        'del=VPNG0' => true,
    ),

    'dynamic_tag_mst' => array(
        'name' => '动态包TAG管理',
        'field' => array(
            'id' => 'ID',
            'tid' => '编号',
            'tag_name' => '名称',
        ),
        'show=DTMO' => array(
            'id', 'tid', 'tag_name'
        ),
        'data=DTMO' => array(
            'tid', 'tag_name'
        ),
        'datasub=DTMO' => array(
            'tid', 'tag_name'
        ),
        'del=DTMO' => true,
    ),
);