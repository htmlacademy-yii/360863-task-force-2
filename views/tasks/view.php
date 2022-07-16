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
        <a href="#" class="button button--blue">Откликнуться на задание</a>
        <div class="task-map">
            <img class="map" src="<?= Url::to(['/img/map.png']); ?>"  width="725" height="346" alt="Новый арбат, 23, к. 1">
            <p class="map-address town">Москва</p>
            <p class="map-address">Новый арбат, 23, к. 1</p>
        </div>
        <h4 class="head-regular">Отклики на задание</h4>
    <?php if ($responses): ?>
        <?php foreach ($responses as $response): ?>
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
                <div class="button-popup">
                    <a href="#" class="button button--blue button--small">Принять</a>
                    <a href="#" class="button button--orange button--small">Отказать</a>
                </div>
            </div>
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
                <?php if ($files): ?>
                <?php foreach ($files as $file): ?>
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
