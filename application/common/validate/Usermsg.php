<?php

namespace app\common\validate;

use think\Validate;

class Usermsg extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
//		"um_code"=>["require"],
		"um_title"=>["require","max:100"],
		"um_content"=>["require","max:500"],
		"um_type"=>["require","number"],
		"um_state"=>["require","number"],
		"um_uid"=>["require","number"],
		"um_desc"=>["max:200"],
		"um_re_uid"=>["require","number"],
		"um_re_content"=>["require","max:500"],
	];
    
	
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
	protected $message = [
//		"um_code.require"=>"系统忙碌",
		"um_title.require"=>"留言标题必须存在",
		"um_title.max"=>"留言标题超过最长100字",
		"um_content.require"=>"留言内容必须存在",
		"um_content.max"=>"留言内容超过最长500字",
		"um_type.require"=>"留言类型必须存在",
		"um_type.number"=>"留言类型错误",
		"um_uid.require"=>"留言用户错误",
		"um_uid.number"=>"留言用户错误",
		"um_desc.max"=>"留言描述超过最长200字",
		"um_re_uid.require"=>"回复用户错误",
		"um_re_uid.number"=>"回复用户错误",
		"um_re_content.require"=>"回复内容错误",
		"um_re_content.max"=>"回复内容超过最长500字",
    ];
	
	protected $scene = [
        'add'  =>  ['um_code','um_title','um_content','um_type','um_uid','um_desc'],//留言
        're' => ['um_re_uid','um_re_content'],//回复
    ];
	
}
