<?php
namespace app\index\controller;

use think\Db;
use think\Model;
use think\Request;
use think\view\driver\Think;
use app\common\model\CoreZichan;

class Index extends Base
{
    public function index()
    {
        $this->getindexdata();
    	return view(); 
    }

    //购买证券
    public function buy(){
        $uid = session("home.uid");
        $cg_id = input("cg_id/d",0);
        $num = input("num/d",0);
        $data = [
            "co_num"=>$num,
            "co_cg_id"=>$cg_id,
            "co_uid"=>$uid,
        ];
        if($data['co_num']+0 < 1){
            $this->error("购买数量错误");
        }
        if($data['co_cg_id']+0 < 1){
            $this->error("购买商品错误");
        }
        $nowmoney = model("vip_user")->find($uid)['v_money2'];
        $goodslist = model("core_goods");
        $money = encodemoney($goodslist->where(['cg_id'=>$data['co_cg_id']])->find()['cg_money']*$data['co_num']);
        if($nowmoney < $money){
            $this->error("当前余额不足，请先充值");
        }

        $data['co_money'] = $money;
        $data['co_create_time'] = time();
        $data['co_update_time'] = time();
        $data['co_create_user'] = $uid;
        $data['co_update_user'] = $uid;
        $model = model("core_order");
        $countdata = [
            "ub_uid"=>$uid,
            "ub_msg"=>"",
            "ub_money"=>"-".$money,
            "ub_type"=>"4",
            "ub_state"=>"1",
            "ub_create_user"=>$uid,
            "ub_update_user"=>$uid,
            "ub_update_time"=>time(),
            "ub_create_time"=>time(),
        ];
        //上面是写订单，一切都不改变！
        //下面开始写资产表
        //先查询是否买过
        $zichanmodel = model("core_zichan");
        $zichandata = $zichanmodel->where(['cz_uid'=>$uid,"cz_state"=>0,"cz_cg_id"=>$cg_id])->find();
        if(!$zichandata){
            //新增
            $zichansavedata = [
                "cz_uid"=>$uid,
                "cz_cg_id"=>$cg_id,
                "cz_state"=>0,
                "cz_num"=>$num,
                "cz_count_time"=>time(),
            ];
            $flag = 0;
        }else{
            //修改
            $zichansavedata = [
                "cz_id"=>$zichandata['cz_id'],
                "cz_num"=>$zichandata['cz_num'] + $num,
            ];
            $flag = 1;
        }
        $rs = Db::transaction(function () use ($data,$countdata,$uid,$money,$zichansavedata,$flag) {
            $zichanmodel = new CoreZichan();
            if($flag){
                $d = $zichanmodel->isUpdate()->save($zichansavedata);
            }else{
                $d = $zichanmodel->save($zichansavedata);
            }
            $a = Db::table('core_order')->insert($data);
            $c = Db::table('user_bank')->insert($countdata);
            $b = Db::table('vip_user')->where(['v_id'=>$uid])->setDec("v_money2",$money);
            return $b;
        });
        if($rs){
            $this->error("购买成功");
        }else{
            $this->success("购买失败");
        }
    }

    //我的资产列表
    public function buylist(){
//        $uid = session("home.uid");
//        $model = model("core_order");
//        $list = $model->where(['co_uid'=>$uid])->order(['co_create_time'=>'desc'])->alias("o")->join('core_goods g','o.co_cg_id = g.cg_id')->paginate(config("mydefind.pagenum"));
//        $this->assign("list",$list);
        $this->getindexdata();
        return view();
    }

    //我的收益明细
    public function shouyi(){
        $uid = session("home.uid");
        $model = model("user_bank");
        $list = $model->where(['ub_uid'=>$uid])->order(['ub_create_time'=>'desc','ub_id'=>'desc'])->paginate(config("mydefind.pagenum"));
//        dump($list->toArray());
/*		if($uid == 5){
			dump($list);exit;
		}
*/
        $this->assign("list",$list);
        return view();
    }

    //设置订单状态
    private function set_order($id,$state){
        $uid = session("home.uid");
        $data = model("core_zichan")->where(["cz_cg_id"=>$id,'cz_uid'=>$uid,"cz_state"=>0])->alias("z")->fetchSql(false)->join("core_goods g","g.cg_id = z.cz_cg_id")->find();
//        $this->error($data);
        if(!$data){
            return false;
        }
        $rs = Db::transaction(function () use ($data,$state){
            //结束订单
            Db::table("core_zichan")->where(['cz_id'=>$data['cz_id']])->update(['cz_state'=>$state]);
            //把收益加进用户钱包
            if($state == 1){
                $money = $data['cz_count_money']+($data['cz_num']*$data['cg_money']/100);
            }else{
                $money = $data['cz_count_money'];
            }
            $rs = Db::table("vip_user")->where(['v_id'=>$data['cz_uid']])->setInc("v_money2",$money);
            return $rs;
        });
        return $rs;
    }

