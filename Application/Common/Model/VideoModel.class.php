<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/26
 * Time: 16:38
 */

namespace Common\Model;

use Think\Model;

class VideoModel extends Model
{
    public function findByCourse($course)
    {
        $where['course_id'] = $course;
        $where['pass'] = 1;
        $result = M('Video')->where($where)->select();

        return $result;
    }

    public function findOne($id)
    {
        $where['id'] = $id;
        $result = M('Video')->where($where)->find();

        return $result;
    }
}