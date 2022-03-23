<?php

namespace TaskForce;
use TaskForce\AcceptAction;
use TaskForce\CancelAction;
use TaskForce\RejectAction;
use TaskForce\TakeAction;
use TaskForce\Exception\ActionException;
use TaskForce\Exception\StatusException;

class TaskStrategy
{
    const STATUS_NEW = 'new'; //новый заказ
    const STATUS_CANCELLED = 'cancelled'; //заказ отменен
    const STATUS_ACTIVE = 'active'; //заказ в работе
    const STATUS_DONE = 'done'; //заказ выполнен
    const STATUS_FAILED = 'failed'; //заказ провален

    public int $userId;
    public int $workerId;
    public int $customerId;
    public string $status;

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
            AcceptAction::getCode() => AcceptAction::getName(),
            CancelAction::getCode() => CancelAction::getName(),
            RejectAction::getCode() => RejectAction::getName(),
            TakeAction::getCode() => TakeAction::getName(),
        ];
    }

    public function getNextStatus (string $action): ?string
    {
        if (!array_key_exists($action, $this->getActionMap())){
            throw new ActionException;
        }

        $map = [
            AcceptAction::getCode() => self::STATUS_DONE,
            CancelAction::getCode() => self::STATUS_CANCELLED,
            RejectAction::getCode() => self::STATUS_CANCELLED,
            TakeAction::getCode() => self::STATUS_ACTIVE,
        ];

        return $map[$action] ?? null;
    }

    public function getActions (string $status): array
    {
        if (!array_key_exists($status, $this->getStatusMap())){
            throw new StatusException;
        }

        $map = [
            self::STATUS_NEW => [CancelAction::class, TakeAction::class],
            self::STATUS_ACTIVE => [AcceptAction::class, RejectAction::class]
        ];

        return array_filter($map[$status], function($action) {
            return call_user_func([$action, 'checkRights'], $this->userId, $this->customerId, $this->workerId);
        }) ?? [];
    }
}