    protected function getindexdata(){

        $uid = session("home.uid");
        //获取我的两个钱包
        $usermodel = model("vip_user");
        $data = $usermodel->where(['v_id'=>$uid])->field("v_money1,v_money2,v_recomm_code,v_id")->find();
        if(!$data){
            $this->error("用户不存在");
        }
        $this->assign("data",$data);
        //获得总资产
        $zongzichan = model("core_zichan")->where(['cz_uid'=>$uid,'cz_state'=>0])->alias("z")->join("core_goods g","z.cz_cg_id = g.cg_id")->select();
        $zichancount = $data['v_money2'];
        $leiji = 0;
        $zuori = 0;
        foreach($zongzichan as $v){
            $leiji += ($v['cz_auto_num']*$v['cg_money']/100) + $v['cz_count_money'];
            $zuori += $v['cz_day_money'];
            $zichancount += ($v['cz_num']*$v['cg_money']/100)+$v['cz_count_money'];
        }
        $this->assign("zongzichancount",$zichancount);
        //获得累计收益
        $this->assign("bankcount",$leiji);
        //获得昨日收益
        $this->assign("daycount",$zuori);
        //获取基金列表
        $goodsmodel = model("core_goods");
        $goodslist = $goodsmodel->select();
        foreach($goodslist as $k=>$v){
            $goodslist[$k]['user'] = model("core_zichan")->where(["cz_uid"=>$uid,"cz_cg_id"=>$v['cg_id'],"cz_state"=>0])->find();
        }
        $this->assign("list",$goodslist);
    }

    //我的资产（新）
    public function zichanquan(){
        $this->getindexdata();
        return view();
    }

    //资产转让执行页面
    public function give(){
        $id = input("id/d",0);
        $email = input("email",0);
        $num = input("num/d",0);
        if(!is_int($num)){
            $this->error("转出数量错误");
        }
        if($num <1){
            $this->error("转出数量错误");
        }
        if(!is_int($id)){
            $this->error("转出类型错误");
        }
        if($id <1){
            $this->error("转出类型错误");
        }
        $uid = session("home.uid");
        $user = model("vip_user")->where(['v_email'=>$email])->find()['v_id'];
        if(!$user){
            $this->error("接受者不存在");
        }
        $goodsdata = model("core_zichan")->where(['cz_uid'=>$uid,'cz_cg_id'=>$id,'cz_state'=>0])->alias("z")->join("core_goods g","z.cz_cg_id=g.cg_id")->fetchSql(false)->find();
//$this->error($goodsdata);
        if(!$goodsdata){
            $this->error("当前资金券不存在");
        }
        if($goodsdata['cz_num'] < $num){
            $this->error("当前用户所剩资产券不足,无法完成转赠");
        }
        //扣除当前用户资产券，增加接受用户资产券，写交易明细表
        $rs = Db::transaction(function() use ($uid,$num,$user,$id,$goodsdata){
            $zichanmodel = new CoreZichan();
            $zichanmodel->where(['cz_uid'=>$uid,"cz_state"=>0,"cz_cg_id"=>$id])->setDec("cz_num",$num);
            if($zichanmodel->where(['cz_uid'=>$user,"cz_state"=>0,"cz_cg_id"=>$id])->count()){
                $zichanmodel->where(['cz_uid'=>$user,"cz_state"=>0,"cz_cg_id"=>$id])->setInc("cz_num",$num);
            }else{
                $zichanmodel->where(['cz_uid'=>$user,"cz_state"=>0,"cz_cg_id"=>$id])->insert(['cz_uid'=>$user,"cz_cg_id"=>$id,"cz_num"=>$num,"cz_create_time"=>time(),"cz_update_time"=>time(),"cz_count_time"=>time()]);
            }
            db::table("user_bank")->insert(['ub_uid'=>$uid,"ub_money"=>"-".$num*$goodsdata['cg_money']/100,"ub_msg"=>"资产券转出","ub_type"=>"6","ub_state"=>1,"ub_update_time"=>time(),"ub_create_time"=>time()]);
            $rs = db::table("user_bank")->insert(['ub_uid'=>$user,"ub_money"=>$num*$goodsdata['cg_money']/100,"ub_msg"=>"资产券转入","ub_type"=>"7","ub_state"=>1,"ub_update_time"=>time(),"ub_create_time"=>time()]);
            return $rs;
        });
        if($rs){
            $this->success("转出成功");
        }else{
            $this->error("转出失败");
        }

    }

    public function end(){
        $id = input("id/d",0);
        if($id < 1){
            $this->error("参数错误");
        }
        $uid = session("home.uid");
        $model = model("core_order");
       if($this->set_order($id,1)){
           $this->success("结束成功");
       }else{
           $this->error("结束失败");
       }
    }
}
