<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/13
 * Time: 12:11
 */

namespace Common\Logic;
use Common\Model\CourseModel;

class CourseLogic
{
    /**
     * @param $title
     * @param $teacher_id
     * @param string $brief
     * @param string $pic
     * @param int $pass
     * @return bool
     * 添加课程
     */
    public function addCourse($title, $teacher_id, $date, $datearr, $sumtime, $hard, $class, $brief="", $pic="/IStudy/Upload/course/showimage/default.png", $pass=0)
    {
        $course = new CourseModel();
        $result = $course->addCourse($title, $teacher_id, $date, $datearr, $sumtime, $hard, $class, $brief, $pic, $pass);

        if($result){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param int $teacher_id
     * @return array
     * 根据教师id查找课程,并三个一组进行分类
     */
    public function findMyCourse($teacher_id = 0)
    {
        $course = new CourseModel();
        $result = $course->findByType('teacher', $teacher_id);

        foreach ($result['result'] as $k => $v){   //转成提示
            switch ($v['pass']){
                case 0:
                    $result['result'][$k]['pass'] = "待审核";
                    break;
                case 1:
                    $result['result'][$k]['pass'] = "已通过";
                    break;
                case 2:
                    $result['result'][$k]['pass'] = "未通过";
                    break;
            }
        }

        $result['result'] = groupArr($result['result']);
        return $result;
    }

    /**
     * @param string $type
     * @param int $status
     * @return mixed
     * 查找所有的
     */
    public function findAll($type = 'pass',$status = 1)
    {
        $course = new CourseModel();
        if($type == 'pass'){
            $result = $course->findByType('all',array(),$status,8,'apply desc,id desc');
            $result['result'] = groupArr($result['result']);
        }elseif($type == 'manage'){
            $result = $course->findByType('all',array(),$status,8,'pass,id desc','course.*,user.name','user on user.id=course.teacher_id');
            foreach ($result['result'] as $k=>$v){
                switch($v['pass']){
                    case 0:
                        $result['result'][$k]['pass'] = '待审核';
                        break;
                    case 1:
                        $result['result'][$k]['pass'] = '已通过';
                        break;
                    case 2:
                        $result['result'][$k]['pass'] = '未通过';
                        break;
                }
            }
        }
        return $result;
    }

    /**
     * @param $condition
     * @return mixed
     * 搜索课程，并进行分组
     */
    public function search($condition)
    {
        $course = new CourseModel();
        $result = $course->findByType('search', $condition);
        $result['result'] = groupArr($result['result']);
        return $result;
    }

    /**
     * @param int $id
     * @return mixed
     * 查找课程详情
     */
    public function findOne($id=0)
    {
        $course = new CourseModel();
        $result = $course->findOne($id,'course.*,user.name,user.brief as ubrief,user.head,user.category','user on user.id=course.teacher_id');
        return $result;
    }

    /**
     * @param $pic
     * @return bool
     * 删除服务器中图片
     */
    public function delImg($pic)
    {
        if($pic=""){
            return false;
        }else{
            if(del($pic)){
                $course = new CourseModel();
                $result = $course->delImg($pic);
                if($result){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

    }

    /**
     * @param $data
     * @return int
     * 更新课程,data中要包含id
     */
    public function editCourse($data)
    {
        $course = new CourseModel();
        $result = $course->updateCourse($data);

        $code = 0;
        if($result !== false){
            if($result > 0){
                $code = 2;
            }else{
                $code = 1;
            }
        }
        return $code;
    }

    /**
     * @param string $condition
     * @param string $order
     * @param int $limit
     * @return mixed
     * 查找限定数量的课
     */
    public function findLimit($condition = '' ,$order = 'id desc', $limit = 4)
    {
        $course = new CourseModel();
        $result = $course->findLimit($condition,$order, $limit);

        return $result;
    }

    /**
     * @param $id
     * @param $status
     * @return bool
     * 更新审核状态
     */
    public function verifyCourse($id, $status, $reason = "")
    {
        $course = new CourseModel();
        $result = $course->verifyCourse($id,$status,$reason);

        if($result !== false){
            return true;
        }else{
            return false;
        }
    }
}