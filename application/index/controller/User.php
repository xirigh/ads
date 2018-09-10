<?php
namespace app\index\controller;

use think\console\Input;
use think\helper\Time;
use think\Session;
use think\Validate;
use think\Db;
use app\common\model\UserBank;

class User extends Index
{
    //注册
    public function reg()
    {
        //根据参数获取邀请码
        $email = input("u");
        if(!$email){
            $this->nopage();
        }
        //根据邮箱获取邀请码
        $model = model("vip_user");
        $data = $model->where(['v_email'=>$email])->find();
        if(!$data){
            $this->nopage();
        }
        if($data['enable_flag'] == 0){
            $this->error("该用户未激活");
        }else if($data['enable_flag'] == 2){
            $this->error("该用户被冻结");
        }else if($data['enable_flag'] == 1){
            //正常可用
        }else{
            $this->nopage();
        }
        //获取推荐码
        $recomm = $data['v_recomm_code'];
        $this->assign("recomm",$recomm);
        //获取性别
        $sex = $this->encodeCommonData($this->getDbCommonData("sex"));
        //获取性别
        $type = $this->encodeCommonData($this->getDbCommonData("v_type"));
        $this->assign("data",$data);
        $this->assign("sex",$sex);
        $this->assign("type",$type);
    	return view();
    }

    //注册执行页面
    public function regact()
    {
        //判断验证码
        $data = input();
        $data['v_vip_id'] = $data['v_email'];
        $codemodel = model("user_phone_code");
        $rs = $codemodel->where(['upc_phone'=>$data['v_tel'],'upc_code'=>$data['phoneCode']])->where("upc_begin_time","<",time())->where('upc_end_time',">",time())->fetchSql(false)->find();
        if(!$rs){
            $this->error("手机验证码错误");
        }
        //判断密码复杂度
        if(!preg_match("/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,12}$/",$data['v_pwd1'])){
            $this->error("登录密码必须为6-12位字母与数字组合");
        }
        if(!preg_match("/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,12}$/",$data['v_pwd2'])){
            $this->error("交易密码必须为6-12位字母与数字组合");
        }
        //判断密码一致性
        if($data['v_pwd1'] != $data['v_pwd1_re']){
            $this->error("登录密码不一致");
        }
        if($data['v_pwd2'] != $data['v_pwd2_re']){
            $this->error("交易密码输入不一致");
        }
        if($data['v_pwd2'] == $data['v_pwd1']){
            $this->error("登陆密码与交易密码不可以一致");
        }
        $data['v_recomm_code'] = $this->createRecommCode();
        $model = model("vip_user");
        $vali = validate("vip_user");
        if(!$vali->check($data)){
            $this->error($vali->getError());
        }
        if(!$model->save($data)){
            $this->error("注册失败");
        }else{
            $this->success("注册成功","User/login");
        }
    }

    //发送验证码页面
    public function sendmsg()
    {
        $data = input();
        $phone = $data['mobile'];
        if(session("phone_code_end_time") > time()){
            $this->error("请勿频繁发送验证码");
        }
        $code = $this->createPhoneCode();
        $max = config("mydefind.duanxin_time");
        $over_time = $max*60;
        $data = [
            "upc_phone"=>$phone,
            "upc_code"=>$code,
            "upc_begin_time"=>time(),
            "upc_end_time"=>time()+$over_time,
        ];
        $model = model("user_phone_code");
        $vali = validate("user_phone_code");
        if(!$vali->check($data)){
            $this->error($vali->getError());
        }
        if($model->save($data)){
            $str = "您的验证码是{$code}";
            $this->yunpian_send($phone,$str);
            session("phone_code_end_time",time()+55);
            $this->success("发送成功");
        }else{
            $this->error("发送失败,请重新发送");
        }
    }

    //登录页面
    public function login(){
        session("home",null);
        return view();
    }

    //登录执行页面
    public function loginact(){
        $data = input();
        if(!captcha_check($data['v_code'])){
            $this->error("验证码错误");
        };
        if(!$data['v_email']){
            $this->error("登录邮箱不可为空");
        }
        if(!$data['v_pwd1']){
            $this->error("登录密码不可为空");
        }
        $model = model("vip_user");
        $data = $model->where(['v_email'=>$data['v_email'],'v_pwd1'=>$data['v_pwd1']])->find();
        if(!$data){
            $this->error("该用户不存在");
        }
        $data = $data->toArray();
        $sessionData = [
            "uid"=>$data['v_id'],
            "email"=>$data['v_email'],
            "vip_id"=>$data['v_vip_id'],
            "vip_id"=>$data['v_vip_id'],
            "uname"=>$data['v_name'],
        ];
        if($data['enable_flag'] == 0){
//            session("home",$sessionData);
//            $this->success("当前用户未激活，请尽快激活","Index/index");
            $this->error("当前用户未激活，无法登陆");
        }else if($data['enable_flag'] == 1){
            session("home",$sessionData);
            $this->success("登录成功","Index/index");
        }else if($data['enable_flag'] == 2){
            $this->error("用户被冻结，无法登陆");
        }
    }

