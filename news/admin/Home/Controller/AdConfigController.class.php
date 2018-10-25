<?php
namespace Home\Controller;

class AdConfigController extends CommonController {

    public function index(){
		$method = I('get.method') ? I('get.method') : 'list';
		$db=M('wechat_adposition');
		switch ($method) {
			case 'list':
				$this->assign('cur_nav','adPositionList');
				$count=$db->count();
				$Page=new \Think\Page($count,25);
				$show= $Page->show();// 分页显示输出
				$list = $db->limit($Page->firstRow.','.$Page->listRows)->select();
				$this->assign('count',$count);
				$this->assign('list',$list);	// 赋值数据集
				$this->assign('page',$show);	// 赋值分页输出
				$this->display('positionList');
			break;
			case 'add':
                $apps = M('wechat_app')->select();
                $this->assign('apps',$apps);
				$this->assign('cur_nav','adPositionList');
				if(I('post.app_id')){
				    $data = $_POST;
				    $data['add_time'] = date('Y-m-d H:i:s');
					if($db->add($data)){
						$this->success('添加成功');
					}else{
						$this->success('添加失败');
					}
                    exit;
				}
				$this->display('positionAdd');
			break;
			case 'edit':
				$info=$db->where('id='.$_GET['id'])->find();
				$this->assign('cur_nav','adPositionList');
				$this->assign('res',$info);
                $apps = M('wechat_app')->select();
                $this->assign('apps',$apps);
				if(I('post.app_id')){
                    $data = $_POST;
                    $data['update_time'] = date('Y-m-d H:i:s');
                    $data['id'] = trim($data['id']);
					if($db->save($data)){
						$this->success('修改成功');
					}else{
						$this->success('修改失败');
					}
                    exit;
				}
				$this->display('positionEdit');
			break;
			case 'del':
				if($db->where('id='.I('get.id'))->delete()){
					$this->success('删除成功');
				}else{
					$this->success('删除失败');
				}
			break;
		}
	}


    public function advert(){
        $method = I('get.method') ? I('get.method') : 'list';
        $db=M('wechat_ad');
        switch ($method) {
            case 'list':
                $this->assign('cur_nav','advertList');
                $count=$db->count();
                $Page=new \Think\Page($count,25);
                $show= $Page->show();// 分页显示输出
                $list = $db->limit($Page->firstRow.','.$Page->listRows)->select();
                $this->assign('count',$count);
                $this->assign('list',$list);	// 赋值数据集
                $this->assign('page',$show);	// 赋值分页输出
                $this->display('advertList');
                break;
            case 'add':
                $this->assign('cur_nav','advertList');
                if(I('post.title')){
                    $data = $_POST;
                    $data['add_time'] = date('Y-m-d H:i:s');
                    if($db->add($data)){
                        $this->success('添加成功');
                    }else{
                        $this->success('添加失败');
                    }
                    exit;
                }
                $this->display('advertAdd');
                break;
            case 'edit':
                $info=$db->where('id='.$_GET['id'])->find();
                $this->assign('cur_nav','advertList');
                $this->assign('res',$info);
                if(I('post.title')){
                    $data = $_POST;
                    $data['update_time'] = date('Y-m-d H:i:s');
                    $data['id'] = trim($data['id']);
                    unset($data['sub']);
                    if($db->save($data)){
                        $this->success('修改成功');
                    }else{
                        $this->success('修改失败');
                    }
                    exit;
                }
                $this->display('advertEdit');
                break;
            //On the shelf
            case 'del':
                if($db->where('id='.I('get.id'))->delete()){
                    $this->success('删除成功');
                }else{
                    $this->success('删除失败');
                }
                break;
        }
    }

