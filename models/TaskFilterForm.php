<?php

namespace app\models;

use TaskForce\TaskStrategy;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

class TaskFilterForm extends \yii\base\Model
{

    public $category;
    public $isWorker;
    public $period;

    public function attributeLabels()
    {
        return [
            'category' => '',
            'isWorker' => 'Без исполнителя',
            'period' => '',
        ];
    }

    public function rules()
    {
        return [
            //['category', 'integer'],
            ['isWorker', 'integer'],
        ];
    }

    public function getDataProvider (): ActiveDataProvider
    {
        $query = Task::find()
            ->where (['status' => TaskStrategy::STATUS_NEW])
            ->with(['category', 'city'])
            ->orderBy(['task.creation_date' => SORT_DESC])
            ->indexBy('id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ]
        ], );

        if ($this->category){
            $query->andWhere('IN', 'category_id', $this->category);
        }

        if ($this->isWorker){
            $query->andWhere('worker_id is NULL');
        }

        if($this->period){
            $query->andWhere(new Expression('creation_date >= NOW() - INTERVAL :hours HOURS'), [
                ':hours' => $this->period,
            ]);
        }

        return $dataProvider;
    }

}