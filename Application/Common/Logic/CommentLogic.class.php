<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/25
 * Time: 20:34
 */

namespace Common\Logic;

use Common\Model\CommentModel;
use Think\Model;

class CommentLogic extends Model
{
    public function addComment($video, $user, $content, $category = 1)
    {
        $comm = new CommentModel();
        $result = $comm->addCom($video, $user, $content, $category);

        if($result){
            return true;
        }else{
            return false;
        }
    }

    public function findByVideo($id = 0, $type = 1)
    {
        $comm = new CommentModel();
        $result = $comm->findByVideo($id, $type);

        return $result;
    }
}