<?php

/** @var object $registration модель формы
 */

$this->title = 'Регистрация';

use yii\widgets\ActiveForm;
use \yii\helpers\Html;
use \app\models\City;

?>
<main class="container container--registration">
    <div class="center-block">
        <div class="registration-form regular-form">
            <?php $form = ActiveForm::begin([
                'method' => 'post',
                'fieldConfig' => [
                    'labelOptions' => ['class' => 'control-label'],
                ]
            ]); ?>
            <h3 class="head-main head-task">Регистрация нового пользователя</h3>
            <?= $form->field($registration, 'name'); ?>
            <div class="half-wrapper">
                <div class="form-group">
                    <?= $form->field($registration, 'email'); ?>
                </div>
                <div class="form-group">
                    <?= $form->field($registration, 'city')->dropDownList(City::getCitiesMap()); ?>
                </div>
            </div>
            <?= $form->field($registration, 'password')->passwordInput(); ?>
            <?= $form->field($registration, 'passwordRepeat')->passwordInput(); ?>
            <?= $form->field($registration, 'isWorker')->checkbox(['uncheck' => 0, 'value' => 1, 'checked' => true], false)->label('я собираюсь откликаться на заказы', ['class' => 'control-label']); ?>
            <?= Html::submitInput('Создать аккаунт', ['class' => 'button button--blue']) ;?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</main>
