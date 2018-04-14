<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/13
 * Time: 12:06
 */

namespace Common\Model;
use Think\Model\RelationModel;

class CourseModel extends RelationModel
{
    /**
     * @param $title
     * @param string $brief
     * @param string $pic
     * @param $teacher_id
     * @param int $pass
     * @return mixed
     * 添加课程
     */
    public function addCourse($title, $teacher_id, $brief="", $pic="", $pass=0)
    {
        $data['title'] = $title;
        $data['brief'] = $brief;
        $data['pic'] = $pic;
        $data['teacher_id'] = $teacher_id;
        $data['pass'] = $pass;
        $data['create_time'] = date('Y-m-d H:i:s', time());

        $result = M('Course')->data($data)->add();
        return $result;
    }

    /**
     * @param $teacher_id
     * @return mixed
     * 根据教师id查课
     */
    public function findByTeacher($teacher_id)
    {
        $where['teacher_id'] = $teacher_id;
        $result = M('Course')->where($where)->order('create_time desc')->select();

        return $result;
    }

    public function findAll()
    {
        $result = M('Course')->select();

        return $result;
    }
}