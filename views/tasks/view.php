<?php
/** @var object $task данные заданя
 * @var object $userCategories категории пользователя
 * @var object $responses отклики
 * @var object $files файлы задания
 */
use yii\helpers\Url;
use \TaskForce\TaskStrategy;
use \app\widgets\StarWidget;
$this->title = "Задание: $task->title";

?>
<main class="main-content container">
    <div class="left-column">
        <div class="head-wrapper">
            <h3 class="head-main"><?= $task->title; ?></h3>
            <p class="price price--big"><?= $task->budget; ?> ₽</p>
        </div>
        <p class="task-description"><?= $task->description; ?></p>
        <a href="#" class="button button--blue action-btn" data-action="act_response">Откликнуться на задание</a>
        <a href="#" class="button button--orange action-btn" data-action="refusal">Отказаться от задания</a>
        <a href="#" class="button button--pink action-btn" data-action="completion">Завершить задание</a>
        <div class="task-map">
            <img class="map" src="<?= Url::to(['/img/map.png']); ?>"  width="725" height="346" alt="Новый арбат, 23, к. 1">
            <p class="map-address town">Москва</p>
            <p class="map-address">Новый арбат, 23, к. 1</p>
        </div>
        <h4 class="head-regular">Отклики на задание</h4>
    <?php if ($task->responses): ?>
        <?php foreach ($task->responses as $response): ?>
            <?php if (Yii::$app->user->id === $task->customer_id ||  Yii::$app->user->id === $response->user_id): ?>
                <div class="response-card">
                    <img class="customer-photo" src="<?= $response->user->avatar; ?>" width="146" height="156" alt="Фото заказчиков">
                    <div class="feedback-wrapper">
                        <a href="<?= Url::to(['/user/view/', 'id' => $response->user->id]); ?>" class="link link--block link--big"><?= $response->user->name; ?></a>
                        <div class="response-wrapper">
                            <div class="stars-rating small"><?= StarWidget::getStars(count($response->user->reviews)); ?></div><br>
                            <p class="reviews"><?= count($response->user->reviews); ?> отзыва</p>
                        </div>
                        <p class="response-message">
                            <?= $response->message; ?>
                        </p>
                    </div>
                    <div class="feedback-wrapper">
                        <p class="info-text"><span class="current-time"><?= TaskForce\Helpers::getTimePassed($response->creation_date); ?></p>
                        <p class="price price--small"><?= $response->price; ?> ₽</p>
                    </div>

                    <?php if($task->customer_id === Yii::$app->user->getId() && $task->status === TaskStrategy::STATUS_NEW && $response->status !== TaskStrategy::RESPONSE_REJECTED): ?>
                    <div class="button-popup">
                        <a href="<?= Url::to(['/tasks/accept/', 'id' => $response->id]); ?>" class="button button--blue button--small">Принять</a>
                        <a href="<?= Url::to(['/tasks/reject/', 'id' => $response->id]); ?>" class="button button--orange button--small">Отказать</a>
                    </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    </div>
    <div class="right-column">
        <div class="right-card black info-card">
            <h4 class="head-card">Информация о задании</h4>
            <dl class="black-list">
                <dt>Категория</dt>
                <dd><?= $task->category->title; ?></dd>
                <dt>Дата публикации</dt>
                <dd><?= TaskForce\Helpers::getTimePassed($task->creation_date); ?></dd>
                <dt>Срок выполнения</dt>
                <dd><?= TaskForce\Helpers::formatDate($task->expiration_date); ?></dd>
                <dt>Статус</dt>
                <dd><?= TaskStrategy::getStatusMap()[$task->status]; ?></dd>
            </dl>
        </div>
        <div class="right-card white file-card">
            <h4 class="head-card">Файлы задания</h4>
            <ul class="enumeration-list">
                <?php if ($task->taskFiles): ?>
                <?php foreach ($task->taskFiles as $file): ?>
                <li class="enumeration-item">
                    <a href="<?= Url::to(["/uploads/{$file->file}"]); ?>" class="link link--block link--clip"><?= $file->file; ?></a>
                    <?php if ($file->size): ?>
                    <p class="file-size"><?= $file->size; ?> Кб</p>
                    <?php endif; ?>
                </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</main>
<section class="pop-up pop-up--refusal pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Отказ от задания</h4>
        <p class="pop-up-text">
            <b>Внимание!</b><br>
            Вы собираетесь отказаться от выполнения этого задания.<br>
            Это действие плохо скажется на вашем рейтинге и увеличит счетчик проваленных заданий.
        </p>
        <a class="button button--pop-up button--orange">Отказаться</a>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>
<section class="pop-up pop-up--completion pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Завершение задания</h4>
        <p class="pop-up-text">
            Вы собираетесь отметить это задание как выполненное.
            Пожалуйста, оставьте отзыв об исполнителе и отметьте отдельно, если возникли проблемы.
        </p>
        <div class="completion-form pop-up--form regular-form">
            <form>
                <div class="form-group">
                    <label class="control-label" for="completion-comment">Ваш комментарий</label>
                    <textarea id="completion-comment"></textarea>
                </div>
                <p class="completion-head control-label">Оценка работы</p>
                <div class="stars-rating big active-stars"><span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span></div>
                <input type="submit" class="button button--pop-up button--blue" value="Завершить">
            </form>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>
<section class="pop-up pop-up--act_response pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Добавление отклика к заданию</h4>
        <p class="pop-up-text">
            Вы собираетесь оставить свой отклик к этому заданию.
            Пожалуйста, укажите стоимость работы и добавьте комментарий, если необходимо.
        </p>
        <div class="addition-form pop-up--form regular-form">
            <form>
                <div class="form-group">
                    <label class="control-label" for="addition-comment">Ваш комментарий</label>
                    <textarea id="addition-comment"></textarea>
                </div>
                <div class="form-group">
                    <label class="control-label" for="addition-price">Стоимость</label>
                    <input id="addition-price" type="text">
                </div>
                <input type="submit" class="button button--pop-up button--blue" value="Завершить">
            </form>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>
<div class="overlay"></div>
