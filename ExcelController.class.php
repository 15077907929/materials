<?php
//操作excel
namespace Pickup\Controller;
class ExcelController extends RoleController{
	public function read_excel($file,$sheet){
		vendor('PHPExcel.PHPExcel');
        $Excel = new \PHPExcel();
        vendor("PHPExcel.PHPExcel.Reader.Excel2007");	// 如果excel文件后缀名为.xlsx
        $PHPReader = new \PHPExcel_Reader_Excel2007();		
        $Excel = $PHPReader -> load($file);	// 载入文件	
        $currentSheet = $Excel -> getSheet($sheet);	//获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $allColumn = $currentSheet -> getHighestColumn();	//获取总列数
        $allRow = $currentSheet -> getHighestRow();	//获取总行数
        //循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
        for($currentRow = 1; $currentRow <= $allRow; $currentRow++) {
            for($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {	//从哪列开始，A表示第一列
				$address = $currentColumn.$currentRow;	//数据坐标       
				$arr[$currentRow][$currentColumn] = $currentSheet-> getCell($address)-> getValue();	//读取到的数据，保存到数组$arr中
            }
        }
		return $arr;	
	}
	
	public function excel_insert_db(){
		$file = '/data/www/googlemanager/Uploads/country_map/country_code.xlsx';
		$arr=$this->read_excel($file,0);
		$db=M('country_world_map');
		$result_arr=$db->select();		
		foreach($arr as $key=>$val){
			$find=$db->where('name=\''.$val['B'].'\' and short_name=\''.$val['A'].'\'')->select();
			if(!$find){
				$data=array('name'=>$val['B'],'short_name'=>$val['A']);
				$db->add($data);	
			}
		}
	}
	
	public function daily_install(){	//日增推荐位
		$file = '/data/www/googlemanager/Uploads/country_map/807201.xlsx';
		$arr=$this->read_excel($file,2);
		$arr_search=$this->read_excel($file,5);
		$count=-1;
		foreach($arr as $key=>$val){
			if($val['F']!=''){
				$count++;
			}
		}
		$db=M('country_world_map');
		for($i=2;$i<$count;$i++){
			foreach($arr_search as $key=>$val){
				$find=$db->where('short_name=\''.$val['C'].'\'')->select();
				if($find){
					if($arr[$i]['E']==$find[0]['name']){
						if($arr[1]['G']==$val['A']){
							// echo $arr[$i]['E'].$val['C'].$val['A'].'ok<br/>';
							$arr[$i]['G']=$val['H'];
						}						
						if($arr[1]['H']==$val['A']){
							$arr[$i]['H']=$val['H'];
						}
					}
				}	
			}
		}
		$filename  = "xz_";
		$head=array('B'=>'国家','C'=>'推荐位数','E'=>'行标签','F'=>'求和项：推荐位数','G'=>'2017/12/22','H'=>'2017/12/23');
		$this->export($head,$arr,$filename);
	}
	
    function export($head, $data, $filename){	//数组导出为excel
        import('@.Org.PHPExcel');
        $excel = new \PHPExcel();
        $writer  =new \PHPExcel_Writer_Excel2007($excel);
        $sheet = $excel->getActiveSheet();
        $ws = array(
            'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T',
            'U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN',
            'AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ'
        );
        $count = 0;
        if(!empty($data)){
            if(!empty($head)){
                $count = count($head);
                $cc = 0;
                foreach($head as $v1){
                    $sheet->setCellValue($ws[$cc].'1', $v1);
                    $cc++;
                }
            }
            $i = 2;
            $th = array_keys($head);
            foreach($data as $v){
                for($j=0; $j<$count; $j++){
                    $sheet->setCellValue($ws[$j].$i, $v[$th[$j]]);
                }
                $i++;
            }
            $tname = $filename.'-'.date('Y-m-d').'.xlsx';
            $name = $tname;
            $writer->save($name);
            $fp = fopen( $name ,"r");
            Header("Content-type: application/octet-stream");
            header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
            Header("Accept-Ranges: bytes");
            Header("Accept-Length: ". filesize ($name) );
            Header("Content-Disposition: attachment; filename=$tname");
            echo fread( $fp ,filesize($name ));
            fclose($fp);
            unlink($name);
            exit();
        }
    }
}