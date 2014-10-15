<?php

namespace common\components;

use yii\web\User as WebUser;

class User extends WebUser
{
	public $enableTier2 = false;
	
	public $tier2Timeout = 36000;
}