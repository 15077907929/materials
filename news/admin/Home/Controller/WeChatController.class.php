<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class WeChatController extends CommonController {
    public function index(){
		$db=M('wechat_app');
		$method = I('get.method') ? I('get.method') : 'list';
		switch ($method) {
			case 'list':
				$this->assign('cur_nav','list');
				$res['count']=$db->count();
				$Page=new \Think\Page($res['count'],225);
				$res['show']= $Page->show();// 分页显示输出
				$res['list'] = $db->limit($Page->firstRow.','.$Page->listRows)->select();
				$this->assign('res',$res);
				$this->display('list');
			break;	
			case 'add':
				$labels=M('wechat_app')->distinct(true)->field('labels')->select();
				if(I('post.sub')){
					$arr=array(
						'type'=>I('post.type'),
						'app_id'=>I('post.app_id'),
						'name'=>I('post.name'),
						'cn_name'=>I('post.cn_name'),
						'secret'=>I('post.secret'),
						'add_time'=>date('Y-m-d')
					);
					if($db->add($arr)){
						$this->success('添加成功');exit;
					}else{
						$this->success('添加失败');
					}
				}
				$this->display('add');
			break;	
			case 'edit':
				$res['field']=$db->where('id='.$_GET['id'])->find();
				$this->assign('res',$res);
				if(I('post.sub')){
					$arr=array(
						'type'=>I('post.type'),
						'app_id'=>I('post.app_id'),
						'name'=>I('post.name'),
						'cn_name'=>I('post.cn_name'),
						'secret'=>I('post.secret'),
						'add_time'=>date('Y-m-d')
					);
					if($db->where('id='.$_POST['id'])->save($arr)){
						$this->success('修改成功');exit;
					}else{
						$this->error('修改失败');exit;
					}
				}
				$this->display('edit');
			break;	
			case 'del':	
				$field=$db->where('id='.I('get.id'))->find();
				if($db->where('id='.I('get.id'))->delete()){
					$this->success('删除成功');exit;
				}else{
					$this->success('删除失败');exit;
				}
			break;			
			case 'search':
				$res['labels']=M('wechat_app')->distinct(true)->field('labels')->select();
				$wechat_app=M('wechat_app');
				$where='labels=\''.$_GET['labels'].'\'';
				$res['count']=$wechat_app->where($where)->count();
				$Page=new \Think\Page($res['count'],25);
				$res['show']= $Page->show();// 分页显示输出
				$res['list'] = $wechat_app->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
				
				$this->assign('cur_labels',$_GET['labels']);
				$this->assign('res',$res);
				$this->display('search');
			break;
		}
		
	}


    public function appConfig()
    {
        $db=M('box_game');
        $method = I('get.method') ? I('get.method') : 'list';
        $apps = M('wechat_app')->select();
        $appsIndex = array();
        foreach ($apps as $row){
            $appsIndex[$row['app_id']] = $row['name'].'_'.$row['cn_name'];
        }
        switch ($method) {
            case 'list':
                $this->assign('cur_nav','appConfigList');
                $res['count']=$db->count();
                $Page=new \Think\Page($res['count'],25);
                $res['show']= $Page->show();// 分页显示输出
                //like 过滤
                $appid = $this->getCurrentUser();
                if ($appid){
                    $res['list'] = $db->where("apps like '%{$appid}%'")->
                    limit($Page->firstRow.','.$Page->listRows)->select();
                }else
                    $res['list'] = $db->limit($Page->firstRow.','.$Page->listRows)->select();
                foreach ($res['list']  as $k=>$row){
                    $appInfo = explode(',',$row['apps']);
                    $boxArr  = array();
                    foreach ($appInfo as $vo){
                        $boxArr[] = $appsIndex[$vo];
                    }
                    $res['list'][$k]['box'] = join(" | ",$boxArr);
                }
                $this->assign('res',$res);
                $this->display('boxList');
                break;
            case 'add':
                $apps = M('wechat_app')->select();
                $this->assign('apps',$apps);
                if(I('post.sub')){
                    $data = $_POST;
                    unset($data['sub']);
                    $data['apps'] = join(',',$data['apps']);
                    $data['tag'] = join(',',$data['tag']);
                    $data['add_time'] = date('Y-m-d H:i:s');
                    if ($data['code_img']){
                        $data['nav_type'] = 2;
                    }
                    if($db->add($data)){
                        $this->success('添加成功');
                    }else{
                        $this->success('添加失败');
                    }
                    exit;
                }
                $this->display('boxAdd');
                break;
            case 'edit':
                $apps = M('wechat_app')->select();
				$cates = M('box_category')->select();
                $this->assign('apps',$apps);
                $res = $db->where("id=".$_GET['id'])->find();
                $this->assign('res',$res);
				$this->assign('cates',$cates);
                if(I('post.sub')){
                    $data = $_POST;
                    unset($data['sub']);
                    $data['apps'] = join(',',$data['apps']);
                    $data['tag'] = join(',',$data['tag']);
                    $data['update_time'] = date('Y-m-d H:i:s');
                    if ($data['code_img']){
                        $data['nav_type'] = 2;
                    }
                    if($db->save($data)){
                        $this->success('添加成功');
                    }else{
                        $this->success('添加失败');
                    }
                    exit;
                }
                $this->display('boxEdit');
                break;
            case 'del':
                if($db->where('id='.I('get.id'))->delete()){
                    $this->success('删除成功');
                }else{
                    $this->success('删除失败');
                }
                exit;
                break;
        }
    }

    /**
     * 获取当前用户信息
     */
    public function getCurrentUser()
    {
        $id = cookie('id');
        if (isset($id)){
            $user = M('user')->where("id='{$id}'")->find();
            if ($user['appid']){
                $app = M('wechat_app')->where("id='{$user['appid']}'")->find();
                if ($app)
                    return $app['app_id'];
                else
                    return false;
            }
        }else
            return false;
    }

    /**
     * 游戏分类管理
     */
    public function gameTypeMange()
    {
        $db=M('box_category');
        $method = I('get.method') ? I('get.method') : 'list';
        $apps = M('wechat_app')->select();
        $appsIndex = array();
        foreach ($apps as $row){
            $appsIndex[$row['app_id']] = $row['name'].'_'.$row['cn_name'];
        }
        switch ($method) {
            case 'list':
                $this->assign('cur_nav','typeList');
                $res['count']=$db->count();
                $Page=new \Think\Page($res['count'],25);
                $res['show']= $Page->show();// 分页显示输出
                $res['list'] = $db->limit($Page->firstRow.','.$Page->listRows)->select();
                $boxArr  = array();
                foreach ($res['list']  as $k=>$row){
                    $appInfo = explode(',',$row['cate_apps']);
                    foreach ($appInfo as $vo){
                        $boxArr[$vo][] = $row['cate_name'];
                    }
                }
                $info = array();
                foreach ($boxArr as $k=>$row){
                    $temp = array();
                    $temp['box'] = $k;
                    $temp['type'] = join(',',$row);
                    $info[] = $temp;
                }
                $res['list'] = $info;
                $this->assign('res',$res);
                $this->display('typeList');
                break;
            case 'add':
                $apps = M('wechat_app')->select();
                $this->assign('apps',$apps);
                if(I('post.sub')){
                    $data = $_POST;
                    unset($data['sub']);
                    $data['cate_apps'] = join(',',$data['apps']);
                    $data['cate_addtime'] = date('Y-m-d');
                    if($db->add($data)){
                        $this->success('添加成功');
                    }else{
                        $this->success('添加失败');
                    }
                    exit;
                }
                $this->display('typeAdd');
                break;
            case 'edit':
                $app = M('wechat_app')->where("app_id='{$_GET['id']}'")->find();
                if ($app){
                    $app = $app['name'].'---'.$app['cn_name'];
                    $this->assign('app',$app);
                }else{
                    $this->assign('app',$_GET['id']);
                }
                $cates = $db->where("cate_apps like '%".$_GET['id']."%'")->select();
                $cateStr = array();
                foreach ($cates as $row){
                    $cateStr[] = $row['cate_name'];
                }
                $this->assign('cate',join(',',$cateStr));
                $all = $db->select();
                $tip = array();
                foreach ($all as $row){
                    $tip[] = $row['cate_name'];
                }
                $this->assign('tips',join(',',$tip));
                if(I('post.sub')){
                    $delApp = $_POST['editid'];
                    $cate = $_POST['cate'];
                    $cateArr = explode(',',$cate);
                    foreach ($all as $k => $row){
                        $apps = explode(',',$row['cate_apps']);
                        $key = array_search($delApp, $apps);
                        if ($key !== false)
                            array_splice($apps, $key, 1);
                        $all[$k]['cate_apps'] = join(',',$apps);
                    }

                    foreach ($all as $k => $row){
                        if (in_array($row['cate_name'],$cateArr)){
                            $arr = explode(',',$row['cate_apps']);
                            $arr[] = $delApp;
                            foreach ($arr as $k => $vo){
                                if (empty($vo)){
                                    unset($arr[$k]);
                                }
                            }
                            $row['cate_apps'] = join(',',$arr);
                        }
                        if ($row['cate_apps'])
                            $db->save($row);
                        else
                            $db->where("cate_id='".$row['cate_id']."'")->delete();
                    }
                    $this->success('添加成功');
                    exit;
                }
                $this->display('typeEdit');
                break;
            case 'del':
                $delApp = I('get.id');
                $all = $db->select();
                foreach ($all as $k => $row){
                    $apps = explode(',',$row['cate_apps']);
                    $key = array_search($delApp, $apps);
                    if ($key !== false)
                        array_splice($apps, $key, 1);
                    $all[$k]['cate_apps'] = join(',',$apps);
                }
                foreach ($all as $row){
                    if ($row['cate_apps'])
                        $db->save($row);
                    else
                        $db->where("cate_id='".$row['cate_id']."'")->delete();
                }
                $this->success('删除成功');
                exit;
                break;
        }
    }


    /**
     * 得到游戏分类
     */
    public function getGameType()
    {
        $json = I('post.game');
        $like = array();
        foreach ($json as $row){
            $like[] = "cate_apps like \"%{$row}%\"";
        }
        $rs = M('box_category')->field("distinct cate_id,cate_name")->where(join(' and ',$like))->select();
        $this->ajaxReturn($rs);
    }

    public function downLoadApp()
    {
        $method = I('get.method') ? I('get.method') : 'list';
        $db=M('wechat_download_log');
        switch ($method) {
            case 'list':
                $this->assign('cur_nav','download');
                $count=$db->where('mb=0')->count();
                $Page=new \Think\Page($count,1025);
                $show= $Page->show();// 分页显示输出
                $list = $db->where('mb=0')->limit($Page->firstRow.','.$Page->listRows)->select();
                $type = array('阅读型','导航类');
                foreach ($list as $k=>$row){
                        $list[$k]['type'] = $type[$row['type']];
                }
                $this->assign('res',array('count'=>$count,
                    'list'=>$list,'page'=>$show));
                $this->display('downloadList');
			break;
        }
    }    
	
	public function downLoadHomeworkBox()
    {
        $method = I('get.method') ? I('get.method') : 'list';
        $db=M('wechat_download_log');
        switch ($method) {
            case 'list':
                $this->assign('cur_nav','homeworkbox');
                $count=$db->where('mb=1')->count();
                $Page=new \Think\Page($count,25);
                $show= $Page->show();// 分页显示输出
                $list = $db->where('mb=1')->limit($Page->firstRow.','.$Page->listRows)->select();
                $this->assign('res',array('count'=>$count,
                    'list'=>$list,'page'=>$show));
                $this->display('downloadHomeworkList');
			break;
        }
    }

    public function getHomeworkBox($down=''){
        if (IS_AJAX || $down=='down'){
            $appid = $_POST['appid'];
            $projectName = $_POST['projectName'];
			$pageName=$projectName;
            $mb = $_POST['mb'];
            if (!$appid || !$projectName || !$mb){
                $this->ajaxReturn(array('status'=>0,'msg'=>'选项填写不全'));
            }
			
            //主配置文件
            $json_string = file_get_contents("/opt/data/web/news/admin/uploads/homeworkbox/project.config.json");
            $value = json_decode($json_string,true);
			
            $value['appid'] = $appid;
            $value['projectname'] = $projectName;
			
            file_put_contents("/opt/data/web/news/admin/uploads/homeworkbox/project.config.json",json_encode($value,JSON_UNESCAPED_UNICODE));

            $str = file_get_contents("/opt/data/web/news/admin/uploads/homeworkbox/pages/math_jisuangongju/math_jisuangongju.js");
            $str = str_replace('wxb70f247785aee701',$appid,$str);
            file_put_contents("/opt/data/web/news/admin/uploads/homeworkbox/pages/math_jisuangongju/math_jisuangongju.js",$str);				
			
            exec("cd /opt/data/web/news/admin/uploads;tar -zcvf app.tar.gz homeworkbox",$result);

            $str = file_get_contents("/opt/data/web/news/admin/uploads/homeworkbox/pages/math_jisuangongju/math_jisuangongju.js");
            $str = str_replace($appid,'wxb70f247785aee701',$str);
            file_put_contents("/opt/data/web/news/admin/uploads/homeworkbox/pages/math_jisuangongju/math_jisuangongju.js",$str);

            //添加记录
            $db = M('wechat_download_log');
			$data['mb']=1;	//模板编号
            $where['app_id'] = $data['app_id'] = $appid;
            $where['project_name'] = $data['project_name'] = $projectName;
            $where['page_name'] = $data['page_name'] = $pageName;
            $find = $db->where($data)->find();
            if ($find){
                $data['count'] = $find['count']+1;
                $db->where($where)->data($data)->save();
            }else{
                $db->data($data)->add();
            }
            if ($down == 'down'){
                return true;
            }
            if (empty($result)){
                $this->ajaxReturn(array('status'=>0,'msg'=>'项目生成失败'));
            }else{
                $this->ajaxReturn(array('status'=>1,'msg'=>'成功生成项目'));
            }
        }
        $this->assign('cur_nav','homeworkbox');
        $this->display();
    }
	
    public function downApp()
    {
        if (IS_GET){
            $_POST = $_GET;
            $rs = $this->changeFile('down');
            if ($rs){
                //输出文件
                header('location:http://newsadmin.hmset.com/uploads/app.tar.gz');
            }
        }
    }
	
	public function downHomeworkBox()
    {
        if (IS_GET){
            $_POST = $_GET;
            $rs = $this->getHomeworkBox('down');
            if ($rs){
                //输出文件
                header('location:http://newsadmin.hmset.com/uploads/app.tar.gz');
            }
        }
    }


    /**
     * 更改阅读文件
     * @param string $down
     * @return bool
     */
    public function changeFile($down='')
    {
        if (IS_AJAX || $down=='down'){
            $appid = $_POST['appid'];
            $projectName = $_POST['projectName'];
            $pageName = $_POST['pageName'];
            if (!$appid || !$projectName || !$pageName){
                $this->ajaxReturn(array('status'=>0,'msg'=>'选项填写不全'));
            }
            //主配置文件
            $json_string = file_get_contents("/opt/data/web/news/admin/uploads/small_procedure2/project.config.json");
            $value = json_decode($json_string,true);
            $value['appid'] = $appid;
            $value['projectname'] = $projectName;
            file_put_contents("/opt/data/web/news/admin/uploads/small_procedure2/project.config.json"
                ,json_encode($value,JSON_UNESCAPED_UNICODE));

            //接口文件
            $str ='class Config{constructor(){}}Config.baseURI = "https://news.hmset.com";
        Config.appid = "'.$appid.'";export{Config};';
            file_put_contents("/opt/data/web/news/admin/uploads/small_procedure2/utils/Config.js"
                ,$str);

            //收藏页
            $json_string =
                file_get_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/collect/collect.json");
            $value = json_decode($json_string,true);
            $value['navigationBarTitleText'] = $pageName.'我的收藏';
            file_put_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/collect/collect.json",
                json_encode($value,JSON_UNESCAPED_UNICODE));

            //内容页
            $json_string =
                file_get_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/display/display.json");
            $value = json_decode($json_string,true);
            $value['navigationBarTitleText'] = $pageName;
            file_put_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/display/display.json",
                json_encode($value,JSON_UNESCAPED_UNICODE));

            $json_string =
                file_get_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/hot/hot.json");
            $value = json_decode($json_string,true);
            $value['navigationBarTitleText'] = $pageName;
            file_put_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/hot/hot.json",
                json_encode($value,JSON_UNESCAPED_UNICODE));

            $str = file_get_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/hot/hot.js");
            $str = str_replace('恋爱情侣',$pageName,$str);
            file_put_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/hot/hot.js",$str);


            $str = file_get_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/index/index.js");
            $str = str_replace('恋爱情侣',$pageName,$str);
            file_put_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/index/index.js",$str);            
			
			$str = file_get_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/index/index.js");
            $str = str_replace('wx7d85f4d298cc18dc',$appid,$str);
            file_put_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/index/index.js",$str);

            $json_string =
                file_get_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/index/index.json");
            $value = json_decode($json_string,true);
            $value['navigationBarTitleText'] = $pageName;
            file_put_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/index/index.json",
                json_encode($value,JSON_UNESCAPED_UNICODE));

            exec("cd /opt/data/web/news/admin/uploads;tar -zcvf app.tar.gz small_procedure2",$result);

            $str = file_get_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/hot/hot.js");
            $str = str_replace($pageName,'恋爱情侣',$str);
            file_put_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/hot/hot.js",$str);


            $str = file_get_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/index/index.js");
            $str = str_replace($pageName,'恋爱情侣',$str);
            file_put_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/index/index.js",$str);            
			
			$str = file_get_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/index/index.js");
            $str = str_replace($appid,'wx7d85f4d298cc18dc',$str);
            file_put_contents("/opt/data/web/news/admin/uploads/small_procedure2/pages/index/index.js",$str);
            //添加记录
            $db = M('wechat_download_log');
            $where['app_id'] = $data['app_id'] = $appid;
            $where['project_name'] = $data['project_name'] = $projectName;
            $where['page_name'] = $data['page_name'] = $pageName;
            $find = $db->where($data)->find();
            if ($find){
                $data['count'] = $find['count']+1;
                $db->where($where)->data($data)->save();
            }else{
                $db->data($data)->add();
            }
            if ($down == 'down'){
                return true;
            }
            if (empty($result)){
                $this->ajaxReturn(array('status'=>0,'msg'=>'项目生成失败'));
            }else{
                $this->ajaxReturn(array('status'=>1,'msg'=>'成功生成项目'));
            }
        }
        $this->assign('cur_nav','download');
        $this->display();
    }
    
	public function createAdmin(){
		$this->assign('cur_nav','create');
		if($_POST['appid']){
			$content=file_get_contents("/opt/data/web/news/admin/Home/Controller/Article29Controller.class.php.bak");
			$app=M('wechat_app')->where('app_id=\''.$_POST['appid'].'\'')->find();
			//生成控制器
			$content=str_replace('appidsjk',$_POST['appid'],$content);
			$content=str_replace("'cur_nav',29","'cur_nav',".$app['id'],$content);
			$content=str_replace("Article29",'Article'.$app['id'],$content);
			file_put_contents('/opt/data/web/news/admin/Home/Controller/Article'.$app['id'].'Controller.class.php',$content);
			//生成模板
			if(!file_exists('/opt/data/web/news/admin/Home/View/Article'.$app['id'])){
				mkdir('/opt/data/web/news/admin/Home/View/Article'.$app['id']);
			}
			$content=file_get_contents('/opt/data/web/news/admin/Home/View/Article29bak/add.html');
			$content=str_replace("Article29",'Article'.$app['id'],$content);
			file_put_contents('/opt/data/web/news/admin/Home/View/Article'.$app['id'].'/add.html',$content);			
			
			$content=file_get_contents('/opt/data/web/news/admin/Home/View/Article29bak/edit.html');
			$content=str_replace("Article29",'Article'.$app['id'],$content);
			file_put_contents('/opt/data/web/news/admin/Home/View/Article'.$app['id'].'/edit.html',$content);			
			
			$content=file_get_contents('/opt/data/web/news/admin/Home/View/Article29bak/gzconfig_edit.html');
			$content=str_replace("Article29",'Article'.$app['id'],$content);
			file_put_contents('/opt/data/web/news/admin/Home/View/Article'.$app['id'].'/gzconfig_edit.html',$content);			
			
			$content=file_get_contents('/opt/data/web/news/admin/Home/View/Article29bak/keyword.html');
			$content=str_replace("Article29",'Article'.$app['id'],$content);
			file_put_contents('/opt/data/web/news/admin/Home/View/Article'.$app['id'].'/keyword.html',$content);			
			
			$content=file_get_contents('/opt/data/web/news/admin/Home/View/Article29bak/list.html');
			$content=str_replace("Article29",'Article'.$app['id'],$content);
			file_put_contents('/opt/data/web/news/admin/Home/View/Article'.$app['id'].'/list.html',$content);
			
			$content=file_get_contents('/opt/data/web/news/admin/Home/View/Article29bak/search.html');
			$content=str_replace("Article29",'Article'.$app['id'],$content);
			file_put_contents('/opt/data/web/news/admin/Home/View/Article'.$app['id'].'/search.html',$content);
			//生成数据库
			$sql="CREATE TABLE `".$_POST['appid']."` (
				  `art_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `art_tit` varchar(100) NOT NULL,
				  `art_keyword` varchar(100) NOT NULL DEFAULT '',
				  `art_img` varchar(255) NOT NULL,
				  `art_cate` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '//文章分类',
				  `art_content` mediumtext NOT NULL,
				  `art_view` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '//浏览次数',
				  `art_order` int(10) unsigned NOT NULL DEFAULT '0',
				  `art_status` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '//0,采集来的文章;1,正常添加或者采集后处理过的文章',
				  `art_addtime` datetime NOT NULL,
				  PRIMARY KEY (`art_id`),
				  UNIQUE KEY `a` (`art_tit`) USING BTREE
				) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;";
			M()->query($sql);
			$sql="INSERT INTO `".$_POST['appid']."` VALUES ('2', '法法师', '', '', '23', '&lt;p&gt;范德萨发生大&lt;br/&gt;&lt;/p&gt;', '1', '0', '1', '2018-08-17 00:00:00');";
			M($_POST['appid'])->query($sql);
		}
		$this->display('createAdmin');
	}
}