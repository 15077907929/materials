<?php

/**
 * 上传文件专用类
 */
namespace Home\Controller;
class FileController extends BaseController
{
    static $head = array(
        'checkedAccountExportSelf'=>array('email'=>'账号','apple_pwd'=>'苹果密码','email_pwd'=>'邮箱密码','q1_idx'=>'问题一','a1'=>'答案一','q2_idx'=>'问题二','a2'=>'答案二','q3_idx'=>'问题三','a3'=>'答案三','birthday'=>'生日'),
        'keywordCollect'=>array('id'=>'ID','start'=>'开始时间','end'=>'结束时间','country'=>'国家','package_name'=>'包名','game_name'=>'应用名称','keyword'=>'关键词','ranking'=>'排名','diff'=>'变化','hot'=>'热度',
            'count'=>'计划数','count_d'=>'下发数','count_s'=>'成功数','rate'=>'成功率','cp'=>'CP','tag'=>'TAG','old_remark'=>'备注'),
        'oneTaskManager'=>array('id'=>'ID','tag'=>'TAG','cp'=>'CP','package_name'=>'包名','task_name'=>'任务标题','task_type'=>'任务类型','country'=>'国家语言','keyword'=>'关键词','count'=>'数量',
            'issued'=>'下发','success'=>'成功','start'=>'开始时间','end'=>'结束时间','status'=>'是否启用','score'=>'优先级','admin_name'=>'操作人','operate_type'=>'操作'),
        'asoBillList'=>array('id'=>'ID','join_business'=>'对接商务','game_name'=>'游戏名称','package_name'=>'包名','time'=>'下单时间','send_time'=>'投放开始时间','send_time_end'=>'投放结束时间','sale_bill_type'=>'订单类型',
            'bill_detail'=>'任务概要','cpi_count'=>'CPI值','bill_amount'=>'订单价格','bill_product'=>'订单预付款','bill_true_amount'=>'订单实际收入','money_type'=>'货币种类','bill_status'=>'订单完成情况','collection_id'=>'收款详情','is_finish_import'=>'是否结清'),
    );
    static $filepath = '/data/www/googlemanager/data/excel/';
//    static $filepath = 'D:/phpStudy/WWW/googlemanager/data/excel/';
    private function uploadAll($savepath, $ext = array('jpg', 'png')) //上传所有图片
    {
        //import('@.Org.UploadFile');
        $up = new \Home\Org\UploadFile();
        if (!is_array($ext)) {
            error("允许上传的类型配置错误");
        }
        $up->allowExts = $ext;
        $re = $up->upload($savepath);
        if ($re) {
            $ret['status'] = 1;
            $ret['info'] = $up->getUploadFileInfo();
        } else {
            $ret['status'] = 0;
            $ret['info'] = $up->getErrorMsg();
        }
        return $ret;
    }

    private function uploadOne($file, $savepath, $ext = null, $newname = 1) //上传一个文件
    {

        $up = new \Home\Org\UploadFile();
        if ($ext)
            $up->allowExts = is_array($ext) ? $ext : array($ext);

        if($ext == '*')
            $up->allowExts = null;

        if (!$newname) {
            $up->saveRule = '';
        }

        $re = $up->uploadOne($file, $savepath);
        if ($re) {
            $ret['status'] = 1;
            $ret['info'] = $re;
        } else {
            $ret['status'] = 0;
            $ret['info'] = $up->getErrorMsg();
        }
        return $ret;
    }

