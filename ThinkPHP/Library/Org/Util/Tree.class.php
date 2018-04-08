<?php
namespace Org\Util;
/*
 * 无限级分类
 * $treeList
 *    =>create() 
 *         => Admin/System
 * */
class Tree
{
	static  public $treeList = array(); //存放无限级分类结果
	
	public  function create($data,$pid = 0)
	{
		foreach($data as $key => $value){
			if($value['pid'] == $pid)
			{
				self::$treeList[] = $value;      //pid 为 0
				unset($data[$key]);              //清除
				self::create($data,$value['id']);//传入对应pid
			}
		}
		return self::$treeList;
	}
}