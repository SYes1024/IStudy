<?php
namespace Home\Controller;
use Think\Controller;
use Common\Logic\CourseLogic;
class IndexController extends Controller {
    public function index(){
        $course = new CourseLogic();
        $where['pass'] = 1;
        $where['apply'] = 1;
        $new = $course->findLimit($where);

        $orderHot = 'people desc';
        $hot = $course->findLimit($where,$orderHot,8);

        $this->assign('new', $new);
        $this->assign('hot', $hot);
        $this->display();
    }

}