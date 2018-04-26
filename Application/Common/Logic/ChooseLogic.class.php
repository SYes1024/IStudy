<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/26
 * Time: 16:01
 */

namespace Common\Logic;

use Common\Model\ChooseModel;

class ChooseLogic
{
    public function isChoose($course, $student)
    {
        $choose = new ChooseModel();
        $result = $choose->findOne($course,$student);

        if($result){
            return true;
        }else{
            return false;
        }
    }

    public function addChoose($course, $student)
    {
        $choose = new ChooseModel();
        $result = $choose->addOne($course, $student);

        if($result){
            return true;
        }else{
            return false;
        }
    }
}