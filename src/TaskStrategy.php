<?php

namespace TaskForce;
use TaskForce\CancelAction;
use TaskForce\TakeAction;
use TaskForce\AcceptAction;
use TaskForce\RejectAction;

class TaskStrategy
{
    const STATUS_NEW = 'new'; //новый заказ
    const STATUS_CANCELLED = 'cancelled'; //заказ отменен
    const STATUS_ACTIVE = 'active'; //заказ в работе
    const STATUS_DONE = 'done'; //заказ выполнен
    const STATUS_FAILED = 'failed'; //заказ провален

    public $userId;
    public $workerId;
    public $customerId;
    public $status;

    public function __construct ($customerId, $userId, $workerId = null  )
    {
        $this->workerId = $workerId;
        $this->customerId = $customerId;
        $this->userId = $userId;
        $this->status = self::STATUS_NEW;
    }

    public function getStatusMap(): array
    {
            return [
                self::STATUS_NEW => 'новый',
                self::STATUS_CANCELLED => 'Отменено',
                self::STATUS_ACTIVE => 'В работе',
                self::STATUS_DONE => 'Выполнено',
                self::STATUS_FAILED => 'Провалено',
            ];
    }

    public function getActionMap(): array
    {
        return [
            AcceptAction::getName() => AcceptAction::getCode(),
            CancelAction::getName() => CancelAction::getCode(),
            RejectAction::getName() => RejectAction::getCode(),
            TakeAction::getName() => TakeAction::getCode(),
        ];
    }

    public function getNextStatus (string $action): ?string
    {
        $map = [
            CancelAction::getCode() => self::STATUS_CANCELLED,
            TakeAction::getCode() => self::STATUS_ACTIVE,
            AcceptAction::getCode() => self::STATUS_DONE,
            RejectAction::getCode() => self::STATUS_CANCELLED,
        ];

        return $map[$action] ?? null;
    }

    public function getActions (string $status): array
    {
        $map = [
            self::STATUS_NEW => [CancelAction::class, TakeAction::class],
            self::STATUS_ACTIVE => [AcceptAction::class, RejectAction::class]
        ];

        return array_filter($map[$status], function($action) {
            return call_user_func([$action, 'checkRights'], $this->userId, $this->customerId, $this->workerId);
        }) ?? [];
    }

}
