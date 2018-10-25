<?php
class KcbController extends Yaf_Controller_Abstract{
	//课程表用户初始化
    public function initAction(){
		if($_COOKIE['user']==''){
			$sql='insert into users set addtime=\''.date('Y-m-d').'\'';
			JoyDb2::insert($sql);
			$sql='select id from users order by id desc limit 1';
			$res=JoyDb2::query($sql)[0];
			header('cookie:user='.$res['id']);
			echo json_encode(array('status'=>1,'res'=>$res));
		}else{
			echo 'done';
		}
	}
	
	
	//学科设置-添加学科
    public function addcourseAction(){
		$sql='insert into courses set user_id=\''.$_COOKIE['user'].'\',name=\''.$_POST['name'].'\',title=\''.$_POST['title'].'\',teacher=\''.$_POST['teacher'].'\',classroom=\''.$_POST['classroom'].'\'';
		JoyDb2::insert($sql);		
		echo json_encode(array('status'=>1,'info'=>'保存成功'));
	}
	//学科设置-获取学科列表
    public function getcourseAction(){
		$sql='select * from courses where user_id='.$_COOKIE['user'];
		$res=JoyDb2::query($sql);
		echo json_encode(array('status'=>1,'list'=>$res));
	}
	//学科设置-编辑学科
    public function editcourseAction(){
		if($_POST){
			$sql='update courses set name=\''.$_POST['name'].'\',title=\''.$_POST['title'].'\',teacher=\''.$_POST['teacher'].'\',classroom=\''.$_POST['classroom'].'\' where id='.$_POST['id'];
			JoyDb2::update($sql);
			echo json_encode(array('status'=>1,'info'=>'修改成功'));			
		}else{
			$sql='select * from courses where id='.$_GET['id'].' limit 1';
			$data=JoyDb2::query($sql)[0];
			echo json_encode(array('status'=>1,'field'=>$data));
		}
	}	
	//学科设置-删除学科
	public function delcourseAction(){
		$sql='delete from courses where id='.$_GET['id'];
		JoyDb2::delete($sql);		
		echo json_encode(array('status'=>1,'info'=>'删除成功'));
	}		
	
	
	//课节设置-添加课节
    public function addkjAction(){
		$sql='insert into classes set user_id=\''.$_COOKIE['user'].'\',title=\''.$_POST['title'].'\',starttime=\''.$_POST['starttime'].'\',endtime=\''.$_POST['endtime'].'\'';
		JoyDb2::insert($sql);	
		echo json_encode(array('status'=>1,'info'=>'保存成功'));
	}
	//课节设置-获取课节列表
    public function getkjAction(){
		$sql='select * from classes where user_id='.$_COOKIE['user'];
		$res=JoyDb2::query($sql);
		echo json_encode(array('status'=>1,'list'=>$res));
	}
	//课节设置-编辑课节
    public function editkjAction(){
		if($_POST){
			$sql='update classes set title=\''.$_POST['title'].'\',starttime=\''.$_POST['starttime'].'\',endtime=\''.$_POST['endtime'].'\' where id='.$_POST['id'];
			JoyDb2::update($sql);
			echo json_encode(array('status'=>1,'info'=>'修改成功'));			
		}else{
			$sql='select * from classes where id='.$_GET['id'].' limit 1';
			$data=JoyDb2::query($sql)[0];
			echo json_encode(array('status'=>1,'field'=>$data));
		}
	}	
	//课节设置-删除课节
	public function delkjAction(){
		$sql='delete from classes where id='.$_GET['id'];
		JoyDb2::delete($sql);		
		echo json_encode(array('status'=>1,'info'=>'删除成功'));
	}
	
	
	//获取日期相关
	public function getdateAction(){
		$sql='select * from users where id='.$_COOKIE['user'].' limit 1';
		$res=JoyDb2::query($sql)[0];
		$weekarray=array("日","一","二","三","四","五","六");
		$date="星期".$weekarray[date("w",time())];
		$arr=array('status'=>1,'date'=>$date,'key'=>date("w",time()));
		if($user['starttime']=='0000-00-00'){
			$arr['sdate']=date('Y-m-d');
			$arr['edate']=date('Y-m-d');
		}else{
			//学期起止时间
			$arr['sdate']=$res['termstart'];
			$arr['edate']=$res['termend'];
			//上课的日期
			$tem_arr=explode(',',$res['sk']);
			foreach($tem_arr as $val){
				$arr['sk'][$val]='checked';
			}
			//周
			$begin_date = strtotime($arr['sdate']);
			$end_date = strtotime($arr['edate']);
			$arr['weeks'] = ceil(($end_date - $begin_date) / 3600 / 24 / 7);
			$arr['cweeks'] = ceil((time() - $begin_date) / 3600 / 24 / 7);
		}
		echo json_encode($arr);
	}		
	//设置日期相关
    public function setdateAction(){
		if($_GET['type']=='s'){
			$sql='update users set termstart=\''.$_GET['val'].'\' where id='.$_COOKIE['user'];
			JoyDb2::update($sql);
		}else if($_GET['type']=='e'){
			$sql='update users set termend=\''.$_GET['val'].'\' where id='.$_COOKIE['user'];
			JoyDb2::update($sql);
		}else{
			$sql='update users set sk=\''.$_GET['val'].'\' where id='.$_COOKIE['user'];
			JoyDb2::update($sql);
		}
		echo json_encode(array('status'=>1,'info'=>'保存成功'));
	}	


