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
    public function addCourse($title, $teacher_id, $date, $datearr, $strtime, $time, $sumtime, $hard, $class, $brief="", $pic="", $pass=0)
    {
        $course = new CourseModel();
        $result = $course->addCourse($title, $teacher_id, $date, $datearr, $strtime, $time, $sumtime, $hard, $class, $brief, $pic, $pass);

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
     * @return mixed
     * 查询所有课程，并对其进行分组
     */
    public function findAll($type = 0)
    {
        $course = new CourseModel();
        if($type == 0){
            $result = $course->findByType('all',array(),1);
            $result['result'] = groupArr($result['result']);
        }elseif($type == 1){
            $result = $course->findByType('all',array(),-1,40,'pass,create_time desc','course.*,user.name','user on user.id=course.teacher_id');
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
        $result = $course->findOne($id,'course.*,user.name,user.brief as ubrief,user.head','user on user.id=course.teacher_id');
        return $result;
    }
}