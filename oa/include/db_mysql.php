<?php
class FMysql{
	//db set 
	public $database='';
	public $server='localhost';
	public $user='root';
	public $password='';
	public $usepconnect=0;
	
	private $link_id=0;
	private $query_id=0;
	private $record=array();
	
	private $errdesc='';
	private $errno=0;
	private $reporterror=1;

	//connect
	public function connect(){
		//connect to db server
		if($this->link_id==0){
			if($this->password==''){
				echo 'password';
			}else{
				if($this->usepconnect==1){
					$this->link_id=mysql_pconnect($this->server,$this->user,$this->password);
				}else{
					$this->link_id=mysql_connect($this->server,$this->user,$this->password);
				}
			}
			if(!$this->link_id){
				$this->halt('link_id错误,链接失败');
			}
			if($this->database!=''){
				if(!mysql_select_db($this->database,$this->link_id)){
					$this->halt('无法使用数据库'.$this->database);
				}
			}
		}
	}
	
	//query
	public function query($query_string){
		//do query
		$this->query_id=mysql_query($query_string,$this->link_id);
		if(!$this->query_id){
			$this->halt('无效的SQL:'.$query_string);
		}
		return $this->query_id;
	}
	
	//get record
	public function query_first($query_string){
		//does a query and returns first row
		$query_id=$this->query($query_string);
		$returnarray=$this->fetch_array($query_id,$query_string);
		$this->free_result($query_id);
		return $returnarray;
	}
	
	public function free_result($query_id=-1){
		//retrieve row
		if($query_id!=-1){
			$this->query_id=$query_id;
		}
		return mysql_free_result($this->query_id);
	}
	
	//get result array
	public function fetch_array($query_id=-1,$query_string=''){
		//retrieve row
		if($query_id!=-1){
			$this->query_id=$query_id;
		}
		if(isset($this->query_id)){
			$this->record=mysql_fetch_array($this->query_id);
		}else{
			if(!empty($query_string)){
				$this->halt('无效的查询id号('.$this->query_id.')在此查询中：'.$this->query_string);
			}else{
				$this->halt('指定了无效的查询id号'.$this->query_id);
			}
		}
		return $this->record;
	}
	
	//halt
	public function halt($msg){
		$this->errdesc=mysql_error();
		$this->errno=mysql_errno();
		//prints warning message when there is an error
		if($this->reporterror==1){
			$message='数据库发生错误：<br/><br/>'.$msg.'<br/><br/>';
			$message.='mysql数据库错误：'.$this->errdesc.'<br/><br/>';
			$message.='mysql数据库错误号：'.$this->errno.'<br/><br/>';
			$message.='时间：'.date('Y-m-d h:i:s A').'<br/>';
			echo $message;
			exit;
		}
	}
	
	public function num_rows($query_id=-1){
		//return number of rows in query
		if($query_id!=-1){
			$this->query_id=$query_id;
		}
		return mysql_num_rows($this->query_id);
	}
}
?>