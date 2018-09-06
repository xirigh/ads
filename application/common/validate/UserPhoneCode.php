<?php

namespace app\common\validate;

use think\Validate;

class UserPhoneCode extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [

	];
    
	
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
	protected $message = [

    ];

    /**
     * 定义错误信息
     * 格式：'edit'  =>  ['user_name','user_tel','user_email','role_code','u_remark'],
     *
     * @var array
     */
    protected $scene = [

    ];
	
}
