<?php
namespace Admin\Controller;

class UserController extends AdminController {

	public function index(){
		//差 用户表与角色表交叉
		if($_GET['name']){
			$where['name'] = array('like',"%{$_GET['name']}%");
		}
		if($_GET['uname']){
			$where['username'] = array('like',"%{$_GET['uname']}%");
		}
		$role = $this->page('User',30,null,$where);
		$this->assign('user',$role);
		$this->display();
	}

}