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
        foreach ($result as $k => $v){
            $result[$k]['totaltime'] = round($v['totaltime']/60,2);
        }

        return $result;
    }
}