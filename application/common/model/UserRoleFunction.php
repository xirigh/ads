<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class UserRoleFunction extends Model
{
	use SoftDelete;
	protected $pk = 'urf_id';


}