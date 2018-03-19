<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class CKEditorController extends CommonController {
    public function upload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
			$callback =$_GET['CKEditorFuncNum'];   
			echo '<script type="text/javascript">';  
			echo "window.parent.CKEDITOR.tools.callFunction(".$callback.",'"."Uploads/".$info['upload']['savepath'].$info['upload']['savename']."','')"; 
			echo '</script>';              
        }
    }
}