<?php
use yii\helpers\Url;
?>
<div class="task-card">
    <div class="header-task">
        <a  href="<?= Url::to(['/tasks/view/', 'id' => $model->id]); ?>" class="link link--block link--big"><?= $model->title; ?></a>
        <p class="price price--task"><?= $model->budget; ?> ₽</p>
    </div>
    <p class="info-text"><span class="current-time"><?= TaskForce\Helpers::getTimePassed($model->creation_date); ?></p>
    <p class="task-text"><?= $model->description; ?>
    </p>
    <div class="footer-task">
        <p class="info-text town-text"><?= $model->city->title; ?></p>
        <p class="info-text category-text"><?= $model->category->title; ?></p>
        <a href="#" class="button button--black">Смотреть Задание</a>
    </div>
</div>