    //Advertising on the shelf
    public function onShelf(){
        $method = I('get.method') ? I('get.method') : 'list';
        $db=M('wechat_ad_to_position');
        switch ($method) {
            case 'list':
                $this->assign('cur_nav','onShelfList');
                $count=$db->count();
                $Page=new \Think\Page($count,25);
                $show= $Page->show();// 分页显示输出
                //列表信息
                $list = $db->limit($Page->firstRow.','.$Page->listRows)->select();
                $positions = M('wechat_adposition')->select();
                $posinfo = array();
                foreach ($positions as $row){
                    $posinfo[$row['position_id']] = $row;
                }
                $apps = M('wechat_app')->select();
                $appinfo = array();
                foreach ($apps as $app){
                    $appinfo[$app['app_id']] = $app;
                }
                $ads = M('wechat_ad')->select();
                $adsinfo = array();
                foreach ($ads as $ad){
                    $adsinfo[$ad['id']] = $ad;
                }
                //列表
                foreach ($list as $k => $row){
                    $list[$k]['position'] = $posinfo[$row['position_id']]['describe'];
                    $list[$k]['appid'] = $posinfo[$row['position_id']]['app_id'];
                    $list[$k]['appname'] = $appinfo[$list[$k]['appid']]['name'].
                        $appinfo[$list[$k]['appid']]['cn_name'];
                    $list[$k]['ad'] = $adsinfo[$row['ad_id']]['title'];
                    $list[$k]['end_time'] = $adsinfo[$row['ad_id']]['end_time'];
                    $list[$k]['start_time'] = $adsinfo[$row['ad_id']]['start_time'];
                }
                $this->assign('count',$count);
                $this->assign('list',$list);	// 赋值数据集
                $this->assign('page',$show);	// 赋值分页输出
                $this->display('shelfList');
                break;
            case 'add':
                $ads = M('wechat_ad')->select();
                $positions = M('wechat_adposition')->select();
                $this->assign('ads',$ads);
                $this->assign('positions',$positions);
                $this->assign('cur_nav','onShelfList');
                if(I('post.ad_id')){
                    $data = $_POST;
                    $data['add_time'] = date('Y-m-d H:i:s');
                    unset($data['sub']);
                    $count = M('wechat_ad_to_position')->field("count(position_id) as num")
                        ->where("position_id='{$data['position_id']}'")->find();
                    $count = $count['num'];
                    $max = M('wechat_adposition')->field("max_number as num")
                        ->where("position_id='{$data['position_id']}'")->find();
                    if ($count['num'] >=  $max['num']){
                        $this->success('该广告位已达上限数量');
                        exit;
                    }
                    if($db->add($data)){
                        $this->success('添加成功');
                    }else{
                        $this->success('添加失败');
                    }
                    exit;
                }
                $this->display('shelfAdd');
                break;
            case 'edit':
                $ads = M('wechat_ad')->select();
                $positions = M('wechat_adposition')->select();
                $this->assign('ads',$ads);
                $this->assign('positions',$positions);
                $info=$db->where('id='.$_GET['id'])->find();
                $this->assign('cur_nav','onShelfList');
                $this->assign('res',$info);
                if(I('post.ad_id')){
                    $data = $_POST;
                    $data['update_time'] = date('Y-m-d H:i:s');
                    $data['id'] = trim($data['id']);
                    unset($data['sub']);
                    if($db->save($data)){
                        $this->success('修改成功');
                    }else{
                        $this->success('修改失败');
                    }
                    exit;
                }
                $this->display('shelfEdit');
                break;
            //On the shelf
            case 'del':
                if($db->where('id='.I('get.id'))->delete()){
                    $this->success('删除成功');
                }else{
                    $this->success('删除失败');
                }
                break;
        }
    }

