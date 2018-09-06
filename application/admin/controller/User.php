<?php
namespace app\admin\controller;

use app\admin\controller;
use app\admin\model;
use think\console\Input;

/*
 * 用户群组会员管理
 */

class User extends Base
{
    //添加会员
    public function add()
    {
        //获取数据字典中类型
        $v_type = $this->getDbCommonData("v_type");
        $this->assign("v_type",$v_type);
        //获取数据字典中性别
        $sex = $this->getDbCommonData("sex");
        $this->assign("sex",$sex);
        return view();
    }

    //根据邮箱获取邀请码
    public function checkemail()
    {
        $email = input("email");
        if($email == "#"){
            $this->success("#");
        }
        $model = model("vip_user");
        $data = $model->where(['v_email'=>$email])->find();
        if(!$data){
            $this->error("该邮箱尚未注册用户");
        }
        if($data['enable_flag'] != 1){
            $this->error("用户未激活");
        }else{
            $this->success($data['v_recomm_code']);
        }
    }

    //激活冻结账户
    public function able(){
        $type = input("type/d",0);
        $uid = input("uid/d",0);
        $model = model("vip_user");
        $data = $model->where(['v_id'=>$uid])->find();
        if(!$data){
            $this->error("E该用户不存在");
        }
        if($data['enable_flag'] == 1){
            //冻结
            if($model->where(['v_id'=>$uid,'enable_flag'=>1])->update(['enable_flag'=>2])){
                $this->success("S冻结成功");
            }else{
                $this->success("S冻结失败");
            }
        }else{
            //激活
            if($model->where(['v_id'=>$uid])->update(['enable_flag'=>1])){
                $this->success("S激活成功");
            }else{
                $this->success("S激活失败");
            }
        }
    }

    //用户信息数据获取
    public function getuserinfo(){
        $uid = input("uid/d",0);
        $this->checkId($uid);
        $model = model("vip_user");
        $data = $model->where(['v_id'=>$uid])->find();
        if(!$data){
            $this->error("用户不存在！");
        }
        return $data;
    }

    //用户信息修改执行
    public function editact(){
        $uid = input("uid/d",0);
        $this->checkId($uid);
        $data = [
            "v_id"=>$uid,
            "v_name"=>input("FullName"),
            "v_sex"=>input("Sex"),
            "v_tel"=>input("TelPhone"),
            "v_pwd1"=>input("LoginPassword"),
            "v_pwd2"=>input("BusinessPassword"),
            "v_card_id"=>input("IDCard"),
            "v_wechat"=>input("Webchat"),
            "v_alipay"=>input("Alipay"),
            "v_bank"=>input("AccountBank"),
            "v_bank_name"=>input("AccountName"),
            "v_card_num"=>input("BankCode"),
            "v_bank_address"=>input("BankAddress"),
            "v_address"=>input("ReceivingAddress"),
            "v_email"=>input("email"),
            "v_type"=>input("ClientLevel"),
            "v_qq"=>input("QQ"),
            "update_user"=>session("admin.u_id/d",0),
        ];
        $validate = validate("vip_user");
        if(!$validate->scene("edit")->check($data)){
            $this->error($validate->getError());
        }
        $vipuser = model("vip_user");
        if($vipuser->update($data)){
            $this->success("修改成功");
        }else{
            $this->error("修改失败");
        }
    }

    //用户信息查看
    public function listact(){
        $uid = input("uid/d",0);
        $this->checkId($uid);
        $model = model("vip_user");
        $data = $model->where(['v_id'=>$uid])->find();
        if(!$data){
            $this->error("用户不存在！");
        }
        //获取数据字典中类型
        $v_type = $this->getDbCommonData("v_type");
        $this->assign("v_type",$v_type);
        //获取数据字典中性别
        $sex = $this->getDbCommonData("sex");
        $this->assign("sex",$sex);
        $this->assign("data",$data);
        return view();
    }

    //删除用户页面
    public function deluser(){
        $uid = input("uid/d",0);
        $this->checkId($uid);
        $vipuser = model("vip_user");
        if($vipuser->destroy($uid)){
            $this->success("S删除成功");
        }else{
            $this->error("E删除失败");
        }
    }

    //检查手机号的唯一性
    public function checkphone(){
        $phone = input("phone");
        $model = model("vip_user");
        $count = $model->where(['v_tel'=>$phone])->count();
        if($count){
            $this->error("该手机号已经注册");
        }else{
            $this->success("该手机号可用");
        }
    }

