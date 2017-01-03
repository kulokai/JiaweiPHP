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

		$Role = M('Role');
		$roles = $Role->select();
		$this->assign('role',$roles);

		$this->display();
	}

	public function del($id){
		$this->del_adapt('User',$id,false);
	}

	public function add(){
		if(!IS_POST){
			$this->error('请求方式错误');
		}
		$Model = D('User');
		$data = $Model->create();
		$data['password'] = md5($data['password']);
		$data['create_time'] = date('Y-m-d H:i:s');
		if($Model->add($data)){
			$this->success('成功添加');
		}else{
			$this->error('失败添加');
		}
	}

	public function upd(){
		if(!IS_POST){
			$this->error('请求方式错误');
		}
		$Model = D('User');
		$data = $Model->create();
		if($data['password']){
			$data['password'] = md5($data['password']);
		}
		$data['update_time'] = date('Y-m-d H:i:s');
		if($Model->save($data)){
			$this->success('成功修改');
		}else{
			$this->error('失败修改');
		}
	}

}