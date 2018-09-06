<?php

namespace app\common\validate;

use think\Validate;

class BankAdd extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		"ba_address"=>["require","max:100"],
		"ba_money"=>["require","max:20"],
		"ba_num"=>["require","max:20"],
		"ba_huilv"=>["require"],
		"ba_type"=>["number","require"],
//        "ba_img_path"=>["require"],
        "ba_code"=>["require","number"],
	];
    
	
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
	protected $message = [
		"ba_address.require"=>"充值地址必须存在",
		"ba_address.max"=>"充值地址格式错误",
		"ba_money.require"=>"充值金额错误",
		"ba_money.max"=>"充值金额错误",
		"ba_num.require"=>"充值数量错误",
		"ba_num.max"=>"充值数量错误",
		"ba_huilv.require"=>"汇率错误",
		"ba_type.require"=>"钱包类型错误",
		"ba_type.number"=>"钱包类型错误",
//		"ba_img_path.require"=>"图片凭证错误",
		"ba_code.require"=>"备注码错误",
		"ba_code.number"=>"备注码错误",
    ];
	
	protected $scene = [
    ];
	
}