	//课程管理-添加课程-课节选项
    public function getkj_pAction(){
		$sql='select * from classes where user_id='.$_COOKIE['user'];
		$res=JoyDb2::query($sql);		
		foreach($res as $val){
			$data[]=$val['title'].'('.$val['starttime'].'-'.$val['endtime'].')';
			$ids[]=$val['id'];
		}
		echo json_encode(array('status'=>1,'list'=>$data,'ids'=>$ids));
	}
	//课程管理-添加课程-学科选项
    public function getxkAction(){
		$sql='select * from courses where user_id='.$_COOKIE['user'];
		$res=JoyDb2::query($sql);		
		foreach($res as $val){
			$data[]=$val['name'];
			$ids[]=$val['id'];
		}
		echo json_encode(array('status'=>1,'list'=>$data,'ids'=>$ids));
	}	
	//课程管理-添加课程
    public function addkcAction(){
		$sql='insert into kechengbiao set user_id=\''.$_COOKIE['user'].'\',date=\''.$_POST['date'].'\',week=\''.$_POST['week'].'\',class_id=\''.$_POST['class_id'].'\''.',course_id=\''.$_POST['course_id'].'\'';
		JoyDb2::insert($sql);
		echo json_encode(array('status'=>1,'info'=>'保存成功'));
	}	
	//课程管理-获取当天课程列表
    public function getckcAction(){
		$weekarray=array("日","一","二","三","四","五","六");
		$date="星期".$weekarray[date("w",time())];
		$sql='select * from kechengbiao where user_id='.$_COOKIE['user'];
		$res=JoyDb2::query($sql);		
		foreach($res as $key=>$val){
			if($val['date']==$date){
				$data[]=$val;
			}
		}
		foreach($data as &$val){
			$sql='select * from courses where id='.$val['course_id'].' limit 1';
			$course=JoyDb2::query($sql)[0];	
			$val['course']=$course;			
			$sql='select * from classes where id='.$val['class_id'].' limit 1';
			$class=JoyDb2::query($sql)[0];	
			$val['class']=$class;
		}
		
		echo json_encode(array('status'=>1,'list'=>$data));
	}    
	//课程管理-编辑课程
	public function editkcAction(){
		if($_POST){
			$sql='update kechengbiao set date=\''.$_POST['date'].'\',week=\''.$_POST['week'].'\',class_id='.$_POST['class_id'].',course_id='.$_POST['course_id'].' where id='.$_POST['id'];
			JoyDb2::update($sql);
			echo json_encode(array('status'=>1,'info'=>'修改成功'));			
		}else{
			$sql='select * from kechengbiao where id='.$_GET['id'].' limit 1';
			$data=JoyDb2::query($sql)[0];
			//获取星期的索引
			$weekarray=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
			foreach($weekarray as $key=>$val){
				if($val==$data['date']){
					$data['index']=$key;
				}
			}
			//获取周的索引
			$weeks=['全周', '单周', '双周'];
			foreach($weeks as $key=>$val){
				if($val==$data['week']){
					$data['windex']=$key;
				}
			}	
			//获取课节的索引
			$sql='select * from classes where user_id='.$_COOKIE['user'];
			$classes=JoyDb2::query($sql);				
			foreach($classes as $key=>$class){
				if($class['id']==$data['class_id']){
					$data['lindex']=$key;
				}
			}			
			//获取学科的索引
			$sql='select * from courses where user_id='.$_COOKIE['user'];
			$courses=JoyDb2::query($sql);				
			foreach($courses as $key=>$course){
				if($course['id']==$data['course_id']){
					$data['cindex']=$key;
				}
			}
			echo json_encode(array('status'=>1,'field'=>$data));
		}
	}
	//课程管理-删除课程
	public function delkcAction(){
		$sql='delete from kechengbiao where id='.$_GET['id'];
		JoyDb2::delete($sql);		
		echo json_encode(array('status'=>1,'info'=>'删除成功'));
	}	
	//获取当天课程
	public function getkcAction(){
		$date=$_GET['date'];
		$weekarray=array("日","一","二","三","四","五","六");
		$sql='select * from kechengbiao where user_id='.$_COOKIE['user'].' and date=\''.$date.'\'';
		$data=JoyDb2::query($sql);		

		foreach($data as &$val){
			$sql='select * from courses where id='.$val['course_id'].' limit 1';
			$course=JoyDb2::query($sql)[0];	
			$val['course']=$course;			
			$sql='select * from classes where id='.$val['class_id'].' limit 1';
			$class=JoyDb2::query($sql)[0];	
			$val['class']=$class;
		}
		
		echo json_encode(array('status'=>1,'list'=>$data));
	}	
	
