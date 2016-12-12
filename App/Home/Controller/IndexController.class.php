<?php
namespace Home\Controller;
use Common\Controller\BaseController;

class IndexController extends BaseController {

    public function index(){
    	$this->login();
    }

    //管理端登录页面
    public function login(){
    	$this->display('login');
    }

    public function logout(){
	    cookie('login_man',null);
    	$this->success('退出成功',U('Home/Index/login'));
    }

    public function check(){
    	$username = $_POST['username'];
    	$password = $_POST['password'];
    	$backUrl = $_GET['back'];

    	$User = M('User');
	    $user = $User->field('id,username,name,password')->where(array('username'=>$username,'status'=>1))->find();
	    if(!$user){
	    	$this->error('不存在的用户账户');
	    }

	    //验证密码
	    if($user['password']!=md5($password)){
		    $this->error('密码错误，请联系管理员修改');
	    }

	    //记录登记cookie
	    my_cookie('login_man',array(
	    	'id'=>$user['id'],
	    	'username'=>$user['username'],
	    	'name'=>$user['name'],
	    ));

	    //需要处理回调url
	    if($backUrl){
	    	header('Location:'.$backUrl);
	    }

	    $this->redirect('Admin/Index/index');
    }

}