<?php
namespace Admin\Controller;

class LogController extends AdminController {


	public function index(){
		if($_GET['id']){
			$where['id'] = array('like',"{$_GET['id']}%");
		}
		if($_GET['uid']){
			$where['user_id'] = array('like',"{$_GET['uid']}%");
		}
		if($_GET['ip']){
			$where['ip'] = array('like',"%{$_GET['ip']}%");
		}
		if($_GET['key']){
			$where['other'] = array('like',"%{$_GET['key']}%");
		}
		$role = $this->page('Log',30,null,$where,null,'id desc');
		$this->assign('log',$role);
		$this->display();
	}

}