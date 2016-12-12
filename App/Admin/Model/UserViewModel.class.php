<?php
namespace Admin\Model;
use Think\Model\ViewModel;


class UserViewModel extends ViewModel {

	public $viewFields = array(
		'User'=>array(
			'*',
		),
		'Role'=>array(
			'name'=>'role_name',
			'_on'=>'User.role_id=Role.id'
		)
	);
}