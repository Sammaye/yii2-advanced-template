<?php

namespace common\rbac;

use Yii;
use yii\rbac\Rule;

Class NotGuestRule extends Rule
{
	public $name = 'notGuest';
	
	public function execute($user, $item, $params)
	{
		return !Yii::$app->user->isGuest;
	}
}