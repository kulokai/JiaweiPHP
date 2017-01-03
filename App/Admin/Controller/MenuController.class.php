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

	public function add(){
		if(!IS_POST){
			$this->error('请求方式错误');
		}
		$Menu = D('Menu');
		$data = $Menu->create();
		if($data['type']==1){
			unset($data['parent_id']);
		}
		$data['create_time'] = date('Y-m-d H:i:s');
		if($Menu->add($data)){
			$this->success('成功添加');
		}else{
			$this->error('失败添加');
		}
	}

	public function upd(){
		if(!IS_POST){
			$this->error('请求方式错误');
		}
		$Menu = D('Menu');
		$data = $Menu->create();
		dump($data);
	}

}