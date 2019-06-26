<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
		$user=cookie('user');
		if($user==''){
			redirect('index.php?m=Home&c=User&a=login');
		}
		$p_new=get_p();
		echo '<pre>';
		print_r($p_new);
		echo '</pre>';
		$p_new=implode(',',$p_new);
		$p_new=renew($p_new);
		echo $p_new;
	}
	
	public function hall(){
		$user=cookie('user');
		if($user==''){
			redirect('index.php?m=Home&c=User&a=login');
		}
		$this->display();
	}
	
	public function get_rooms(){
		$db=M('room_ddz');
		$room_arr=$db->select();
		$ori_time=time();
		foreach($room_arr as $key=>$val){
			if($ori_time - $val['system_time'] > 30){
				$val['player1_name']=$val['player2_name']='';
				$val['lord']='';
				$val['player1_p']=$val['player2_p']='';
				$val['lord_p']='';
				$val['flag']='';
				$val['player1_show']=$val['player2_show']='';
				$db->where('id='.$val['id'])->save($val);
			}
			$player1_name=$val['player1_name'];
			$player2_name=$val['player2_name'];
			$content.='<li><table>';
			$content.='<tr><td colspan="3" class="room_num"><a href="index.php?m=Home&c=Index&a=room_ddz&id='.$val['id'].'">'.$val['name'].'</a></td></tr>';
			$content.='<tr><td class="player1">'.$player1_name.'</td>';
			$content.='<td><a href="index.php?m=Home&c=Index&a=room_ddz&id='.$val['id'].'"><img src="Public/images/hall/table'.(($player1_name || $player2_name)?'':'_blank').'.gif" /></td></a>';
			$content.='<td class="player2">'.$player2_name."</td>".'</tr>';
			$content.='<tr><td colspan="3" class="sort">-'.($key + 1).'-</td></tr>';
			$content.='</table></li>';
		}
		echo $content;
	}
	
	public function room_ddz(){
		$db=M('room_ddz');
		$user=cookie('user');
		if($user==''){
			redirect('index.php?m=Home&c=User&a=login');
		}
		$room=$db->where('id='.$_GET['id'])->find();
		if(empty($room)){
			die('房间不存在！');
		}
		$player1_name = $room['player1_name'];
		$player2_name = $room['player2_name'];
		$player_name=cookie('user')['name'];
		if($player_name == '' || ($player_name != $player1_name && $player_name != $player2_name)){
			header("location:index.php?m=Home&c=Index&a=join_game&id=".$_GET['id']);
			exit;
		}
		$res['room']=$room;
		$res['user']=$user;
		$this->assign('res',$res);
		$this->display();
	}
	
	public function get_info(){
		$db=M('room_ddz');
		$udb=M('user_ddz');
		$user=cookie('user');
		$room=$db->where('id='.$_GET['id'])->find();
		$player1_name=$room['player1_name'];
		$player2_name=$room['player2_name'];
		$player1_p=$room['player1_p'];
		$player2_p=$room['player2_p'];
		$lord_p=$room['lord_p'];
		$lord=$room['lord'];
		$flag=$room['flag'];
		$player1_show=$room['player1_show'];
		$player2_show=$room['player2_show'];
		$player1_time=$room['player1_time'];
		$player2_time=$room['player2_time'];
		$system_time = $room['system_time'];
		
		if($player1_name){
			$user1 = $udb->where('name = \''.$player1_name.'\'')->find();
			$player1_face = $user1['face'];
			$player1_win = $user1['win'];
			$player1_lost = $user1['lost'];
			$player1_run = $user1['run'];
			$player1_win_p = ($player1_win+$player1_lost+$player1_run == 0)?0:round(100*$player1_win/($player1_win+$player1_lost+$player1_run), 2);
			$player1_run_p = ($player1_win+$player1_lost+$player1_run == 0)?0:round(100*$player1_run/($player1_win+$player1_lost+$player1_run), 2);
			
		}
		if($player2_name){	
			$user2 = $udb->where('name = \''.$player2_name.'\'')->find();
			$player2_face = $user2['face'];
			$player2_win = $user2['win'];
			$player2_lost = $user2['lost'];
			$player2_run = $user2['run'];
			$player2_win_p = ($player2_win+$player2_lost+$player2_run == 0)?0:round(100*$player2_win/($player2_win+$player2_lost+$player2_run), 2);
			$player2_run_p = ($player2_win+$player2_lost+$player2_run == 0)?0:round(100*$player2_run/($player2_win+$player2_lost+$player2_run), 2);
		}	
	
		if($player1_p == '' || $player2_p == ''){
			$room['lord']='';
			$room['player1_p']='';
			$room['player2_p']='';
			$room['lord_p']='';
			$room['flag']='';
			$room['player1_show']='';
			$room['player2_show']='';
			$db->where('id='.$_GET['id'])->save($room);
			if($player1_p == '' && $lord_p){
				$udb->query('update user_ddz set `win` = `win` + 1 where name = \''.$player1_name.'\'');
				$udb->query('update user_ddz set `lost` = `lost` + 1 where name = \''.$player2_name.'\'');
			}
			if($player2_p == '' && $lord_p){
				$udb->query('update user_ddz set `win` = `win` + 1 where name = \''.$player2_name.'\'');
				$udb->query('update user_ddz set `lost` = `lost` + 1 where name = \''.$player1_name.'\'');
			}
			$lord_p = "";
			$player1_p = "";
			$player2_p = "";
		}
	
		if($_GET['player_id'] == 'player1'){
			if(($system_time - $player2_time > 30) && $lord_p!=''){
				$room['player2_name']='';
				$room['lord']='';
				$room['player1_p']='';
				$room['player2_p']='';
				$room['lord_p']='';
				$room['flag']='';
				$room['player1_show']='';
				$room['player2_show']='';
				$room['player2_time']=0;
				$room['system_time']=0;
				$db->where('id='.$_GET['id'])->save($room);
				$user2['run']=$user2['run']+1;
				$udb->where('name=\''.$player2_name.'\'')->save($user2);
			}
		}else{
			if(($system_time - $player1_time > 30) && $lord_p!=''){
				$room['player1_name']='';
				$room['lord']='';
				$room['player1_p']='';
				$room['player2_p']='';
				$room['lord_p']='';
				$room['flag']='';
				$room['player1_show']='';
				$room['player2_show']='';
				$room['player1_time']=0;
				$room['system_time']=0;
				$db->where('id='.$_GET['id'])->save($room);
				$user1['run']=$user2['run']+1;
				$udb->where('name=\''.$player1_name.'\'')->save($user1);
			}
		}
	
		$player1_p_num = sizeof(explode(",", $player1_p)) - 1;
		$player2_p_num = sizeof(explode(",", $player2_p)) - 1;
	
		if($lord_p == '' && $player1_name && $player2_name){
			$p_new = get_p();

			for($i = 0;$i < 17;$i ++)
				$player1_p .= $p_new[$i].",";
			
			for($i = 17;$i < 34;$i ++)
				$player2_p .= $p_new[$i].",";

			for($i = 34;$i < 37;$i ++)
				$lord_p .= $p_new[$i].",";
			
			$room['player1_p']=$player1_p;
			$room['player2_p']=$player2_p;
			$room['lord_p']=$lord_p;
			$db->where('id='.$_GET['id'])->save($room);
		}
		
		$room[$_GET['player_id'].'_name'] = $user['name'];
		$room[$_GET['player_id'].'_time'] = time();
		$room['system_time'] = time();
		$db->where('id='.$_GET['id'])->save($room);
	
		$str=$player1_name.'|'.$player2_name.'|'.($_GET['player_id'] == 'player1'?renew($player1_p):renew($player2_p));
		$str=$str.'|'.($_GET['player_id'] == 'player1'?$player2_p_num:$player1_p_num).'|'.$lord.'|'.renew($lord_p);
		$str=$str.'|'.$flag.'|'.$player1_show.'|'.$player2_show.'|'.$player1_face.'|'.$player2_face;
		$str=$str.'|'.$player1_win_p.'|'.$player2_win_p.'|'.$player1_run_p.'|'.$player2_run_p;
		echo $str;
	}
	
	public function get_lord(){
		$db=M('room_ddz');
		$room=$db->where('id='.$_GET['id'])->find();
		if($_GET['action'] == no){
			if($_GET['player_id'] == 'player1')
				$_GET['player_id'] = 'player2';
			else
				$_GET['player_id'] = 'player1';
		}
	
		if($room['lord'] == ''){
			$room[$_GET['player_id'].'_p']=$room[$_GET['player_id'].'_p'].$room['lord_p'];
			$room['lord']=$_GET['player_id'];
			$room['flag']=$_GET['player_id'];
			$db->where('id='.$_GET['id'])->save($room);
		}
	}
	
	public function end_game(){
		M('room_ddz')->query('update room_ddz set player1_name = \'\', player2_name = \'\' where id = \''.$_GET['id'].'\'');
	}
	
	public function show_p(){
		$db=M('room_ddz');
		$room=$db->where('id='.$_GET['id'])->find();
		if($_GET['p_show_var'] == '')
			$_GET['p_show_var'] = 'NO,';
		$pai=$room[$_GET['player_id'].'_p'];
		$e_pai=explode(",", $pai);
		$e_p_show_var=explode(',', $_GET['p_show_var']);
		for($i = 0;$i < sizeof($e_pai) - 1;$i ++){
			$flag = 1;
			for($j = 0;$j < sizeof($e_p_show_var) - 1;$j ++){
				if($e_pai[$i] == $e_p_show_var[$j])
					$flag = 0;
			}
			if($flag)
				$pai_new .= $e_pai[$i].",";
		}
		$room[$_GET['player_id'].'_p']=$pai_new;
		$room[$_GET['player_id'].'_show']=$_GET['p_show_var'];
		$room['flag']=($_GET['player_id'] == 'player1'?'player2':'player1');
		$db->where('id='.$_GET['id'])->save($room);
	}
	
	public function join_game(){
		$db=M('room_ddz');
		$player_name=cookie('user')['name'];
		$ori_time=time();
		$rst=$db->where('(player1_name=\''.$player_name.'\' or player2_name=\''.$player_name.'\') and id='.$_GET['id'])->find();
		if(!empty($rst)){
			header("location:index.php?m=Home&c=Index&a=room_ddz&id=".$_GET['id']);
			exit;
		}else{
			$rst=M('user_ddz')->where('name=\''.$player_name.'\'')->find();
			if(empty($rst)){
				redirect('index.php?m=Home&c=User&a=login');
			}
			$room=$db->where('id='.$_GET['id'])->find();
			if(empty($room)){
				die('参数有误！');
			}	
			$player1_name = $room['player1_name'];
			$player2_name = $room['player2_name'];	
			if($player1_name&&$player2_name){
				redirect('index.php?m=Home&c=Index&a=hall');
				exit;
			}
			if($player1_name==''){
				$room['player1_name']=$player_name;
				$room['player1_time']=$ori_time;
				$room['system_time']=$ori_time;
				$db->where('id='.$_GET['id'])->save($room);
				redirect('index.php?m=Home&c=Index&a=room_ddz&id='.$_GET['id']);
			}		
			if($player2_name==''){
				$room['player2_name']=$player_name;
				$room['player2_time']=$ori_time;
				$room['system_time']=$ori_time;
				$db->where('id='.$_GET['id'])->save($room);
				redirect('index.php?m=Home&c=Index&a=room_ddz&id='.$_GET['id']);
			}
		}
		
	}
}