    /**
     * 广告配置
     */
    public function adConfig()
    {
        $method = I('get.method') ? I('get.method') : 'list';
        $db=M('wechat_simple_ad');
        $this->assign('action',ACTION_NAME);
        switch ($method) {
            //查
            case 'list':
                $this->assign('cur_nav','simple_ad_List');
                $count=$db->count();
                $Page=new \Think\Page($count,25);
                $show= $Page->show();// 分页显示输出
                //主要列表信息
                $list = $db->limit($Page->firstRow.','.$Page->listRows)->select();
                //对应的app列表
                $appInfo = M('wechat_ad_to_app')->field('app_id,ad_id')->select();
                $apps = array();
                foreach ($appInfo as $row){
                    $apps[$row['ad_id']][] = $row['app_id'];
                }
                foreach ($list as $k => $row){
                    $list[$k]['appid'] = join(' | ',$apps[$row['id']]);
                }
                $apps = M('wechat_app')->select();
                $appsIndex = array();
                foreach ($apps as $row){
                    $appsIndex[$row['app_id']] = $row['name'].'_'.$row['cn_name'];
                }
                foreach ($list as $k=>$row){
                    $list[$k]['name'] = $appsIndex[$row['appid']];
                }
                $id = cookie('appid');
                $rs = M('wechat_app')->where("id='{$id}'")->find();
                $appid = $rs['app_id'];
                if ($appid){
                    foreach ($list as $k=>$row){
                        if ($row['appid'] != $appid){
                            unset($list[$k]);
                        }
                    }
                }
                $this->assign('count',$count);
                $this->assign('list',$list);	// 赋值数据集
                $this->assign('page',$show);	// 赋值分页输出
                $this->display('simpleAdList');
                break;
            //添加
            case 'add':
                $apps = M('wechat_app')->where('id='.cookie('appid'))->select();
                $this->assign('apps',$apps);
                if(I('post.apps')){
                    $data = $_POST;
                    $data['add_time'] = date('Y-m-d H:i:s');
                    unset($data['sub']);
                    //数组
                    $appValues = $data['apps'];
                    $data['image'] = $data['imageUrl'];
                    unset($data['imageUrl']);
                    unset($data['apps']);
                    $appDB = M('wechat_ad_to_app');
                    $db->startTrans();
                    $adId = $db->add($data);
                    if (!$adId){
                        $this->success('添加失败');
                        exit;
                    }
                    $values = array();
                    foreach ($appValues as $row){
                        $temp = array();
                        $temp['ad_id'] = $adId;
                        $temp['app_id'] = $row;
                        $exist = $appDB->where($temp)->find();
                        if (!$exist){
                            $temp['add_time'] = $data['add_time'];
                            $values[] =  $temp;
                        }
                    }
                    if ($values){
                        $rs = $appDB->addAll($values);
                        if (!$rs){
                            //回滚
                            $db->rollback();
                            $this->success('添加失败');
                            exit;
                        }else{
                            //提交
                            $db->commit();
                            $this->success('添加成功');
                            exit;
                        }
                    }
                }
                $this->display('simpleAdd');
                break;
            case 'edit':
                $apps = M('wechat_app')->select();
                $this->assign('apps',$apps);
                //广告信息
                $info= $db->where('id='.$_GET['id'])->find();
                $this->assign('res',$info);
                //对应的应用信息
                $info= M('wechat_ad_to_app')->where('ad_id='.$_GET['id'])->select();
                $appSelect = array();
                foreach ($info as $row){
                    $appSelect[] = $row['app_id'];
                }
                $this->assign('appSelect',join('|',$appSelect));
                if(I('post.apps')){
                    $data = $_POST;
                    $data['update_time'] = date('Y-m-d H:i:s');
                    $data['id'] = trim($data['id']);
                    unset($data['sub']);
                    $appValues = $data['apps'];
                    $data['image'] = $data['imageUrl'];
                    unset($data['imageUrl']);
                    unset($data['apps']);
                    $appDB = M('wechat_ad_to_app');
                    $adId = $db->save($data);
                    if (!$adId){
                        $this->success('编辑失败');
                        exit;
                    }
                    $addTime = date('Y-m-d H:i:s');
                    $allAd = $appDB->where('ad_id='.$data['id'])->select();
                    $allAdArr = array();
                    $updateAdArr = array();
                    foreach ($allAd as $row){
                        $allAdArr[] = $row['app_id'];
                    }
                    foreach ($appValues as $row){
                        $temp = array();
                        $temp['ad_id'] = $adId;
                        $temp['app_id'] = $row;
                        $updateAdArr[] = $row;
                        $exist = $appDB->where($temp)->find();
                        $temp['add_time'] = $addTime;
                        if ($exist){
                            $appDB->where('ad_id='.$adId)->save($temp);
                        }else{
                            $appDB->data($temp)->add();
                        }
                    }
                    $deleteArr = array_diff_assoc($allAdArr,$updateAdArr);
                    if (!empty($deleteArr)){
                        $deleteArr = array_values($deleteArr);
                        $rs = $appDB->where("app_id in ('".join("','",$deleteArr)."')")->delete();
                        if (!$rs){
                            $this->success('编辑失败');
                            exit;
                        }
                    }
                    $this->success('编辑成功');
                    exit;
                }
                $this->display('simpleEdit');
                break;
            case 'del':
                $db->startTrans();
                $db->where('id='.I('get.id'))->delete();
                $rs = M('wechat_ad_to_app')->where('ad_id='.I('get.id'))->delete();
                if($rs){
                    $db->commit();
                    $this->success('删除成功');
                }else{
                    $db->rollback();
                    $this->success('删除失败');
                }
                break;
        }
    }

