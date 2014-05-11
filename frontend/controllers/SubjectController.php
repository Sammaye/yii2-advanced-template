<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Subject;

class SubjectController extends Controller
{
	public function actionIndex()
	{
		return $this->actionAdmin();
	}
	
	public function actionAdmin()
	{
		$model = new Subject;
		$model->setScenario('search');
		foreach($model->attributes() as $k){
			$model->$k = null;
		}
		$model->load($_GET);
		
		echo $this->render('admin', ['model' => $model]);
	}
	
	public function actionCreate()
	{
		$model = new Subject;
		if($model->load($_POST) && $model->validate()){
			$parent = Subject::findOne($model->parent);
			if($parent){
				$model->appendTo($parent);
			}else{
				$model->saveNode();
			}
			return $this->redirect(['admin']);
		}
		echo $this->render('form', ['model' => $model]);
	}
	
	public function actionUpdate()
	{
		$model = new Subject;
		if($oldParent = $model->ancestors(1)->one()){
			$model->parent = $oldParent = $oldParent->id;
		}
		if($model->load($_POST) && $model->saveNode()){
			if($oldParent != $model->parent){
				$model->moveAsLast(Subject::findOne($model->parent));
			}
			return $this->redirect(['admin']);
		}
		echo $this->render('form', ['model' => $model]);
	}
	
	public function actionDelete()
	{
		if(Subject::findOne($id)->delete()){
			Yii::$app->session->setFlash('success', 'That subject was deleted!');
		}else{
			Yii::$app->session->setFlash('error', 'That subject could not be deleted for some reason, dunno why');
		}
		return $this->redirect(['admin']);
	}
}