<?php

namespace common\components;

use Yii;

class Request extends \yii\web\Request
{
	/**
	 * By default CSRF will be turned on but disabled for all actions.
	 * This will turn Allow CSRF to run on certain actions, for example put add "user/login" as 
	 * an element in this array to have CSRF run there
	 */
	public $csrfRoutes = [];
	
	public $enableSslRoutes = true;
	
	/**
	 * For a site that is not completely SSL you define SSL routes, i.e.: site/login
	 */
	public $sslRoutes = [];

	public function validateCsrfToken()
	{
		if(
			$this->enableCsrfValidation &&
			!in_array(Yii::$app->getUrlManager()->parseRequest($this)[0], $this->csrfRoutes)
		){
			return true;
		}
		return parent::validateCsrfToken();
	}
}