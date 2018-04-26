<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/11
 * Time: 13:02
 */

namespace Home\Controller;

use Think\Controller;
use Common\Logic\CommentLogic;

class VideoController extends Controller
{
    public function play(){
        $id = 12;
        $comm = new CommentLogic();
        $result = $comm->findByVideo($id,1);

        $this->assign('comment', $result['result']);//评论
        $this->assign('page', $result['page']);
        $this->assign('video', $id);
        $this->display();
    }

}