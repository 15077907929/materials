<?php
// 本类由系统自动生成，仅供测试用途
namespace Pickup\Controller;
use Think\Controller;
class PickupArtsController extends Controller {
	public function index(){
		//抓取首页热门文章
		$res=$this->getList();
		$this->pickup_art($res);sleep(10);
		// 抓取搞笑文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_1/pc_1.html',2);sleep(10);
		$this->pickup_art($res);		
		// 抓取养生堂文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_2/pc_2.html',3);sleep(10);
		$this->pickup_art($res);		
		// 抓取私房话文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_3/pc_3.html',4);sleep(10);
		$this->pickup_art($res);		
		// 抓取八卦精话文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_4/pc_4.html',5);sleep(10);
		$this->pickup_art($res);		
		// 抓取科技咖文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_5/pc_5.html',6);sleep(10);
		$this->pickup_art($res);		
		// 抓取财经迷文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_6/pc_6.html',7);sleep(10);
		$this->pickup_art($res);
		// 抓取汽车控文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_7/pc_7.html',8);sleep(10);
		$this->pickup_art($res);
		// 抓取生活家文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_8/pc_8.html',9);sleep(10);
		$this->pickup_art($res);			
		// 抓取时尚圈文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_9/pc_9.html',10);sleep(10);
		$this->pickup_art($res);		
		// 抓取育儿文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_10/pc_10.html',11);sleep(10);
		$this->pickup_art($res);		
		// 抓取旅游文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_11/pc_11.html',12);sleep(10);
		$this->pickup_art($res);		
		// 抓取职场文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_12/pc_12.html',13);sleep(10);
		$this->pickup_art($res);		
		// 抓取美食文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_13/pc_13.html',14);sleep(10);
		$this->pickup_art($res);		
		// 抓取历史文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_14/pc_14.html',15);sleep(10);
		$this->pickup_art($res);			
		// 抓取教育文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_15/pc_15.html',16);sleep(10);
		$this->pickup_art($res);		
		// 抓取星座文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_16/pc_16.html',17);sleep(10);
		$this->pickup_art($res);		
		// 抓取体育文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_17/pc_17.html',18);sleep(10);
		$this->pickup_art($res);		
		// 抓取军事文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_18/pc_18.html',19);sleep(10);
		$this->pickup_art($res);		
		// 抓取游戏文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_19/pc_19.html',20);sleep(10);
		$this->pickup_art($res);		
		// 抓取萌宠文章
		$res=$this->getAsyList('http://weixin.sogou.com/pcindex/pc/pc_20/pc_20.html',21);sleep(10);
		$this->pickup_art($res);		
	}
	
	public function pickup_art($res){
		foreach($res['url'] as $key=>$url){
			if(M('article')->where('art_tit=\''.$res['tit'][$key].'\'')->find()){
				continue;
			}
			//抓取文章内容，同时下载图片，更改图片路径
			$ch = curl_init();	//初始化
			curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
			curl_setopt($ch,CURLOPT_HEADER,0);	//关闭header输出
			curl_setopt($ch,CURLOPT_URL,$url);  //设置请求地址
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);	//对认证证书来源的检查，0表示阻止对证书的合法性的检查。这个选项是必须的，对https协议来说的
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);	//关闭直接输出  
			$content=curl_exec($ch);	//触发请求 
			if (curl_errno($ch)) {    
				echo 'Errno:'.curl_error($ch);  
			} 
			curl_close($ch);	//关闭curl，释放资源
			