    /**
     * 上传图片公共方法，根据$_REQUEST['id']判断是否是修改，如果是修改且有上传了新图片，则删除原图片后上传新图片。否则，直接上传新图片
     * @param string $conf 上传路径
     * @param string $field 表中图片的列名称
     * @param int $must 默认是 1，表示添加时必须有此项，其他表示添加时可以没有此项
     */
    public function img($table, $conf, $field, $must = 1, $newname = 1, $allowExt = array("jpg", "png", 'gif', 'jpeg')) //上传图片, 新增图片和修改图片都做了判断····
    {
        $id = is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        if (!$table)
            $table = $_REQUEST['table'];
        $conf = strtolower($conf);

        if ($table && $id && $field) //有id
        {
            $t = M($table);
            $data = $t->find($id);
            $old_img = $data[$field];
        }

        $base_dir = $this->readPath('BASE_DIR');
        $path = C("img.$conf");
        if (!$path) {
            $info = "未读取到路径配置：img.{$conf} . ";
            LogController::e($info . __FILE__ . __LINE__);
            error($info);
        }

        if (is_string($path)) //单独上传模式，不生成任何缩略图
        {
            $dir = $base_dir . $path;
            if ($newname) {

                $re = $this->uploadOne($_FILES[$field], $dir, $allowExt);
            } else {
                $re = $this->uploadOne($_FILES[$field], $dir, $allowExt, 0);
            }
        } else {
            $upload_path = $this->checkPath($path['path']);
            $dir = $base_dir . $upload_path;
            $allowExt = isset($path['ext']) ? $path['ext'] : $allowExt;
            if ($newname)
                $re = $this->uploadOne($_FILES[$field], $dir, $allowExt);
            else
                $re = $this->uploadOne($_FILES[$field], $dir, $allowExt, 0);

            if (isset($path['thumb']) && is_array($path['thumb'])) {
                $thumb = $path['thumb'];
                if (!is_array($thumb[0]))
                    $thumbs[0] = $thumb;
                else
                    $thumbs = $thumb;

                if ($re['status'] == 1) //执行thumb
                {
                    $old_image = $re['info'][0]['savename'];
                    $old_image_name = substr($old_image, 0, strrpos($old_image, '.'));
                    $old_image_ext = substr($old_image, strrpos($old_image, '.') + 1);
                    //import('@.Org.UploadFile');
                    $up = new \Home\Org\UploadFile();

                    foreach ($thumb as $v) {
                        if ($v['size']) {
                            $size = explode('_', $v['size']);
                            if (is_numeric($size[0])) {
                                $width = $size[0];
                                $height = is_numeric($size[1]) ? $size[1] : $width;
                                $ext = isset($v['type']) ? $v['type'] : $old_image_ext;
                                $from_image = $dir . $old_image;
                                $thumb_image = $dir . "{$width}_{$height}/" . $old_image_name . '.' . $ext;
                                $up->thumb($from_image, $thumb_image, $width, $height, $v['radius']);
                            }
                        }
                    }
                }
            }
        }


        if ($re['status'] == 0) //上传失败
        {
            if ($old_img) //如果是修改的情况，直接直接返回原 图片名称
            {
                $this->setGlobal($field , $old_img);
                return $old_img;
            }
            else if ($must)
                error($re['info']);
            else
                return "";
        } else //上传成功
        {
            if ($re['info'][0]['savename'] != $old_img) {
                $this->delAllImage($conf, $old_img); //删除原先图片
            }
            $this->setGlobal($field , $re['info'][0]['savename']);
            return $re['info'][0]['savename'];
        }
    }


    private function setGlobal($field , $value){
        $GLOBALS[$field.'-path'] = $value;
    }

    public function getGlobal($field)
    {
        return $GLOBALS[$field.'-path'];
    }


    /**
     * 公共方法：  删除数据库，且删除对应的图片
     * @param string $table 表名称
     * @param string $field 字段名称
     * @param int $id id值
     */
    function img_del($table, $conf, $field = 'img', $id = null)
    {

        if (!is_numeric($id))
            $id = is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : 0;

        if (!$id)
            error('未找到id值');

        $db = M($table);
        $wh = "id=$id";
        $role_wh = R("Role/role", array('delete', $table, $id));
        if ($role_wh)
            $wh .= " and $role_wh";

        $data = $db->where($wh)->find();
        if (!$data)
            error("未找到数据");
        $path = C("img.$table");
        if (!$path)
            error("$table,未找到路径");

        $field = explode('&', $field);

        foreach ($field as $v) {
            if ($data[$v]) {
                $this->delAllImage($conf, $data[$v]);
//				$filepath = C('BASE_DIR').$path.$data[$v];
//				unlink($filepath);
            }
        }
        $db->where("id=$id")->delete() ? '' : error('错误' . $db->getLastSql());
    }


    /**
     * 删除所有图片，包括对应的缩略图，区分sae服务器和普通服务器
     */
    public function delAllImage($img_conf, $name)
    {
        if (!$img_conf || !$name)
            return false;
        $base_dir = $this->readPath('BASE_DIR');
        $img_conf = C('img.' . $img_conf);


        if (is_string($img_conf))
            return $this->unlinkImg($base_dir . $this->checkPath($img_conf) . $name);
        else {
            $path = $this->checkPath($img_conf['path']);
            $this->unlinkImg($base_dir . $path . $name);
            if (!is_array($img_conf['thumb'][0]))
                $thumbs[0] = $img_conf['thumb'];
            else
                $thumbs = $img_conf['thumb'];

            $img_name = substr($name, 0, strrpos($name, '.'));
            $img_ext = substr($name, strrpos($name, '.') + 1);

            foreach ($thumbs as $v) {
                $ext = isset($v['type']) ? $v['type'] : $img_ext;
                $thumb_path = $base_dir . $path . $this->checkPath($v['size']) . $img_name . '.' . $ext;
                $this->unlinkImg($thumb_path);
            }
            return true;
        }
    }

    /*
     * 获取文件路径 ,可根据传入的$width获取相应缩略图路径
     * $width  intval  或者 array(intval,intval)
     * 前台也会调用 ,前台调用方法 ： R("Admin://File/getFilePath",array('table',80));
     */
    function getFilePath($table, $width = null)
    {
        $base_path = C("BASE_URL");
        $file_path = C("img.{$table}");

        if ($file_path) {
            if (is_string($file_path))
                return $base_path . $file_path;
            else if ($width === null) {
                if (isset($file_path['path']))
                    return $base_path . $file_path['path'];
            } else {
                $w = is_string($width) ? intval($width) : intval($width[0]);
                if (isset($file_path['path']) && isset($file_path['thumb'])) {
                    foreach ($file_path['thumb'] as $v) {
                        $sizes = explode('_', $v['size']);
                        if (count($sizes) == 2 && $sizes[0] == $w) {
                            if (isset($v['type']))
                                return array($base_path . $file_path['path'] . $v['size'] . "/", $v['type']);
                            else
                                return $base_path . $file_path['path'] . $v['size'] . "/";
                        }
                    }
                }
            }
        }

        //LogController::e(__FILE__ . " , ".__LINE__ ." 配置项有误： img.{$table}");
        return "";

    }

