<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class CoreGoods extends Model
{
	use SoftDelete;
    protected $pk = 'cg_id';
    protected $createTime = 'cg_create_time';
    protected $updateTime = 'cg_update_time';
    protected $deleteTime = 'cg_delete_time';

    // 读取器
    protected function getCgMoneyAttr($value,$data)
    {
        return encodemoney($value/100);
    }

    protected function getCgDayAttr($value,$data)
    {
        return $value/100;
    }

    protected function getCgBeishuAttr($value,$data)
    {
        return $value/100;
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