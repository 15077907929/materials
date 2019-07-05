<?php
namespace Admin\Model;
use Think\Model;
class AlbumsModel extends Model{
	public static function del_album($id){
		$del_album=M('albums')->where('id='.$_GET['id'])->delete();
		$del_album_imgs=$db2=M('imgs')->where('album='.$_GET['id'])->delete();
		return $del_album && $del_album_imgs;
	}
	
	public static function priv_album($id,$private){
		$data['id']=$id;
		$data['private']=$private;
		$ret=M('albums')->where('id='.$id)->save($data);
		if($ret){
            M('imgs')->query('update imgs set private='.$private.' where album='.$id);
        }
        return $ret;
	}
	
	public static function remove_cover($picid){
		M('albums')->query('update albums set cover=0 where cover='.$picid);
	}
	
	public static function set_cover($id,$thumb){
		$data['cover']=$thumb;
		$ret=M('albums')->where('id='.$id)->save($data);
		return $ret;
	}
	
	public static function get_cover($album_id,$cover_id = 0){
        $where = 'album='.intval($album_id).' and status=1';
        if($cover_id >0){
            $where .= ' and id='.intval($cover_id);
        }
        $find=M('imgs')->where($where)->find();
		if($find){
           return $find;
		}else{
           return false;
       }
    }
	
	public static function get_albums_assoc($album_id=0){
		$where = '';
        if($album_id>0){
            $where = 'id <> '.intval($album_id);
        }
        return M('albums')->where($where)->select();
	}
	
	public static function update_pic($id,$name,$album=0){
		$data['name'] = $name;
        $data['status'] = 1;
        if($album>0){
            $album_arr = M('albums')->where('id='.$album)->find();
            if($album_arr){
                $data['private'] = $album_arr['private'];
                $data['album'] = intval($album);
            }
        }
        $ret=M('imgs')->where('id='.$id)->save($data);
        return $ret;
	}
}