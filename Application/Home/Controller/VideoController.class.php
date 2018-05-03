<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/11
 * Time: 13:02
 */

namespace Home\Controller;

use Common\Logic\CourseLogic;
use Common\Logic\VideoLogic;
use Think\Controller;
use Common\Logic\CommentLogic;
use Common\Logic\RankLogic;
use Common\Logic\UserLogic;

class VideoController extends Controller
{
    /**
     * 界面：视频播放
     */
    public function play(){
        if(I('get.user')){
            $user = new UserLogic();
            $result = $user->findById(I('get.user'));
            session('id', $result['id']);
            session('category', $result['category']);
            session('username', $result['username']);
            session('name', $result['name']);
            session('class', $result['class']);
        }
        $id = I('get.id');
        $comm = new CommentLogic();
        $comment = $comm->findByVideo($id,1);

        $video = new VideoLogic();
        $video_detail = $video->findOne($id);

        $rank = new RankLogic();
        $studyRank = $rank->getStudyTimeRank();

        $this->assign('comment', $comment['comment']);//评论
        $this->assign('page', $comment['page']);
        $this->assign('video', $video_detail);
        $this->assign('studyRank', $studyRank);

        $this->display();
    }

    /**
     * 界面：上传/修改 视频界面
     */
    public function newVideo()
    {
        $id = I('get.id');
        $course = new CourseLogic();
        $result = $course->findOne($id);

        //修改界面
        if(I('get.video')){
            $video_id = I('get.video');
            $video = new VideoLogic();

            $result2 = $video->findOne($video_id);
            $this->assign('video', $result2);
        }

        $this->assign('course', $result);
        $this->display();
    }

    /**
     * 功能：上传视频
     */
    public function upload()
    {
        $root = I('get.rootpath');
        $save = I('get.savepath');
        $size = I('get.size');


        $result = upload('video', $root, $save, $size);
        if($result['state'] != ""){
            $this->ajaxReturn($result);
        }else{
            $this->ajaxReturn($result);
        }
    }

    /**
     * 功能：添加视频
     */
    public function add()
    {
        $data['title'] = I('post.title');
        $data['up_id'] = I('post.up_id');
        $data['course_id'] = I('post.course_id');
        $data['upload'] = I('post.upload');
        $data['size'] = I('post.size');

        $video = new VideoLogic();

        $result = $video->add($data);

        if($result){
            $this->ajaxReturn(array('code' => 1, 'msg' => '上传成功，请等待后台审核！'));
        }else{
            $this->ajaxReturn(array('code' => 0, 'msg' => '上传失败'));
        }
    }

    /**
     * 页面:管理员视频管理
     */
    public function manageVideo()
    {
        $status = I('get.status');
        $video = new VideoLogic();
        $result = $video->findAll('manage', $status);

        $this->assign('result', $result['result']);
        $this->assign('page', $result['page']);
        $this->display();

    }

    /**
     * 功能：更新审核状态
     */
    public function verify()
    {
        $id = I('get.id');
        $status = I('get.status');
        $reason = I('get.reason');

        $video = new VideoLogic();
        $result = $video->verifyCourse($id, $status, $reason);
        if($result){
            $this->ajaxReturn(array('code' => 1, 'msg' => '审核完成'));
        }else{
            $this->ajaxReturn(array('code' => 0, 'msg' => '审核失败'));
        }
    }
}