<?php

namespace app\models;

use TaskForce\TaskStrategy;
use yii\data\ActiveDataProvider;
use yii\db\Expression;


function debug($data, $die = false){
    echo "<pre>" . print_r($data, 1) . "</pre>";
    if($die){
        die;
    }
}

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

        if ($this->category){
            $array = implode(',', $this->category);
            debug($this->category);
            $query->andWhere( "category_id IN ($array)");
        }

        if ($this->isWorker){
            debug($this->category);
            $query->andWhere('worker_id is NULL');
        }

        if($this->period){
            $query->andWhere(new Expression('creation_date >= NOW() - INTERVAL :hours HOURS'), [
                ':hours' => $this->period,
            ]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 1,
            ]
        ], );

        return $dataProvider;
    }

}