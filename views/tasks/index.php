<?php
/** @var object $tasks данные заданий
 * @var object $filter модель формы
 */
function debug($data, $die = false){
    echo "<pre>" . print_r($data, 1) . "</pre>";
    if($die){
        die;
    }
}

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use \app\models\Category;

?>
<div class="left-column">
    <h3 class="head-main head-task">Новые задания</h3>
<!--    --><?php //debug($taskFilterForm);?>
<!--    --><?php //debug($categoryList); ?>

    <?php \yii\widgets\ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_details'
    ]); ?>

<!--    --><?php //if(!empty($tasks)): ?>
<!---->
<!--        --><?php //foreach ($tasks as $task): ?>
<!--            <div class="task-card">-->
<!--                <div class="header-task">-->
<!--                    <a  href="#" class="link link--block link--big">--><?//=$task->title; ?><!--</a>-->
<!--                    <p class="price price--task">--><?//=$task->budget; ?><!-- ₽</p>-->
<!--                </div>-->
<!--                <p class="info-text"><span class="current-time">--><?//=TaskForce\Helpers::getTimePassed($task->creation_date); ?><!--</p>-->
<!--                <p class="task-text">--><?//=$task->description; ?>
<!--                </p>-->
<!--                <div class="footer-task">-->
<!--                    <p class="info-text town-text">--><?//=$task->city->title; ?><!--</p>-->
<!--                    <p class="info-text category-text">--><?//=$task->category->title; ?><!--</p>-->
<!--                    <a href="#" class="button button--black">Смотреть Задание</a>-->
<!--                </div>-->
<!--            </div>-->
<!--        --><?php //endforeach; ?>
<!---->
<!--    --><?php //else: ?>
<!--        <p>Новых заданий нет</p>-->
<!--    --><?php //endif; ?>

    <div class="pagination-wrapper">
        <ul class="pagination-list">
            <li class="pagination-item mark">
                <a href="#" class="link link--page"></a>
            </li>
            <li class="pagination-item">
                <a href="#" class="link link--page">1</a>
            </li>
            <li class="pagination-item pagination-item--active">
                <a href="#" class="link link--page">2</a>
            </li>
            <li class="pagination-item">
                <a href="#" class="link link--page">3</a>
            </li>
            <li class="pagination-item mark">
                <a href="#" class="link link--page"></a>
            </li>
        </ul>
    </div>
</div>
<div class="right-column">
    <div class="right-card black">
        <div class="search-form">
            <?php $form = ActiveForm::begin([
                'method' => 'get'
            ]); ?>
            <form>
                <h4 class="head-card">Категории</h4>
                <div class="form-group">
                    <div>
                        <?= $form->field($filter, 'category')->checkboxList($categoryList);?>
                    </div>
                </div>
                <h4 class="head-card">Дополнительно</h4>
                <div class="form-group">
                    <?= $form->field($filter, 'isWorker')->checkbox([0 => 'Без исполнителя', 'checked'=>1]); ?>
                </div>
                <h4 class="head-card">Период</h4>
                <div class="form-group">
                <?= $form->field($filter, 'period')->dropdownList($periodList); ?>
                </div>
                <?= Html::submitButton('Искать', ['class' => 'button button--blue']); ?>
            </form>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
