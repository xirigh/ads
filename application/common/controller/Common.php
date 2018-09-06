<?php
namespace app\common\controller;

use think\Controller;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;
use Ender\YunPianSms\SMS\YunPianSms;
use Ender\YunPianSms\SMS\YunPianUser;
class Common extends Controller
{
	public function _empty($name)
    {
        $this->nopage();
    }

	//获取数据字典的一些数据
	protected function getDbCommonData($key){
		$model = model('db_common_data');
		$list = $model->where(array('c_key'=>$key))->order(array('c_sort'=>"asc"))->field('c_title,c_key,c_value,c_value_name,c_sort')->select();
		return $list;
	}

	//格式化字典数据
	protected function encodeCommonData($data){
		$newdata = array();
		foreach($data as $v){
			$newdata[$v['c_value']] = $v['c_value_name'];
		}
		return $newdata;
	}

	//检查参数正确
	protected function checkId($id){
		if($id < 1){
			//获取当前页面url
			$url= $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
			$this->nopage($url);
		}
	}

	//404页面跳转
	protected function nopage($url = ""){
		$this->error("404 not found");
	}

	//生成二维码页面
    protected function qrcode($str)
    {
        $qrcode = new BaconQrCodeGenerator;
        $img = $qrcode->errorCorrection("L")->encoding("utf-8")->format("png")->size(500)->generate($str);
        return $img;
    }

    //云片网发送短信
    protected function yunpian_send($phone,$msg){
        $yunpianSms=new YunPianSms(config("mydefind.yunpian_api"));
        $response=$yunpianSms->sendMsg($phone,"【".config('mydefind.yunpian_str')."】".$msg);
    }

    public function yunpianyue(){
        $yunpianSms=new YunPianUser(config("mydefind.yunpian_api"));
        $response=$yunpianSms->getAccountInfo();
        //dump($response);
    }

    //生成随机验证码
    protected function createPhoneCode(){
	    $str = rand(100000,999999);
	    return $str;
    }

    //创建邀请码
    protected function createRecommCode()
    {
        $str = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789ABCDEFGHJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789";
        $str = substr(str_shuffle($str),0,6);
        $model = model("vip_user");
        if($model->where(['v_recomm_code'=>$str])->find()) {
            $this->createRecommCode();
        }else{
            return $str;
        }
    }

    //获取用户树状图
    protected function getUserTree($list,$recomm,$id,$lev)
    {
        $tree = [];
        foreach ($list as $v) {
            if($v['v_re_recomm_code'] == $recomm){
                $v['lev'] = $lev;
                $v['parent'] = $id;
                $tree[] = $v;
                $tree = array_merge($tree,$this->getUserTree($list,$v['v_recomm_code'],$v['v_id'],$lev+1));
            }
        }
        return $tree;
    }

    protected function getUserZongzichan($uid){
	    $usd = model("vip_user")->find($uid)['v_money2'];
	    $zichanlist = model("core_zichan")->where(['cz_uid'=>$uid,'cz_state'=>0])->alias("z")->join("core_goods g","z.cz_cg_id = g.cg_id")->select();
	    $zichan = 0;
	    foreach($zichanlist as $v){
	        $zichan += $v['cg_money'] * $v['cz_num']/100;
	        $zichan += $v['cz_count_money'];
        }
	    return $usd+$zichan;
    }
}