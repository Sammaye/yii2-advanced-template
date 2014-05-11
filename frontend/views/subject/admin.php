<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Administrate Subjects';

?>
<h1>All Subjects</h1>
<?= Html::a('Create Subject', ['create'], ['class' => 'btn btn-default']) ?>
<?= GridView::widget([
	'dataProvider' => $model->search(),
	'filterModel' => $model,
	'columns' => [
		[
			'class' => 'yii\grid\ActionColumn'
		],
		'id',
		'caption',
		'lft',
		'rgt',
		'root',
		'level'
	]
]) ?>