    //检查邮箱的唯一性
    public function checkemailisone(){
        $email = input("email");
        $model = model("vip_user");
        $count = $model->where(['v_email'=>$email])->count();
        if($count){
            $this->error("该邮箱已经注册");
        }else{
            $this->success("该邮箱可用");
        }
    }

    //添加会员执行页面
    public function addact()
    {
        $data = [
            "v_vip_id"=>input("email"),
            "v_re_recomm_code"=>input("RecommendID"),
            "v_name"=>input("FullName"),
            "v_sex"=>input("Sex"),
            "v_tel"=>input("TelPhone"),
            "v_pwd1"=>input("LoginPassword"),
            "v_pwd2"=>input("BusinessPassword"),
            "v_card_id"=>input("IDCard"),
            "v_wechat"=>input("Webchat"),
            "v_alipay"=>input("Alipay"),
            "v_bank"=>input("AccountBank"),
            "v_bank_name"=>input("AccountName"),
            "v_card_num"=>input("BankCode"),
            "v_bank_address"=>input("BankAddress"),
            "v_address"=>input("ReceivingAddress"),
            "v_email"=>input("email"),
            "v_type"=>input("ClientLevel"),
            "v_qq"=>input("QQ"),
            "create_user"=>session("admin.u_id/d",0),
            "update_user"=>session("admin.u_id/d",0),
            "v_recomm_code"=>$this->createRecommCode(),
        ];
        $validate = validate("vip_user");
        if(!$validate->check($data)){
            $this->error($validate->getError());
        }
        $vipuser = model("vip_user");
        if($vipuser->save($data)){
            $this->success("添加成功");
        }else{
            $this->error("添加失败");
        }

    }

    //获取用户下级人数
    public function getUserNum($list,$countlist,$code)
    {
        $count = 0;
        foreach ($list as $v) {
            if($v['v_re_recomm_code'] == $code){
                ++$count;
                //获取它下面的邀请码，并递归
                $recomm = $v['v_recomm_code'];
                if(@$countlist[$recomm]){
                    $count += $this->getUserNum($list,$countlist,$recomm);
                }
            }
        }
        return $count;
    }

    //获取团队管理树数据组合页面
    public function getUserLevTree()
    {
        $v_vip_id = input("ClientID",null);
        $vipuser = model("vip_user");
        $list = $vipuser->select()->toArray();
        foreach ($list as $k=>$v){
            $recommlist[$v['v_recomm_code']] = $v;
        }
        if($v_vip_id){
            foreach (array_reverse($list) as $k=>$v){
                if(substr_count($v['v_name'],$v_vip_id)){
                    $comm = $v['v_recomm_code'];
                }
            }
            $tree = [];
            $ownarr[0] = $recommlist[$comm];
            $ownarr[0]['lev'] = 0;
            $ownarr[0]['parent'] = "#";
            $tree = array_merge($tree,$this->getUserTree($list, $comm, $recommlist[$comm]['v_id'], 1));
            $tree = array_merge($ownarr,$tree);
        }else{
            $tree = $this->getUserTree($list, "#", "#", 1);
        }
        $countlist = [];
        foreach($list as $v){
            $countlist[] = $v['v_re_recomm_code'];
        }
        $count = array_count_values($countlist);
        $returndata = [];
        $commdata = $this->encodeCommonData($this->getDbCommonData("v_type"));
        foreach ($tree as $v) {
            $returndata[] = [
                "id" => $v['v_id'],
                "parent" => $v['parent'],
                "fullname" => $v['v_name'],
                "count" => $this->getUserNum($list,$count,$v['v_recomm_code']),
                "parentcount" => $v['lev']-1,
                "createdata" => $v['create_time'],
                "clientlevel" => $commdata[$v['v_type']],
            ];
        }


        return $returndata;
    }

