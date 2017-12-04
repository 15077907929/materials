<?php
/***************巢湖市槐林中学***************/
class MicroTpl{
	//左定界符
	public $left_delimiter='{';
	//右定界符
	public $right_delimiter='}';
	//模板文件所在目录
	public $template_dir='templates';
	//编译文件所在目录
	public $compile_dir='cache';
	//静态输出文件目录
	public $html_dir='cache/html';
	//强制编译
	public $force_compile=false;
	//强制生成html
	public $force_html=false;
	//保存模板变量
	private $ftpl_var=array();
	
	//构造函数
	public function __construct($template_dir='',$compile_dir='',$html_dir='',$left_tag='',$right_tag=''){
		if(!empty($left_tag)&&!empty($right_tag)){
			$this->left_delimiter=$left_tag;
			$this->right_delimiter=$right_tag;
		}
		if(!empty($template_dir)){
			$this->template_dir=$template_dir;
		}
		if(!empty($compile_dir)&&!empty($html_dir)){
			$this->compile_dir=$compile_dir;
			$this->html_dir=$html_dir;
		}
		$this->create($this->compile_dir);
		$this->create($this->html_dir);
	}
	
	//目录建立函数
	public function create($dir){
		if(!is_dir($dir)){
			$temp=explode('/',$dir);
			$cur_dir='';
			for($i=0;$i<count($temp);$i++){
				$cur_dir.=$temp[$i].'/';
				if(!is_dir($cur_dir)){
					mkdir($cur_dir,0777);
					fopen($cur_dir.'/index.html','a');
				}
			}
		}
	}
	
	//模板变量处理
	public function parse_vars($vars){
		$vars_arr = explode('.',$vars);
		foreach ($vars_arr as $key=>$value){
			$len_n=strspn("[",$value);
			$len_s=strrpos($value,"[");
			if($key == 0){
				if(preg_match_all('/(\w+)(\[\w+\])*?/',$value,$vars_arr1)){
					foreach ($vars_arr1[0] as $key2=>$value2) {
						if($key2 == 0) {
							$rep[] = '$this->ftpl_var[\''.$value2.'\']';
						}
						else{
							$rep[] = '[\$this->ftpl_var[\''.$value2.'\']]';
						}
					}
				}
			}
			else{
				if(preg_match_all('/(\w+)(\[\w+\])*?/',$value,$vars_arr1)){
					foreach ($vars_arr1[0] as $key2=>$value2) {
						if($key2 == 0) {
							$rep[] = ($len_n>0 && $len_s<1)?'[$this->ftpl_var[\''.$value2.'\']]':'[\''.$value2.'\']';
						}
						else{
							$rep[] = '[\$this->ftpl_var[\''.$value2.'\']]';
						}
					}
				}
			}
		}
		$replace = implode('',$rep);
		return $replace;
	}
	
	//解析模板变量
	public function parse_variable($content){
		$variable_regular = '/'.$this->_quote($this->left_delimiter).'\$(\w([\w\.\[\]]*[\w\]])?)'.$this->_quote($this->right_delimiter).'/';
		if(preg_match_all($variable_regular,$content,$variable_arr)){
			foreach ($variable_arr[1] as $key=>$value){
				$rep = "<?php echo ";
				$rep .= $this->parse_vars($value);
				$rep .= ";?>";
				$content = preg_replace('/'.$this->_quote($variable_arr[0][$key]).'/',$rep,$content,1);
			}
		}
		return $content;
	}
	
