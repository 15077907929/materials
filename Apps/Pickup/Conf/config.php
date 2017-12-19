<?php
$conf1 = array(
    'VERIFY_CODE' => false, //开启验证码
    'ADMIN_ROLE' => array('超级管理员' => '0', '录入员' => '1', '操作员' => '2'), //后台角色
    'ADMIN_SUPER' => 0, //超级管理员的类型
    'ADMIN_STATUS' => array('关闭' => '0', '正常' => '1', '锁定' => '2'), //锁定是用户连续登陆错误时系统自动锁定
    'ADMIN_LOCK_ERROR' => 5, //连续5此密码错误，自动锁定
    'ADMIN_LOCK_TIME' => 60, //自动解锁时间，设置为0表示永不解锁，只有后台可以解锁
    'LOG_TAG' => array('错误' => '0', '登录' => '1', 'Ajax' => '2'),
    'LOG_LOGIN_SUCCESS' => array('<span style="color:red">错误</span>' => '0', '成功' => '1'),
    'LOG_SYSTEM_READ' => array('未读' => '0', '已读' => '1'),
    'ENABLE' => array('禁止' => '0', '允许' => '1'),
    'YESORNO' => array('否' => '0', '是' => '1'),
    'LOGINCHECK' => array('待审核' => '0', '通过' => '1'),
    'SORTSTATUS' => array('最低级' => '1', '次低级' => '2', '中级' => '3', '次高级' => '4', '最高级' => '5'),
    'TASKTYPE' => array('测试' => '1', '正常' => '2', '高质量' => '3'),
    'CLIENTSTATUS' => array('禁用' => '0', '待审核' => '1', '启用' => '2'),
    'STEPUPDATE' => array('无进度' => '0', '升级中' => '1', '升级完成' => '2', '升级失败' => '2'),
    'LARGESTIDTYPE' => array('测试最大账号id' => 'test_max_account_id', '普通最大账号id' => 'max_account_id', '高质最大账号id' => 'vip_max_account_id'),
    'ASOTYPE' => array('下载' => '1','评论' => '2','搜索下载' => '3','只登录' => '4','只登陆搜索' => '5','不登陆搜索' => '6'),
    'SUPPLYSTATUS' => array('0' => '0','1' => '1','2' => '2','3' => '3','4' => '4'),
    'STATICSTATUS' => array('正常' => '0','异常' => '1','被拒' => '2'),
    'CURD' => array('添加'=>'add','修改'=>'edit','删除'=>'del'),
    'RATE' => array('五星'=>'5','四星'=>'4','三星'=>'3','二星'=>'2','一星'=>'1'),
    'ASOOPERATETYPE' => array('自营'=>'1','代理'=>'2'),
    'VPSTASKTYPE' => array('找回'=>'1','注册'=>'2','激活'=>'3'),
    'DYNAMICTYPE' => array('l2tp' => '0', '双通道' => '1','pptp' => '2'),
    'DYNAMICTESTSTATUS' => array('测试' => '1', '测试中' => '2','正常' => '3','禁用' => '4','不正常' => '5'),
    'CHANDASHI' => array('禁用' => '0', '可用' => '1'),
    'ACCOUNTTYPE' => array('icloud' => '1', '搜狐' => '2'),
    'DYNAMICUSER' => array('iphone' => '1', 'PC' => '2'),
    'TASKMODEL' => array('商业' => '1', '测试' => '2', '屠榜' => '3', '联运' => '4'),
    'IPHONEAUTH' => array('未授权' => '0', '已授权' => '1'),
    'IPHONEBINDINGTYPE' => array('数量' => '0', '比例' => '1'),
    'SEARCHKEYWORDTYPE' => array('首绑' => '1', '切换国家' => '2', '找回账号' => '3', '授权恢复' => '5', '只打开指定APP' => '7', '刷评论' => '10'),
    'TASKORDERCLASSTYPE' => array('商业单' => '1', '游戏推广' => '2', '测试' => '3', '洗号' => '4', '评论评星' => '5'),
    'COMMENTTYPE' => array('评星并评论' => '2', '只评星' => '1'),
    'COUNTRYTYPE' => array('国内' => '1', '国外' => '2'),
    'IPHONEVERSIONTYPE' => array('开发版' => '1', '商用版' => '2'),
    'PROXYDEVICETYPE' => array('手机' => 1, '打号' => 2, '协议' => 3),
    'PROXYTYPE' => array('阿里云' => 1, 'ucloud' => 2, '亚马逊' => 3),
    'KEYWORDFLAG' => array('有效' => '1', '无效' => '2', '疑似有效' => '3'),
    'COMMENTGAMETYPE' => array('乐盟海外运营' => '1', '联运' => '2', '评论测试' => '3'),
    'SALEBILLTYPE' => array('CPI'=>'1','评分'=>'2','评论'=>'3','冲榜'=>'4','ASO'=>'5'),
    'BILLSTATUS' => array('已完成'=>'1','未完成'=>'2','执行中'=>'3'),
    'ASOBALANCETYPE' => array('预收'=>'1','尾款'=>'2','退款'=>'3'),
    'ASOPAYTYPE' => array('paypal'=>'1','西联电汇'=>'2','银行转账'=>'3'),
    'SALEMONEYTYPE' => array('美元'=>'1','人民币'=>'2'),
    'MINUTE' => array(
        '00'=>'00','01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09',
        '10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19',
        '20'=>'20','21'=>'21','22'=>'22','23'=>'23','24'=>'24','25'=>'25','26'=>'26','27'=>'27','28'=>'28','29'=>'29',
        '30'=>'30','31'=>'51','32'=>'32','33'=>'33','34'=>'34','35'=>'35','36'=>'36','37'=>'37','38'=>'38','39'=>'39',
        '40'=>'40','41'=>'51','42'=>'42','43'=>'43','44'=>'44','45'=>'45','46'=>'46','47'=>'47','48'=>'48','49'=>'49',
        '50'=>'50','51'=>'51','52'=>'52','53'=>'53','54'=>'54','55'=>'55','56'=>'56','57'=>'57','58'=>'58','59'=>'59',
    ),
    'HOURS' => array(
        '00'=>'00','01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09',
        '10'=>'10','11'=>'11','12'=>'12', '13'=>'13', '14'=>'14', '15'=>'15', '16'=>'16', '17'=>'17', '18'=>'18', '19'=>'19',
        '20'=>'20', '21'=>'21', '22'=>'22', '23'=>'23',
    ),
    'NAVIGATION' => array(
        /**
         * 顶部导航 => array(
         *      左侧导航1=> array(
         *          'link'=> 链接地址， 格式：控制器名/方法名?参数1=值&参数2=值
         *          'power'=> 所需权限 ，不设置power则无需任何权限，允许多个权限用|分隔
         *      ),
         * ),
         */
        '销售管理' => array(
            '订单详情' => array(
                'link' => '/Sale/asoBillList',
                'power' => 'ABLO,ABLSALL'
            ),
            '订单打款详情' => array(
                'link' => '/Sale/balanceDetailList',
                'power' => 'BDLO,BDLSALL'
            ),
            '收款信息配置' => array(
                'link' => '/Sale/collectionList',
                'power' => 'CLO'
            ),
        ),
        '手机管理' => array(
            '手机管理段查看' => array(
                'link' =>  '/Iphone/iphoneClientListSegmentShow',
                'power' => 'ICLSSS'
            ),
            '手机管理TAG查看' => array(
                'link' =>  '/Iphone/iphoneClientListShow',
                'power' => 'ICLSSS'
            ),
            '手机管理' => array(
                'link' =>  '/Iphone/iphoneList',
                'power' => 'IPHONES,IPHONEO'
            ),
            '开发版相关设置' => array(
                'link' =>  '/Iphone/iphoneConfig',
                'power' => 'IPHONECO'
            ),
            '商用版相关设置' => array(
                'link' =>  '/Iphone/iphoneConfigBusiness',
                'power' => 'IPHONECO'
            ),
            '代理服务器' => array(
                'link' =>  '/Iphone/proxyServerList',
                'power' => 'PSL'
            ),
            '手机模式管理' => array(
                'link' => '/Iphone/iphoneModelList',
                'power' => 'IMO'
            ),
            '手机TAG管理' => array(
                'link' =>  '/Table/index?table=iphone_tag_mst',
                'power' => 'IMO'
            ),
            '手机段成功率查看' => array(
                'link' =>  '/Iphone/iphoneSidList',
                'power' => 'ICLSSS'
            ),
        ),
        '动态包管理' => array(
            '动态包TAG管理' => array(
                'link' =>  '/Table/index?table=dynamic_tag_mst',
                'power' => 'DTMO',
            ),
            '动态包类型管理' => array(
                'link' => '/Dynamic/dynamicTypeList',
                'power' => 'DTLO'
            ),
            '上传动态包管理' => array(
                'link' => '/Dynamic/dynamicPackageList',
                'power' => 'DPLO'
            ),
            '动态更新记录' => array(
                'link' => '/Dynamic/dynamicUpdateList',
                'power' => 'DULO'
            ),
			'手机动态包版本管理' => array(
                'link' =>  '/Iphone/googleMobileList',
                'power' => 'PDCL'
            ),
        ),
        '任务管理' => array(
            'CP管理' => array(
                'link' => '/Table/index?table=google_cp_config',
                'power' => 'GCPO',
                'parent' => '基本设置',
            ),
            '应用管理' => array(
                'link' => '/Task/appManager',
                'power' => 'GGAMES,GGAMEO',
                'parent' => '基本设置',
            ),
            '任务TAG管理' => array(
                'link' =>  '/Table/index?table=task_tag_mst',
                'power' => 'TTMO',
                'parent' => '协议任务管理'
            ),
            '任务类型管理' => array(
                'link' => '/Table/index?table=google_task_type',
                'power' => 'GTT',
                'parent' => '协议任务管理',
            ),
            '协议管理' => array(
                'link' => '/Task/agreementList',
                'power' => 'AMLO',
                'parent' => '协议任务管理',
            ),
            '组任务管理' => array(
                'link' => '/Task/taskManager',
                'power' => 'GTASKS,GTASKO,GTASKO1',
                'parent' => '协议任务管理',
            ),
            '单条任务查看' => array(
                'link' => '/Task/oneTaskManager',
                'power' => 'OTMS',
                'parent' => '协议任务管理',
            ),
            '协议任务计划评估' => array(
                'link' =>  '/Total/proTaskPlan',
                'power' => 'PTASKP',
                'parent' => '协议任务管理',
            ),
            '真机任务列表' => array(
                'link' =>  '/Task/searchKeywordIpTaskList',
                'power' => 'SKITLS,SKITLO',
                'parent' => '真机任务管理',
            ),
            '真机评论任务列表' => array(
                'link' =>  '/Task/commentKeywordIpTaskList',
                'power' => 'SKITLS,SKITLO',
                'parent' => '真机任务管理',
            ),
            '真机任务计划评估' => array(
                'link' =>  '/Total/taskPlan',
                'power' => 'TASKPS',
                'parent' => '真机任务管理',
            ),
            '商业单综合查看' => array(
                'link' =>  '/Iphone/totalListBusiness',
                'power' => 'TLBS',
                'parent' => '真机任务管理',
            ),
            '评论库' => array(
                'link' =>  '/Task/commentList',
                'power' => 'CLS',
                'parent' => '真机任务管理',
            ),
            '关键词跟踪' => array(
                'link' => '/Task/keywordCollect',
                'power' => 'KCS,KCSO',
                'parent' => '真机任务管理',
            ),
            '历史排名导出' => array(
                'link' => '/Task/historyRankExport',
                'power' => 'HRE',
                'parent' => '真机任务管理',
            ),
            '搜索关键字排名' => array(
                'link' => '/Task/searchRank',
                'power' => 'SYYPM',
                'parent' => '搜索关键字排名',
            ),
            '国家管理' => array(
                'link' => '/Task/countryMst',
                'power' => 'CIL',
                'parent' => '账号任务管理',
            ),
            '国家表管理' => array(
                'link' => '/Task/countryDBMst',
                'power' => 'CDBM',
                'parent' => '账号任务管理',
            ),
            '国家运营商管理' => array(
                'link' => '/Task/countryInfoList',
                'power' => 'CIL',
                'parent' => '账号任务管理',
            ),
            '账号任务管理' => array(
                'link' =>  '/Task/accountBindingList',
                'power' => 'ABL',
                'parent' => '账号任务管理',
            ),
            '账号追踪组' => array(
                'link' =>  '/Task/accountGroupList',
                'power' => 'AGL',
                'parent' => '账号任务管理',
            ),
//            '搜索关键词' => array(
//                'link' => '/Task/searchKeywordList',
//                'power' => 'OTMS'
//            ),
        ),
        '数据分析' => array(
            '打号统计' => array(
                'link' => '/Total/accountInfoList',
                'power' => 'AIL'
            ),
            '账号任务统计' => array(
                'link' => '/Total/getBackList',
                'power' => 'GBL'
            ),
            '协议任务统计' => array(
                'link' => '/Total/agreementTaskStatistic',
                'power' => 'ATS'
            ),
            '网络请求统计' => array(
                'link' => '/Total/getTempLog',
                'power' => 'GTL'
            ),
			'新增查询页面' => array(
                'link' => '/Total/getKeywords',
                'power' => 'XZCX'
            ),
			'appfigures' => array(
                'link' =>  '/Total/appfigures',
                'power' => 'APPF'
            ),			
			'appfigures图' => array(
                'link' =>  '/Total/appfigures_graph',
                'power' => 'APPFT'
            ),			
			'成功数图' => array(
                'link' =>  '/Total/appfigures_graph_S',
                'power' => 'APPFTS'
            ),			
			'成功数天' => array(
                'link' =>  '/Total/appfigures_T',
                'power' => 'CGST'
            ),
        ),
        'VPN管理' => array(
            'VPN管理' => array(
                'link' =>  '/Vpn/vpnList',
                'power' => 'VPNS,VPNO'
            ),
            'VPN组管理' => array(
                'link' =>  '/Table/index?table=vpn_mst_group',
                'power' => 'VPNG0'
            ),
            'VPN文件导入' => array(
                'link' =>  '/Vpn/vpnFileImport',
                'power' => 'VPNFIO'
            ),
        ),
        '系统管理' => array(
            '账号管理' => array(
                'link' => '/Account/accountManage',
                'power' => 'AMO'
            ),
            '系统日志' => array(
                'link' => '/Table/index?table=system_log',
                'power' => 'all'
            ),
        ),
    ),

    'USER_POWER' => array(
        '最高权限' => array(
            '所有权限' => 'all',
        ),
        '销售管理' => array(
            '订单详情个人' => 'ABLO',
            '订单详情全部' => 'ABLSALL',
            '订单打款详情个人' => 'BDLO',
            '订单打款详情全部' => 'BDLSALL',
            '收款信息配置' => 'CLO',
        ),
        '手机管理' => array(
            '手机模式/国家/TAG管理' => 'IMO',
            '手机管理查看' => 'IPHONES',
            '手机管理修改' => 'IPHONEO',
            '手机管理段,TAG查看' => 'ICLSSS',
            '手机相关设置' => 'IPHONECO',
            '代理服务器' => 'PSL',
        ),
        '动态包管理' => array(
            '动态包TAG管理' => 'DTMO',
            '动态包类型管理' => 'DTLO',
            '上传动态包管理' => 'DPLO',
            '动态更新记录' => 'DULO',
			'手机动态包版本管理' => 'PDCL',
        ),
        '任务管理' => array(
            'CP管理' => 'GCPO',
            '应用管理查看' => 'GGAMES',
            '应用管理操作' => 'GGAMEO',
            '任务TAG管理' => 'TTMO',
            '任务类型管理' => 'GTT',
            '协议管理' => 'AMLO',
            '组任务管理查看' => 'GTASKS',
            '组任务管理操作' => 'GTASKO',
            '组任务管理启用禁用' => 'GTASKO1',
            '单条任务查看' => 'OTMS',
            '协议任务评估' => 'PTASKP',
            '真机任务列表查看' => 'SKITLS',
            '真机任务列表操作' => 'SKITLO',
            '真机任务计划评估' => 'TASKPS',
            '商业单综合查看' => 'TLBS',
            '评论库' => 'CLS',
            '关键词跟踪' => 'KCS',
            '关键词跟踪按钮操作' => 'KCSO',
            '历史排名导出' => 'HRE',
            '搜索关键字排名' => 'SYYPM',
            '国家管理' => 'CIL',
            '国家表管理' => 'CDBM',
            '账号任务管理' => 'ABL',
            '账号追踪组' => 'AGL',
        ),
        '数据分析' => array(
            '打号统计' => 'AIL',
            '账号任务统计' => 'GBL',
            '协议任务统计' => 'ATS',
            '网络请求统计' => 'GTL',
            '新增查询页面' => 'XZCX',
			'appfigures'   => 'APPF',		
			'appfigures图' => 'APPFT',
			'appfigures成功数图' => 'APPFTS',
			'成功数天' => 'CGST'
        ),
        'VPN管理' => array(
            'VPN管理查看' => 'VPNS',
            'VPN管理修改' => 'VPNO',
            'VPN组管理' => 'VPNG0',
            'VPN文件导入' => 'VPNFIO',
        ),
        '系统管理' => array(
            '账号管理' => 'AMO',
        ),
    ),
);
//网游账单权限

$conf2 = require('config_role.php');
$conf3 = require('config_table.php');


return array_merge($conf1, $conf2, $conf3);