    public function loginout(){
        session("home",null);
        $this->success("退出成功","User/login");
    }

    //个人页面
    public function home(){
        $uid = session("home.uid");
        $this->checkId($uid);
        $model = model("vip_user");
        $data = $model->where(['v_id'=>$uid])->find();
        $this->assign("data",$data);
        return view();
    }

    //用户激活页面
    public function jihuo(){
        $uid = session("home.uid");
        $begintime = strtotime(date("y-m-d ").str_replace("：",":",config("mydefind.jihuo_begin_time")));
        $endtime = strtotime(date("y-m-d ").str_replace("：",":",config("mydefind.jihuo_end_time")));
        if(time() < $begintime || time() > $endtime){
            $this->error("激活通道未开启");
        }
        if(config('mydefind.jihuo_max_num')+0 <= model("vip_user")->whereTime('jihuo_time', 'today')->count()){
            $this->error("今日激活人数已满，请明天再来");
        }

        //如果传了id，说明是给别人激活的。如果没有传id，说明是给自己激活的。
        $id = input("id")??$uid;
        $this->checkId($id);
        $needmoney = config("mydefind.kaihujin");
        $usermodel = model("vip_user");
        $money1 = $usermodel->where(['v_id'=>$uid])->Field("v_money1")->find()["v_money1"];
        if($money1 < $needmoney){
            $this->error("开户金不足","User/myteam");
        }
        $state = $usermodel->where(['v_id'=>$id])->Field("enable_flag")->find()["enable_flag"];
        if($state != 0){
            $this->error("用户已激活，无法重复激活！");
        }
        $money = $money1-$needmoney;
        $rs = \think\Db::transaction(function () use ($id,$uid,$money) {
            \think\Db::table('vip_user')->where(['enable_flag'=>0,"v_id"=>$id])->update(["enable_flag"=>1,"jihuo_time"=>time()]);
            \think\Db::table('vip_user')->where(["v_id"=>$uid])->update(["v_money1"=>$money]);
        });
       if($rs){
           $this->success("激活成功");
       }else{
           $this->success("激活成功");
       }
    }

    //修改用户密码页面
    public function changepwd(){
        $type = input("type/d",0);
        if(!in_array($type,[1,2])){
            $this->nopage();
        }
        $uid = session("home.uid");
        $this->checkId($uid);
        $data = input();
        if(!$data){
            $this->error("输入内容不能为空");
        }
        if($data['opwd'] == $data['npwd']){
            $this->error("新旧密码输入不能相同");
        }
        if($data['npwd'] != $data['npwd2']){
            $this->error("两次密码输入不一致");
        }
        if(!preg_match("/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,12}$/",$data['npwd'])){
            $this->error("新密码必须为6-12位字母与数字组合");
        }
        $model = model("vip_user");
        $info = $model->where(['v_id'=>$uid,'v_pwd'.$type => $data['opwd']])->fetchSql(false)->find();
        if(!$info){
            $this->error("旧密码输入错误，请重新输入");
        }
        $rs = $model->where(['v_id'=>$uid])->update(['v_pwd'.$type=>$data['npwd']]);
        if($rs){
            //清楚session,重新登录
            session("home",null);
            $this->success("修改成功,需要重新登录");
        }else{
            $this->error("修改失败");
        }
    }

    //创建备注码
    public function createIntroCode(){
        $code = rand(100000,999999);
        $model = model("bank_add");
        if($model->where(['ba_code'=>$code])->count()){
            $this->createIntroCode();
        }else{
            return $code;
        }
    }

    //用户充值页面
    public function bank(){
        //生成备注码
        $code = $this->createIntroCode();
        $this->assign("code",$code);
        //获取个人充值列表
        $uid = session("home.uid");
        $model = model("bank_add");
        $list = $model->where(['ba_uid'=>$uid])->order(['ba_create_time'=>'desc'])->paginate(config("mydefind.pagenum"));
        $this->assign("list",$list);
        //获取充值通道状态
        $state = config("mydefind.chongzhi_state");
        $this->assign("state",$state);
        return view();
    }

