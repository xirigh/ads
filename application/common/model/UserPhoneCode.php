<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class UserPhoneCode extends Model
{
	use SoftDelete;
    protected $pk = 'upc_id';
    protected $createTime = 'upc_create_time';
    protected $updateTime = 'upc_update_time';
    protected $deleteTime = 'upc_delete_time';

}