<?php

namespace app\common\validate;

use think\Validate;

class UserBank extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        "ub_uid"=>["require","number"],
        "ub_money"=>["require","max:30"],
        "ub_msg"=>["max:100"],
        "ub_type"=>["require","number"],
        "ub_state"=>["require","number"],
    ];


    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        "ub_uid.require"=>"用户ID必须存在",
        "ub_uid.number"=>"用户ID格式错误",
        "ub_money.require"=>"交易金额必须存在",
        "ub_money.max"=>"交易金额过大",
        "ub_msg.max"=>"交易留言过长",
        "ub_type.require"=>"交易类型错误",
        "ub_type.number"=>"交易类型错误",
        "ub_state.require"=>"交易状态错误",
        "ub_state.number"=>"交易状态错误",
    ];

    protected $scene = [
    ];

}
