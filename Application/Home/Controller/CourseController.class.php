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

class CourseController extends Controller
{
    /**
     * 所有课程
     */
    public function all(){
        $this->display();
    }

    /**
     * 开设课程
     */
    public function newCourse(){
        if(session('category') >= 3){
            $this->error("你没有权限");
        }else{
            $this->display();
        }
    }

    /**
     * 图片上传
     */
    public function imgUp(){
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
     * 图片删除
     */
    public function imgDel(){
        $filename = I('post.key');//文件地址
        if(del($filename)){
//            $where['url'] = array('LIKE',$filename);
//            M('ItemPic')->where($where)->delete();//数据库内容删除
            $result['status'] = true;
            $this->ajaxReturn($result,'json');
        }else{
            $result['status'] = false;
            $this->ajaxReturn($result,'json');
        }
    }
    /**
     * 课程开设
     */
    public function add(){
        $title = I('post.title');
        $teacher_id = I('teacher_id');
        $brief = I('post.brief');
        $pic = I('post.showpic');

        $course = new CourseLogic();
        if($course->addCourse($title, $teacher_id, $brief, $pic)){
            $this->ajaxReturn(array('code' => 1, 'msg' => '开设成功，请等待后台审核！'));
        }else{
            $this->ajaxReturn(array('code' => 0, 'msg' => '开设失败'));
        }
    }

    /**
     * 教师开设的课程
     */
    public function myCourse(){
        $course = new CourseLogic();
        $teacher_id = I('get.id');
        $result = $course->findMyCourse($teacher_id);

        $this->assign('result', $result['result']);
        $this->assign('page', $result['page']);
        $this->display();
    }

    /**
     * 所有课程
     */
    public function allCourse(){
        $course = new CourseLogic();
        if(I('get.search')){
            $condition = I('get.search');
            $result = $course->search($condition);
        }else{
            $result = $course->findAll();
        }
        $this->assign('result', $result['result']);
        $this->assign('page', $result['page']);
        $this->assign('search', $condition);
        $this->display();
    }

    public function detail(){
        $id = I('get.id');
        $course = new CourseLogic();
        $result = $course->findOne($id);
        $this->assign('result', $result);
        $this->display();
    }
}