    //用户管理
    public function list()
    {
        $vid = input("v_vip_id","");
        $uname = input("v_name","");
        $where = [];
        if($vid){
            $where[] = ["v_vip_id","like","%$vid%"];
        }

        if($uname){
            $where[] = ["v_name","like","%$uname%"];
        }
        if(!$where){
            $where['delete_time'] = NUll;
        }
        $vip_user = model("vip_user");
        $userlist = $vip_user->where($where)->fetchSql(false)->paginate(config("mydefind.pagenum"));
        $dbcomm = $this->encodeCommonData($this->getDbCommonData("v_type"));
        foreach ($userlist as $k=>$v){
            $userlist[$k]['v_type'] = $dbcomm[$v['v_type']]??"";
            $userlist[$k]['v_recomm'] = recomm2uname($v['v_re_recomm_code']);
            $userlist[$k]['zongzichan'] = $this->getUserZongzichan($v['v_id']);
        }
        $this->assign("userlist",$userlist);
        //获取用户级别
        $usertype = $this->encodeCommonData($this->getDbCommonData("v_type"));
        $this->assign("usertype",$usertype);
        return view();
    }

    //修改用户密码
    public function editpwd(){
        $type = input("Type/d",0);
        $pwd = input("Pwd","");
        $id = input("ClientID/d",0);
        if(!in_array($type,array(1,2))){
            $this->error("E密码类型错误");
        }
        if(!$pwd){
            $this->error("E密码不可为空");
        }
        $this->checkId($id);
        if($type == 1){
            $data = [
                "v_id"=>$id,
                "v_pwd1"=>$pwd,
            ];
        }else{
            $data = [
                "v_id"=>$id,
                "v_pwd2"=>$pwd,
            ];
        }
        $vipuser = model("vip_user");
        if($vipuser->update($data)){
            $this->success("S修改成功");
        }else{
            $this->error("E修改失败");
        }

    }
    //修改用户类型
    public function edittype(){
        $id = input("ClientID/d",0);
        $type = input("ClientLevel/d",0);
        if(!$type){
            $this->error("E用户类型不可为空");
        }
        $this->checkId($id);
        $data = [
            "v_id"=>$id,
            "v_type"=>$type,
        ];
        $vipuser = model("vip_user");
        if($vipuser->update($data)){
            $this->success("S修改成功");
        }else{
            $this->error("E修改失败");
        }
    }

    //跳转用户前台页面
    public function home(){
        $id = input('id/d',0);
        $data = model("vip_user")->find($id);
        if(!$data){
            $this->error("参数错误");
        }
        $sessiondata = [
            "uid"=>$data['v_id'],
            "email"=>$data['v_email'],
            "vip_id"=>$data['v_vip_id'],
            "vip_id"=>$data['v_vip_id'],
            "uname"=>$data['v_name'],
        ];
        session("home",$sessiondata);
        $this->success("成功","/index.php/index/index");
    }

    //ajax角色信息查询页面
    public function GetRoleInfo()
    {
        $id = input("RoleCode/d",0);
        $this->checkId($id);
        $role = model("user_role");
        $info = $role->where(['ur_id'=>$id])->find();
        $treemodel = model("user_role_function");
        $treelist = $treemodel->where(array('role_code'=>$info['ur_id']))->select();
        $tree = [];
        foreach($treelist as $k=>$v){
            $tree[] = ['RoleCode'=>$v['role_code'],"FunctionCode"=>"F".$v['function_code']];
        }
        $data = [
            "RoleCode"=>$info['role_code'],
            "RoleName"=>$info['role_name'],
            "Remark"=>$info['ur_remark'],
            "TreeData"=>$tree,
        ];
        return $data;
    }

    //角色管理列表
    public function modulelist()
    {
        //获得当前表内自增字段
        $module = model("user_role");
        $nowid = $module->order(array("ur_id"=>"desc"))->find();
        $nowid = $nowid['ur_id']??1;
        $nowid += 1000000000;
        $nowid = "R".time().substr($nowid,-6);
        $this->assign("nowid",$nowid);
        session("rolecode",$nowid);
        $role = model("user_role");
        $rolelist = $role->paginate(config('mydefind.pagenum'));
        $this->assign("rolelist",$rolelist);
        return view();
    }

    //查询所有模块功能树
    public function getModuleTree()
    {
        $modulelist = $this->getLeftMenu();
        $returnData = [];
        foreach($modulelist as $k=>$v){
            $returnData[] = array(
                "ID" => "M".$v['code'],
                "NAME" =>$v['title'],
                "PID" =>"#"
            );
            foreach($v['data'] as $key=>$val){
                $returnData[] = array(
                    "ID"=>"F".$val['function_code'],
                    "NAME"=> $val['function_name'],
                    "PID"=>"M".$v['code'],
                );
            }
        }
        return $returnData;
    }