    //TODO 需要针对sae重写
    function showImg($table, $name, $size)
    {

        if ($name === null || $name === '')
            return '';

        if (!$table)
            $table = isset($_REQUEST['table']) ? $_REQUEST['table'] : null;
        if (!$table) {
            LogController::e('未找到图片地址的配置文件');
            error('未找到图片地址的配置文件');
        }

        $width = is_string($size) ? $size : $size[0];
        $height = is_array($size) ? $size[1] : null;


        $url = $this->getFilePath($table, $width); //尝试获取相应宽度的缩略图路径
        if (!$url) //获取缩略图路径失败，获取通用路径
            $url = $this->getFilePath($table);

        if (!$url) {
            LogController::e("未找到 {$table} 图片地址的配置文件" . __FILE__ . " : " . __LINE__);
            error('未找到图片地址的配置文件');
        }
        if (is_string($url))
            $ret_url = $url . $name;
        else //缩略图改变了原文件的扩展类型，比如从jpg图片变成了png图片
        {
            $ret_url = $url[0] . substr($name, 0, strrpos($name, '.') + 1) . $url[1];
        }

        if (!$size)
            return '<a href="' . $ret_url . '" target="_blank"><img src="' . $ret_url . '" title="点击查看大图"/></a>';

        $attr = '';
        if ($width)
            $attr .= ' width="' . $width . 'px" ';
        if ($height)
            $attr .= ' height="' . $height . 'px" ';
        return '<a href="' . $ret_url . '" target="_blank"><img src="' . $ret_url . '" ' . $attr . ' title="点击查看大图"/></a>';
    }


    //区别sae模式和本地模式
    private function unlinkImg($path)
    {
        if (false) //sae模式
        {
            $s = getSaeStorage();
            list($domain, $path) = parseDomain($path);
            return $s->delete($domain, $path);
        } else {
            return unlink($path);
        }
    }


    private function readPath($conf)
    {
        return $this->checkPath(C($conf));
    }

    private function checkPath($path)
    {
        $path = rtrim(trim($path), '/') . '/';
        if (!is_string($path)) {
            LogController::e("未读取到路径配置：{$path}");
            error("未读取到路径配置，请查看日志");
        }
        return $path;
    }

    function downFile()
    {
        $base = C('BASE_DIR');
        $filename = I('get.filename');//文件地址
        $arr = explode('/', $filename);
        $tname = date("Y-m-d").'-'.array_reverse($arr)[0];//下载文件名
        $realPath = $base . $filename;

        if(file_exists($realPath))
        {
            $fp = fopen($realPath, 'r');
            Header("Content-type: application/octet-stream");
            Header("Content-Disposition: attachment; filename=$tname");
            Header("Accept-Ranges: bytes");
            Header("Accept-Length: ".filesize($realPath) );
            echo fread($fp, filesize($realPath));
            fclose($fp);
            exit;
        }
    }

    function down($module)
    {
        if(!$module)
            $module = I('get.module') ? I('get.module') : '';
        if($module)
        {
            $file = self::$filepath.'File'.$module.'-'.getAdminName().'.txt';
            if(file_exists($file))
                $do = unserialize(file_get_contents($file));
            $th = self::$head[$module];
            $this->export($th, $do, $module);
        }
    }

    function export($head, $data, $filename)
    {
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
        if(!empty($data))
        {
            if(!empty($head))
            {
                $count = count($head);
                $cc = 0;
                foreach($head as $v1)
                {
                    $sheet->setCellValue($ws[$cc].'1', $v1);
                    $cc++;
                }
            }
            $i = 2;
            $th = array_keys($head);
            foreach($data as $v)
            {
                for($j=0; $j<$count; $j++)
                {
                    $sheet->setCellValue($ws[$j].$i, $v[$th[$j]]);
                }
                $i++;
            }
            $tname = $filename.'-'.date('Y-m-d').'.xlsx';
            $name = self::$filepath.$tname;
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

    function save_file($head, $data, $filename,$url)
    {
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
        if(!empty($data))
        {
            if(!empty($head))
            {
                $count = count($head);
                $cc = 0;
                foreach($head as $v1)
                {
                    $sheet->setCellValue($ws[$cc].'1', $v1);
                    $cc++;
                }
            }
            $i = 2;
            $th = array_keys($head);
            foreach($data as $v)
            {
                for($j=0; $j<$count; $j++)
                {
                    $sheet->setCellValue($ws[$j].$i, $v[$th[$j]]);
                }
                $i++;
            }
            $tname = $filename.'-'.date('Y-m-d').'.xlsx';
            $name = self::$filepath.$tname;
            $writer->save($name);
            success('生成成功', $url);
            exit();
        }
    }
}

?>