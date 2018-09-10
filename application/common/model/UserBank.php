<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class UserBank extends Model
{
	use SoftDelete;
	protected $pk = 'ub_id';
    protected $deleteTime = 'ub_delete_time';
    protected $createTime = 'ub_create_time';
    protected $updateTime = 'ub_update_time';

    // 读取器
    protected function getUbTypeAttr($value,$data)
    {
        switch ($value){
            case "1":
                return "系统操作";
                break;
            case "2":
                return "动态分红";
                break;
            case "3":
                return "静态分红";
                break;
            case "4":
                return "购买基金";
                break;
            case "5":
                return "提现";
                break;
            case "6":
                return "资产券转出";
                break;
            case "7":
                return "资产券转入";
                break;
            case "8":
                return "系统自动兑换资产券";
                break;
            default:
                break;
        }
    }
    protected function getUbStateAttr($value,$data)
    {
        switch ($value){
            case "0":
                return "待审核";
                break;
            case "1":
                return "已完成";
                break;
            case "2":
                return "审核失败";
                break;
            default:
                return "";
                break;
        }
    }

}