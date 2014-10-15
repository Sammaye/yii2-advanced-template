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
		if(Yii::$app->request->enableSslRoutes){
			/**
			 * This piece of code here is to allow partial SSL for the minute while we cannot fully use SSL all over the site
			 */
			$found = false;
			foreach(Yii::$app->request->sslRoutes as $route){
				if($route == Yii::$app->controller->id . '/' . Yii::$app->controller->action->id){
					$found = true;
					if(!Yii::$app->request->getIsSecureConnection() && !isset(error_get_last()['type'])){
						$sslUrl = Yii::$app->getUrlManager()->createAbsoluteUrl(Yii::$app->request->absoluteUrl, 'https');
						return Yii::$app->controller->redirect($sslUrl)->send();
					}
				}
			}
					
			if(
				Yii::$app->request->getIsSecureConnection() &&
				!$found &&
				(Yii::$app->controller->id . '/' . Yii::$app->controller->action->id !== 'site/error')
			){
				$httpUrl = Yii::$app->getUrlManager()->createAbsoluteUrl(Yii::$app->request->absoluteUrl, 'http');
				return Yii::$app->controller->redirect($httpUrl)->send();
			}
		}
		
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