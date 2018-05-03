<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/26
 * Time: 16:38
 */

namespace Common\Model;

use Think\Model;
use Org\Util\Page;

class VideoModel extends Model
{
    /**
     * @param $type
     * @param string $condition
     * @param int $pass
     * @return mixed
     * 根据条件查询课程
     */
    public function findByType($type, $condition = null, $pass = -1, $num = 8, $order = 'pass,id desc', $fields = "", $join = "")
    {
        $model = M('Video');
        switch ($type){
            case 'all':
                $where = array();
                break;
            case 'teacher':
                $where['up_id'] = $condition;
                break;
            case 'search':
                $where['title'] = array('like',"%$condition%");
                break;
            default:
                $where = array();
                break;
        }
        if($pass != -1){
            $where['pass'] = $pass;
        }
        $count = $model->where($where)->count();//总数
        $Page = new Page($count,$num);//分页实例化
        $pageShow = $Page->show();// 分页显示输出
        $result = $model->field($fields)->join($join)->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
        $return['result'] = $result;
        $return['page'] = $pageShow;

        return $return;
    }

    /**
     * @param $course
     * @return mixed
     * 通过课程找全部视频
     */
    public function findByCourse($course)
    {
        $where['course_id'] = $course;
        $where['pass'] = 1;
        $result = M('Video')->where($where)->select();

        return $result;
    }

    /**
     * @param $id
     * @return mixed
     * 找一个视频
     */
    public function findOne($id)
    {
        $where['id'] = $id;
        $result = M('Video')->where($where)->find();

        return $result;
    }

    /**
     * @param $data
     * @return mixed
     * 添加视频
     */
    public function addVideo($data)
    {
        $result = M('Video')->data($data)->add();

        return $result;
    }

    /**
     * @param $id
     * @param int $status
     * @return bool
     * 更新审核状态
     */
    public function verifyCourse($id, $status = 0, $reason = "")
    {
        $where['id'] = $id;
        $data['pass'] = $status;
        $data['reason'] = $reason;
        $result = M('Video')->where($where)->data($data)->save();

        return $result;
    }
}