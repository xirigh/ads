<?php
namespace app\admin\controller;

use app\admin\controller;
use app\admin\model;
use think\Db;

/*
 * 系统管理
 */

class System extends Base
{
	//系统参数配置
	public function sys()
    {
        $config = config("mydefind.");
        $this->assign("config",$config);
        return view();
	}

    public function setconfig()
    {
        $data = input();
        if(!@$data['xhyzctd']){
            $data['xhyzctd'] = 0;
        }
        if(!@$data['xzipzckg']){
            $data['xzipzckg'] = 0;
        }
        $configdata = config("mydefind.");
        foreach($data as $k=>$v){
            if(@$configdata[$k]){
                $configdata[$k] = $v;
            }
        }
        $configdata['chongzhi_state'] = $data['chongzhi_state'];
        $str = array2string($configdata);
        $f = fopen("../config/mydefind.php","w");
        fwrite($f,"<?php \r\n return ".$str.";");
        fclose($f);
        $this->success("设置成功");
    }
	
	//奖金参数配置 
	public function rule()
    {
        $config = config("rule.");
        $this->assign("config",$config);
        return view();
	}

	public function getrule(){
        $config = config("rule.");
        return $config;
    }
	
	//清空数据
	public function clear()
    {
		return view();
	}

	public function clearact(){
	    $tables = ["user_role_function","user_phone_code","vip_user","user_msg","user_bank","notice","core_order","bank_give","bank_add","bank_card","core_zichan"];
	    foreach($tables as $v){
            $sql = "truncate table {$v}";
            $rs = Db::query($sql);
        }
        $this->success("清除成功");
    }
	
	//收款账号管理
	public function pay()
    {
		return view();
	}
}
