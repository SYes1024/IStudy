<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/11
 * Time: 13:04
 */

namespace Home\Controller;

use Common\Logic\CommentLogic;
use Think\Controller;

class CommentController extends Controller
{
    public function add(){
        $user = I('post.user_id');
        $video = I('post.video_id');
        $content = I('post.content');
        $type = 1;
        $comm = new CommentLogic();
        $result = $comm->addComment($video, $user, $content, $type);
        if($result){
            $this->ajaxReturn(array('code' => 1, 'msg' => '评论发表成功'));
        }else{
            $this->ajaxReturn(array('code' => 0, 'msg' => '评论发表失败'));
        }
    }
}