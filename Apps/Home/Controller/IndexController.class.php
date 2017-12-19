<?php
namespace Home\Controller;
class IndexController extends RoleController{
    public function index(){
       redirect($this->getFristNavigation());
    }
}
?>