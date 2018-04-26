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
     * @param $type
     * @param string $condition
     * @param int $pass
     * @return mixed
     * 根据条件查询课程
     */
    public function findByType($type, $condition = null, $pass = 0)
    {
        $model = M('Course');
        switch ($type){
            case 'all':
                $where = array();
                break;
            case 'teacher':
                $where['teacher_id'] = $condition;
                break;
            case 'search':
                $where['title'] = array('like',"%$condition%");
                break;
            default:
                $where = array();
                break;
        }
        if($pass == 1){
            $where['pass'] = $pass;
        }
        $count = $model->where($where)->count();//总数
        $Page = new Page($count,8);//分页实例化
        $pageShow = $Page->show();// 分页显示输出
        $result = $model->where($where)->order('apply desc,create_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $return['result'] = $result;
        $return['page'] = $pageShow;

        return $return;
    }

    /**
     * @return mixed
     * 查询全部课程，无分页
     */
    public function findAll()
    {
        $result = M('Course')->select();

        return $result;
    }

    public function findOne($id)
    {
        $where['id'] = $id;
        $result = M('Course')->where($where)->find();

        return $result;
    }
}