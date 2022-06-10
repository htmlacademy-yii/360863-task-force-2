<?php
/** @var object $tasks данные заданий
 * @var object $filter модель формы
 *  * @var ActiveDataProvider $dataProvider дата провайдер
 */

use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use \app\models\Category;
use \app\models\TaskFilterForm;
use \yii\widgets\ListView;



?>
<main class="main-content container">
    <div class="left-column">
        <h3 class="head-main head-task">Новые задания</h3>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_details',
            'pager' => [
                'hideOnSinglePage' => 'true',
                'pageCssClass' => 'pagination-item',
                'activePageCssClass' => 'pagination-item--active',
                'nextPageCssClass' => 'pagination-item mark',
                'prevPageCssClass' => 'pagination-item mark',
                'prevPageLabel' =>'',
                'nextPageLabel' => '',
                'options' => [
                    'class' => 'pagination-list',
                ],
                'linkOptions' => [
                    'class' => 'link link--page',
                ],
            ],
        ]); ?>
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
                            <?= $form->field($filter, 'category')->checkboxList(Category::getCategoriesMap()); ?>
                        </div>
                    </div>
                    <h4 class="head-card">Дополнительно</h4>
                    <div class="form-group">
                        <?= $form->field($filter, 'isWorker')->checkbox(['uncheck' => '1', 'value' => 0, 'checked'=>'checked']); ?>
                    </div>
                    <h4 class="head-card">Период</h4>
                    <div class="form-group">
                    <?= $form->field($filter, 'period')->dropdownList(TaskFilterForm::getPeriodList()); ?>
                    </div>
                    <?= Html::submitButton('Искать', ['class' => 'button button--blue']); ?>
                </form>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</main>
