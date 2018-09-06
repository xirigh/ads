<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Notice extends Model
{
	use SoftDelete;
	protected $pk = 'n_id';
	
//	// 读取器
//	protected function getAAddTimeAttr($value,$data)
//	{
//		return date('Y-m-d', $data['a_add_time']);
//	}
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