	//解析 foreach 语句
	public function parse_foreach($content){
		$foreach_regular =  '/'.$this->_quote($this->left_delimiter).'foreach\s+(name\s*=\s*(\w+)\s*)?(key\s*=\s*(\w+)\s*)?item\s*=\s*([\w\[\]\.]+)\s+from\s*=\s*\$([\w\[\]\.]+)\s*'.$this->_quote($this->right_delimiter).'/';
		if(preg_match_all($foreach_regular,$content,$foreach_arr)){
			foreach($foreach_arr[6] as $key=>$val){
				$key2=$foreach_arr[6][$key];
				preg_match_all('/\s*from\s*=\s*\$([\w\.\]\[]+)\s*/i',$foreach_arr[0][$key],$output1);
				$from = $this->parse_vars($output1[1][0]);
				$key2=null;
				if (!empty($foreach_arr[4][$key])) {
					$key1  = $foreach_arr[4][$key];
					$key_part = "\$this->ftpl_var['$key1'] => ";
				} else {
					$key1=null;
					$key_part = '';
				}
				$name=$foreach_arr[2][$key];
				$item=$foreach_arr[5][$key];
				$rep = array();
				$rep[] = '<?php ';
				$rep[]= "\$_from = $from; if (!is_array(\$_from) && !is_object(\$_from)) { settype(\$_from, 'array');}";
				if (!empty($name)) {
					$foreach_props = "\$this->ftpl_var['foreach']['$name']";
					$rep[]= "{$foreach_props} = array('total' => count(\$_from), 'iteration' => 0);";
					$rep[]= "if ({$foreach_props}['total'] > 0){";
					$rep[]= "    foreach (\$_from as $key_part\$this->ftpl_var['$item']){";
					$rep[]= "        {$foreach_props}['iteration']++;";
				} else {
					$rep[]= "if (count(\$_from)){";
					$rep[]= "    foreach (\$_from as $key_part\$this->ftpl_var['$item']){";
				}
				$rep[]= '?>';
				$rs = implode("\r\n",$rep);
				$content = preg_replace('/'.$this->_quote($foreach_arr[0][$key]).'/s',$rs,$content,1);
				unset($rs,$key2,$name,$item,$from,$key_part);
			}
		}
		return $content;
	}
	
