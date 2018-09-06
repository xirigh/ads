<?php
/**
 * 格式化钱数，将分格式成两位浮点值
 * @param int $fen
 */

function encodemoney(int $fen){
    if(!is_int($fen)){
        $fen = floor($fen);
    }
    return sprintf("%.2f", $fen);

}

function uid2uname($uid){
    if(!$uid){
        return "";
    }
    $model = model("vip_user");
    $data = $model->where(['v_id'=>$uid])->find();
    return $data?$data['v_vip_id']:"用户已删除";
}

//===================================发送短信=========================================
function SendSMSToMsg($Msg, $mobile) {
    header ( "Content-Type:text/html;charset=utf-8" );
    $apikey = "8b39d3bf5361a626512891c37dec6fba";
    $text = $Msg;
    $ch = curl_init ();
    /* 设置验证方式 */
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
    'Accept:text/plain;charset=utf-8',
    'Content-Type:application/x-www-form-urlencoded',
    'charset=utf-8'
    ) );
    /* 设置返回结果为流 */
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    /* 设置超时时间 */
    curl_setopt ( $ch, CURLOPT_TIMEOUT, 10 );
    /* 设置通信方式 */
    curl_setopt ( $ch, CURLOPT_POST, 1 );
    curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
    // 取得用户信息
    $json_data = get_user ( $ch, $apikey );
    $array = json_decode ( $json_data, true );
	// 发送短信
	$data = array (
			'text' => $text,
			'apikey' => $apikey,
			'mobile' => $mobile
	);
	$json_data = send ( $ch, $data );
	$array = json_decode ( $json_data, true );
	curl_close ( $ch );
}

function SendSMS($code, $mobile) {
	header ( "Content-Type:text/html;charset=utf-8" );
	$apikey = "8b39d3bf5361a626512891c37dec6fba";
	$text = "【BFC网】您的验证码是" . $code . "。如非本人操作，请忽略本短信。此短信有效期3分钟";
	$ch = curl_init ();

	/* 设置验证方式 */

	curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
			'Accept:text/plain;charset=utf-8',
			'Content-Type:application/x-www-form-urlencoded',
			'charset=utf-8'
	) );

	/* 设置返回结果为流 */
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

	/* 设置超时时间 */
	curl_setopt ( $ch, CURLOPT_TIMEOUT, 10 );

	/* 设置通信方式 */
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
	// 取得用户信息
	$json_data = get_user ( $ch, $apikey );
	$array = json_decode ( $json_data, true );
	// 发送短信
	$data = array (
			'text' => $text,
			'apikey' => $apikey,
			'mobile' => $mobile
	);
	$json_data = send ( $ch, $data );
	$array = json_decode ( $json_data, true );
	curl_close ( $ch );
}
// 获得账户
function get_user($ch, $apikey) {
	curl_setopt ( $ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/user/get.json' );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( array (
			'apikey' => $apikey
	) ) );
	return curl_exec ( $ch );
}
function send($ch, $data) {
	curl_setopt ( $ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json' );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( $data ) );
	return curl_exec ( $ch );
}
function tpl_send($ch, $data) {
	curl_setopt ( $ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/tpl_single_send.json' );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( $data ) );
	return curl_exec ( $ch );
}
function voice_send($ch, $data) {
	curl_setopt ( $ch, CURLOPT_URL, 'http://voice.yunpian.com/v2/voice/send.json' );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( $data ) );
	return curl_exec ( $ch );
}