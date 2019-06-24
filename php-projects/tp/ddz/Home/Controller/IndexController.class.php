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
		$user=cookie('user');
		if($user==''){
			redirect('index.php?m=Home&c=User&a=login');
		}
		$room=M('room_ddz')->where('id='.$_GET['id'])->find();
		if(empty($room)){
			die('房间不存在！');
		}
		$name = mysql_result($sql, 0, name);
		$player1_name = $room['player1_name'];
		$player2_name = $room['player2_name'];
		$player_name=cookie('user')['name'];
		if($player_name == '' || ($player_name != $player1_name && $player_name != $player2_name)){
			header("location:index.php?m=Home&c=Index&a=join_game&id=".$_GET['id']);
			exit;
		}
		$this->display();
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