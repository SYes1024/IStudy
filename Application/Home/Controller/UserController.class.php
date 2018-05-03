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
    public function manageUser()
    {
        $user = new UserLogic();
        $result = $user->findAllTeacher();

        $this->assign('result', $result['result']);
        $this->assign('page', $result['page']);

        $this->display();
    }
}