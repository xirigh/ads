<?php
namespace app\admin\controller;

use app\common\controller as C;
use app\common\controller\Common;

/*
 * 后台公共页面
 */

class Base extends Common
{
	protected $beforeActionList = [
        'getLeftMenuAct',
        'checkLogin'=>['except' => 'login,loginact'],
    ];

	//获取后台左侧栏目数据
    protected function getLeftMenu()
    {
        //获得当前用户的id,查询权限
        $uid = session('admin.u_id');
        $roleid = model("user")->find($uid)['role_code'];
        $functionids = model("user_role_function")->where(['role_code'=>$roleid])->select();
//        dump($functionids);
    	$model = model("user_module");
		$data = $model->field('module_code,module_name,module_disp_seq')->order(array("module_disp_seq"))->select();
		$function = $model->field('module_code,function_code,function_name,function_disp_seq,function_url')->select();
		foreach($data as $k=>$v){
			$menu[$v['module_code']]['code'] = $v['module_code'];
			$menu[$v['module_code']]['title'] = $v['module_name'];
			$menu[$v['module_code']]['order'] = $v['module_disp_seq'];
		}
		
		foreach($function as $k=>$v){
			$menu[$v['module_code']]['data'][] = $v;
		}
		return $menu;
    }

    //左侧公用
	protected function getLeftMenuAct()
    {
		$menu = $this->getLeftMenu();
		$this->assign("menu",$menu);
	}

	//检测登录
    protected function checkLogin()
    {
        if (!session("admin.u_id")) {
            $this->error("用户未登录", "User/login");
        }

        if(session("admin.login_time")+1800 < time()){
            session("admin",null);
            $this->error("用户登录超时，请重新登录", "User/login");
        }else{
            session("admin.login_time",time());
        }
    }
}
