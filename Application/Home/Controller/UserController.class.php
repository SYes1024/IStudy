<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/11
 * Time: 13:07
 */

namespace Home\Controller;

use Common\Logic\UserLogic;
use Think\Controller;

class UserController extends Controller
{
    /**
     * 页面：管理教师
     */
    public function manageUser()
    {
        $user = new UserLogic();
        $result = $user->findAllTeacher();

        $this->assign('result', $result['result']);
        $this->assign('page', $result['page']);

        $this->display();
    }

    /**
     * 功能：获取用户数据
     */
    public function getUserData()
    {
        $id = I('get.id');
        $user = new UserLogic();
        $result = $user->findById($id);
        $this->ajaxReturn(array('code' => 1, 'data' => $result));
    }

    /**
     * 功能：修改用户信息
     */
    public function editUser()
    {
        $id = session('id');
        $data['brief'] = I('post.editBrief');
        $data['class'] = I('post.editClass');
        $data['email'] = I('post.editEmail');
        $data['head'] = I('post.headUpPic');

        $user = new UserLogic();
        $result = $user->editUser($id, $data);

        if($result){
            $this->ajaxReturn(array('code' => 1, 'msg' => '修改成功'));
        }else{
            $this->ajaxReturn(array('code' => 0, 'msg' => '修改失败'));
        }
    }

    /**
     * 功能：修改密码
     */
    public function editPwd()
    {
        $id = session('id');
        $data['password'] = I('post.password2');

        $user = new UserLogic();
        $result = $user->editUser($id, $data);

        if($result){
            $this->ajaxReturn(array('code' => 1, 'msg' => '修改成功'));
        }else{
            $this->ajaxReturn(array('code' => 0, 'msg' => '修改失败'));
        }
    }

    public function addTeacher()
    {
        $username = I('post.username');
        $name = I('post.name');
        $password = I('post.password');
        $email = I('post.email');

        $user = new UserLogic();
        $result = $user->addStu($username,$password,$email,$name,'',2);

        if($result == -1){
            $this->ajaxReturn(array('code' => 0, 'msg' => '用户名已存在'));
        }elseif($result == 0){
            $this->ajaxReturn(array('code' => 0, 'msg' => '添加失败'));
        }elseif($result == 1){
            $this->ajaxReturn(array('code' => 1, 'msg' => '添加成功'));
        }
    }
}