			preg_match_all('/<div class="rich_media_content " id="js_content">([^\']*)<\/div>/iU', $content, $content_arr);
			// echo '<pre>';
			// print_r($content_arr);
			// echo '</pre>';
			if(empty($content_arr[0])){
				continue;
			}
			$content=$content_arr[0][0];
			// $content=str_replace("data-src",'src',$content);
			preg_match_all('/<img [^>]*data-src="([^\']*)"[^>]*>/iU', $content, $content_img_arr);
			$content_img_arr=$content_img_arr[1];
			foreach($content_img_arr as $img){
				$filename=date('His').rand(100,999).'.jpg';
				$this->getImage($img,'/opt/data/web/news/admin/uploads/'.date('Y').'/'.date('m').'/'.date('d').'/',$filename);
				// $this->getImage($img.'&wxfrom=5&wx_lazy=1','/opt/data/web/news/admin/uploads/'.date('Y').'/'.date('m').'/'.date('d').'/',$filename);
				$content=str_replace($img,'/uploads/'.date('Y').'/'.date('m').'/'.date('d').'/'.$filename,$content);
			}
			$content=str_replace("data-src",'src',$content);
			$content=str_replace("🌵",'',$content);
			//保存文章封面图片
			$dir='/opt/data/web/news/admin/uploads/'.date('Y').'/'.date('m').'/'.date('d').'/';
			$filename=date('His').rand(100,999).'.jpg';
			$art_img='uploads/'.date('Y').'/'.date('m').'/'.date('d').'/'.$filename;
			$this->getImage('http:'.$res['img'][$key],$dir,$filename);
			
