<?php
/**
 * 后台用户uid转uname
 * @param $uid uid
 * @return uname
 */
function uid2uname($uid){
    if(!$uid){
        return "";
    }
    $model = model("user");
    $data = $model->where(['u_id'=>$uid])->find();
    return $data?$data['user_id']:"用户已删除";
}
/**
 * 前台用户uid转uname
 * @param $uid uid
 * @return uname
 */
function indexuid2uname($uid){
    if(!$uid){
        return "";
    }
    $model = model("vip_user");
    $data = $model->where(['v_id'=>$uid])->find();
    return $data?$data['v_vip_id']:"用户已删除";
}

function recomm2uname($recomm){
    if(!$recomm){
        return "";
    }
    if($recomm == "#"){
        return "#";
    }
    $model = model("vip_user");
    $data = $model->where(['v_recomm_code'=>$recomm])->find();
    return $data?$data['v_vip_id']:"用户已删除";
}

/**
 * 格式化钱数，将分格式成两位浮点值
 * @param int $fen
 */

function encodemoney(int $fen=0){
    if(!is_int($fen)){
        $fen = floor($fen);
    }
    return sprintf("%.2f", $fen);

}

/**
 * 返回经addslashes处理过的字符串或数组
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_addslashes($string){
    if(!is_array($string)) return addslashes($string);
    foreach($string as $key => $val) $string[$key] = new_addslashes($val);
    return $string;
}

/**
 * 返回经stripslashes处理过的字符串或数组
 *
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_stripslashes($string) {
    if(!is_array($string)) return stripslashes($string);
    foreach($string as $key => $val) $string[$key] = new_stripslashes($val);
    return $string;
}

/**
 * 将字符串转换为数组
 *
 * @param   string  $data   字符串
 * @return  array   返回数组格式，如果，data为空，则返回空数组
 */
function string2array($data) {
    if($data == '') return array();
    eval("\$array = $data;");
    return $array;
}
/**
 * 将数组转换为字符串
 *
 * @param   array   $data       数组
 * @param   bool    $isformdata 如果为0，则不使用new_stripslashes处理，可选参数，默认为1
 * @return  string  返回字符串，如果，data为空，则返回空
 */
function array2string($data, $isformdata = 1) {
    if($data == '') return '';
    if($isformdata) $data = new_stripslashes($data);
    return var_export($data, TRUE);
}