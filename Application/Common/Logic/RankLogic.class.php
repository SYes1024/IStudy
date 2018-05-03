<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/5/2
 * Time: 16:17
 */

namespace Common\Logic;

use Common\Model\ChooseModel;

class RankLogic
{
    public function getStudyTimeRank(){
        $choose = new ChooseModel();
        $result = $choose->sumTimeTop();

        return $result;
    }
}