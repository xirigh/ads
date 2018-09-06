<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class VipUser extends Model
{
	use SoftDelete;
	protected $pk = 'v_id';

    public function getVStateAttr($value,$data)
    {
        if($data['enable_flag'] == 1){
            return "已激活";
        }else if($data['enable_flag'] == 2){
            return "已冻结";
        }else{
            return "未激活";
        }
    }

}