    //用户充值执行页面
    public function bankact(){
        if(config("mydefind.chongzhi_state") != 1){
            $this->error("充值通道未开启");
        }
        $data = input();
        if(!preg_match("/^[0-9]+.?[0-9]*$/",$data['ba_money'])){
            $this->error("充值金额错误");
        }
        if(!preg_match("/^[0-9]+.?[0-9]*$/",$data['ba_num'])){
            $this->error("充值数量错误");
        }
        $data['ba_type'] = 2;
        if(!in_array($data['ba_type'],[1,2])){
            $this->error("充值类型错误");
        }

//        // 上传图片吧
//        $file = request()->file('ba_file');
//        $maxsize = config("mydefind.upload_max_size_rar");
//        $maxsize = $maxsize*1024*1024;
//        $info = $file->validate(['size'=>$maxsize,'ext'=>'jpg,gif,png,jpeg,zip,rar,7z'])->move( './uploads/bank');
//        if($info){
//            $data['ba_img_path'] = $info->getSaveName();
//        }else{
//            $this->error($file->getError());
//        }
        //图片也没问题了，那就写库
        $vali = validate("bank_add");
        if(!$vali->check($data)){
            $this->error($vali->getError());
        }
        $model = model("bank_add");
        $data['ba_uid'] = session("home.uid");
        $data['ba_state'] = 3;
        $data['ba_create_user'] = session("home.uid");
        $data['ba_update_user'] = session("home.uid");
        if($model->save($data)){
            $this->success("下单成功，请及时付款");
        }else{
            $this->error("充值失败");
        }
    }

    //上传图片页面
    public function upimgfile(){
        $id = input('id/d',0);
        $uid = session("home.uid");
        $data = model("bank_add")->fetchSql(false)->find($id);
        if(!$data){
            $this->error("该订单不存在");
        }
        if($data['ba_uid'] != $uid){
            $this->error("当前用户没有上传权限");
        }
        if(strtotime($data['ba_create_time'])+(config("mydefind.dakuan_time")*60) < time()){
            $data = model("bank_add")->where(['ba_id'=>$id,'ba_state'=>3])->update(['ba_state'=>4]);
            $this->error("打款已超时，无法完成");
        }
        if($data['ba_state'] != 3){
            $this->error("当前状态不可以上传凭证");
        }
        if(!@$_FILES["ba_file"]['size']){
            $this->error("未选择图片或上传图片过大（1M以内）");
        }
        if(!$_FILES["ba_file"]['size'] > 1*1024*1024){
            $this->error("上传图片过大，请压缩后上传");
        }
        $file = request()->file('ba_file');
        $maxsize = config("mydefind.upload_max_size_rar");
        $maxsize = $maxsize*1024*1024;
        $info = $file->validate(['size'=>$maxsize,'ext'=>'jpg,gif,png,jpeg,zip,rar,7z'])->move( './uploads/bank');
        if($info){
            $path = $info->getSaveName();
        }else{
            $this->error($file->getError());
        }
        $rs = model("bank_add")->where(['ba_id'=>$id,'ba_state'=>3])->update(['ba_state'=>0,"ba_img_path"=>$path]);
        if($rs){
            $this->success("打款成功");
        }else{
            $this->error("打款失败");
        }
    }

    //个人推广页面
    public function myqrcodeimg(){
        $email = session("home.email");
        $url = url('User/reg',['u'=>$email],"html",true);
        echo $this->qrcode($url);
        exit;
    }

    //个人推广页面
    public function myqrcode(){
        $email = session("home.email");
        $url = url('User/reg',['u'=>$email],"html",true);
        $this->assign("url",$url);
        return view();
    }

    //转账页面
    public function give(){
        //获取我的转账列表
        $uid = session("home.uid");
        $model = model("bank_give");
        $list = $model->where('bg_out_uid|bg_in_uid','=',$uid)->paginate(config("mydefind.pagenum"));
        foreach($list as $k=>$v){
            if($v['bg_out_uid'] == $uid){
                $list[$k]['flag'] = "转出";
            }else{
                $list[$k]['flag'] = "转入";
            }
        }
        $usermodel = model("vip_user");
        $info = $usermodel->where(['v_id'=>$uid])->field("v_money1,v_money2")->find();
        $this->assign("info",$info);
        $this->assign("list",$list);
        return view();
    }

