<?php
namespace Admin\Controller;
use Common\Controller\BaseController;

class AdminController extends BaseController {

	//初始化函数
	public function _initialize(){
		parent::_initialize();

		//检查是否存在登录后的cookie
		$theUser = my_cookie('login_man');
		if(!$theUser){
			//回调管理端登录页面
			$this->error('请你先登录',U('Home/Index/login').'?back='.U(__INFO__,null,''));
		}

//		dump($theUser);
		$User = M('User');
		$user = $User->field('role_id')->find($theUser['id']);

		//检查角色权限
		$model = new \Think\Model();
		$is_node_allow = $model->table('jw_php_role_node rn,jw_php_node n')
			->where(" n.id=rn.node_id and rn.role_id = {$user['role_id']} and n.module='"
				.MODULE_NAME."' and controller='".CONTROLLER_NAME."' and action='".ACTION_NAME."'")
			->select();
		if(!$is_node_allow){
			$this->error('你没有权限访问该页面或者操作');
		}

		//处理角色菜单
		$menus = $model
			->field('m.id,type,name,icon,url,parent_id')
			->table('jw_php_role_menu rm,jw_php_menu m')
			->where('m.id=rm.menu_id and rm.role_id='.$user['role_id'])
			->select();
//		dump($menus);
		$arr = array();
		$sub = array();
		$ca = CONTROLLER_NAME.'/'.ACTION_NAME;
		foreach ($menus as $item) {
			if($item['type']==1){
				$arr[$item['id']]=$item;
				if($item['url']==$ca)
					$arr[$item['id']]['active'] = 1;
			}else{
				$sub[$item['id']]=$item;
				if($item['url']==$ca)
					$sub[$item['id']]['active'] = 1;
			}
		}
//		dump($arr);
//		dump($sub);exit;
		foreach ($sub as $theSub){
			$index = $theSub['parent_id'];
			if($theSub['active']==1){
				$arr[$index]['active'] = 2;
				$active = 'class="active"';
			}else{
				$active = '';
			}
			$arr[$index]['subs'] .='<li '.$active.'><a href="'.U($theSub['url'])
				.'"><span class="submenu-label"><i class="fa fa-'
				.$theSub['icon'].'"></i> '.$theSub['name'].'</span></a></li>';
		}
//		dump($arr);
		$menu_html = '';
		$k=1;
		foreach ($arr as $value){
			if($value['active']==1){
				$active = 'active';
			}elseif($value['active']==2){
				$active = 'open';
			}else{
				$active = '';
			}
			if($value['subs']){
				$menu_html .= '<li class="openable bg-palette'
					.$k.' '.$active.'"><a ><span class="menu-content block"><span class="menu-icon"><i class="block fa fa-'
					.$value['icon'].' fa-lg"></i></span><span class="text m-left-sm">'
					.$value['name'].'</span></span><span class="submenu-icon"></span></a><ul class="submenu">'
					.$value['subs'].'</ul></li>';
			}else{
				$menu_html .= '<li class="bg-palette'
					.$k.' '.$active.'"><a href="'
					.U($value['url']).'"><span class="menu-content block"><span class="menu-icon"><i class="block fa fa-'
					.$value['icon'].' fa-lg"></i></span><span class="text m-left-sm">'
					.$value['name'].'</span></span></a></li>';
			}

			$k+=1;
			if($k>4)
				$k=1;
		}
		$this->assign('menu_html',$menu_html);
//		exit;
	}

	//通用删除
	public function del_adapt($ModelName,$id,$is_true_delete=true){
		$Model = M($ModelName);
		if($id==1){
			$this->error('该用户不允许删除');
		}
		if($is_true_delete){
			$res = $Model->where(array('id'=>$id))->delete();
		}else{
			$res = $Model->where(array('id'=>$id))->save(array('status'=>0));
		}
		if($res){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}
}