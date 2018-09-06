<?php
namespace app\admin\controller;
use think\helper\Time;
class Index extends Base
{
    
    public function index()
    {

        //获取今日注册数
        $daynum = model("vip_user")->whereTime('create_time', 'today')->count();
        $mounum = model("vip_user")->whereTime('create_time', 'month')->count();
        $jihuonum = model("vip_user")->where(['enable_flag'=>0])->count();
        $this->assign("daynum",$daynum);
        $this->assign("mounum",$mounum);
        $this->assign("jihuonum",$jihuonum);
    	return view();
    }

    public function getlineimg(){
        $usernum = [];
        list($start, $end) = Time::today();
        $user = model("vip_user");
        for($i=0;$i<7;$i++){
            $endtime = $end-(24*3600*$i);
            //查询当天的用户注册量
            $num =$user->whereBetweenTime('create_time', $endtime-(24*3600), $endtime)->count();
            $timedata[] = date("Y-m-d",$endtime);
            $userdata[] = $num;
        }
        $timedata[0] = "今天";
        $timedata = $a = array_reverse($timedata);
        $userdata = $a = array_reverse($userdata);
        $data = [
            "labels"=>$timedata,
            "datasets"=>[[
                "label"=>"新注册用户数量",
                "fill"=>false,
                "lineTesion"=>0.1,
                "backgroundColor"=>"rgba(75,192,192,0.4)",
                "borderColor"=>"rgba(75,192,192,1)",
                "borderCapStyle"=>"butt",
                "borderDash"=>[],
                "borderDashOffset"=>0,
                "borderJoinStyle"=>"miter",
                "pointBorderColor"=>"",
                "pointBackgroundColor"=>"rgba(255,255,255,1)",
                "pointBorderWidth"=>1,
                "pointHoverRadius"=>5,
                "pointHoverBackgroundColor"=>"rgba(75,192,192,1)",
                "pointHoverBorderColor"=>"rgba(220,220,220,1)",
                "pointHoverBorderWidth"=>2,
                "pointRadius"=>1,
                "pointHitRadius"=>10,
                "spanGaps"=>false,
                "data"=>$userdata,
            ]]
        ];
//        $timestr = "";
//        foreach ($timedata as $v){
//            $timestr .= '"'. $v . '",';
//        }
//        $datastr = "";
//        foreach ($userdata as $v){
//            $datastr .= $v . ',';
//        }
//        $data = '{"labels":['. $timestr .'],"datasets":[{"label":"\u65b0\u6ce8\u518c\u7528\u6237\u6570\u91cf","fill":false,"lineTension":0.1,"backgroundColor":"rgba(75,192,192,0.4)","borderColor":"rgba(75,192,192,1)","borderCapStyle":"butt","borderDash":[],"borderDashOffset":0,"borderJoinStyle":"miter","pointBorderColor":"","pointBackgroundColor":"#fff","pointBorderWidth":1,"pointHoverRadius":5,"pointHoverBackgroundColor":"rgba(75,192,192,1)","pointHoverBorderColor":"rgba(220,220,220,1)","pointHoverBorderWidth":2,"pointRadius":1,"pointHitRadius":10,"data":['. $datastr .'],"spanGaps":false}]};';
        return $data;
    }

    //清理数据库
    public function clear(){

    }

}