    //添加角色执行页面
    public function addroleact()
    {
        $data = [
            "ur_remark" => input("Remark"),
            "role_code" => session("rolecode"),
            "role_name" => input("RoleName"),
            "update_time" => time(),
            "update_user" => session("admin.u_id"),
            "create_time" => time(),
            "create_user" => session("admin.u_id"),
        ];
        session("rolecode");
        $tree = input("Tree");
        $validate=validate("UserRole");
        if(!$validate->check($data)){
            $this->error($validate->getError());
        }
        $role = model("UserRole");
        $rolecode = $role->insertGetId($data);
        if(!$rolecode){
            $this->error("E添加失败");
        }else{
            //写权限树
            foreach($tree as $k=>$v){
                if(substr($v,0,1) == "F"){
                    $treedata[] = ["role_code"=>$rolecode,"function_code"=>substr($v,1),"update_time" => time(),"create_time" => time()];
                }
            }
            $treemodel = model("UserRoleFunction");
            if($treemodel->insertAll($treedata)){
                $this->success("S添加成功");
            }else{
                $this->success("W角色权限添加失败");
            }
        }
    }

    //修改角色执行页面
    public function editroleact()
    {
        $data = [
            "ur_remark" => input("Remark"),
            "role_code" => input("RoleCode"),
            "role_name" => input("RoleName"),
            "update_time" => time(),
            "update_user" => session("admin.u_id"),
        ];
        $tree = input("Tree");
        $validate=validate("UserRole");
        if(!$validate->check($data)){
            $this->error($validate->getError());
        }
        $role = model("UserRole");
        $rolecode = $role->where(['role_code'=>$data['role_code']])->update($data);
        if(!$rolecode){
            $this->error("E修改失败");
        }else{
            //修改权限树,先全部软删除
            //获取id
            $role_id = $role->where(['role_code'=>$data['role_code']])->find();
            $role_id = $role_id['ur_id'];
            $treemodel = model("UserRoleFunction");
            //查询主键
            $idsarray = $treemodel->where(['role_code'=>$role_id])->field("urf_id")->select();
            if(!$idsarray){
                foreach($idsarray as $v){
                    $ids[] = $v['urf_id'];
                }
                $treelist = $treemodel->destroy($ids);//全部软删除，然后再去添加
            }
            //直接增加
            foreach($tree as $k=>$v){
                if(substr($v,0,1) == "F"){
                    $treedata[] = ["role_code"=>$role_id,"function_code"=>substr($v,1),"update_time" => time(),"create_time" => time()];
                }
            }
            $treemodel = model("UserRoleFunction");
            if($treemodel->insertAll($treedata)){
                $this->success("S修改成功");
            }else{
                $this->success("W角色权限修改失败");
            }
        }
    }

    //删除角色信息页面
    public function delroleact(){
        $id = input("RoleCode");
        $this->checkId($id);
        $role = model("UserRole");
        if(!$role->destroy($id)){
            $this->error("E删除失败");
        }else{
            //修改权限树,先全部软删除
            $treemodel = model("UserRoleFunction");
            //查询主键
            $idsarray = $treemodel->where(['role_code'=>$id])->field("urf_id")->select();
            if($idsarray){
                foreach($idsarray as $v){
                    $ids[] = $v['urf_id'];
                }
                if($treemodel->destroy($ids)){
                    $this->success("S删除成功");
                }else{
                    $this->error("W删除成功");
                }
            }else{
                $this->success("S删除成功");
            }
        }
    }


    //用户信息管理
    public function adminuser()
    {
        //获取角色列表
        $role = model("user_role");
        $rolelist = $role->field("ur_id,role_name")->select();
        $this->assign("rolelist",$rolelist);
        //获取用户列表
        $user = model("user");
        $userlist = $user->alias('u')->join('user_role r','u.role_code = r.ur_id')->fetchSql(false)->paginate(config('mydefind.pagenum'));
        $this->assign("userlist",$userlist);
        return view();
    }

