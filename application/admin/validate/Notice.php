<?php

namespace app\admin\validate;

use think\Validate;



/*
 * $data = [
			"n_code" => session("noticecode"),
			"n_lev" => input("NewsIco"),
			"n_title" => input("Title"),
			"n_desc" => input("Description"),
			"n_content" => input("Content"),
		];
 */

class Notice extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
		"n_code"=>['require','alphaNum'],
		"n_lev"=>['require','number'],
		"n_title"=>['require','max:100'],
		"n_desc"=>['max:200'],
		"n_content"=>['require'],
	];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
    	"n_code.require"=>"E系统忙碌",
    	"n_code.alphaNum"=>"E系统忙碌",
    	"n_lev.require"=>"E公告级别错误",
    	"n_lev.number"=>"E公告级别错误",
    	"n_title.require"=>"E公告标题必须存在",
    	"n_title.max"=>"E公告标题超出最大长度100字",
    	"n_desc.max"=>"E公告描述超出最大长度200字",
    	"n_content.require"=>"E公告内容不能为空",
    ];
	
	protected $scene = [
        'edit'  =>  ['n_lev','n_title','n_desc','n_content'],
    ];
}
