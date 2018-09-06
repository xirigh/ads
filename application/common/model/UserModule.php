<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class UserModule extends Model
{
	use SoftDelete;
	protected $pk = 'um_id';


}