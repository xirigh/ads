<?php
namespace app\admin\controller;

use app\admin\controller;
use app\admin\model;
/*
 * 用户留言功能实现
 */
 
class Usermsg extends Base
{
	//留言列表
	public function list()
	{
		$data = input();
		$where['v.delete_time'] = null;
		
		if(@$data['um_state']){
			$where['um_state'] = $data['um_state'];
		}
		//暂时无法使用
//		if(@$data['uname']){
//			$where['uname'] = array("like"=>"%{$data['uname']}%");
//		}
		
		$msg = model("Usermsg");
		$list = $msg->where($where)->alias("u")->join("vip_user v","u.um_uid = v.v_id")->field("u.*,v.v_vip_id")->paginate(config("mydefind.pagenum"));
		//查询数据字典
		$um_type = $this->encodeCommonData($this->getDbCommonData("um_type"));
		$um_state = $this->encodeCommonData($this->getDbCommonData("um_state"));
		foreach($list as $k=>$v){
			$list[$k]['um_type'] = $um_type[$v['um_type']];
			$list[$k]['um_state'] = $um_state[$v['um_state']];
		}
		$this->assign("list",$list);
		$this->assign("um_type",$um_type);
		$this->assign("um_state",$um_state);
		return view();
	}
	
	//留言查看
	public function show()
	{
		$id = input("id/d",0);
		$this->checkId($id);
		$msg = model("Usermsg");
		$data = $msg->where(array('um_id'=>$id))->alias("u")->join("vip_user v","u.um_uid = v.v_id")->field("u.*,v.v_vip_id")->find();
		$um_type = $this->encodeCommonData($this->getDbCommonData("um_type"));
		$um_state = $this->encodeCommonData($this->getDbCommonData("um_state"));
		$data['um_type'] = $um_type[$data['um_type']];
		$data['um_state'] = $um_state[$data['um_state']];
		$this->assign("data",$data);
		return view();
	}
	
	//留言回复
	public function re()
	{
		$id = input('um_id/d',0);
		$this->checkId($id);
		$uid = 1;
		$data = array(
			"um_re_content" => input("um_re_content",""),
			"um_re_time" => time(),
			"um_state"=>2,
			"um_re_uid"=>$uid,
		);
		$validate = validate("Usermsg");
		if (!$validate->scene('re')->check($data)) {
        	$this->error($validate->getError());
        }
		$msg = model("Usermsg");
		if($msg->where(array('um_id'=>$id))->update($data)){
			$this->success("回复成功");
		}else{
			dump($msg->_sql());
			$this->error("系统忙碌");
		}
	}
}
