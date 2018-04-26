<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/26
 * Time: 13:25
 */

namespace Common\Model;

use Think\Model\ViewModel;

class CourseViewModel extends ViewModel
{
    public $viewFields = array(
        'User'=>array('name', '_on'=>'Course.teacher_id=User.id'),
    );
}