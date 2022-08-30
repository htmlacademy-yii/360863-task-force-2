<?php

namespace app\models;

use TaskForce\TaskStrategy;
use Yii;

/**
 * This is the model class for table "response".
 *
 * @property int $id
 * @property string|null $message
 * @property int $price
 * @property string $creation_date
 * @property int $task_id
 * @property int $user_id
 *
 * @property Task $task
 * @property User $user
 */
class Response extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'response';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'task_id', 'user_id'], 'required'],
            [['price', 'task_id', 'user_id'], 'integer'],
            [['creation_date'], 'safe'],
            [['message'], 'string', 'max' => 255],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            ['user_id','checkRole'],
            ['user_id','checkUnique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Ваш комментарий',
            'price' => 'Стоимость',
            'creation_date' => 'Creation Date',
            'task_id' => 'Task ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    protected function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function checkUnique() {
        if (Response::find()->where(['task_id' => $this->task_id, 'user_id' => $this->user_id])->one()) {
            $this->addError('user_id', 'Ваш запрос уже отправлен, повторная отправка не возможна');
        }
    }

    public function checkRole() {
        if (User::find()->where(['id' => $this->user_id])->one()->is_worker !== TaskStrategy::USER_WORKER) {
            $this->addError('user_id', 'Пользователь должен быть исполнителем');
        }
    }

    public function formName()
    {
        return 'responseForm';
    }
}
