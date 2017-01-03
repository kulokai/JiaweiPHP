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

	public function del($id){
		$this->del_adapt('Role',$id);
	}

	public function add(){
		if(!IS_POST){
			$this->error('请求方式错误');
		}
		$Model = D('Role');
		$data = $Model->create();
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
		$Model = D('Role');
		$data = $Model->create();
		$data['create_time'] = date('Y-m-d H:i:s');
		if($Model->save($data)){
			$this->success('成功修改');
		}else{
			$this->error('失败修改');
		}
	}

}