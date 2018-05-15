<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/2
 * Time: 12:48
 */

namespace Home\Controller;
use Admin\Model\UserModel;
use Common\Logic\UserLogic;
use Think\Controller;

class LoginController extends Controller
{
    /**
     * 邮箱验证
     */
    public function emailOk()
    {
        $user  = new UserLogic();
        if($user->checkEmail(I('get.email'))){
            echo "邮箱已被使用";
        }else{
            echo "";
        }
    }

    /**
     * 用户名重名检查
     */
    public function usernameOk()
    {
        $user  = new UserLogic();
        if($user->checkUser(I('get.username'))){
            echo "名字已被使用";
        }else{
            echo "";
        }
    }

    /**
     * 验证码检测
     */
    public function verCodeOk()
    {
        if(session('verCode') != "" && time()-session('expire') < 6000){
            if(I('get.verCode') == session('verCode')){
                echo "";
            }else{
                echo "验证码错误";
            }
        }else{
            echo "验证码已过期";
        }

    }

    /**
     * 验证码发送
     */
    public function sendVerCode(){
        $to = I('get.email');
        $title = "孜智-邮箱验证";
        $verCode = rand(100001,999999);
        session('expire', time());
        session('verCode', $verCode);
        $content = "欢迎注册孜智在线学习平台，本次注册验证码：".$verCode." ，验证码有效期为10分钟，请尽快完成注册！";
        if(sendMail($to, $title, $content)){
            $this->ajaxReturn(array('code' => '1', 'msg' => "验证码已发送"));
        }else{
            $this->ajaxReturn(array('code' => '0', 'msg' => "验证码发送失败"));
        }

    }

    /**
     * 学生注册
     */
    public function addStu()
    {
        $username = I('post.username');
        $password = I('post.password');
        $pwdAgain = I('post.pwdAgain');
        $email = I('post.email');
        $name = I('post.name');
        $class = I('post.class');
        $verCode = I('post.verCode');

        $user = new UserLogic();
        //注册时再做检测
        if($user->checkUser($username)){
            $this->ajaxReturn(array('code' => '0', 'msg' => "该账号已被注册"));
        }
        elseif($user->checkEmail($email)){
            $this->ajaxReturn(array('code' => '0', 'msg' => "该邮箱已被使用"));
        }
        elseif($password != $pwdAgain){
            $this->ajaxReturn(array('code' => '0', 'msg' => "密码不一致"));
        }
        elseif($verCode == null){
            $this->ajaxReturn(array('code' => '0', 'msg' => '验证码不能为空'));
        }
        elseif(time()-session('expire') > 6000){
            session('verCode',null);
            session('expire',null);
            $this->ajaxReturn(array('code' => '0', 'msg' => '验证码已过期'));
        }
        elseif($verCode != session('verCode')){ //验证码验证
            $this->ajaxReturn(array('code' => '0', 'msg' => "验证码错误"));
        }else{
            $result = $user->addStu($username, $password, $email, $name,$class);
            if (!$result){
                $this->ajaxReturn(array('code' => '0', 'msg' => "注册失败"));
            }else{
                session('id', $result['id']);
                session('category', 3);
                session('username', $username);
                session('name', $name);
                $this->ajaxReturn(array('code' => '1', 'msg' => "注册成功"));
            }
        }
    }

    /**
     * 登录
     */
    public function login(){
        $username = I('post.username');
        $password = I('post.password');

        $user = new UserLogic();
        $result = $user->findByUsername($username);
        if($result == null){
            $this->ajaxReturn(array('code' => '0', 'msg' => "账号不存在"));
        }
        elseif($password = $result['password']){
            session('id', $result['id']);
            session('category', $result['category']);
            session('username', $username);
            session('name', $result['name']);
            session('class', $result['class']);
            $this->ajaxReturn(array('code' => '1', 'msg' => "登录成功"));
        }else{
            $this->ajaxReturn(array('code' => '0', 'msg' => "密码错误"));
        }
    }

    public function loginOut(){
        session_unset();
        if(session_destroy()){
            $this->ajaxReturn(array('code' => '1', 'msg' => "退出成功"));
        }else{
            $this->ajaxReturn(array('code' => '0', 'msg' => "退出失败"));
        }


    }
}