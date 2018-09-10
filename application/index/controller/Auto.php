<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Controller;
use think\helper\Time;
use think\Db;
use think\facade\Debug;

class Auto extends Common
{
   private $flag = 60;
   private $lian1 = [];

   //日常结算
   public function index(){
		if(input("pwd") == '111'){
			Debug::remark('begin');
	//        $this->remove_wait();
			$this->daycount();
		   Debug::remark('end');
		   $runtime = Debug::getRangeTime('begin','end');
		   return json("OK:".$runtime);
		}else{
			exit("密码错误");
		}
       
   }

    //对订单进行取消冻结
   private function remove_wait(){
       $model = model("core_order");
       //获取所有状态码为0的，判断时间
       $list = $model->where(['co_state'=>0])->select()->toArray();
       if(!$list) return false;
       foreach($list as $k=>$v){
           if(time()-strtotime($v['co_update_time']) > config('mydefind.wait_time')*$this->flag){
               $rs = $model->fetchSql(false)->update(['co_state'=>1,'co_id'=>$v['co_id'],'co_count_time'=>time()]);
           }else{
               unset($list[$k]);
           }
       }
   }

   //每日进行分红
    private function daycount(){
       //给一个小时结算时间
		$model = model("core_zichan");
        $list = $model->where(['cz_state'=>0])->alias("z")->fetchSql(false)->join("core_goods g","g.cg_id = z.cz_cg_id")->select();
        $list = array_unique($list->toArray(),SORT_REGULAR);
        //查到了数据，结算一下
        //收益=数量*价格/100*利率 =
        foreach ($list as $v){
            //直接算收益
            $savedata['cz_day_money'] = $v['cg_money']*$v['cz_num']/100*$v['cg_day']/10000;
            $savedata['cz_count_money'] = $v['cz_count_money']+$v['cg_money']*$v['cz_num']/100*$v['cg_day']/10000;
            $savedata['cz_count_time'] = time();
            $savedata['cz_id'] = $v['cz_id'];
            $bei = floor($savedata['cz_count_money']/($v['cg_money']/100));
            $systemdata = [];
            if($bei > 0){
                $savedata['cz_count_money'] = $savedata['cz_count_money']-($bei*$v['cg_money']/100);
                $savedata['cz_auto_num'] = $v['cz_auto_num']+$bei;
                $savedata['cz_num'] = $v['cz_num']+$bei;
                //系统兑换的一张券写收益库
                $systemdata = [
                    "ub_uid"=>$v['cz_uid'],
                    "ub_msg"=>"",
                    "ub_money"=>$bei*$v['cg_money']/100,
                    "ub_type"=>"8",
                    "ub_state"=>"1",
                    "ub_create_user"=>$v['cz_uid'],
                    "ub_update_user"=>$v['cz_uid'],
                ];
            }
            //写收益库
            $countdata = [
                "ub_uid"=>$v['cz_uid'],
                "ub_msg"=>"",
                "ub_money"=>$savedata['cz_day_money'],
                "ub_type"=>"3",
                "ub_state"=>"1",
                "ub_create_user"=>$v['cz_uid'],
                "ub_update_user"=>$v['cz_uid'],
            ];
            //根据id获取用户的邀请码
            $recomm = model("vip_user")->where(['v_id'=>$v['cz_uid']])->field('v_recomm_code')->find()['v_recomm_code'];
            $parentlist = $this->get_parent($recomm);
            //拿出父链以后，要给父链分红。怎么分？
            $countSaveData = [];
            $parentSaveData = [];
            if($parentlist){
                foreach ($parentlist as $key=>$val){
                    $parentSaveData[$key] = [
                        "v_id"=>$val['uid'],
                        "v_money2"=>$val['money']+($savedata['cz_day_money']*$val['lev_money']/100),
                    ];
                    $countSaveData[$key] = [
                        "ub_uid"=>$val['uid'],
                        "ub_msg"=>"来自用户：".uid2uname($v['cz_uid'])."(".$v['cg_title'].")",
                        "ub_money"=>($savedata['cz_day_money']*$val['lev_money']/100),
                        "ub_type"=>"2",
                        "ub_state"=>"1",
                        "ub_create_user"=>$v['cz_uid'],
                        "ub_update_user"=>$val['uid'],
                    ];
                }

            }
            if(!@$parentSaveData){
                $parentSaveData = [];
            }
            if(!@$countSaveData){
                $countSaveData = [];
            }
/*
            //dump($savedata);//用户日收益数据
            //dump($countdata);//用户日收益写记录库
            //dump($parentSaveData);//父级收益数据
           dump($countSaveData);//父级收益写数据库
		   dump("------------------------------------------------");
*/


            //$parentSaveData = array_unique($parentSaveData,SORT_REGULAR);
            Db::transaction(function () use ($savedata,$countdata,$parentSaveData,$countSaveData,$systemdata) {
                $a = Db::table('core_zichan')->update($savedata);
                $user = new \app\common\model\VipUser();
                foreach ($parentSaveData as $kk=>$vv){
                    //写之前判断一下，是否存在，存在则跳过
//                    if(!$user->where($vv)->count()){
                       $user->isUpdate(true)->save($vv);
//                    }
                }

                $bank = new \app\common\model\UserBank();
                if(!$systemdata){
                    $c = $bank->save($systemdata);
                }
                $c = $bank->save($countdata);
                foreach($countSaveData as $kk=>$vv){
                    //写之前判断一下，是否存在，存在则跳过
//                    if(!$bank->where($vv)->count()){
                        $d = $bank->save($vv);
//                    }
                }
            });

        }
        return true;
    }

    private function get_parent($recomm){
       $model = model("vip_user");
       $list = $model->field('v_id,v_re_recomm_code,v_recomm_code,v_money2')->select()->toArray();
        $moneyconfig = explode(";",config('mydefind.user_money'));
        $levconfig = explode(";",config('mydefind.user_lev'));
        $getconfig = explode(";",config('mydefind.user_get'));
        $config = [];
        foreach ($moneyconfig as $k=>$v){
            $config[$v] = $levconfig[$k];
        }
       //先找父级链条
        $userlist = [];
        foreach($list as $k=>$v){
            $v['getlev'] = 1;
            $userlist[$v['v_recomm_code']] = $v;
        }
        $this->getfulian($userlist,$recomm,[],$lev=0);
        $lian = $this->lian1;
        //新的，写死
        $returndata = [];
        foreach ($lian as $k=>$v){
            $zongzichan = $this->getUserZongzichan($v['v_id']);
            $index = $v['lev']-1;
            if($v['lev'] < 1){

            }else if($v['lev'] == 1){
                //有资格拿钱,且拿一代奖金
				if($zongzichan > 100){
					$returndata[] = [
						"lev_money"=>$getconfig[$index],
						"uid"=>$v['v_id'],
						"money"=>$v['v_money2'],
					];
				}
            }else if($v['lev'] > 6){
                
            }else{
                if($zongzichan >= 1000){
                    $returndata[] = [
                        "lev_money"=>$getconfig[$index],
                        "uid"=>$v['v_id'],
                        "money"=>$v['v_money2'],
                    ];
                }
            }
        }
        return $returndata;
    }


    private function getfulian($list,$recomm,$lian,$lev){
       //先把自己拿出来，附加到链上
        $user = $list[$recomm];
        $user['lev'] = $lev;
        $lian[] = $user;
        if($user['v_re_recomm_code'] != "#"){
            $this->getfulian($list,$user['v_re_recomm_code'],$lian,$lev+1);
        }else{
            $this->lian1 = $lian;
            return $lian;
        }
    }
}
