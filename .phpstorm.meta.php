<?php
	namespace PHPSTORM_META {
	/** @noinspection PhpUnusedLocalVariableInspection */
	/** @noinspection PhpIllegalArrayKeyTypeInspection */
	$STATIC_METHOD_TYPES = [

		\D('') => [
			'Adv' instanceof Think\Model\AdvModel,
			'Mongo' instanceof Think\Model\MongoModel,
			'View' instanceof Think\Model\ViewModel,
			'Video' instanceof Common\Model\VideoModel,
			'Relation' instanceof Think\Model\RelationModel,
			'Question' instanceof Common\Model\QuestionModel,
			'CourseView' instanceof Common\Model\CourseViewModel,
			'Course' instanceof Common\Model\CourseModel,
			'User' instanceof Common\Model\UserModel,
			'Choose' instanceof Common\Model\ChooseModel,
			'Merge' instanceof Think\Model\MergeModel,
			'Comment' instanceof Common\Model\CommentModel,
		],
		\DL('') => [
			'CourseLogic' instanceof Common\Logic\CourseLogic,
			'UserLogic' instanceof Common\Logic\UserLogic,
			'QuestionLogic' instanceof Common\Logic\QuestionLogic,
			'VideoLogic' instanceof Common\Logic\VideoLogic,
			'CommentLogic' instanceof Common\Logic\CommentLogic,
			'RankLogic' instanceof Common\Logic\RankLogic,
			'ChooseLogic' instanceof Common\Logic\ChooseLogic,
		],
	];
}