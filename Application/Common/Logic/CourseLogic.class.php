<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/13
 * Time: 12:11
 */

namespace Common\Logic;
use Common\Model\CourseModel;
use Think\Model;

class CourseLogic extends Model
{
    public function addCourse($title, $teacher_id, $brief="", $pic="", $pass=0)
    {
        $course = new CourseModel();
        $result = $course->addCourse($title, $teacher_id, $brief, $pic, $pass);

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
        $result = $course->findByTeacher($teacher_id);

        foreach ($result as $k => $v){   //转成提示
            switch ($v['pass']){
                case -1:
                    $result[$k]['pass'] = "未通过";
                    break;
                case 0:
                    $result[$k]['pass'] = "待审核";
                    break;
                case 1:
                    $result[$k]['pass'] = "已通过";
                    break;
            }
        }

        $return = groupArr($result);
        return $return;
    }

    public function findAll()
    {
        $course = new CourseModel();
        $result = $course->findAll();
        $return = groupArr($result);
        return $return;
    }
}