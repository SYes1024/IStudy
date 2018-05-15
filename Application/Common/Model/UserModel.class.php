<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/3
 * Time: 10:48
 */

namespace Common\Model;
use Think\Model\RelationModel;
use Org\Util\Page;

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
    public function addUser($username, $password, $email="", $name="",$class="", $category=3, $brief="这个人很懒，什么都没有写")
    {
        $data['username'] = $username;
        $data['password'] = $password;
        $data['email'] = $email;
        $data['name'] = $name;
        $data['class'] = $class;
        $data['brief'] = $brief;
        $data['category'] = $category;
        $data['create_time'] = date('Y-m-d H:i:s', time());

        $result = M('User')->data($data)->add();
        return $result;
    }

    /**
     * @param int $id
     * @return mixed
     * 通过id找用户
     */
    public function findById($id = 0)
    {
        $where['id'] = $id;
        $result = M('User')->where($where)->find();

        return $result;
    }

    /**
     * @param int $num
     * @return mixed
     * 找所有老师
     */
    public function findAllTeacher($num = 8)
    {
        $model = M('User');
        $where['category'] = 2;
        $count = $model->where($where)->count();//总数
        $Page = new Page($count,$num);//分页实例化
        $pageShow = $Page->show();// 分页显示输出
        $result = $model->where($where)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $return['result'] = $result;
        $return['page'] = $pageShow;

        return $return;
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     * 修改用户信息
     */
    public function editUser($id, $data)
    {
        $where['id'] = $id;
        $result = M('User')->where($where)->data($data)->save();

        return $result;
    }
}