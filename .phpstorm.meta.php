<?php
	namespace PHPSTORM_META {
	/** @noinspection PhpUnusedLocalVariableInspection */
	/** @noinspection PhpIllegalArrayKeyTypeInspection */
	$STATIC_METHOD_TYPES = [

		\D('') => [
			'Adv' instanceof Think\Model\AdvModel,
			'Mongo' instanceof Think\Model\MongoModel,
			'View' instanceof Think\Model\ViewModel,
			'Relation' instanceof Think\Model\RelationModel,
			'Course' instanceof Common\Model\CourseModel,
			'User' instanceof Common\Model\UserModel,
			'Merge' instanceof Think\Model\MergeModel,
		],
		\DL('') => [
			'CourseLogic' instanceof Common\Logic\CourseLogic,
			'UserLogic' instanceof Common\Logic\UserLogic,
		],
	];
}