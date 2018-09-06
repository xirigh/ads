<?php

namespace app\common\validate;

use think\Validate;

class User extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		"user_id"=>["require","max:30","unique:user"],
		"Password"=>["require","length:6,12"],
		"Password2"=>["require","length:6,12"],
		"user_name"=>["require","max:10"],
		"user_tel"=>["number"],
		"user_email"=>["email"],
		"role_code"=>["require","number"],
		"u_remark"=>["max:200"],
	];
    
	
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
	protected $message = [
		"user_id.require"=>"用户ID必须存在",
		"user_id.max"=>"用户ID超过最长30个字符",
		"user_id.unique"=>"用户ID已经存在",
		"Password.require"=>"密码1必须存在",
		"Password.length"=>"密码1必须在6-12个字符之间",
		"Password2.require"=>"密码2必须存在",
		"Password2.length"=>"密码2必须在6-12个字符之间",
		"user_name.require"=>"用户姓名必须存在",
		"user_name.max"=>"用户姓名格式不符合",
		"user_tel.number"=>"联系方式格式不符合",
		"user_email.email"=>"Email格式不正确",
		"role_code.require"=>"角色必须存在",
		"role_code.number"=>"角色错误",
		"u_remark.max"=>"备注超过最大值200字",
    ];
	
	protected $scene = [
        'edit'  =>  ['user_name','user_tel','user_email','role_code','u_remark'],
    ];
	
}