	//获取全周课程
	public function getwkcAction(){
		$sql='select * from kechengbiao where user_id='.$_COOKIE['user'];
		$data=JoyDb2::query($sql);	
		
		foreach($data as $key=>&$val){
			$sql='select * from courses where id='.$val['course_id'].' limit 1';
			$temp_data=JoyDb2::query($sql)[0];
			$val['course']=$temp_data;
		}
		$weekarr=array("星期一","星期二","星期三","星期四","星期五");
		$sql='select * from classes where user_id='.$_COOKIE['user'];
		$classes=JoyDb2::query($sql);	
		foreach($classes as $class){
			foreach($weekarr as $v){
				$find=false;
				foreach($data as $key=>$d){
					if($d['date']==$v && $d['class_id']==$class['id']){
						$find=$d;
					}
				}
				if($find){
					$res[$class['title']][$v]=$find;
				}else{
					$res[$class['title']][$v]='';
				}
			}
		}
		
		echo json_encode(array('status'=>1,'list'=>$res,'data'=>$data));
	}	
		
	

	

	
	
	
	
    /**
     * Verifying token
     */
    public function vaTokenAction()
    {
        $token = $this->getRequest()->getPost( "token", false );
        if (!$token){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }
        $wechatModel = new WechatModel();
        $isExpire = $wechatModel->varification($token);
        if ($isExpire){
            echo json_encode(array('status'=>1,'msg'=>'TOKEN有效'));
        }else{
            echo json_encode(array('status'=>0,'msg'=>'TOKEN超时'));
        }
	}


    /**
     * 得到广告数据
     */
    public function getAdDataAction()
    {
        $appid = $this->getRequest()->getPost( "appid", false );
        if (!$appid){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }
        $advertModel = new AdvertModel();
        $info = $advertModel->getAdRedis($appid);
        if (!$info){
            $info = $advertModel->getAdSql($appid);
        }
        if ($info){
            echo json_encode(array('status'=>1,'data'=>$info));
        }else
            echo json_encode(array('status'=>0,'msg'=>'未查到该应用广告信息'));
    }

    /**
     * 得到首页标题
     * Get the title of the article
     */
    public function getArticleTitleAction()
    {
        $appid = $this->getRequest()->getPost('appid',false);
        $count = $this->getRequest()->getPost('count',false);
        $page = $this->getRequest()->getPost('page',false);

        if (!$appid || !$count || !$page){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }

        $articleModel = new ArticleModel();
        $res = $articleModel->getTitle($appid,$count,$page);
        if (!empty($res)){
            echo  json_encode(array('data'=>$res,'status'=>1));
        }else{
            $res = $articleModel->getRand($appid,$count);
            if (empty($res))
                echo  json_encode(array('msg'=>"没有文章信息",'status'=>2));
            else
                echo  json_encode(array('data'=>$res,'status'=>1));
        }
    }


    /**
     * 得到实际内容
     */
    public function getArticleAction()
    {
        $appid = $this->getRequest()->getPost('appid',false);
        $articleID = $this->getRequest()->getPost('article',false);
        $token = $_SERVER['HTTP_TOKEN'];
        if (!$appid || !$articleID || !$token){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }

        $wechatModel = new WechatModel();
        if (!$wechatModel->varification($token)){
            echo json_encode(array('status'=>403,'msg'=>'token超时'));
            exit();
        }

        $articleModel = new ArticleModel();

        $res = $articleModel->getArticle($appid,$articleID);
        if (!empty($res)){
            echo  json_encode(array('data'=>$res,'status'=>1));
        }else{
            echo  json_encode(array('msg'=>"没有文章信息",'status'=>2));
        }
    }