    //转账执行页面
    public function giveact(){
        $data = input();
        if(!preg_match("/^[0-9]+.?[0-9]*$/",$data['bg_money'])){
            $this->error("转出金额错误");
        }
        if(!in_array($data['bg_type'],[1,2])){
            $this->error("转出类型错误");
        }
        if($data['bg_money']%config("mydefind.out_money_min") != 0){
            $this->error("转出金额必须为".config("mydefind.out_money_min")."的倍数");
        }
        $uid = session("home.uid");
        //根据邮箱查出id
        $model = model("vip_user");
        $money = $model->where(['v_id'=>$uid])->find()['v_money'.$data['bg_type']];
        if($money < $data['bg_money']){
            $this->error("当前账户余额不足");
        }
        $info = $model->where(['v_email'=>$data['bg_email']])->find();
        if(!$info){
            $this->error("用户不存在");
        }
        $savedata = [
            "bg_out_uid"=>$uid,
            "bg_in_uid"=>$info['v_id'],
            "bg_money"=>$data['bg_money'],
            "bg_type"=>$data['bg_type'],
            "bg_create_user"=>$uid,
            "bg_update_user"=>$uid,
            "bg_create_time"=>time(),
            "bg_update_time"=>time(),
        ];
        $rs = \think\Db::transaction(function () use ($savedata,$money,$uid) {
            \think\Db::table('bank_give')->fetchSql(false)->insert($savedata);
            \think\Db::table('vip_user')->fetchSql(false)->where(["v_id"=>$savedata['bg_out_uid']])->setDec("v_money".$savedata['bg_type'],$savedata['bg_money']);
            \think\Db::table('vip_user')->fetchSql(false)->where(["v_id"=>$savedata['bg_in_uid']])->setInc("v_money".$savedata['bg_type'],$savedata['bg_money']);
        });
        if($rs){
            $this->success("转出成功");
        }else{
            $this->success("转出成功");
        }
    }

    public function myteam(){
        //获取我的直推列表
        $uid = session("home.uid");
        $model = model("vip_user");
        $bankmodel = model('user_bank');
        $recomm = $model->where(['v_id'=>$uid])->find()['v_recomm_code'];
        $list = $model->where(['v_re_recomm_code'=>$recomm])->order(['create_time'=>'desc'])->paginate(config("mydefind.pagenum"));
        $count = $model->where(['v_re_recomm_code'=>$recomm])->count();
        $this->assign("list",$list);
        $this->assign("count",$count);

        //获得团队总收益
        $usermodel = model("vip_user");
        $userlist = $usermodel->field('v_id,v_recomm_code,v_re_recomm_code')->select();
        $data = $usermodel->where(['v_id'=>$uid])->field("v_money1,v_money2,v_recomm_code,v_id")->find();
        $treelist = $this->getUserTree($userlist,$data['v_recomm_code'],$data['v_id'],1);
        $ids = [];
        $zongrujin = 0;
        foreach ($treelist as $v){
            $zongrujin += $this->getUserZongzichan($v['v_id']);
            $ids[] = $v['v_id'];
        }
        $this->assign("zongrujin",$zongrujin);
//        if(!$ids){
//            $ids = [0];
//        }
//        $teamlist = $bankmodel->where(['ub_uid'=>$ids,'ub_type'=>[2,3]])->fetchSql(false)->select();
//        $teamcount = 0;
//        foreach($teamlist as $v){
//            $teamcount += $v['ub_money'];
//        }
//        $this->assign("teamcount",1);

        //获得当前账户的动态收益
//        $teamcount = model("user_bank")->where(['ub_type'=>2,"ub_state"=>1,"ub_uid"=>$uid])->field("count(ub_money) a")->find()['a'];
        $teamcountlist = model("user_bank")->where(['ub_type'=>2,"ub_state"=>1,"ub_uid"=>$uid])->select();
		$teamcount = 0;
		foreach($teamcountlist as $v){
			$teamcount += $v['ub_money'];
		}
        $this->assign("teamcount",$teamcount);

        $this->assign("uid",session("home.uid"));
        return view();
    }

    //用户留言列表
    public function msg(){
        //获取我的留言
        $uid = session("home.uid");
        $model = model("usermsg");
        $typelist = $this->encodeCommonData($this->getDbCommonData("um_type"));
        $list = $model->where(['u.um_uid'=>$uid])->alias("u")->join("vip_user v","u.um_uid = v.v_id")->field("u.*,v.v_vip_id")->fetchSql(false)->paginate(config("mydefind.pagenum"));
        foreach($list as $k=>$v){
            $list[$k]['type'] = $typelist[$v['um_type']];
        }
        $this->assign("list",$list);
        $this->assign("typelist",$typelist);
        return view();
    }
    
