<?php
namespace Admin\Controller;

class NodeController extends AdminController {

	public function index(){
		if($_GET['id']){
			$where['id'] = array('like',"%{$_GET['id']}%");
		}
		if($_GET['mod']){
			$where['module'] = $_GET['mod'];
		}
		if($_GET['con']){
			$where['controller'] = $_GET['con'];
		}
		if($_GET['act']){
			$where['action'] = $_GET['act'];
		}
		$role = $this->page('Node',30,'id,name,module,controller,action',$where);
		$this->assign('node',$role);
		$this->display();
	}

	public function del($id){
		$this->del_adapt('Node',$id);
	}

}