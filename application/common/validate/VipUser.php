<?php

namespace app\common\validate;

use think\Validate;

class VipUser extends Validate
{
	protected $rule = [
		"v_vip_id"=>["require","max:50","unique:vip_user"],
		"v_pwd1"=>["require","length:6,12"],
		"v_pwd2"=>["require","length:6,12"],
		"v_name"=>["require","max:10"],
        "v_tel"=>["require","number","mobile","unique:vip_user"],
        "v_email"=> ["require","email","unique:vip_user"],
        "v_type"=>["number","max:2"],
        "v_recomm_code"=>["alphaNum","max:10"],
        "v_re_recomm_code"=>["require","max:10"],
        "v_sex"=>["number","max:2"],
        "v_card_id"=>["idCard"],
        "v_qq"=>["number","max:10"],
        "v_wechat"=>["max:50"],
        "v_alipay"=>["max:100"],
        "v_bank"=>["max:20"],
        "v_bank_name"=>["max:20"],
        "v_card_num"=>["number","max:30"],
        "v_bank_address"=>["max:100"],
        "v_address"=>["max:100"],
        "v_remark"=>["max:500"],
        "v_money1"=>["number"],
        "v_money2"=>["number"],
        "v_que1"=>["max:50"],
        "v_que2"=>["max:500"],
        "v_an1"=>["max:500"],
        "v_an2"=>["max:500"],
	];

	protected $message = [
        "v_vip_id.require"=>"注册邮箱必须存在",
        "v_vip_id.max"=>"注册邮箱超过最长30字",
        "v_vip_id.unique"=>"注册邮箱已经存在",
        "v_pwd1.require"=>"登录密码必须存在",
        "v_pwd1.length"=>"登录密码必须在6-12位之间",
        "v_pwd2.require"=>"支付密码必须存在",
        "v_pwd2.length"=>"支付密码必须在6-12位之间",
        "v_name.require"=>"真实姓名必须存在",
        "v_name.max"=>"真实姓名过长",
        "v_tel.mobile"=>"手机号格式不正确",
        "v_tel.number"=>"手机号格式不正确",
        "v_tel.require"=>"手机号格式不正确",
        "v_tel.unique"=>"该手机号已经注册，请勿重复注册",
        "v_email.email"=>"邮箱格式不正确",
        "v_email.unique"=>"该邮箱已经注册，请勿重复注册",
        "v_type.number"=>"用户类型不正确",
        "v_type.max"=>"用户类型不正确",
        "v_recomm_code.alphaNum"=>"邀请码不正确",
        "v_recomm_code.max"=>"邀请码不正确",
        "v_re_recomm_code.require"=>"邀请码必须存在",
//        "v_re_recomm_code.alphaNum"=>"邀请码不正确",
        "v_re_recomm_code.max"=>"邀请码不正确",
        "v_sex.max"=>"性别格式不正确",
        "v_sex.number"=>"性别格式不正确",
        "v_card_id.idCard"=>"身份证号格式不正确",
        "v_qq.number"=>"QQ号格式不正确",
        "v_qq.max"=>"QQ号格式不正确",
        "v_wechat.max"=>"微信号格式不正确",
        "v_alipay.max"=>"ETH地址不正确",
        "v_bank.max"=>"开户行不正确",
        "v_bank_name.max"=>"开户名不正确",
        "v_card_num.number"=>"银行卡号不正确",
        "v_card_num.max"=>"银行卡号不正确",
        "v_bank_address.max"=>"开户行地址不正确",
        "v_address.max"=>"收货地址超出最大长度100字",
        "v_remark.max"=>"备注超出最大长度100字",
        "v_money1.number"=>"静态钱包错误",
        "v_money2.number"=>"动态钱包错误",
        "v_que1.max"=>"问题最长为50字",
        "v_que2.max"=>"问题最长为50字",
        "v_an1.max"=>"答案最长为100字",
        "v_an2.max"=>"答案最长为100字",
    ];
	
	protected $scene = [
        "edit"=>["v_name","v_type","v_sex","v_card_id","v_qq","v_wechat","v_alipay","v_bank","v_bank_name","v_card_num","v_bank_address","v_address","v_remark"],
        "wanshan"=>["v_name","v_sex","v_bank","v_bank_name","v_card_num","v_bank_address","v_alipay","v_card_num"],
    ];
	
}
