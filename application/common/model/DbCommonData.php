<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class DbCommonData extends Model
{
	use SoftDelete;
	protected $pk = 'c_id';


}