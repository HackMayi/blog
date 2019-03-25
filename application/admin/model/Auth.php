<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/11
 * Time: 14:31
 */

namespace app\admin\model;


use think\Db;
use think\Model;
use think\Validate;

class Auth extends Model
{
    protected $createTime = 'create_at';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;
    public static $rule_table = 'auth_menus';#规则表
    public static $role_table = 'auth_role';#角色表
    public static $rule_and_role = 'auth_rule';#角色对应规则
    public static $role_and_user = 'auth_assignment';#角色对应用户

    public function getRuleList()
    {
        $this->setTable(self::$rule_table);
        return $this->order('name','asc')->select();
    }

    /**
     * 新增路由
     * @param $url
     * @param string $name
     * @return mixed
     */
    public function createRule($url,$name = '')
    {
        $this->setTable(self::$rule_table);
        $this->save(array(
            'name' => $url
            ,'description' => $name
        ));
        return $this->id;
    }

    /**
     * 修改路由
     * @param $id
     * @param $url
     * @param string $name
     * @return false|int
     */
    public function updateRule($id,$url,$name='')
    {
        $this->setTable(self::$rule_table);
        return $this->save(array(
                    'name' => $url
                    ,'description' => $name
                    ,'update_at' => time()
                ),array('id'=>$id));
    }

    /**
     * 删除路由
     * @param $id
     * @return int
     */
    public function deleteRule($id)
    {
        $this->setTable(self::$rule_table);
        return $this->where(array('id'=>$id))->delete();
    }

    public function getRoleList()
    {
        $this->setTable(self::$role_table);
        return $this->order('create_at','desc')->select();
    }

    /**
     * 创建角色
     * @param $name
     * @param $remark
     * @return false|int
     */
    public function createRole($name, $remark)
    {
        $this->setTable(self::$role_table);
        return $this->save(array(
                    'name' => $name
                    ,'remark' => $remark
                ));
    }

    public function updateRole($id, $name, $remark)
    {
        $this->setTable(self::$role_table);
        return $this->save(array(
            'name' => $name
            ,'remark' => $remark
            ,'update_at' => time()
        ),array('id'=>$id));
    }

    public function deleteRole($id)
    {
        Db::startTrans();
        $this->setTable(self::$role_table);
        $delRole = $this->where(array('id'=>$id))->delete();
        $delRule = $this->deleteRuleOnRole($id);
        if ($delRole and $delRule) {
            Db::commit();
            return true;
        } else {
            Db::rollback();
            return false;
        }
    }

    public function getRole($id)
    {
        $this->setTable(self::$role_table);
        return $this->where(array('id'=>$id))->find();
    }

    public function createRuleOnRole($params = array())
    {
        $this->setTable(self::$rule_and_role);
        $arr['role_id'] = $params['id'];
        $arr['child']   = serialize($params['rule']);
        return $this->insert($arr);
    }

    public function RoleGetRule($id)
    {
        $this->setTable(self::$rule_and_role);
        return $this->where(array('role_id'=>$id))->find();
    }

    public function deleteRuleOnRole($id)
    {
        $this->setTable(self::$rule_and_role);
        return $this->where(array('role_id'=>$id))->delete();
    }

    public function roleGetUser($id)
    {
        $this->setTable(self::$role_and_user);
        return $this->where(array('uid'=>$id))->find();
    }

    public function deleteUserOnRole($id)
    {
        $this->setTable(self::$role_and_user);
        return $this->where(array('uid'=>$id))->delete();
    }

    public function createRoleOnUser($param)
    {
        $this->setTable(self::$role_and_user);
        return $this->save(array(
            'role_id' => $param['role_id']
            ,'uid' => $param['id']
        ));
    }
}