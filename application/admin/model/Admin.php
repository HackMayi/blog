<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/27
 * Time: 16:26
 */
namespace app\admin\model;

use app\admin\validate\AdminValidate;
use think\Exception;
use think\Model;
use think\Session;

class Admin extends Model
{
    public static $fields = 'id,uname,last_login_time,last_login_ip,status,create_at,update_at,email';

    public static function getLists($where = array())
    {
        $result = array();
        $users = self::where($where)->field(self::$fields)->select();
        if (!empty($users)) {
            $auth = new Auth();
            foreach ($users as $user) {
                $u_role = $auth->roleGetUser($user['id']);
                if (!is_null($u_role)) {
                    $role = $auth->getRole($u_role->role_id);
                    $user['role_name'] = $role['name'];
                } else {
                    $user['role_name'] = '';
                }
                $result[] = $user;
            }
        }
        return $result;
    }

    /**
     * 验证登录
     * @param array $param
     * @throws Exception
     */
    public function checkLogin($param = array())
    {
        $validate = new AdminValidate();
        if (!$validate->scene('login')->check($param)) throw new Exception($validate->getError());
        $user = $this->where('uname',$param['uname'])->find();
        if (empty($user) || $user->password !== md5($param['password'])) throw new Exception('用户名或密码不正确');
        if ($user->status) throw new Exception('用户已被禁用');
        $this->setLogin($user);
    }

    /**
     * 设置登录状态
     * @param array $user
     * @throws Exception
     */
    public function setLogin($user = array())
    {
        if (empty($user)) throw new Exception('缺少用户信息');
        Session::set('uid',$user['id']);
        Session::set('username',$user['uname']);
    }

    public static function encryption($pwd,$type = '')
    {
        return md5($pwd);
    }
}