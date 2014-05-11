<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\data\ActiveDataProvider;

class Subject extends ActiveRecord
{
	public $parent;
	
	public function behaviors()
	{
		return [
			[
				'class' => 'sammaye\extensions\NestedSetBehavior',
				'hasManyRoots' => true
			]
		];
	}
	
	public static function tableName()
	{
		return '{{%subject}}';
	}
	
	public function rules()
	{
		return [
			['caption', 'string', 'max' => 250],
			[['parent', 'lft', 'rgt', 'level', 'root'], 'integer'],
			
			[['id', 'caption', 'lft', 'rgt', 'root', 'level'], 'safe', 'on' => 'search']
		];
	}
	
	public function search()
	{
		$q = static::find();
		
		$q->andFilterWhere(['like', 'id', $this->id]);
		$q->andFilterWhere(['like', 'caption', $this->caption]);
		$q->andFilterWhere(['like', 'lft', $this->lft]);
		$q->andFilterWhere(['like', 'rgt', $this->rgt]);
		$q->andFilterWhere(['like', 'root', $this->root]);
		$q->andFilterWhere(['like', 'level', $this->level]);
		
		$q->orderby(['root' => SORT_ASC]);
		
		return new ActiveDataProvider([
			'query' => $q
		]);
	}
}