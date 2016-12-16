<?php
namespace Admin\Controller;

class MenuController extends AdminController {

	public function index(){
		if($_GET['name']){
			$where['name'] = array('like',"%{$_GET['name']}%");
		}
		if($_GET['url']){
			$where['url'] = array('like',"%{$_GET['url']}%");
		}

		$Menu = M('Menu');
		$menu = $Menu->where(array('type'=>1))->select();
		$this->assign('menux',$menu);

		$role = $this->page('Menu',30,null,$where);

		$this->assign('menu',$role);
		$this->display();
	}

	public function del($id){
		$this->del_adapt('Menu',$id);
	}

}