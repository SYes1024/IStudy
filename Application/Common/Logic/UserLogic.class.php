<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/3
 * Time: 11:20
 */

namespace Common\Logic;
use Common\Model\UserModel;

class UserLogic
{
    /**
     * @param $email
     * @return bool
     * 检查邮箱是否存在
     */
    public function checkEmail($email)
    {
        $user = new UserModel();
        if($user->findByEmail($email)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $username
     * @return bool
     * 检查用户重复
     */
    public function checkUser($username)
    {
        $user = new UserModel();
        if($user->findByUser($username)){
            return true;
        }else{
            return false;
        }
    }
    /**
     * @param $username
     * @param $password
     * @param string $email
     * @return int
     * 添加学生账号
     */
    public function addStu($username, $password, $email="", $name = "",$class, $category = 3)
    {
        $user = new UserModel();
        if($user->findByUser($username)){
            return -1;//用户名存在
        }else{
            $result = $user->addUser($username, $password, $email, $name,$class, $category);
            if($result)
                return 1;//添加成功
            else
                return 0;//添加失败
        }
    }

    /**
     * @param $username
     * @return mixed
     * 查找一条数据
     */
    public function findByUsername($username)
    {
        $user = new UserModel();
        $result = $user->findByUser($username);
        return $result;
    }

    /**
     * @param $id
     * @return mixed
     * 通过id找用户
     */
    public function findById($id)
    {
        $user = new UserModel();
        $result = $user->findById($id);

        return $result;
    }

    /**
     * @return mixed
     * 找所有老师
     */
    public function findAllTeacher($num = 8)
    {
        $user = new UserModel();
        $result = $user->findAllTeacher($num);

        return $result;
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     * 修改用户信息
     */
    public function editUser($id ,$data)
    {
        $user = new UserModel();
        $result = $user->editUser($id ,$data);

        if($result !== false){
            return true;
        }else{
            return false;
        }
    }
}