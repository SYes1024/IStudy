<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/11
 * Time: 13:03
 */

namespace Home\Controller;

use Think\Controller;
use Common\Logic\CourseLogic;
use Common\Logic\ChooseLogic;
use Common\Logic\VideoLogic;

class CourseController extends Controller
{

    /**
     * 界面:开设/修改 课程
     */
    public function newCourse()
    {
        if(I('get.id')){
            $id = I('get.id');
            $course = new CourseLogic();
            $result = $course->findOne($id);

            $this->assign('result', $result);
        }
        $this->display();
    }
    /**
     * 功能:图片上传
     */
    public function imgUp()
    {
        $root = I('get.rootpath');
        $save = I('get.savepath');
        $size = I('get.size');


        $result = upload('img', $root, $save, $size);
        if($result['state'] != ""){
            $this->ajaxReturn($result);
        }else{
            $this->ajaxReturn($result);
        }
    }

    /**
     * 功能:图片删除
     */
    public function imgDel()
    {
        $pic = I('post.key');//文件地址
        $course = new CourseLogic();
        $result = $course->delImg($pic);
        if($result){
            $result['status'] = true;
            $this->ajaxReturn($result,'json');
        }else{
            $result['status'] = false;
            $this->ajaxReturn($result,'json');
        }
    }
    /**
     * 功能:课程开设
     */
    public function add()
    {
        $title = I('post.title');
        $date = I('post.date');
        $sumtime = I('post.sumtime');
        $hard = I('post.hard');
        $class = I('post.class');
        $teacher_id = I('teacher_id');
        $brief = I('post.brief');
        $pic = I('post.showpic');

        $datearr = explode("至",$date);//拆成开始和结束日期
        $course = new CourseLogic();
        if($course->addCourse($title, $teacher_id, $date, $datearr, $sumtime, $hard, $class, $brief, $pic)){
            $this->ajaxReturn(array('code' => 1, 'msg' => '开设成功，请等待后台审核！'));
        }else{
            $this->ajaxReturn(array('code' => 0, 'msg' => '开设失败'));
        }
    }

    /**
     * 页面:教师管理课程
     */
    public function myCourse()
    {
        $course = new CourseLogic();
        $teacher_id = I('get.id');
        $result = $course->findMyCourse($teacher_id);

        $this->assign('result', $result['result']);
        $this->assign('page', $result['page']);
        $this->display();
    }

    /**
     * 页面:所有课程
     */
    public function allCourse()
    {
        $course = new CourseLogic();
        if(I('get.search')){
            $condition = I('get.search');
            $result = $course->search($condition);
        }else{
            $result = $course->findAll('pass');
        }
        $this->assign('result', $result['result']);
        $this->assign('page', $result['page']);
        $this->assign('search', $condition);
        $this->display();
    }

    /**
     * 页面:课程详情
     */
    public function detail()
    {
        $id = I('get.id');
        $course = new CourseLogic();
        $result = $course->findOne($id);//课程信息
        $choose = new ChooseLogic();
        $ischoose = $choose->isChoose($id,session('id'));//是否已报名
        $result['ischoose'] = $ischoose;
        $video = new VideoLogic();
        $allVideo = $video->findByCourse($id);
        $result['video'] = $allVideo;
        $this->assign('result', $result);
        $this->display();
    }

    /**
     * 页面:管理员课程管理
     */
    public function manageCourse()
    {
        $status = I('get.status');
        $course = new CourseLogic();
        $result = $course->findAll('manage', $status);

        $this->assign('result', $result['result']);
        $this->assign('page', $result['page']);
        $this->display();

    }

    /**
     * 功能:报名
     */
    public function apply()
    {
        $course = I('post.course');
        $student = I('post.student');

        $choose = new ChooseLogic();
        $result = $choose->addChoose($course, $student);

        if($result){
            $this->ajaxReturn(array('code' => 1, 'msg' => '报名成功！'));
        }else{
            $this->ajaxReturn(array('code' => 0, 'msg' => '报名失败'));
        }
    }

    /**
     * 功能：修改课程
     */
    public function edit()
    {
        $data = I('post.');
        $data['strtime'] = $data['time'];
        $data['pic'] = $data['showpic'];
        unset($data['showpic']);//移除数据库中没有的字段
        unset($data['teacher_id']);
        $dataarr = explode("至",$data['date']);//拆成开始和结束日期
        $data['startdate'] = $dataarr[0];
        $data['enddate'] = $dataarr[1];
        preg_match_all("/([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]/", $data['time'], $time);
        $data['time'] = implode(',',$time[0]);
        $data['edit_time'] = date('Y-m-d H:i:s', time());
        $course = new CourseLogic();
        $result = $course->editCourse($data);

        if($result){
            if($result == 1){
                $msg = '无更新内容';
            }elseif($result == 2){
                $msg = '更新成功，请等待后台审核！';
            }
            $this->ajaxReturn(array('code' => 1, 'msg' => $msg));
        }else{
            $this->ajaxReturn(array('code' => 0, 'msg' => '更新失败'));
        }
    }

    /**
     * 功能：更新审核状态
     */
    public function verify()
    {
        $id = I('get.id');
        $status = I('get.status');
        $reason = I('get.reason');

        $course = new CourseLogic();
        $result = $course->verifyCourse($id, $status, $reason);
        if($result){
            $this->ajaxReturn(array('code' => 1, 'msg' => '审核完成'));
        }else{
            $this->ajaxReturn(array('code' => 0, 'msg' => '审核失败'));
        }
    }

    /**
     * 页面：选课情况汇总
     */
    public function getSum(){
        $id = I('get.id');

        $this->display();
    }
}