	//解析 section 和 if 结束标记
	public function parse_end($content){
		$section_end_regular = '/'.$this->_quote($this->left_delimiter).'\/section'.$this->_quote($this->right_delimiter).'/';
		$section_rep = "<?php\r\n    }\r\n}\r\n?>";
		$content = preg_replace($section_end_regular,$section_rep,$content);
		$if_end_regular = '/'.$this->_quote($this->left_delimiter).'\/if'.$this->_quote($this->right_delimiter).'/';
		$if_rep = "<?php\r\n}\r\n?>";
		$content = preg_replace($if_end_regular,$if_rep,$content);
		$if_end_regular = '/'.$this->_quote($this->left_delimiter).'\/foreach'.$this->_quote($this->right_delimiter).'/';
		$if_rep = "<?php\r\n}
		unset(\$_form);
		\r\n} ?>";
		$content = preg_replace($if_end_regular,$if_rep,$content);
		return $content;
	}
	
	//模板变量赋值
	public function assign($vars,$value=null){
		if(is_array($vars)){
			foreach($vars as $key=>$val){
				if($key!=''){
					$this->ftpl_var[$key]=$val;
				}
			}
		}else{
			if($vars!=''){
				$this->ftpl_var[$vars]=$value;
			}
		}
	}
	
	//内容输出
	public function display($file_name){
		error_reporting(E_ALL^E_NOTICE);
		echo $this->fetch($file_name);
		$this->outtime();
	}
	
	//获得输出内容
	public function fetch($file_name){
		$compiledfile_url=$this->get_compiledfile_url($file_name);
		ob_start();
		$this->compile($file_name);
		include($compiledfile_url);
		$content=ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
	//编译
	public function compile($file_name){
		$content=$this->get_comtents($file_name);
		if(!$this->is_compiled($file_name)){
			$content = $this->parse_variable($content);
			$content = $this->parse_foreach($content);
			$content = $this->parse_end($content);
			$this->write_file($file_name,$content);
		}
	}

	//正则字符转义
	public function _quote($val){
		return preg_quote($val,'/');
	}
	
	//写编译文件
	public function write_file($file_name,$content){
		$compiledfile_url = $this->get_compiledfile_url($file_name);
		if(!is_dir($this->compile_dir)){
			$this->create($this->compile_dir);
		}
		if(!is_writable($this->compile_dir)){
			$this->show_messages("请先将编译文件夹".$this->compile_dir."和该文件夹中的所有文件的属性改成777。");
		}
		$fp = fopen($compiledfile_url,'wb');
		fwrite($fp,$content);
		fclose($fp);
		chmod($compiledfile_url,0777);
	}
	
	//读取模板
	public function get_comtents($file_name){
		$sourcefile_url=$this->get_sourcefile_url($file_name);
		if(!file_exists($sourcefile_url)||!($content=file_get_contents($sourcefile_url))){
			$this->show_messages("无法读取模板文件{".$file_name."}，请检查文件是否存在");
		}
		return $content;
	}
	
	//计算输出时间
	public function outtime(){
		global $start;
		$end=explode(' ',microtime());
		$end=$end[1]+$end[0];
		if($start>0){
			echo '<div class="timer">执行时间为：'.number_format(($end-$start)*1000,1).'毫秒</div>';
		}
	}
	
	//模板文件路径
	public function get_sourcefile_url($file_name){
		return preg_match('/\/$/',$this->template_dir)?$this->template_dir.$file_name:$this->template_dir.'/'.$file_name;		
	}
	
	//编译文件路径
	public function get_compiledfile_url($file_name){
		return preg_match('/\/$/',$this->compile_dir)?$this->compile_dir.$file_name.'.php':$this->compile_dir.'/'.$file_name.'.php';
	}	
	
	//静态文件路径
	public function get_html_url($file_name){
		return preg_match('/\/$/',$this->html_dir)?$this->html_dir.$file_name.'.html':$this->html_dir.'/'.$file_name.'.html';
	}
	
	//判断编译条件
	public function is_compiled($file_name){
		if($this->force_compile){
			return false;
		}else{
			$sourcefile_url=$this->get_sourcefile_url($file_name);
			$compiledfile_url=$this->get_compiledfile_url($file_name);
			if(!file_exists($compiledfile_url)||filemtime($sourcefile_url)>filemtime($compiledfile_url)){
				return false;
			}
		}
	}
	
	//生成html文件
	public function to_html($filename,$addname='',$pagenumber=1){
		$compiledfile_url=$this->get_compiledfile_url($filename);
		$this->compile($filename);
		if(!$this->is_html($filename,$addname)){
			ob_start();	//打开缓冲区
			if(!empty($addname)){
				$filename.='_'.$addname;
			}
			if($pagenumber>1){
				$filename.='_'.$pagenumber;
			}
			$fn=$this->get_html_url($filename);	//生成文件名
			include($compiledfile_url);	//载入要生成静态页的文件，因为后台有ob_clean()所以不会显示出来
			$fs=fopen($fn,'wb');	//打开静态文件
			fwrite($fs,ob_get_contents());	//生成静态文件
			fclose($fs);	//关闭静态文件
			ob_clean();	//清空缓存
			chmod($fn,0777);
		}else{
			if(!empty($addname)){
				$filename.='_'.$addname;
			}
			if($pagenumber>1){
				$filename.='_'.$pagenumber;
			}
		}
		include($this->get_html_url($filename));
		$this->outtime();
	}
	
	//判定html生成条件
	public function is_html($file_name,$addname='',$pagenumber=1){
		if($this->force_html){
			return false;
		}else{
			$html_name=(empty($addname))?$file_name:$file_name.'_'.$addname;
			$html_name=($pagenumber>1)?$file_name.'_'.$pagenumber:$html_name;
			$compiledfile_url=$this->get_compiledfile_url($file_name);
			$html_url=$this->get_html_url($html_name);
			if(!file_exists($html_url) ||(filemtime($html_url)<filemtime($compiledfile_url))){
				return false;
			}
		}
	}
	
	//信息提示
	public function show_messages($message){
		echo $message;
		exit;
	}
}
?>