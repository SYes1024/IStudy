<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/13
 * Time: 12:06
 */

namespace Common\Model;
use Think\Model\RelationModel;
use Org\Util\Page;

class CourseModel extends RelationModel
{
    protected $_link = array(
        'User' => array(
            'mapping_type'      =>  self::MANY_TO_MANY,
            'class_name'        =>  'User',
            'mapping_name'      =>  'Users',
            'foreign_key'       =>  'student_id',
            'relation_foreign_key'  =>  'course_id',
            'relation_table'    =>  'choose_course' //此处应显式定义中间表名称，且不能使用C函数读取表前缀
        )
    );

    /**
     * @param $title
     * @param $teacher_id
     * @param $date
     * @param $datearr 数组，0开始日期，1结束日期
     * @param $strtime
     * @param $time
     * @param $sumtime
     * @param $hard
     * @param $class
     * @param string $brief
     * @param string $pic
     * @param int $pass
     * @return mixed
     * 添加课程
     */
    public function addCourse($title, $teacher_id, $date, $datearr, $sumtime, $hard, $class, $brief="", $pic="/IStudy/Upload/course/showimage/default.png", $pass=0)
    {
        $data['title'] = $title;
        $data['date'] = $date;
        $data['startdate'] = $datearr[0];
        $data['enddate'] = $datearr[1];
        $data['sumtime'] = $sumtime;
        $data['hard'] = $hard;
        $data['class'] = $class;
        $data['brief'] = $brief;
        $data['pic'] = $pic;
        $data['teacher_id'] = $teacher_id;
        $data['pass'] = $pass;
        $data['create_time'] = date('Y-m-d H:i:s', time());

        $result = M('Course')->data($data)->add();
        return $result;
    }

    /**
     * @param $type
     * @param string $condition
     * @param int $pass
     * @return mixed
     * 根据条件查询课程
     */
    public function findByType($type, $condition = null, $pass = -1, $num = 8, $order = 'pass,id desc', $fields = "", $join = "")
    {
        $model = M('Course');
        switch ($type){
            case 'all':
                $where = array();
                break;
            case 'teacher':
                $where['teacher_id'] = $condition;
                break;
            case 'student':
                $where = array();
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
        $count = $model->where($where)->join($join)->count();//总数
        $Page = new Page($count,$num);//分页实例化
        $pageShow = $Page->show();// 分页显示输出
        $result = $model->field($fields)->join($join)->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
        $return['result'] = $result;
        $return['page'] = $pageShow;

        return $return;
    }

    /**
     * @return mixed
     * 查询全部课程，无分页
     */
    public function findAll($apply = 0)
    {
        $model = M('Course');

//        $where['apply'] = $apply;
//        $count = $model->where($where)->count();//总数
//        $Page = new Page($count,8);//分页实例化
//        $pageShow = $Page->show();// 分页显示输出
        $result = $model->join('user on user.id = course.teacher_id')->select();

        return $result;
    }

    /**
     * @param $id
     * @param string $fields
     * @param string $join
     * @return mixed
     * 查找一门课的详情
     */
    public function findOne($id, $fields = "", $join = "")
    {
        $where['course.id'] = $id;
        $result = M('Course')->field($fields)->join($join)->where($where)->find();

        return $result;
    }

    /**
     * @param $pic
     * @return bool
     * 数据库中图片地址清除
     */
    public function delImg($pic)
    {
        $where['pic'] = $pic;
        $result = M('Course')->where($where)->setField('pic','');

        return $result;
    }

    /**
     * @param $data
     * @return bool
     * 更新课程
     */
    public function updateCourse($data)
    {
        $data['pass'] = 0;//重新变为审核状态

        $result = M('Course')->data($data)->save();

        return $result;
    }

    /**
     * @param string $condition
     * @param string $order
     * @param int $limit
     * @return mixed
     * 查找限定数量的课
     */
    public function findLimit($condition = '',$order = 'id desc', $limit =4)
    {
        $result = M('Course')->where($condition)->order($order)->limit($limit)->select();

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
        $result = M('Course')->where($where)->data($data)->save();

        return $result;
    }
}