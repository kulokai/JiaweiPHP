<?php
namespace Common\Controller;
use Think\Controller;

class BaseController extends Controller {
	public function _initialize(){

	}

	//日志功能操作
	private function logSave($type,$content){
		$data['type'] = $type;
		$data['user_id'] = $this->getUserId();
		$data['action'] = __INFO__;
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		$data['other'] = $content;
		$data['createtime'] = date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']);
		$Model = M('Log');
		$Model->add($data);
	}

	private function getUserId(){
		$man = my_cookie('login_man');
		return $man['id'];
	}

	//行为
	public function log_action($content){
		$this->logSave('action',$content);
	}

	//调试记录
	public function log_debug($content){
		if(!APP_DEBUG){
			return;
		}
		$this->logSave('debug',$content);
	}

	//警告记录
	public function log_warn($content){
		$this->logSave('warn',$content);
	}

	//危险记录
	public function log_danger($content){
		$this->logSave('danger',$content);
	}

	/**
	 * 分页操作
	 * @param String $ModelName 模型名称
	 * @param int $size 分页大小
	 * @param null $field 字段域
	 * @param null $where 查询条件
	 * @param null $group 分组条件
	 * @param null $order 排序
	 * @return mixed 返回结果
	 */
	public function page($ModelName,$size=10,$field=null,$where=null,$group=null,$order=null){
		$Model = D($ModelName);
		if(!$_GET['p']){
			$thePage = 1;
		}else{
			$thePage = $_GET['p'];
		}
		if($group){
			$count = $Model->field($field)->where($where)->count('distinct '.$group);
		}else{
			$count = $Model->field($field)->where($where)->count();
		}

		if(!$count){
			return null;
		}
		$p_count  = ceil($count/$size);
		if($thePage<1||$thePage>$p_count){
			$this->error('不存在该页面哦哦！',U(__INFO__));
		}
		$res = $Model->field($field)->where($where)->group($group)->order($order)->page($thePage,$size)->select();

		$get = $_GET;
		unset($get['p']);
		$get = http_build_query($get);

		$url = U(__INFO__,null,'').'?'.$get.'&p=';
		$pages = array();
		if($thePage-1>0){
			$pages[] = array('page'=>-1,'link'=>$url.($thePage-1));
		}
		for($i=$thePage-3;$i<=$thePage+3;$i++){
			if($i>0&&$i<=$p_count){
				if($i==$thePage){
					$pages[] = array('page'=>$i,'link'=>$url.$i,'active'=>1);
				}else{
					$pages[] = array('page'=>$i,'link'=>$url.$i);
				}
			}
		}
		if($thePage+1<=$p_count){
			$pages[] = array('page'=>-2,'link'=>$url.($thePage+1));
		}
		$this->assign('current_page',$thePage);
		$this->assign('page_count',$p_count);
		$this->assign('pages',$pages);
		return $res;
	}

	//生成验证码
	public function makeVerify(){
		$config = array(
			'fontSize'    =>    18,    // 验证码字体大小
			'length'      =>    4,     // 验证码位数
			'useNoise'    =>    false, // 关闭验证码杂点
		);
		$Verify = new \Think\Verify($config);
		$Verify->entry();
	}

}