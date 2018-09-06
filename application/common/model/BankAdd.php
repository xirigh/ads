<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class BankAdd extends Model
{
	use SoftDelete;
    protected $pk = 'ba_id';
    protected $createTime = 'ba_create_time';
    protected $updateTime = 'ba_update_time';
    protected $deleteTime = 'ba_delete_time';

	// 读取器
	protected function getBaStateTextAttr($value,$data)
	{
		switch ($data['ba_state']){
            case "0":
                return "待审核";
                break;
            case "1":
                return "充值成功";
                break;
            case "2":
                return "审核失败";
                break;
            case "3":
                return "等待打款";
                break;
            case "4":
                return "打款超时";
                break;
            default:
                return "未知状态";
                break;
        }
	}
//	
//	protected function getAContentAttr($value,$data)
//	{
//		return htmlspecialchars_decode($data['a_content']);
//	}
//	
//	// 修改器
//	protected function setAAddTimeAttr()
//	{
//		return time();
//	}
//	
//	protected $insert = ['a_add_time'];

}