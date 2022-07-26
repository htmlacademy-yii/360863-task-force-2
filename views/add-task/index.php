<?php

/** @var object $task модель формы
 * @var object $files модель формы
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Category;

?>

<main class="main-content main-content--center container">
    <div class="add-task-form regular-form">
        <?php $form = ActiveForm::begin([
                'options' => [
                        'enctype' => 'multipart/form-data',
                ],
        ]);  ?>
        <h3 class="head-main head-main">Публикация нового задания</h3>
        <div class="form-group">
            <?= $form->field($task, 'title'); ?>
        </div>
        <div class="form-group">
            <?= $form->field($task, 'description'); ?>
        </div>
        <div class="form-group">
            <?= $form->field($task, 'category_id')->dropDownList(Category::getCategoriesMap()); ?>
        </div>
        <div class="form-group">
            <?= $form->field($task, 'location'); ?>
        </div>
        <div class="half-wrapper">
            <div class="form-group">
                <?= $form->field($task, 'budget'); ?>
            </div>
            <div class="form-group">
                <?= $form->field($task, 'expiration_date')->textInput(['type' => 'datetime-local', 'value' => str_replace(date('Y-m-d', strtotime($task->expiration_date)).' ',date('Y-m-d', strtotime($task->expiration_date)).'T', $task->expiration_date)]); ?>
            </div>
        </div>
        <?= $form->field($files, 'files[]')->fileInput(['multiple' => true, 'class' => 'new-file']); ?>
        <?= Html::submitInput('Опубликовать', ['class' => 'button button--blue add-task-blue']) ;?>
        <?php ActiveForm::end(); ?>
    </div>

</main>

