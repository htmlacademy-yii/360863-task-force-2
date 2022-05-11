<?php
/** @var object $user данные пользователя
 * @var object $userCategories категорий пользователя
 * @var object $reviews отзывы пользователя
 * @var string $totalDone количество выполненных заданий
 * @var string $averageGrade средний рейтинг
 */

?>


<div class="left-column">
    <h3 class="head-main"><?=$user->name; ?></h3>
    <div class="user-card">
        <div class="photo-rate">
            <img class="card-photo" src="<?=$user->avatar; ?>" width="191" height="190" alt="Фото пользователя">
            <div class="card-rate">
                <div class="stars-rating big"><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span>&nbsp;</span></div>
                <span class="current-rate"><?=$averageGrade;?></span>
            </div>
        </div>
        <p class="user-description">
            <?=$user->description; ?>
        </p>
    </div>
    <div class="specialization-bio">
        <div class="specialization">
            <p class="head-info">Специализации</p>
            <ul class="special-list">
                <?php foreach ($userCategories as $userCategory): ?>
                <li class="special-item">
                    <a href="#" class="link link--regular"><?=$userCategory->category->title; ?></a>
                </li>
                <?php endforeach; ?>

            </ul>
        </div>
        <div class="bio">
            <p class="head-info">Био</p>
            <p class="bio-info"><span class="country-info">Россия</span>, город <span class="town-info"><?=$user->city->title; ?></span>, <span class="age-info"><?= TaskForce\Helpers::getAge($user->birth_date);?></span></p>
        </div>
    </div>
    <h4 class="head-regular">Отзывы заказчиков</h4>

    <?php if ($reviews): ?>
        <?php foreach ($reviews as $review): ?>
            <div class="response-card">
                <img class="customer-photo" src="<?=$review->customer->avatar;?>" width="120" height="127" alt="Фото заказчиков">
                <div class="feedback-wrapper">
                    <p class="feedback">«<?=$review->description;?>»</p>
                    <p class="task">Задание «<a href="#" class="link link--small"><?=$review->task->title;?></a>» выполнено</p>
                </div>
                <div class="feedback-wrapper">
                    <div class="stars-rating small"><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span>&nbsp;</span></div>
                    <p class="info-text"><span class="current-time"><?=TaskForce\Helpers::getTimePassed($review->creation_date);?></span></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>
<div class="right-column">
    <div class="right-card black">
        <h4 class="head-card">Статистика исполнителя</h4>
        <dl class="black-list">
            <dt>Всего заказов</dt>
            <dd><?=$totalDone; ?> выполнено, <?=$totalFailed; ?> провалено</dd>
            <dt>Место в рейтинге</dt>
            <dd>25 место</dd>
            <dt>Дата регистрации</dt>
            <dd><?=TaskForce\Helpers::formatDate($user->registration_date); ?></dd>
            <dt>Статус</dt>
            <dd>Открыт для новых заказов</dd>
        </dl>
    </div>
    <div class="right-card white">
        <h4 class="head-card">Контакты</h4>
        <ul class="enumeration-list">
            <li class="enumeration-item">
                <a href="#" class="link link--block link--phone"><?=$user->telephone; ?></a>
            </li>
            <li class="enumeration-item">
                <a href="#" class="link link--block link--email"><?=$user->email; ?></a>
            </li>
            <li class="enumeration-item">
                <a href="#" class="link link--block link--tg"><?=$user->telegram; ?></a>
            </li>
        </ul>
    </div>
</div>
