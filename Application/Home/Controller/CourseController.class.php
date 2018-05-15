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
use Common\Logic\QuestionLogic;

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
     * 页面:学生已选课界面
     */
    public function myCourse()
    {
        $id = I('get.id');
        $course = new CourseLogic();
        $result = $course->findMyCourse('student',$id);
        $this->assign('result', $result['result']);
        $this->assign('page', $result['page']);
        $this->display();
    }

    /**
     * 页面:管理员课程管理
     */
    public function manageCourse()
    {

        $course = new CourseLogic();
        $status = I('get.status');
        if(I('get.type') == 'teacher'){
            $teacher_id = I('get.id');
            $result = $course->findMyCourse('teacher', $teacher_id, $status);
            //dump($result);
        }else{
            $result = $course->findAll('manage', $status);
        }

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
    public function getSum()
    {
        $id = I('get.id');
        $course = new CourseLogic();

        $result = $course->getCourseSum($id);

        $this->assign('title',$result['course_name']);
        $this->assign('choose',$result['choose']);
        $this->assign('count',$result['count']);

        $this->display();
    }

    /**
     * 功能：导入excel数据
     */
    public function import_question()
    {
        $root = 'course';
        $save = 'excel';
        $size = 10485760;

        $result = upload('excel', $root, $save, $size);

        if($result['code']) {
            $pFilename = $result['fileinfo'];
            $data = import_excel($pFilename);
            $question = new QuestionLogic();
            $result2 = $question->insertInto($data);
            if($result2){
                $this->success("导入成功");
            }else{
                $this->error('导入至数据库失败');
            }
        }else{
            $this->error('上传失败');
        }
    }

    /**
     * 页面：题库管理
     */
    public function question_import()
    {
        $this->display();
    }

    /**
     * 页面：获得测试考题页面
     */
    public function getTest()
    {
        $course_id = I('get.id');
        $course = new CourseLogic();
        $course_result = $course->findOne($course_id);
        $course_title = $course_result['title'];

        Vendor('scws.pscws4');
        $pscws = new \PSCWS4();
        $pscws->set_dict(VENDOR_PATH.'scws/lib/dict.utf8.xdb');
        $pscws->set_rule(VENDOR_PATH.'scws/lib/rules.utf8.ini');
        $pscws->set_ignore(true);
        $pscws->send_text($course_title);
        $words = $pscws->get_tops(5);
        $tags = array();
        foreach ($words as $val) {
            $tags[] = $val['word'];
        }
        $pscws->close();
        $question = new QuestionLogic();
        foreach ($tags as $k => $v){
            $result = $question->findByWord($v);
            foreach($result as $v2){
                $result2[] = $v2;
            }
        }
        $result2 = array_unique_fd($result2);//去重复
        $result2 = array_slice($result2,1,5);//最后取其中前5个

        for ($i=1;$i<6;$i++){
            $answer[$i] = $result2[$i-1]['answer'];
        }
        session('answer', $answer);
        $this->assign('course_id', $course_id);
        $this->assign('course_title', $course_title);
        $this->assign('result', $result2);
        //dump(session('answer'));
        $this->display();
    }

    /**
     * 页面：测试结果
     */
    public function submitTest()
    {
        $answer = session('answer');
        $true_num = 0;
        $false_num = 0;
        for($i=1;$i<6;$i++){
            $user_answer = I("post.item$i");
            if($answer[$i] == $user_answer){
                $true_num += 1;
            }else{
                $false_num += 1;
            }
        }

        $this->assign('true_num', $true_num);
        $this->assign('false_num', $false_num);
        $this->display();
    }
}