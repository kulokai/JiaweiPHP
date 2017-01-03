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

	public function node($id){
		$Role = M('Role');
		$the_role = $Role->find($id);
		$this->assign('role',$the_role);

		$Node = M('Node');
		$nodes = $Node->select();
		$RoleNode = M('RoleNode');
		$isNode = array();
		$rn = $RoleNode->where(array('role_id'=>$id))->select();
		foreach($rn as $vo){
			$isNode[] = $vo['node_id'];
		}
		for($i=0;$i<sizeof($nodes);$i++){
			if(in_array($nodes[$i]['id'],$isNode)){
				$nodes[$i]['checked'] = 1;
			}else{
				$nodes[$i]['checked'] = 2;
			}
		}
		$this->assign('node',$nodes);

		$Menu = M('Menu');
		$menus = $Menu->select();
		$RoleMenu = M('RoleMenu');
		$isMenu = array();
		$rm = $RoleMenu->where(array('role_id'=>$id))->select();
		foreach($rm as $vo){
			$isMenu[] = $vo['menu_id'];
		}
		for($i=0;$i<sizeof($menus);$i++){
			if(in_array($menus[$i]['id'],$isMenu)){
				$menus[$i]['checked'] = 1;
			}else{
				$menus[$i]['checked'] = 2;
			}
		}
		$this->assign('menu',$menus);
		$this->display();
	}

	public function save($id){
		dump($_POST);
	}

}