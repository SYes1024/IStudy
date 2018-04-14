<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/3
 * Time: 10:48
 */

namespace Common\Model;
use Think\Model\RelationModel;

class UserModel extends RelationModel
{
    private $username;
//    protected $_link = array(
//        'Role' => array(
//            'mapping_type'  => self::MANY_TO_MANY,
//            'foreign_key'   => 'user_id',
//            'relation_key'  => 'role_id',
//            'relation_table'=> 'ebsz_role_admin',
//            'mapping_fields'=> 'id,name'
//        ),
//    );

    /**
     * @param $email
     * @return mixed
     * 通过邮箱查找单条数据
     */
    public function findByEmail($email)
    {
        $where['email'] = $email;

        $result = M('User')->where($where)->find();
        return $result;
    }

    /**
     * @param $username
     * @return mixed
     * 通过账号查找单条数据
     */
    public function findByUser($username)
    {
        $where['username'] = $username;

        $result = M('User')->where($where)->find();
        return $result;
    }

    /**
     * @param $username
     * @param $password
     * @param string $email
     * @param string $name
     * @param string $brief
     * @param int $category
     * @return mixed
     * 添加用户
     */
    public function addUser($username, $password, $email="", $name="", $category=3, $brief="这个人很懒，什么都没有写")
    {
        $data['username'] = $username;
        $data['password'] = $password;
        $data['email'] = $email;
        $data['name'] = $name;
        $data['brief'] = $brief;
        $data['category'] = $category;
        $data['create_time'] = date('Y-m-d H:i:s', time());

        $result = M('User')->data($data)->add();
        return $result;
    }
}