    //提现
    public function moneyout(){
        $uid = session('home.uid');
        //获取我的提现列表
        $model = model("user_bank");
        $list = $model->where(['ub_type'=>5,"ub_uid"=>$uid])->order(['ub_create_time'=>"desc"])->paginate(config("mydefind.pagenum"));
        $usermodel = model("vip_user");
        $ethaddress = $usermodel->find($uid)['v_alipay'];
        $this->assign("list",$list);
        $this->assign("ethaddress",$ethaddress);
        //查询当前用户还有多少钱
        $money2 = $usermodel->find($uid)['v_money2'];
        $this->assign("money",$money2);
        return view();
    }

    //提现执行页面
    public function outact(){
        $data = input();
        $uid = session('home.uid');
        if(!($data['ub_msg']||$data['ub_money'])){
            $this->error("请输入提现地址或提现金额");
        }
        $usermodel = model("vip_user");
        $money2 = $usermodel->find($uid)['v_money2'];
        if($data['ub_money'] > $money2){
            $this->error("金额不足，无法完成提现");
        }
        // TODO 还需要设置最高提现金额
        if(($data['ub_money']+0)%config('mydefind.tixian_money_min') != 0){
            $this->error("提现金额必须是".config('mydefind.tixian_money_min')."的倍数");
        }
        $savedata = [
            "ub_money"=> "-".$data['ub_money'],
            "ub_msg"=>$data['ub_msg'],
            "ub_uid"=>$uid,
            "ub_type"=>5,
            "ub_state"=>0,
        ];
        $vali = validate("user_bank");
        if(!$vali->check($savedata)){
            $this->error($vali->getError());
        }
        //扣除钱包金额
        $rs = Db::transaction(function() use ($savedata){
			$vipuser = new UserBank;
            Db::table("vip_user")->where(['v_id'=>$savedata['ub_uid']])->setInc('v_money2',$savedata['ub_money']);
            $rs = $vipuser->save($savedata);
            return $rs;
        });
        if($rs){
            $this->success("提交成功");
        }else{
            $this->error("提交失败");
        }
    }

    public function wjmm(){
        return view();
    }

    public function wjmmact(){
        $data = input();
        //判断密码复杂度
        if($data['v_pwd1'] != $data['v_pwd1_re']){
            $this->error("登录密码不一致");
        }
        if(!preg_match("/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,12}$/",$data['v_pwd1'])){
            $this->error("密码必须为6-12位字母与数字组合");
        }
        $codemodel = model("user_phone_code");
        $rs = $codemodel->where(['upc_phone'=>$data['v_tel'],'upc_code'=>$data['phoneCode']])->where("upc_begin_time","<",time())->where('upc_end_time',">",time())->fetchSql(false)->find();
        if(!$rs){
            $this->error("手机验证码错误");
        }
        $model = model("vip_user");
        $info = $model->where(['v_email'=>$data['v_email'],'v_tel'=>$data['v_tel']])->find();
        if(!$info){
            $this->error("邮箱或手机号输入错误");
        }
        if($info['v_pwd1'] == $data['v_pwd1']){
            $this->success("密码修改成功");
        }
        $savedata = [
            "v_id" => $info['v_id'],
            "v_pwd1" => $data['v_pwd1'],
        ];
        if($model->update($savedata)) {
            $this->success("密码修改成功");
        }else{
            $this->error("密码修改失败");
        }
    }

    public function caiwu(){

        $this->getindexdata();
//        $uid = session("home.uid");
//        $this->checkId($uid);
//        $model = model("vip_user");
//        $data = $model->where(['v_id'=>$uid])->find();
//        $this->assign("data",$data);
//
//        $core_order = model("core_order");
//        $list = $core_order->where(['co_uid'=>$uid])->order(['co_create_time'=>'desc'])->alias("o")->join('core_goods g','o.co_cg_id = g.cg_id')->paginate(config("mydefind.pagenum"));
//        $this->assign("list",$list);

        return view();
    }

    //绑定银行卡
    public function yinhangka(){
        //获取我的银行卡信息
        $uid = session("home.uid");
        $model = model("bank_card");
        $data = $model->where(['bc_uid'=>$uid])->find();
        $this->assign("data",$data);
        return view();
    }

