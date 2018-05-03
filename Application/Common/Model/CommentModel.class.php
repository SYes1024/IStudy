<?php
/**
 * Created by PhpStorm.
 * Author: SYes
 * Date: 2018/4/25
 * Time: 20:35
 */

namespace Common\Model;
use Think\Model\RelationModel;
use Org\Util\Page;

class CommentModel extends RelationModel
{
    public $_link = array(
        'User' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'user',
            'foreign_key'   => 'user_id',
            'mapping_name'  => 'name,head,category',
            'as_fields' => 'name,head,category',
        ),
    );

    public function addCom($video, $user, $content, $category = 1)
    {
        $data['video_id'] = $video;
        $data['user_id'] = $user;
        $data['content'] = $content;
        $data['category'] = $category;
        $data['create_time'] = date('Y-m-d H:i:s', time());
        $result = M('Comment')->data($data)->add();
        return $result;
    }

    public function findByVideo($id = 0, $type = 1)
    {
        $where['video_id'] = $id;
        $where['type'] = $type;
        $model = M('Comment');
        $count = $model->where($where)->count();//总数
        $Page = new Page($count,8);//分页实例化
        $pageShow = $Page->show();// 分页显示输出
        $result = D('Comment')->Relation(true)->where($where)->order('create_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        $return['comment'] = $result;
        $return['page'] = $pageShow;

        return $return;
    }
}