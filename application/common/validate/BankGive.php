<?php

namespace app\common\validate;

use think\Validate;

class BankGive extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		"bg_out_uid"=>["require","number"],
		"bg_in_uid"=>["require","number"],
		"bg_money"=>["require","max:20"],
	];
    
	
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
	protected $message = [
		"bg_out_uid.require"=>"转出用户错误",
		"bg_out_uid.number"=>"转出用户错误",
		"bg_in_uid.require"=>"转入用户错误",
		"bg_in_uid.number"=>"转入用户错误",
		"bg_money.require"=>"转出金额错误",
		"bg_money.max"=>"转出金额错误",
    ];
	
	protected $scene = [
    ];
	
}
