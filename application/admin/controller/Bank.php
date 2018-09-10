<?php
namespace app\admin\controller;

use app\admin\controller;
use app\admin\model;
use app\common\model\UserBank;
use think\Db;
/*
 * 用户群组会员管理
 */

class Bank extends Base
{
   //充值扣款钱包
    public function add()
    {
        return view();
    }

    //根据邮箱检查用户
    public function checkuserinfo(){
        $email = input('email');
        $usermodel = model("vip_user");
        $rs = $usermodel->where(['v_email'=>$email])->find();
        if($rs){
            $this->success($rs['v_vip_id']);
        }else{
            $this->error("用户不存在");
        }
    }

    //充值扣款执行
    public function addact(){
        $email = input("email");
        $type = input("type/d",0);
        $money = input("money",0);
        if(!$email){
            $this->error("E用户不存在");
        }
        if(!in_array($type,[1,2])){
            $this->error("E钱包类型错误");
        }
        if(!preg_match('/^(-)?[1-9][0-9]*$/',$money)) {
            $this->error("E金额输入错误");
        }
        $model = model("vip_user");
        $info = $model->where(['v_email'=>$email])->find();
        $rs = false;
        if($money < 0){
            //扣款操作
            if(@$info['v_money'.$type] < abs($money)){
                $this->error("W该用户余额不足，不可扣除");
            }
            $rs = $model->where(['v_email'=>$email])->setDec("v_money".$type,abs($money));
        }else{
            //充值操作
            $rs = $model->where(['v_email'=>$email])->setInc("v_money".$type,abs($money));
        }
        $uid = session("admin.uid");
        if($rs){
            $bankmodel = model("user_bank");
            $uid = $info['v_id'];
            $bankmodel->save(['ub_uid'=>$uid,'ub_money'=>$money,"ub_msg"=>"系统操作","ub_type"=>1,"ub_state"=>1,"ub_create_user"=>$uid,"ub_update_user"=>$uid]);
            $this->success("S操作成功");
        }else{
            $this->error("E操作失败！");
        }
    }

    //资金转入申请
    public function applyin(){
        $model = model("bank_add");
        $list = $model->order(['ba_create_time'=>"desc"])->alias("b")->join("vip_user u","u.v_id = b.ba_uid")->field("b.*,u.v_id,u.v_vip_id,v_email")->paginate(config("mydefind.pagenum"));
        $this->assign("list",$list);
//        dump($list->toArray());exit;
        return view();
    }

    //资金转入审核执行页面
    public function inact(){
        $type = input("action/d",0);
        $id = input("id/d",0);
        if(!($type||$id)){
            $this->error("E参数错误");
        }
        if(!in_array($type,[1,2])){
            $this->error("E参数错误");
        }
        $model = model('bank_add');
        $data = $model->find($id);
        if(!$data){
            $this->error("E该申请不存在");
        }
        if($data['ba_state'] != 0){
            $this->error("E该申请已处理，请勿重复处理");
        }
        if($type == 1){
            $rs = Db::transaction(function() use ($data){
                Db::table("vip_user")->where(['v_id'=>$data['ba_uid']])->setInc('v_money'.$data['ba_type'],$data['ba_money']);
                $rs = Db::table("bank_add")->where(['ba_id'=>$data['ba_id']])->update(['ba_state'=>1]);
                return $rs;
            });
            if($rs){
                $this->success("S通过成功");
            }else{
                $this->error("E通过失败");
            }
        }else{
            $rs = Db::table("bank_add")->where(['ba_id'=>$data['ba_id']])->update(['ba_state'=>2]);

            if($rs){
                $this->success("S拒绝成功");
            }else{
                $this->error("E拒绝失败");
            }
        }
    }

    //钱包提现申请
    public function applyout(){
        $list = UserBank::withAttr('profile.ub_state', function($value, $data) {
            $data = ["0"=>"待审核","1"=>"已通过","2"=>"已拒绝"];
            return $data[$value];
        })->order(['ub_create_time'=>"desc"])->alias("b")->join("vip_user u","u.v_id = b.ub_uid")->field("b.*,u.v_id,u.v_vip_id,u.v_email,u.v_money2")->where(['ub_type'=>"5"])->paginate(config("mydefind.pagenum"));
        $this->assign("list",$list);
        return view();
    }

    //提现审核执行页面
    public function outact(){
        $type = input("action/d",0);
        $id = input("id/d",0);
        if(!($type||$id)){
            $this->error("E参数错误");
        }
        if(!in_array($type,[1,2])){
            $this->error("E参数错误");
        }
        $model = model('user_bank');
        $data = $model->where(['ub_type'=>5])->find($id);
        if(!$data){
            $this->error("E该申请不存在");
        }
        if($data['ub_state'] != "待审核"){
            $this->error("E该申请已处理，请勿重复处理");
        }
        if($type == 1){
            $rs = Db::transaction(function() use ($data){
//                Db::table("vip_user")->where(['v_id'=>$data['ub_uid']])->setInc('v_money2',$data['ub_money']);
                $rs = Db::table("user_bank")->where(['ub_id'=>$data['ub_id']])->update(['ub_state'=>1]);
                return $rs;
            });
            if($rs){
                $this->success("S通过成功");
            }else{
                $this->error("E通过失败");
            }
        }else{
            $rs = Db::transaction(function() use ($data){
                Db::table("vip_user")->where(['v_id'=>$data['ub_uid']])->setDec('v_money2',$data['ub_money']);
                $rs = Db::table("user_bank")->where(['ub_id'=>$data['ub_id']])->update(['ub_state'=>2]);
                return $rs;
            });

            if($rs){
                $this->success("S拒绝成功");
            }else{
                $this->error("E拒绝失败");
            }
        }
    }
}
