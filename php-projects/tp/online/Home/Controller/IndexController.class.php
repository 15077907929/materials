<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
		redirect('index.php?m=Home&c=Exam&a=hall');
	}
}