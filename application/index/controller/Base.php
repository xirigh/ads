<?php
namespace app\index\controller;

use app\common\controller as C;
use think\Session;

/*
 * 前台公共页面
 */

class Base extends C\Common
{
    protected $beforeActionList = [
        "all",
        'checkLogin'=>['except' => 'login,loginact,reg,regact,sendmsg,wjmm,wjmmact'],
    ];

    protected function checkLogin(){
        if(!session("home.uid")){
            $this->redirect("User/login");
        }
    }

    protected function all(){
        app("url")->root("/index.php");
    }
}
