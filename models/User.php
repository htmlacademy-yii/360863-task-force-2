<?php

namespace app\models;

use TaskForce\TaskStrategy;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $registration_date
 * @property string $name
 * @property string $email
 * @property string $password
 *  * @property string $password_repeat
 * @property string|null $avatar
 * @property string|null $birth_date
 * @property string|null $telephone
 * @property string|null $telegram
 * @property string|null $description
 * @property int|null $city_id
 * @property int $is_worker
 *
 * @property City $city
 * @property Response[] $responses
 * @property Task[] $tasks
 * @property Task[] $tasks0
 * @property UserCategory[] $userCategories

 */

class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['registration_date', 'birth_date'], 'safe'],
            [['name', 'email', 'password'], 'required'],
            [['city_id'], 'integer'],
            [['name', 'email', 'telegram'], 'string', 'max' => 45],
            [['password', 'password_repeat', 'avatar', 'description'], 'string', 'max' => 255],
            [['telephone'], 'string', 'max' => 20],
            [['email'], 'unique'],
            [['city_id'], 'exist', 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
            [['is_worker'], 'integer', 'max' => 1],
            ['password', 'compare'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'registration_date' => 'Registration Date',
            'name' => 'Ваше имя',
            'email' => 'Email',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'avatar' => 'Avatar',
            'birth_date' => 'Birth Date',
            'telephone' => 'Telephone',
            'telegram' => 'Telegram',
            'description' => 'Description',
            'city_id' => 'Город',
            'is_worker' => 'я собираюсь откликаться на заказы'
        ];
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['customer_id' => 'id']);
    }


    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategory::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Review]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['worker_id' => 'id']);
    }

    public function getWorkerStatus(): string
    {
        if (Task::find()->where(['worker_id' => $this->id, 'status' => TaskStrategy::STATUS_ACTIVE])->all()) {
            return 'Занят' ;
        } else {
            return 'Открыт для новых заказов';
        }
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}
