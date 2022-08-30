<?php
/** @var object $task данные задания
 * @var object $responses отклики
 * @var object $response объект формы отклика
 * @var object $review объект формы отзыва
 *
 */

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use TaskForce\TaskStrategy;

?>

<?php if ($task->status === TaskStrategy::STATUS_NEW && Yii::$app->user->id !== $task->customer_id): ?>
<a href="#" class="button button--blue action-btn" data-action="act_response">Откликнуться на задание</a>
<section class="pop-up pop-up--act_response pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Добавление отклика к заданию</h4>
        <p class="pop-up-text">
            Вы собираетесь оставить свой отклик к этому заданию.
            Пожалуйста, укажите стоимость работы и добавьте комментарий, если необходимо.
        </p>
        <div class="addition-form pop-up--form regular-form">
            <?php $formTake = ActiveForm::begin([
                'id' => 'take-form',
                'method' => 'post'
            ]); ?>
            <form>
                <div class="form-group">
                    <?= $formTake->field($response, 'message')->textarea(['rows' => '6']) ?>
                </div>
                <div class="form-group">
                    <?= $formTake->field($response, 'price')->textInput(['type' => 'number']) ?>
                </div>
                <?= Html::submitInput('Завершить', ['class' => 'button button--pop-up button--blue']) ;?>
            </form>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>

<?php elseif ($task->status === TaskStrategy::STATUS_ACTIVE && Yii::$app->user->id === $task->worker_id): ?>
<a href="#" class="button button--orange action-btn" data-action="refusal">Отказаться от задания</a>
<section class="pop-up pop-up--refusal pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Отказ от задания</h4>
        <p class="pop-up-text">
            <b>Внимание!</b><br>
            Вы собираетесь отказаться от выполнения этого задания.<br>
            Это действие плохо скажется на вашем рейтинге и увеличит счетчик проваленных заданий.
        </p>
        <a class="button button--pop-up button--orange" href="<?= Url::to(['/tasks/reject-task/', 'id' => $task->id]); ?>">Отказаться</a>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>

<?php elseif ($task->status === TaskStrategy::STATUS_ACTIVE && Yii::$app->user->id === $task->customer_id): ?>
<a href="#" class="button button--pink action-btn" data-action="completion">Завершить задание</a>
<section class="pop-up pop-up--completion pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Завершение задания</h4>
        <p class="pop-up-text">
            Вы собираетесь отметить это задание как выполненное.
            Пожалуйста, оставьте отзыв об исполнителе и отметьте отдельно, если возникли проблемы.
        </p>
        <div class="completion-form pop-up--form regular-form">
            <?php $formAccept = ActiveForm::begin([
                'method' => 'post'
            ]); ?>
            <form>
                <div class="form-group">
                    <?= $formAccept->field($review, 'description')->textarea(['rows' => '6']) ?>
                </div>
                <?= $formAccept->field($review, 'grade')->radioList(array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5)) ;?>
                <div class="stars-rating big active-stars"><span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span></div>
                <?= Html::submitInput('Завершить', ['class' => 'button button--pop-up button--blue']) ;?>
            </form>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>

<?php elseif ($task->status === TaskStrategy::STATUS_NEW && Yii::$app->user->id === $task->customer_id): ?>
<a href="#" class="button button--orange action-btn" data-action="cancel">Отменить задание</a>
<section class="pop-up pop-up--cancel pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Отмена задания</h4>
        <p class="pop-up-text">
            <b>Внимание!</b><br>
            Вы собираетесь отменить это задание.<br>
        </p>
        <a class="button button--pop-up button--orange" href="<?= Url::to(['/tasks/cancell-task/', 'id' => $task->id]); ?>">Отменить</a>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>

<?php endif; ?>