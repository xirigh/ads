<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class UserRole extends Model
{
	use SoftDelete;
	protected $pk = 'ur_id';


}