    //添加用户执行页面
    public function addadminact()
    {
        $data = [
            "user_email"=>input("Email"),
            "Password"=>input("Password1"),
            "Password2"=>input("Password2"),
            "u_remark"=>input("Remark"),
            "role_code"=>input("RoleCode"),
            "user_tel"=>input("Tel"),
            "user_id"=>input("UserID"),
            "user_name"=>input("UserName"),
            "create_user" => session("admin.u_id"),
            "update_user" => session("admin.u_id"),
            "enable_flag"=>0,
        ];

        $validate = validate("User");
        if(!$validate->check($data)){
            $this->error("E".$validate->getError());
        }

        $user = model("user");
        if($user->save($data)){
            $this->success("S添加成功");
        }else{
            $this->error("E添加失败");
        }


    }

    //编辑用户执行页面
    public function editadminact()
    {
        $id = input("Uid/d",0);
        $this->checkId($id);
        $data = [
            "u_id"=>$id,
            "user_email"=>input("Email"),
            "u_remark"=>input("Remark"),
            "role_code"=>input("RoleCode"),
            "user_tel"=>input("Tel"),
            "user_name"=>input("UserName"),
            "update_user" => session("admin.u_id"),
        ];

        $validate = validate("User");
        if(!$validate->scene("edit")->check($data)){
            $this->error("E".$validate->getError());
        }

        $user = model("user");
        if($user->update($data)){
            $this->success("S修改成功");
        }else{
            $this->error("E修改失败");
        }
    }

    //删除用户执行页面
    public function deladminact()
    {
        $id = input("UserID/d",0);
        $this->checkId($id);
        $user = model("user");
        if($user->destroy($id)){
            $this->success("S删除成功");
        }else{
            $this->error("E删除失败");
        }
    }

    //设置用户状态执行页面
    public function setadminable()
    {
        $id = input("UserID/d",0);
        $this->checkId($id);
        $data = [
            "u_id"=>$id,
            "enable_flag"=>input("EnableFlag/d",0),
        ];
        $user = model("user");
        if($user->update($data)){
            $this->success("S操作成功");
        }else{
            $this->error("E操作失败");
        }
    }

    //获取用户状态
    public function getadmininfo()
    {
        $id = input("UserID/d",0);
        $this->checkId($id);
        $user = model("user");
        $info = $user->find($id);
        $returndata = [
            "Uid"=>$info['u_id'],
            "UserID"=>$info['user_id'],
            "UserName"=>$info['user_name'],
            "Tel"=>$info['user_tel'],
            "Email"=>$info['user_email'],
            "RoleCode"=>$info['role_code'],
            "Remark"=>$info['u_remark'],
        ];
        return $returndata;

    }

    //修改用户密码
    public function changepwd()
    {
        //获取用户列表
        $user = model("user");
        $userlist = $user->field("u_id,user_name")->select();
        $this->assign("userlist",$userlist);
        return view();
    }

    //修改用户密码执行页面
    public function changepwdact()
    {
        $uid = input("UserID/d",0);
        $this->checkId($uid);
        $pwd1 = input("OldPassword1","");
        $pwd2 = input("Password1","");
        if($pwd1 == $pwd2){
            $this->error("新密码与旧密码不可以一致");
        }
        $user = model("user");
        if(!$user->where(['u_id'=>$uid,"Password"=>$pwd1])->find()){
            $this->error("密码错误");
        }
        //修改密码
        if($user->where(['u_id'=>$uid])->update(['Password'=>$pwd2])){
            $this->success("修改成功");
        }else{
            $this->error("修改失败");
        }
    }

    //登录
    public function login()
    {
        return view();
    }

    //登录执行页面
    public function loginact()
    {
        $data['user_id'] = input("user_id");
        $data['Password'] = input("Password");
        $user = model("user");
        $userdata = $user->where($data)->field("u_id,user_id,user_name,enable_flag")->find();
        if(!$userdata){
            $this->error("登录失败");
        }else{
            $userdata = $userdata->toArray();
            if($userdata['enable_flag'] != 1){
                $this->error("当前用户未激活");
            }
            unset($userdata['enable_flag']);
            $userdata['login_time'] = time();
            session("admin",$userdata);
            $sessionid = session_id();
            $user->where(['u_id'=>$userdata['u_id']])->update(['last_login_session_id'=>$sessionid]);
            $this->success("登录成功","Index/index");
        }
    }

    //退出登录
    public function logout()
    {
        session("admin",null);
        $this->success("退出成功","User/login");
    }

    //会员树
    public function usertree()
    {
        return view();
    }

    //会员收益
    public function usermoney()
    {
        return view();
    }
}
