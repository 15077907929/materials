<?php
namespace Data_analysis\Controller;

require('/data/www/googlemanager/Apps/Home/Common/function.php');

use Home\Controller\RoleController;

class AppfiguresController extends RoleController{

    public function index(){
		
		echo getAdminName();
		echo getAdminId();
		
	}	
}