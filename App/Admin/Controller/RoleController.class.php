<?php
namespace Admin\Controller;

class RoleController extends AdminController {

    public function index(){
    	if($_GET['name']){
    		$where['name'] = array('like',"%{$_GET['name']}%");
	    }
    	if($_GET['short']){
    		$where['short'] = array('like',"%{$_GET['short']}%");
	    }
    	$role = $this->page('Role',30,'id,name,short',$where);
    	$this->assign('role',$role);
    	$this->display();
    }

}