    /**
     * 保存异步上传的图片
     */
    public function ajaxImgSave()
    {
        if(IS_AJAX){
            $imgFiles = $_FILES['file'];
            if ($imgFiles){
                $imgName=date('His').rand(100,999).'.jpg';
                $tmp = $imgFiles['tmp_name'];
                $filePath = '/opt/data/web/news/admin/uploads/'.date('Y').'/'.date('m').'/'.date('d').'/';
                $rePath = '/uploads/'.date('Y').'/'.date('m').'/'.date('d').'/'.$imgName;
                is_dir($filePath) || mkdir($filePath, 0777, true);
                if(move_uploaded_file($tmp,$filePath.$imgName)){
                    echo json_encode(array('path'=>$rePath,'status'=>1));
                }else{
                    echo json_encode(array('path'=>0,'status'=>0));
                }
            }
        }
    }


    /**
     * 盒子广告配置
     */
    public function adBoxConfig()
    {
        $method = I('get.method') ? I('get.method') : 'list';
        $db=M('box_simple_ad');
        $this->assign('action',ACTION_NAME);
        switch ($method) {
            //查
            case 'list':
                $this->assign('cur_nav','simple_ad_List');
                $count=$db->count();
                $Page=new \Think\Page($count,25);
                $show= $Page->show();// 分页显示输出
                //主要列表信息
                $list = $db->limit($Page->firstRow.','.$Page->listRows)->select();
                //对应的app列表
                $appInfo = M('box_ad_to_app')->field('app_id,ad_id')->select();
                $apps = array();
                foreach ($appInfo as $row){
                    $apps[$row['ad_id']][] = $row['app_id'];
                }
                foreach ($list as $k => $row){
                    $list[$k]['appid'] = join(' | ',$apps[$row['id']]);
                }
                $apps = M('wechat_app')->select();
                $appsIndex = array();
                foreach ($apps as $row){
                    $appsIndex[$row['app_id']] = $row['name'].'_'.$row['cn_name'];
                }
                foreach ($list as $k=>$row){
                    $list[$k]['name'] = $appsIndex[$row['appid']];
                }
                $this->assign('count',$count);
                $this->assign('list',$list);	// 赋值数据集
                $this->assign('page',$show);	// 赋值分页输出
                $this->display('boxAdList');
                break;
            //添加
            case 'add':
                $apps = M('wechat_app')->where('id='.cookie('appid'))->select();
                $this->assign('apps',$apps);
                if(I('post.apps')){
                    $data = $_POST;
                    $data['add_time'] = date('Y-m-d H:i:s');
                    unset($data['sub']);
                    //数组
                    $appValues = $data['apps'];
                    $data['image'] = $data['imageUrl'];
                    unset($data['imageUrl']);
                    unset($data['apps']);
                    $appDB = M('box_ad_to_app');
                    $db->startTrans();
                    $adId = $db->add($data);
                    if (!$adId){
                        $this->success('添加失败');
                        exit;
                    }
                    $values = array();
                    foreach ($appValues as $row){
                        $temp = array();
                        $temp['ad_id'] = $adId;
                        $temp['app_id'] = $row;
                        $exist = $appDB->where($temp)->find();
                        if (!$exist){
                            $temp['add_time'] = $data['add_time'];
                            $values[] =  $temp;
                        }
                    }
                    if ($values){
                        $rs = $appDB->addAll($values);
                        if (!$rs){
                            //回滚
                            $db->rollback();
                            $this->success('添加失败');
                            exit;
                        }else{
                            //提交
                            $db->commit();
                            $this->success('添加成功');
                            exit;
                        }
                    }
                }
                $this->display('boxAdd');
                break;
            case 'edit':
                $apps = M('wechat_app')->select();
                $this->assign('apps',$apps);
                //广告信息
                $info= $db->where('id='.$_GET['id'])->find();
                $this->assign('res',$info);
                //对应的应用信息
                $info= M('box_ad_to_app')->where('ad_id='.$_GET['id'])->select();
                $appSelect = array();
                foreach ($info as $row){
                    $appSelect[] = $row['app_id'];
                }
                $this->assign('appSelect',join('|',$appSelect));
                if(I('post.apps')){
                    $data = $_POST;
                    $data['update_time'] = date('Y-m-d H:i:s');
                    $data['id'] = trim($data['id']);
                    unset($data['sub']);
                    $appValues = $data['apps'];
                    $data['image'] = $data['imageUrl'];
                    unset($data['imageUrl']);
                    unset($data['apps']);
                    $appDB = M('box_ad_to_app');
                    $adId = $db->save($data);
                    if (!$adId){
                        $this->success('编辑失败');
                        exit;
                    }
                    $addTime = date('Y-m-d H:i:s');
                    $allAd = $appDB->where('ad_id='.$data['id'])->select();
                    $allAdArr = array();
                    $updateAdArr = array();
                    foreach ($allAd as $row){
                        $allAdArr[] = $row['app_id'];
                    }
                    foreach ($appValues as $row){
                        $temp = array();
                        $temp['ad_id'] = $adId;
                        $temp['app_id'] = $row;
                        $updateAdArr[] = $row;
                        $exist = $appDB->where($temp)->find();
                        $temp['add_time'] = $addTime;
                        if ($exist){
                            $appDB->where('ad_id='.$adId)->save($temp);
                        }else{
                            $appDB->data($temp)->add();
                        }
                    }
                    $deleteArr = array_diff_assoc($allAdArr,$updateAdArr);
                    if (!empty($deleteArr)){
                        $deleteArr = array_values($deleteArr);
                        $rs = $appDB->where("app_id in ('".join("','",$deleteArr)."')")->delete();
                        if (!$rs){
                            $this->success('编辑失败');
                            exit;
                        }
                    }
                    $this->success('编辑成功');
                    exit;
                }
                $this->display('boxEdit');
                break;
            case 'del':
                $db->startTrans();
                $db->where('id='.I('get.id'))->delete();
                $rs = M('box_ad_to_app')->where('ad_id='.I('get.id'))->delete();
                if($rs){
                    $db->commit();
                    $this->success('删除成功');
                }else{
                    $db->rollback();
                    $this->success('删除失败');
                }
                break;
        }
    }

