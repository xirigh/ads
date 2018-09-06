<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class CoreOrder extends Model
{
	use SoftDelete;
    protected $pk = 'co_id';
    protected $createTime = 'co_create_time';
    protected $updateTime = 'co_update_time';
    protected $deleteTime = 'co_delete_time';

    // 读取器
    protected function getCoStateAttr($value,$data)
    {
        switch ($value){
            case "0":
                return "等待中";
                break;
            case "1":
                return "分红中";
                break;
            case "2":
                return "已结束";
                break;
            case "3":
                return "已转出";
                break;
            default:
                return "状态码未定义";
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