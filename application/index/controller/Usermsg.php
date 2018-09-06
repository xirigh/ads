<?php

namespace app\index\controller;

use app\index\controller;
use app\index\model;

class Usermsg extends Base
{
	//添加留言页面
	public function add()
	{
		return view();
	}
	
	//添加留言执行页面
	public function addact(){
		$data = input();
		if(@$_FILES['um_file']['size']){
			//有文件上传，传一下吧
			$file = request()->file('um_file');
			$maxsize = config("mydefind.upload_max_size_rar");
			$maxsize = $maxsize*1024*1024; 
		    $info = $file->validate(['size'=>$maxsize,'ext'=>'jpg,gif,png,jpeg,zip,rar,7z'])->move( './uploads/msg');
		    if($info){
		        $data['um_file'] = $info->getSaveName();
		    }else{
		        $this->error($file->getError());
		    }
		}
		$uid = session("home.uid");
		$data['um_uid'] = $uid;
		$data['um_state'] = 1;
		$data['create_user'] = $uid;
		$data['update_user'] = $uid;
		$validate = validate("Usermsg");
		if (!$validate->scene('add')->check($data)) {
        	$this->error($validate->getError());
        }
		$usermsg = model("usermsg");
		if($usermsg->save($data)){
			$this->success("发布成功");
		}else{
			$this->error("发布失败！");
		}
	}
}
