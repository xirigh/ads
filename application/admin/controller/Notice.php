<?php
namespace app\admin\controller;

use app\admin\controller;
use app\admin\model;
/*
 * 系统公告功能实现
 */

class Notice extends Base
{
	
	//生成公告编号
	protected function create_rand(){
		$num = date("YmdHis",time()).rand(100000,999999);
		$notice = model("notice");
		if($notice->where(['n_code'=>$num])->count()){
			$this->create_rand();
		}else{
			return $num;
		}
	}
	//系统公告发布
    public function add()
    {
    	//生成公告编号
    	$n_code = $this->create_rand();
		$this->assign("noticecode",$n_code);
		//写入session
		//session("noticecode",$n_code);
		$nlev = $this->getDbCommonData('n_lev');
		$this->assign("nlev",$nlev);
    	return view();
    }
	
	//上传图片
	public function upimg()
	{
	    $file = request()->file('file');
        $maxsize = config("mydefind.upload_max_size_rar");
        $maxsize = $maxsize*1024*1024;
        $info = $file->validate(['size'=>$maxsize,'ext'=>'jpg,gif,png,jpeg'])->move( './uploads/notice');
	    if($info){
	        echo $info->getSaveName();
	    }else{
	        echo $file->getError();
	    }
	}
	
	//系统公告发布执行
	public function addact()
	{
		//组合数据
    	$n_code = $this->create_rand();
		$data = [
			"n_code" => $n_code,
			"n_lev" => input("NewsIco"),
			"n_title" => input("Title"),
			"n_desc" => input("Description"),
			"n_content" => input("Content"),
            "create_user"=>session("admin.u_id"),
            "update_user"=>session("admin.u_id"),
		];
		session("noticecode",null);
		$validate = validate("Notice");
		if (!$validate->check($data)) {
        	$this->error($validate->getError());
        }
		//验证成功
		$notice = model("Notice");
		if($notice->save($data)){
			$this->success("S保存成功！");
		}else{
			$this->error("E保存失败！");
		}
	}
	
	//系统公告列表
	public function list()
	{
		$notice = model("Notice");
		$common_data = $this->encodeCommonData($this->getDbCommonData("n_lev"));
		$list = $notice
//            ->join("__USER__","notice.create_user = user.u_id")
            ->paginate(config('mydefind.pagenum'));
		foreach($list as $k=>$v){
			$list[$k]['n_lev_title'] = $common_data[$v['n_lev']];
		}
		$this->assign('list',$list);
		return view();
	}
	
	//系统公告查看
	public function show()
	{
		$id = input('id/d',0);
		$this->checkId($id);
		$notice = model("Notice");
		$common_data = $this->encodeCommonData($this->getDbCommonData("n_lev"));
		$data = $notice->where(array('n_id'=>$id))->find();
		$data['n_lev'] = $common_data[$data['n_lev']];
		$this->assign("data",$data);
		return view();
	}
	
	//系统公告编辑
	public function edit()
	{
		$id = input('id/d',0);
		$this->checkId($id);
		$this->assign("editid",$id);
		$notice = model("Notice");
		$common_data = $this->encodeCommonData($this->getDbCommonData("n_lev"));
		$data = $notice->where(array('n_id'=>$id))->alias('n')->find();
		$data['n_lev_name'] = $common_data[$data['n_lev']];
		$this->assign("data",$data);
		$nlev = $this->getDbCommonData('n_lev');
		$this->assign("nlev",$nlev);
		return view();
	}
	
	//系统公告编辑执行
	public function editact()
	{
		$id = input('editid/d',0);
		$this->checkId($id);
		//组合数据
		$data = [
			"n_lev" => input("NewsIco"),
			"n_title" => input("Title"),
			"n_desc" => input("Description"),
			"n_content" => input("Content"),
            "update_user"=>session("admin.u_id"),
        ];
		$validate = validate("Notice");
		if (!$validate->scene('edit')->check($data)) {
        	$this->error($validate->getError());
        }
		//验证成功
		$notice = model("Notice");
		if($notice->where(array('n_id'=>$id))->update($data)){
			$this->success("S保存成功！");
		}else{
			$this->error("E保存失败！");
		}
	}
	
	//系统公告删除执行页面
	public function del()
	{
		$id = input('n_id/d',0);
		$this->checkId($id);
		$notice = model("Notice");
		if($notice->destroy($id)){
			$this->success("S删除成功!");
		}else{
			$this->error("E系统繁忙!");
		}
	}
}
