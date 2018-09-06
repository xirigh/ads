<?php

namespace app\common\validate;

use think\Validate;

class UserRole extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		"role_code"=>["require"],
		"role_name"=>["require","max:20"],
		"ur_remark"=>["max:500"],
	];
    
	
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
	protected $message = [
		"role_code.require"=>"系统忙碌",
		"role_name.require"=>"角色名字必须存在",
		"role_name.max"=>"角色名字超过最长20字",
		"ur_remark.max"=>"角色备注超过最长500字",
    ];
	
	protected $scene = [
        'add'  =>  ['um_code','um_title','um_content','um_type','um_uid','um_desc'],//留言
        're' => ['um_re_uid','um_re_content'],//回复
    ];
	
}
