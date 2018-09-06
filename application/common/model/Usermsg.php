<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class UserMsg extends Model
{
	use SoftDelete;
	protected $pk = 'um_id';

    protected function getStateAttr($value,$data)
    {
        return ($data['um_state'] == 1)?"未回复":"已回复";
    }
}
