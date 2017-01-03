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

	public function add(){
		if(!IS_POST){
			$this->error('请求方式错误');
		}
		$Model = D('Node');
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
		$Model = D('Node');
		$data = $Model->create();
		$data['create_time'] = date('Y-m-d H:i:s');
		if($Model->save($data)){
			$this->success('成功修改');
		}else{
			$this->error('失败修改');
		}
	}

}