			$arr=[
					'art_tit'=>$res['tit'][$key],
					'art_keyword'=>$res['art_keyword'],
					'art_img'=>$art_img,
					'art_cate'=>$res['cate_id'],
					'art_content'=>$content,
					'art_addtime'=>date('Y-m-d H:i:s')
				];
			if(M('article')->add($arr)){
				$count=cookie('count')+1;
				cookie('count',$count);
			}
			if(cookie('count')>cookie('num')){
				exit;
			}
		}
	}
	
	public function getList(){
		$url='http://weixin.sogou.com/';	//带采集的页面
		$ch = curl_init();	//初始化
		curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
		curl_setopt($ch,CURLOPT_HEADER,0);	//关闭header输出
		curl_setopt($ch,CURLOPT_URL,$url);  //设置请求地址
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);	//对认证证书来源的检查，0表示阻止对证书的合法性的检查。这个选项是必须的，对https协议来说的
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);	//关闭直接输出  
		$content=curl_exec($ch);	//触发请求 
		if (curl_errno($ch)) {    
			echo 'Errno:'.curl_error($ch);  
		} 
		curl_close($ch);	//关闭curl，释放资源
		
		preg_match_all('/<img src="([^\"]*)" onload="resizeImage\(this\)" onerror="errorImage\(this\)"\/>/iU', $content, $img_arr);
		preg_match_all('/<h3>[^\"]*<a uigs="[^\"]*" href="([^\"]*)" target="_blank" data-share="[^\"]*">([^>]*)<\/a>[^\"]*<\/h3>/iU', $content, $tit_arr);
		$res['img']=$img_arr[1];
		$res['url']=$tit_arr[1];
		$res['tit']=$tit_arr[2];
		foreach($res['url'] as &$val){
			// $val=str_replace("&",'&amp;',$val);
			$val=str_replace("http",'https',$val);
		}
		$res['art_keyword']='';
		$res['cate_id']=1;
		return $res;			
	}	
	
	public function getAsyList($url,$cate_id){
		$ch = curl_init();	//初始化
		curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
		curl_setopt($ch,CURLOPT_HEADER,0);	//关闭header输出
		curl_setopt($ch,CURLOPT_URL,$url);  //设置请求地址
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);	//对认证证书来源的检查，0表示阻止对证书的合法性的检查。这个选项是必须的，对https协议来说的
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);	//关闭直接输出  
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(					
			'Accept:*/*',
			'Accept-Encoding:gzip, deflate',
			'Accept-Language:zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
			'Connection:keep-alive',
			'Host:weixin.sogou.com',
			'Referer:http://weixin.sogou.com/',
			'User-Agent:Mozilla/5.0 (Windows NT 6.1; W…) Gecko/20100101 Firefox/61.0',
			'X-Requested-With:XMLHttpRequest'
		));
		$content=curl_exec($ch);	//触发请求 
		if (curl_errno($ch)) {    
			echo 'Errno:'.curl_error($ch);  
		} 
		curl_close($ch);	//关闭curl，释放资源
		
		preg_match_all('/<img src="([^\"]*)" onload="resizeImage\(this\)" onerror="errorImage\(this\)"\/>/iU', $content, $img_arr);
		preg_match_all('/<h3>[^\"]*<a uigs="[^\"]*" href="([^\"]*)" target="_blank" data-share="[^\"]*">([^>]*)<\/a>[^\"]*<\/h3>/iU', $content, $tit_arr);
		$res['img']=$img_arr[1];
		$res['url']=$tit_arr[1];
		$res['tit']=$tit_arr[2];
		foreach($res['url'] as &$val){
			// $val=str_replace("&",'&amp;',$val);
			$val=str_replace("http",'https',$val);
		}
		$res['art_keyword']='';
		$res['cate_id']=$cate_id;
		return $res;			
	}
	
	public function getKeywordList($url){
		$ch = curl_init();	//初始化
		curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
		curl_setopt($ch,CURLOPT_HEADER,0);	//关闭header输出
		curl_setopt($ch,CURLOPT_URL,$url);  //设置请求地址
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);	//对认证证书来源的检查，0表示阻止对证书的合法性的检查。这个选项是必须的，对https协议来说的
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);	//关闭直接输出 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(					
			'Accept:text/html,application/xhtml+xm…plication/xml;q=0.9,*/*;q=0.8',
			'Accept-Encoding:gzip, deflate',
			'Accept-Language:zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
			'Connection:keep-alive',
			'Cookie:IPLOC=CN3401; SUID=B24768DA2F2…SSIONID=aaa8D0K49us-T_RIt36tw',
			'Host:weixin.sogou.com',
			'Referer:http://weixin.sogou.com/weixin…&_sug_=n&type=2&page=4&ie=utf8',
			'Upgrade-Insecure-Requests:1',
			'User-Agent:Mozilla/5.0 (Windows NT 6.1; W…) Gecko/20100101 Firefox/61.0'
		));		
		$content=curl_exec($ch);	//触发请求 
		if (curl_errno($ch)) {    
			echo 'Errno:'.curl_error($ch);  
		} 
		curl_close($ch);	//关闭curl，释放资源
		
		preg_match_all('/<img src="([^\"]*)" onload="[^\"]*" onerror="[^\"]*">/iU', $content, $img_arr);
		preg_match_all('/<h3>[^\"]*<a target="[^\"]*" href="([^\"]*)" id="[^\"]*" uigs="[^\"]*" data-share="[^\"]*">([^`]*)<\/a>[^\"]*<\/h3>/iU', $content, $tit_arr);
		$res['img']=$img_arr[1];
		$res['url']=$tit_arr[1];
		$res['tit']=$tit_arr[2];
		if(count($res['img'])!=count($res['url']) or count($res['img'])!=count($res['tit'])){
			$res['url']=[];
			$res['img']=[];
			$res['tit']=[];
		}
		foreach($res['url'] as $key=>&$val){
			$val=str_replace("&amp;",'&',$val);
			$res['img'][$key]=str_replace("&amp;",'&',$res['img'][$key]);
			$val=str_replace("http",'https',$val);
			$res['tit'][$key]=str_replace("<em><!--red_beg-->",'',$res['tit'][$key]);
			$res['tit'][$key]=str_replace("<!--red_end--></em>",'',$res['tit'][$key]);
		}
		if(empty($res['tit'])){
			exec("sudo /opt/bin/vpn_aso100/vpn_aso100.sh all",$output,$result);
		}
		$res['cate_id']=0;		
		return $res;	
	}
	
	public function pickupKeyword(){
		cookie('num',$_GET['num']);
		cookie('count',1);
		for($i=1;$i<=200;$i++){
			$url='http://weixin.sogou.com/weixin?oq=&query='.$_GET['art_keyword'].'&_sug_type_=1&sut=0&lkt=0,0,0&s_from=input&ri=0&_sug_=n&type=2&sst0=1533521127488&page='.$i.'&ie=utf8&p=40040108&dp=1&w=01015002&dr=1';
			$res=$this->getKeywordList($url);
			$res['art_keyword']=$_GET['art_keyword'];
			$this->pickup_art($res);
			// sleep(10);
			echo '<pre>';
			print_r($res);
			echo '</pre>';
		}
	}
	
	public function pickupKeyword2(){
		$keyword_arr=M('article')->distinct(true)->field('art_keyword')->where('art_keyword!=\'\'')->select();
		print_r($keyword_arr);
	}
	
	public function html2wx(){
		$content=str_replace("<p",'<view',$content);
		$content=str_replace("</p>",'</view>',$content);			
		$content=str_replace("<div",'<view',$content);
		$content=str_replace("</div>",'</view>',$content);			
		$content=str_replace("<section",'<view',$content);
		$content=str_replace("</section>",'</view>',$content);		
	}

    public function getImage($url,$dir,$filename){
		//创建保存目录
		if(!file_exists($dir)&&!mkdir($dir,0777,true)){
			return array('file_name'=>'','save_path'=>'','error'=>5);
		}
		//获取远程文件所采用的方法
		$ch = curl_init();	//初始化
		curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
		curl_setopt($ch,CURLOPT_HEADER,0);	//关闭header输出
		curl_setopt($ch,CURLOPT_URL,$url);  //设置请求地址
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);	//关闭直接输出  
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(					
			'accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
			'accept-encoding:gzip, deflate, br',
			'accept-language:zh-CN,zh;q=0.9',
			'cache-control:max-age=0',
			'upgrade-insecure-requests:1',
			'user-agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36',
		));
		$img=curl_exec($ch);
		curl_close($ch);
			
		//文件大小
		$fp2=@fopen($dir.$filename,'a');
		fwrite($fp2,$img);
		fclose($fp2);
		unset($img,$url);
		return array('file_name'=>$filename,'save_path'=>$dir.$filename,'error'=>0);
	}
	
	
    public function getImage2($url,$dir,$filename){
		//创建保存目录
		if(!file_exists($dir)&&!mkdir($dir,0777,true)){
			return array('file_name'=>'','save_path'=>'','error'=>5);
		}
		//获取远程文件所采用的方法
		$ch = curl_init();	//初始化
		curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
		curl_setopt($ch,CURLOPT_HEADER,0);	//关闭header输出
		curl_setopt($ch,CURLOPT_URL,$url);  //设置请求地址
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);	//关闭直接输出  
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(					
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
			'Accept-Encoding:gzip, deflate',
			'Accept-Language:zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
			'Connection:keep-alive',
			'Host:i3.17173cdn.com',
			'Upgrade-Insecure-Requests:1',
			'User-Agent:Mozilla/5.0 (Windows NT 6.1; W…) Gecko/20100101 Firefox/61.0'
		));
		$img=curl_exec($ch);
		// echo $img;exit;
		curl_close($ch);
			
		//文件大小
		$fp2=@fopen($dir.$filename,'a');
		fwrite($fp2,$img);
		fclose($fp2);
		unset($img,$url);
		return array('file_name'=>$filename,'save_path'=>$dir.$filename,'error'=>0);
	}
	
	public function pickupzqlist(){
		$url='http://wx.zcxfgx.cn/index.php?g=Wap&m=Index&a=lists&token=tdlkiw1471125766&diymenu=1&classid=70733';
		$ch = curl_init();	//初始化
		curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
		curl_setopt($ch,CURLOPT_HEADER,0);	//关闭header输出
		curl_setopt($ch,CURLOPT_URL,$url);  //设置请求地址
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);	//对认证证书来源的检查，0表示阻止对证书的合法性的检查。这个选项是必须的，对https协议来说的
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);	//关闭直接输出 	
		$content=curl_exec($ch);	//触发请求 
		if (curl_errno($ch)) {    
			echo 'Errno:'.curl_error($ch);  
		} 
		curl_close($ch);	//关闭curl，释放资源
		
		preg_match_all('/<a href="([^\"]*)">[^\"]*<div class="img"><img src="([^\"]*)" \/><\/div>[^\"]*<h2>([^\"]*)<\/h2>[^\"]*<p class="onlyheight">([^\"]*)<\/p>[^\"]*<span class="icon">&nbsp;<\/span>[^\"]*<div class="clr"><\/div>[^\"]*<\/a>/iU', $content, $list);
		$res['link']=$list[1];
		$res['img']=$list[2];
		$res['name']=$list[3];
		$res['tit']=$list[4];
		return $res;		
	}
	
	public function pickupzq(){
		$res=$this->pickupzqlist();
		foreach($res['link'] as $key=>$val){
			if(M('zqdh')->where('art_name=\''.$res['name'][$key].'\' and art_cate=2')->find()){
				continue;
			}
			if($val{0}=='/'){
				$val='http://wx.zcxfgx.cn'.$val;
			}
			$ch = curl_init();	//初始化
			curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
			curl_setopt($ch,CURLOPT_HEADER,0);	//关闭header输出
			curl_setopt($ch,CURLOPT_URL,$val);  //设置请求地址
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);	//对认证证书来源的检查，0表示阻止对证书的合法性的检查。这个选项是必须的，对https协议来说的
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);	//关闭直接输出 	
			$content=curl_exec($ch);	//触发请求 
			if (curl_errno($ch)) {    
				echo 'Errno:'.curl_error($ch);  
			} 
			curl_close($ch);	//关闭curl，释放资源

			preg_match_all('/<div class="text" id="content">([^\']*)<\/div>/iU', $content, $content_arr);
			$content=$content_arr[0][0];
			
			preg_match_all('/<img [^>]*src="([^\"]*)"[^>]*>/iU', $content, $content_img_arr);
			$content_img_arr=$content_img_arr[1];
			//保存文章内容中的图片
			foreach($content_img_arr as $img){
				$sourceimg=$img;
				if($img{0}=='/'){
					$img='http://wx.zcxfgx.cn'.$img;
				}
				$ext_arr=explode('.',$img);
				$ext=$ext_arr[count($ext_arr)-1];
				$filename=date('His').rand(100,999).'.'.$ext;
				$this->getImage($img,'/opt/data/web/news/admin/uploads/'.date('Y').'/'.date('m').'/'.date('d').'/',$filename);
				$content=str_replace($sourceimg,'uploads/'.date('Y').'/'.date('m').'/'.date('d').'/'.$filename,$content);
			}
			if($content==''){
				$art_url=$res['link'][$key];
				$content='';
			}else{
				$art_url='';
			}
			//保存文章封面图片
			$dir='/opt/data/web/news/admin/uploads/'.date('Y').'/'.date('m').'/'.date('d').'/';
			$filename=date('His').rand(100,999).'.jpg';
			$art_img='uploads/'.date('Y').'/'.date('m').'/'.date('d').'/'.$filename;
			$this->getImage($res['img'][$key],$dir,$filename);
			$arr=[
				'art_name'=>$res['name'][$key],
				'art_tit'=>$res['tit'][$key],
				'art_img'=>$art_img,
				'art_url'=>$art_url,
				'art_cate'=>2,
				'art_content'=>$content,
				'art_addtime'=>date('Y-m-d H:i:s')
			];
			M('zqdh')->add($arr);
		}
	}
	
	public function getArtPic(){
		$db=M('wx1b45d851e064b14a');
		$field=$db->where('art_id=25')->find();
		preg_match_all('/<img [^>]*src="([^\"]*)"[^>]*>/iU', html_entity_decode($field['art_content']), $content_img_arr);
		$content_img_arr=$content_img_arr[1];
		//保存文章内容中的图片
		foreach($content_img_arr as $img){
			if($img{0}!='u'){
				$ext_arr=explode('.',$img);
				$ext=substr($ext_arr[count($ext_arr)-1],0,3);
				$filename=date('His').rand(100,999).'.'.$ext;
				$this->getImage($img,'/opt/data/web/news/admin/uploads/'.date('Y').'/'.date('m').'/'.date('d').'/',$filename);
				$field['art_content']=str_replace($img,'uploads/'.date('Y').'/'.date('m').'/'.date('d').'/'.$filename,$field['art_content']);
			}
		}	
		if($db->where('art_id='.$field['art_id'])->save($field)){
			echo '修改成功';
		}else{
			echo '修改失败';
		}	
		echo '<pre>';
		print_r($content_img_arr);
		echo '</pre>';
	}
}