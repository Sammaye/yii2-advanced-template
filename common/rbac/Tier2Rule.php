<?php

namespace common\rbac;

use Yii;
use yii\rbac\Rule;

Class Tier2Rule extends Rule
{
	public $name = 'tier2';
	public $loginUrl = ['site/login'];
	
	public function execute($user, $item, $params)
	{
		if(Yii::$app->user->isGuest){
			$request = Yii::$app->getRequest();
			if (!$request->getIsAjax()) {
				Yii::$app->user->setReturnUrl($request->getUrl());
			}
			Yii::$app->getResponse()->redirect($this->loginUrl);
			Yii::$app->end();
			return false;
		}
		
		if(
			!Yii::$app->user->isGuest &&
			Yii::$app->session->get('tier2Timeout') > time()
		){
			return true;
		}
		$request = Yii::$app->getRequest();
		$user = Yii::$app->getUser();
		if(!$request->getIsAjax()){
			$user->setReturnUrl($request->getUrl());
		}
		Yii::$app->getResponse()->redirect(['site/confirm-login']);
		Yii::$app->end();
		return false;
	}
}