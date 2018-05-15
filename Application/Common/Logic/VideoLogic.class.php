<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/26
 * Time: 16:39
 */

namespace Common\Logic;

use Common\Model\ChooseModel;
use Common\Model\VideoModel;
use Think\Model\ViewModel;

class VideoLogic
{
    /**
     * @param $course
     * @return mixed
     * 根据课程查找视频
     */
    public function findByCourse($course)
    {
        $video = new VideoModel();
        $result = $video->findByCourse($course);

        return $result;
    }

    /**
     * @param $id
     * @return mixed
     * 根据id查找
     */
    public function findOne($id)
    {
        $video = new VideoModel();
        $result = $video->findOne($id);

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
        $video = new VideoModel();
        if($type == 'pass'){
            $result = $video->findByType('all',array(),$status,8,'apply desc,id desc');
            $result['result'] = groupArr($result['result']);
        }elseif($type == 'manage'){
            $result = $video->findByType('all',array(),$status,8,'pass,id desc','video.*,user.name','user on user.id=video.up_id');
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
     * @param $data
     * @return bool
     * 添加视频
     */
    public function add($data)
    {
        $data['pass'] = 0;
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $video = new VideoModel();

        $result = $video->addVideo($data);

        if($result){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $id
     * @param $status
     * @return bool
     * 更新审核状态
     */
    public function verifyCourse($id, $status, $reason = "")
    {
        $course = new VideoModel();
        $result = $course->verifyCourse($id,$status,$reason);

        if($result !== false){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $time
     * @param $student_id
     * @param $course_id
     * @return bool
     * 添加学习时长
     */
    public function addLearnTime($time,$student_id,$course_id)
    {
        $choose = new ChooseModel();
        $result = $choose->addLearnTime($time,$student_id,$course_id);

        if($result !== false){
            return true;
        }else{
            return false;
        }
    }
}