<?php
/** @var object $task данные заданя
 * @var object $userCategories категории пользователя
 * @var object $responses отклики
 * @var object $files файлы задания
 * @var object $response объект формы отклика
 * @var object $review объект формы отзыва
 *
 */

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use TaskForce\TaskStrategy;
use app\widgets\StarWidget;
use yii\widgets\ActiveForm;

$this->title = "Задание: $task->title";

?>
<main class="main-content container">
    <div class="left-column">
        <div class="head-wrapper">
            <h3 class="head-main"><?= $task->title; ?></h3>
            <p class="price price--big"><?= $task->budget; ?> ₽</p>
        </div>
        <p class="task-description"><?= $task->description; ?></p>
        <?= $this->render('_buttons',['task' => $task, 'review' => $review, 'response' => $response,]); ?>
        <div class="task-map">
            <img class="map" src="<?= Url::to(['/img/map.png']); ?>"  width="725" height="346" alt="Новый арбат, 23, к. 1">
            <p class="map-address town">Москва</p>
            <p class="map-address">Новый арбат, 23, к. 1</p>
        </div>
        <h4 class="head-regular">Отклики на задание</h4>
    <?php if ($task->responses): ?>
        <?php foreach ($task->responses as $response): ?>
            <?php if (in_array(Yii::$app->user->id, [$task->customer_id, $response->user_id])): ?>
                <div class="response-card">
                    <img class="customer-photo" src="<?= $response->user->avatar; ?>" width="146" height="156" alt="Фото заказчиков">
                    <div class="feedback-wrapper">
                        <a href="<?= Url::to(['/user/view/', 'id' => $response->user->id]); ?>" class="link link--block link--big"><?= $response->user->name; ?></a>
                        <div class="response-wrapper">
                            <?php if ($response->user->reviews): ?>
                            <div class="stars-rating small"><?= StarWidget::getStars(array_sum(array_column($response->user->reviews, 'grade')) / (count($response->user->reviews) + count($response->user->failed))); ?></div><br>
                            <?php endif; ?>
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
<div class="overlay"></div>
