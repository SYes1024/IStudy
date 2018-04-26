<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/26
 * Time: 16:39
 */

namespace Common\Logic;

use Common\Model\VideoModel;
use Think\Model\ViewModel;

class VideoLogic
{
    public function findByCourse($course)
    {
        $video = new VideoModel();
        $result = $video->findByCourse($course);

        return $result;
    }

    public function findOne($id)
    {
        $video = new VideoModel();
        $result = $video->findOne($id);

        return $result;
    }
}