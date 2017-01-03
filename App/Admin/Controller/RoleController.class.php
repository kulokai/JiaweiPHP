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
//		dump($nodes);exit;
		$this->assign('node',$nodes);
		$this->display();exit;

		$RoleFunc = M('RoleFunc');
		$rf = $RoleFunc->where(array('role_id'=>$id))->select();
		$isFunc = array();
		$isArea1 = array();
		$isArea2 = array();
		foreach($rf as $vo){
			$isFunc[] = $vo['func_id'];
		}
		for($i=0;$i<sizeof($funcs);$i++){
			if(in_array($funcs[$i]['id'],$isFunc)){
				$funcs[$i]['checked'] = 1;
			}else{
				$funcs[$i]['checked'] = 0;
			}
		}
		$this->assign('func',$funcs);

		$Area = M('Area');
		$areas = $Area->where(array('status'=>1))->select();
		$Role1 = M('RoleArea');
		$ra1 = $Role1->where(array('role_id'=>$id))->select();
		$Role2 = M('RoleAreaAdd');
		$ra2 = $Role2->where(array('role_id'=>$id))->select();
		foreach($ra1 as $vo){
			$isArea1[] = $vo['area_id'];
		}
		foreach($ra2 as $vo){
			$isArea2[] = $vo['area_id'];
		}
		for($i=0;$i<sizeof($areas);$i++){
			if(in_array($areas[$i]['id'],$isArea1)){
				$areas[$i]['checked1'] = 1;
			}else{
				$areas[$i]['checked1'] = 0;
			}
			if(in_array($areas[$i]['id'],$isArea2)){
				$areas[$i]['checked2'] = 1;
			}else{
				$areas[$i]['checked2'] = 0;
			}
		}
		$this->assign('area',$areas);

		$this->display();
	}

}