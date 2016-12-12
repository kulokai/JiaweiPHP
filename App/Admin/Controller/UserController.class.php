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
		$role = $this->page('UserView',30,null,$where);
		$this->assign('user',$role);
		$this->display();
	}

	public function del($id){
		$User = M('User');
		if($id==1){
			$this->error('该用户不允许删除');
		}
		if($User->where(array('id'=>$id))->save(array('status'=>0))){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}

}