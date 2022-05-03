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

    public static function getPeriodList()
    {
        return [
            0 => 'весь период',
            1 => '1 час',
            12 => '12 часов',
            24 => '24 часа',
        ];
    }

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
            ['category', 'each',  'rule' => ['integer']],
            ['isWorker', 'number'],
            [['category', 'isWorker', 'period'], 'safe']
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
            $query->andWhere( "category_id IN ($array)");
        }

        if (!$this->isWorker){
            $query->andWhere('worker_id is NULL');
        } else {
            $query->andWhere('worker_id > 0');
        }

        if($this->period){
            $query->andWhere(new Expression('creation_date >= NOW() - INTERVAL :hours HOUR'), [
                ':hours' => $this->period,
            ]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ]
        ], );
    }

}