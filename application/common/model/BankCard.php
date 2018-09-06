<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class BankCard extends Model
{
	use SoftDelete;
    protected $pk = 'bc_id';
    protected $createTime = 'bc_create_time';
    protected $updateTime = 'bc_update_time';
    protected $deleteTime = 'bc_delete_time';

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