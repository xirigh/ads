<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class User extends Model
{
	use SoftDelete;
	protected $pk = 'u_id';
	
	public function getEditTimeAttr($value,$data)
    {
        return $data['update_time'];
    }

}