    public function jump(){
        $method = I('get.method') ? I('get.method') : 'list';
        $db=M('wechat_app_jump');
        $apps = M('wechat_app')->select();
        $appIndex = array();
        foreach ($apps as $row){
            $appIndex[$row['app_id']] = $row['cn_name'];
        }
        switch ($method) {
            case 'list':
                $this->assign('cur_nav','jumpList');
                $count=$db->count();
                $Page=new \Think\Page($count,25);
                $show= $Page->show();// 分页显示输出
                $list = $db->limit($Page->firstRow.','.$Page->listRows)->select();
                $this->assign('count',$count);
                foreach ($list as $k=>$row){
                    if ($appIndex[$row['app_id']])
                        $list[$k]['app_id'] = $row['app_id']."(".$appIndex[$row['app_id']].")";
                }
                $this->assign('list',$list);	// 赋值数据集
                $this->assign('page',$show);	// 赋值分页输出
                $this->display('jumpList');
                break;
            case 'add':
                if(I('post.app_id')){
                    $data = $_POST;
                    $data['add_time'] = date('Y-m-d H:i:s');
                    if($db->add($data)){
                        $this->success('添加成功');
                    }else{
                        $this->success('添加失败');
                    }
                    exit;
                }
                $this->display('jumpAdd');
                break;
            case 'edit':
                $info=$db->where('id='.$_GET['id'])->find();
                $this->assign('cur_nav','jumpList');
                $this->assign('res',$info);
                if(I('post.app_id')){
                    $data = $_POST;
                    $data['update_time'] = date('Y-m-d H:i:s');
                    $data['id'] = trim($data['id']);
                    unset($data['sub']);
                    if($db->save($data)){
                        $this->success('修改成功');
                    }else{
                        $this->success('修改失败');
                    }
                    exit;
                }
                $this->display('jumpEdit');
                break;
            //On the shelf
            case 'del':
                if($db->where('id='.I('get.id'))->delete()){
                    $this->success('删除成功');
                }else{
                    $this->success('删除失败');
                }
                break;
        }
    }


}