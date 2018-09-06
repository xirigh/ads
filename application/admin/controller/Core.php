<?php
namespace app\admin\controller;

class Core extends Base
{
    public function index()
    {
    	return view();
    }

    //证券列表
    public function goods(){
        $model = model("core_goods");
        $list = $model->select();
        $this->assign("list",$list);
        return view();
    }

    //证券查看修改页面
    public function goodsshow(){
        $data = input();
        $id = $data['id'];
        $model = model("core_goods");
        $data = $model->where(['cg_id'=>$id])->find();
        if(!$data){
            $this->error("暂无数据");
        }else{
            return $data;
        }
    }

    //证券修改页面
    public function edit(){
        $data = [
            "cg_id"=>input("cg_id"),
            "cg_title"=>input("cg_title"),
            "cg_money"=>input("cg_money")*100,
            "cg_day"=>input("cg_day")*100,
            "cg_beishu"=>input("cg_beishu")*100,
        ];
        if(@$_FILES['cg_img']['size']){
            $file = request()->file('cg_img');
            $info = $file->move( './uploads/core');
            if($info){
                $data['cg_img'] =  $info->getSaveName();
            }else{
                $this->error($file->getError());
            }
        }
        $vali = validate("core_goods");
        if(!$vali->check($data)){
            $this->error($vali->getError());
        }
        $model = model("core_goods");
        $rs = $model->update($data);
        if($rs){
            $this->success("修改成功");
        }else{
            $this->error("修改失败");
        }
    }

    //证券交易列表
    public function list(){
        //获取交易内容
        $model = model("core_order");
        $list = $model->order(["co_create_time"=>"desc"])->alias("o")->join("core_goods g","g.cg_id = o.co_cg_id")->join('vip_user v','v.v_id = o.co_uid')->field("o.*,g.*,v.v_vip_id,v.v_id,v.v_email")->paginate(config("mydefind.pagenum"));
//        dump($list->toArray());exit;
        $this->assign("list",$list);
        return view();
    }

    //交易明细
    public function jiaoyi(){
        $model = model("user_bank");
        $list = $model->order(["ub_create_time"=>"desc"])->alias("o")->join('vip_user u','o.ub_uid = u.v_id')->field("o.*,u.v_email")->paginate(config("mydefind.pagenum"));
        $this->assign("list",$list);
        return view();
    }


}
