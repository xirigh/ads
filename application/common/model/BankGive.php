<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class BankGive extends Model
{
	use SoftDelete;
    protected $pk = 'bg_id';
    protected $createTime = 'bg_create_time';
    protected $updateTime = 'bg_update_time';
    protected $deleteTime = 'bg_delete_time';

    // 读取器
    protected function getBgMoneyNameAttr($value,$data)
    {
        return ($data['bg_type'] == 1)?"开户金":"余额";
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