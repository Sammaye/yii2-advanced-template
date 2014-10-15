<?php

namespace common\components;

use Yii;
use yii\web\Cookie;
use common\models\User as WebUser;
use common\models\Product;
use common\models\Ad;

class Controller extends \yii\web\Controller
{
	public function beforeAction($action)
	{
		if(
			Yii::$app->user->enableTier2 &&
			!Yii::$app->user->getIsGuest() &&
			Yii::$app->session->get('tier2Timeout') > time()
		){
			Yii::$app->session->set('tier2Timeout', Yii::$app->user->tier2Timeout);
		}
		return parent::beforeAction($action);
	}
}