    /**
     * 得到热搜的标题
     */
    public function getHotArticleAction()
    {
        $appid = $this->getRequest()->getPost('appid',false);
        $count = $this->getRequest()->getPost('count',false);
        $page = $this->getRequest()->getPost('page',false);

        if (!$appid || !$count || !$page){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }

        $articleModel = new ArticleModel();
        $res = $articleModel->getHotArticle($appid,$count,$page);
        if (!empty($res)){
            echo  json_encode(array('data'=>$res,'status'=>1));
        }else{
            echo  json_encode(array('msg'=>"没有文章信息",'status'=>2));
        }
    }


    /**
     * 随机得到首页标题
     * Get the title of the article
     */
    public function getRandomAction()
    {
        $appid = $this->getRequest()->getPost('appid',false);
        $count = $this->getRequest()->getPost('count',false);

        if (!$appid || !$count){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }

        $articleModel = new ArticleModel();
        $res = $articleModel->getRand($appid,$count);
        if (!empty($res)){
            echo  json_encode(array('data'=>$res,'status'=>1));
        }else{
            echo  json_encode(array('msg'=>"没有文章信息",'status'=>2));
        }
    }

    /**
     * 随机得到同类推荐
     */
    public function getRandomRecommendedAction()
    {
        $appid = $this->getRequest()->getPost('appid',false);
        $cate = $this->getRequest()->getPost('cate',false);
        $count = $this->getRequest()->getPost('count',false);

        if (!$cate || !$count){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }

        $articleModel = new ArticleModel();
        $res = $articleModel->getRandomRecommended($appid,$cate,$count);
        if (!empty($res)){
            echo  json_encode(array('data'=>$res,'status'=>1));
        }else{
            echo  json_encode(array('msg'=>"没有文章信息",'status'=>2));
        }
    }


    //Get all the advertising information

    /**
     * 得到所有广告信息
     */
    public function getAllAdAction()
    {
        $appid = $this->getRequest()->getPost( "appid", false );
        if (!$appid){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }
        $advertModel = new AdvertModel();
        $info = $advertModel->getSimpleAdSQL($appid);
        if ($info){
            echo json_encode(array('status'=>1,'data'=>$info));
        }else
            echo json_encode(array('status'=>0,'msg'=>'未查到该应用广告信息'));
    }


    /**
     * 获取分享封面
     */
    public function shareCoverAction()
    {
        $appid = $this->getRequest()->getPost( "appid", false );
        if (!$appid){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }
        $advertModel = new AdvertModel();
        $url = $advertModel->getRandCover($appid);
        if ($url){
            echo json_encode(array('status'=>1,'url'=>$url));
        }else
            echo json_encode(array('status'=>0,'msg'=>'未查到该应用封面信息'));
    }

	public function getGzAction(){
		$appid = $this->getRequest()->getPost( "appid", false );
        if (!$appid){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }
		$sql='select * from wechat_app where app_id=\''.$_POST['appid'].'\'';
		$app=JoyDb::query($sql)[0];
		echo  json_encode(array('data'=>$app,'status'=>1));
	}
	
	public function getInnerAdAction(){
		$appid = $this->getRequest()->getPost( "appid", false );
        if (!$appid){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }
		$sql='select * from wechat_ad_to_app where app_id=\''.$_POST['appid'].'\'';
		$ads=JoyDb::query($sql);
		foreach($ads as $val){
			$sql='select * from wechat_simple_ad where id='.$val['ad_id'];
			$ad=JoyDb::query($sql)[0];
			if($ad['is_top']==2){
				$res=$ad;
			}
		}
		echo  json_encode(array('data'=>$res,'status'=>1));
	}

    /**
     * 得到跳转信息
     */
    public function getJumpAction()
    {
        $appid = $this->getRequest()->getPost( "appid", false );
        if (!$appid){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }
        $wechatModel = new WechatModel();
        $rs = $wechatModel->getJumpInfo($appid);
        if ($rs){
            echo json_encode(array('status'=>1,'data'=>$rs));
        }else{
            echo json_encode(array('status'=>0,'msg'=>'未查到该应用跳转信息'));
        }

    }

}

