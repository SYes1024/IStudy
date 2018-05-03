<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/26
 * Time: 15:56
 */

namespace Common\Model;

use Think\Model;

class ChooseModel extends Model
{
    /**
     * @param array|mixed $course
     * @param $student
     * @return mixed
     * 查找报名情况
     */
    public function findOne($course, $student)
    {
        $where['course_id'] = $course;
        $where['student_id'] = $student;
        $result = M('Choose')->where($where)->find();
        return $result;
    }

    /**
     * @param $course
     * @param $student
     * @return bool
     * 添加选课
     */
    public function addOne($course, $student)
    {
        $data['course_id'] = $course;
        $data['student_id'] = $student;
        $data['create_time'] = date('Y-m-d H:i:s', time());

        $return = false;
        $result1 = M('Choose')->data($data)->add();
        if($result1){
            $return = true;
        }
        $where['id'] = $course;
        $result2 = M('Course')->where($where)->setInc('people');
        if($result2){
            $return = true;
        }
        return $return;
    }

    public function sumTimeTop(){
        $result = M('Choose')->field('user.name,sum(sumtime) as totaltime')->join('user on user.id = student_id')->group('student_id')->order('totaltime desc')->limit(5)->select();
        return $result;
    }
}