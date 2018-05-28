<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model{
    protected $table='config';
	protected $primaryKey='id';
	public $timestamps=false;
	protected $guarded=[];
	
	static public function getConfig(){
		$config=Config::paginate(10);;
		foreach($config as $key=>&$val){
			switch($val['field_type']){
				case '1':	//input
					$val['content']='<input type="text" name="content[]" value="'.$val['content'].'" />';
				break;				
				case '2':	//textarea
					$val['content']='<textarea name="content[]">'.$val['content'].'</textarea>';
				break;				
				case '3':	//radio
					$field_val_arr=explode(',',$val['field_value']);
					$content=$val['content'];
					$val['content']='';
					foreach($field_val_arr as $k=>$v){
						$status=($v==1)?'开启':'关闭';
						$checked=($content==$v)?'checked':'';
						$val['content'].='<input type="radio" name="content[]" value="'.$v.'"'.$checked.' />'.$status.' ';
					}
				break;
			}
		}
		return $config;		
	}
}
