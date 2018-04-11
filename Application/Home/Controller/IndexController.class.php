<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->display();
    }

    public function newCourse(){
        if(session('category') >= 3){
            $this->error("你没有权限");
        }else{
            $this->display();
        }
    }
}