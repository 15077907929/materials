<?php
require("conn.php"); 
require(__DIR__ .'/vendor/PHPExcel/PHPExcel.php');
require(__DIR__ .'/vendor/PHPExcel/PHPExcel/IOFactory.php');
require(__DIR__ .'/vendor/PHPExcel/PHPExcel/Reader/Excel5.php');

$excelpath='/usr/deploy/andplus/androidplus/admin/facebook/abcd.xlsx';
$WriteFilePath='/usr/deploy/andplus/androidplus/admin/facebook/new_abc.xlsx';

$extension = strtolower( pathinfo($excelpath, PATHINFO_EXTENSION) );

if ($extension =='xlsx') {
    $objReader = new PHPExcel_Reader_Excel2007();
    $objPHPExcel = $objReader ->load($excelpath);
} else if ($extension =='xls') {
    $objReader = new PHPExcel_Reader_Excel5();
    $objPHPExcel = $objReader ->load($excelpath);
} else if ($extension=='csv') {
    $PHPReader = new PHPExcel_Reader_CSV();
    //默认输入字符集
    $PHPReader->setInputEncoding('GBK');
    //默认的分隔符
    $PHPReader->setDelimiter(',');
    //载入文件
    $objPHPExcel = $PHPReader->load($excelpath);
}

$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow();           //取得总行数 
$highestColumn = $sheet->getHighestColumn(); //取得总列数

/** 循环读取每个单元格的数据 */ 
$pick_date_arr=[
	'2018-04-21','2018-04-22','2018-04-23','2018-04-24','2018-04-25','2018-04-26','2018-04-27','2018-04-28','2018-04-29','2018-04-30'
];
$date=date('Y-m-d');
foreach($pick_date_arr as $pick_date){
	for ($row = 2; $row <= $highestRow; $row++){    //行号从1开始   
		$d=[];
		for ($column = 'A'; $column <= $highestColumn; $column++){  //列数是以A列开始  
			$d[$column]=$sheet->getCell($column.$row)->getValue();  
		} 
		$d['A']=date('Y-m-d',($d['A']-25569)*24*60*60);
		$d['B']=date('Y-m-d',($d['B']-25569)*24*60*60);
		if($d['A']==$pick_date && $d['B']==$pick_date){
			$data=array(
				'app_id'=>$d['E'],
				'date_start'=>$d['A'],
				'date_stop'=>$d['B'],
				'country'=>$d['D'],
				'impressions'=>$d['G'],
				'unique_clicks'=>$d['H'],
				'app_installs'=>$d['I'],
				'spend'=>$d['K'],
				'addtime'=>$date,
			);
			$tmp[] = implode('||', $data);
			// $query='insert into facebook_ads set app_id='.$data['app_id'].',date_start=\''.$data['date_start'].'\',date_stop=\''.$data['date_stop'].'\',country=\''.$data['country'].'\',impressions='.$data['impressions'].',unique_clicks='.$data['unique_clicks'].',app_installs='.$data['app_installs'].',spend='.$data['spend'].',addtime=\''.$data['addtime'].'\'';
			// echo $i++.'.'.$query.'<br/>';
			// mysql_query($query);
			// print_r($data);exit;
		}	
	}
}
//写入处理之后文件内容
file_put_contents($WriteFilePath, implode(PHP_EOL, $tmp));

$mysql_cmd = '/opt/mysql/bin/mysql';
$logSQl = $mysql_cmd . ' -h192.168.1.8 -uplugpig -p76dF2RxRvDpF99E6 --local-infile=1 lt_androidplus -e  "load  data local infile \'' . $WriteFilePath . '\'  ignore into table facebook_ads fields terminated by \'||\' enclosed by \'\"\' lines terminated by \'\n\' (app_id,date_start,date_stop,country,impressions,unique_clicks,app_installs,spend,addtime);"';
exec($logSQl, $out, $status);
						
echo 'facebook data picked completely!';

// $app_id_arr=[];
// foreach($data as $d){
	// if(!in_array($d['E'],$app_id_arr)){
		// $app_id_arr[$d['E']]='';
	// }
// }
// foreach($app_id_arr as $a=>&$app){
	// foreach($data as $d){
		// if($d['E']==$a){
			// $app[]=$d;
		// }
	// }
// }

// foreach($app_id_arr as $key=>$val){
	// foreach($val as $v){
		
	// }
// }




