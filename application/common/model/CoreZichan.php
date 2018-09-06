<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class CoreZichan extends Model
{
	use SoftDelete;
    protected $pk = 'cz_id';
    protected $createTime = 'cz_create_time';
    protected $updateTime = 'cz_update_time';
    protected $deleteTime = 'cz_delete_time';

    // 读取器
    protected function getCzStateTextAttr($value,$data)
    {
        switch ($data['cz_state']){
            case "0":
                return "分红中";
                break;
            case "1":
                return "已结束";
                break;
            default:
                return "状态码未定义";
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