<?php

namespace app\common\validate;

use think\Validate;

class CoreGoods extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		"cg_title"=>["require","max:20"],
		"cg_money"=>["require","number"],
		"cg_day"=>["require","number"],
		"cg_beishu"=>["require","number"],
		"cg_img"=>["max:100"],
	];
    
	
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
	protected $message = [
		"cg_title.require"=>"基金名称错误",
		"cg_title.max"=>"基金名称最长为20字",
		"cg_money.require"=>"单价错误",
		"cg_money.number"=>"单价只能保留两位小数",
		"cg_day.require"=>"日利率错误",
		"cg_day.number"=>"日利率为0.01%，且只能保留两位小数",
		"cg_beishu.require"=>"复利倍数错误",
		"cg_beishu.number"=>"复利倍数最小为1，且只能保留两位小数",
//		"cg_img.require"=>"图片错误",
		"cg_img.max"=>"图片错误",
    ];
	
	protected $scene = [
    ];
	
}
