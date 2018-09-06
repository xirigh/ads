<?php

namespace app\common\validate;

use think\Validate;

class BankCard extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		"bc_kaihuhang"=>["require","max:100"],
		"bc_kaihuming"=>["require","max:100"],
		"bc_kahao"=>["require","max:100"],
		"bc_address"=>["require","max:100"],
	];
    
	
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
	protected $message = [
        "bc_kaihuhang.require"=>"开户行错误",
        "bc_kaihuhang.max"=>"开户行错误",
        "bc_kaihuming.require"=>"开户名错误",
        "bc_kaihuming.max"=>"开户名错误",
        "bc_kahao.require"=>"卡号错误",
        "bc_kahao.max"=>"卡号错误",
        "bc_address.require"=>"开户行地址错误",
        "bc_address.max"=>"开户行地址错误",
    ];
	
	protected $scene = [
    ];
	
}