    public function yinhangkaact(){
        $data = input();
        $uid = session("home.uid");
        $model = model("bank_card");
        $vali = validate("bank_card");
        if(!$vali->check($data)){
            $this->error($vali->getError());
        }

        $info = $model->where(['bc_uid'=>$uid])->find();
        if($info){
            //修改
            $data['bc_uid'] = $uid;
            $data['bc_update_user'] = $uid;
            $data['bc_id'] = $info['bc_id'];
            $rs = $model->update($data);
            if($rs){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }
        }else{
            //新增
            $data['bc_uid'] = $uid;
            $data['bc_create_user'] = $uid;
            $data['bc_update_user'] = $uid;
            $rs = $model->save($data);
            if($rs){
                $this->success("绑定成功");
            }else{
                $this->error("绑定失败");
            }
        }
    }

    //完善用户信息
    public function wanshan(){
        //获取性别
        $sex = $this->encodeCommonData($this->getDbCommonData("sex"));
        $this->assign("sex",$sex);
        //获取用户信息
        $uid = session("home.uid");
        $model = model("vip_user");
        $data = $model->find($uid);
        if(!$data){
            $this->nopage();
        }
        $this->assign("data",$data);
        return view();
    }

    //完善用户信息执行页面
    public function wanshanact(){
        $data = input();
        $uid = session("home.uid");
        $vali = validate("vip_user");
        if(!$vali->scene("wanshan")->check($data)){
            $this->error($vali->getError());
        }
        $model = model("vip_user");
        $rs = $model->where(['v_id'=>$uid])->field("v_sex,v_name,v_alipay,v_bank,v_bank_name,v_card_num,v_bank_address,v_card_id")->update($data);
        if($rs){
            $this->success("完善成功");
        }else{
            $this->error("完善失败");
        }
    }

    //获取团队管理树数据组合页面
    public function getUserLevTree()
    {
        $v_id = input("ClientID",null);
        $vipuser = model("vip_user");
        $list = $vipuser->select()->toArray();
        foreach ($list as $k=>$v){
            $recommlist[$v['v_recomm_code']] = $v;
        }
        if($v_id){
            foreach (array_reverse($list) as $k=>$v){
                if(substr_count($v['v_id'],$v_id)){
                    $comm = $v['v_recomm_code'];
                }
            }
            if(!@$comm){
                $this->error("该用户不存在");
            }
            $tree = [];
            $ownarr[0] = $recommlist[$comm];
            $ownarr[0]['lev'] = 0;
            $ownarr[0]['parent'] = "#";
            $tree = array_merge($tree,$this->getUserTree($list, $comm, $recommlist[$comm]['v_id'], 1));
            $tree = array_merge($ownarr,$tree);
        }else{
            $tree = $this->getUserTree($list, "#", "#", 1);
        }
        $countlist = [];
        foreach($list as $v){
            $countlist[] = $v['v_re_recomm_code'];
        }
        $count = array_count_values($countlist);
        $returndata = [];
        $commdata = $this->encodeCommonData($this->getDbCommonData("v_type"));
        foreach ($tree as $v) {
            $returndata[] = [
                "id" => $v['v_id'],
                "parent" => $v['parent'],
                "fullname" => $v['v_name'],
                "count" => $this->getUserNum($list,$count,$v['v_recomm_code']),
                "parentcount" => $v['lev']-1,
                "createdata" => $v['create_time'],
                "clientlevel" => $commdata[$v['v_type']],
                "jihuo" => $v['enable_flag'],
            ];
        }


        return $returndata;
    }

    //获取用户下级人数
    public function getUserNum($list,$countlist,$code)
    {
        $count = 0;
        foreach ($list as $v) {
            if($v['v_re_recomm_code'] == $code){
                ++$count;
                //获取它下面的邀请码，并递归
                $recomm = $v['v_recomm_code'];
                if(@$countlist[$recomm]){
                    $count += $this->getUserNum($list,$countlist,$recomm);
                }
            }
        }
        return $count;
    }

    public function getuname(){
        $email = input("email");
        $info = model("vip_user")->where(['v_email'=>$email])->find()['v_name'];
        if(!$info){
            $this->error("用户不存在");
        }else{
            $this->success("当前用户姓名：".$info);
        }
    }

    public function tree(){
        $this->assign("uid",session("home.uid"));
        return view();
    }

    public function notice(){
        $list = model("notice")->order(['update_time'=>"desc"])->select();
        $this->assign("list",$list);
        return view();
    }

}
