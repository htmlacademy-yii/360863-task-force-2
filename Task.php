<?php

class Task
{
    const STATUS_NEW = 'new'; //новый заказ
    const STATUS_CANCELLED = 'cancelled'; //заказ отменен
    const STATUS_ACTIVE = 'active'; //заказ в работе
    const STATUS_DONE = 'done'; //заказ выполнен
    const STATUS_FAILED = 'failed'; //заказ провален
    const ACTION_CANCEL = 'cancel'; //отменить заказ
    const ACTION_TAKE = 'take'; //взять заказ
    const ACTION_ACCEPT = 'accept'; //принять заказ
    const ACTION_REJECT = 'reject'; //отказаться от заказа

    public $workerId;
    public $customerId;
    public $status;

    public function __construct ($customerId, $workerId = null )
    {
        $this->workerId = $workerId;
        $this->customerId = $customerId;
        $this->status = self::STATUS_NEW;
    }

    public function getMap(): array
    {
            return [
                self::STATUS_NEW => 'новый',
                self::STATUS_CANCELLED => 'Отменено',
                self::STATUS_ACTIVE => 'В работе',
                self::STATUS_DONE => 'Выполнено',
                self::STATUS_FAILED => 'Провалено',
                self::ACTION_CANCEL => 'Отменить',
                self::ACTION_TAKE => 'Откликнуться',
                self::ACTION_ACCEPT => 'Выполнено',
                self::ACTION_REJECT => 'Отказаться'
            ];
    }

    public function getNextStatus (string $action): string
    {
        $map = [
            self::ACTION_CANCEL => self::STATUS_CANCELLED,
            self::ACTION_TAKE => self::STATUS_ACTIVE,
            self::ACTION_ACCEPT => self::STATUS_DONE,
            self::ACTION_REJECT => self::STATUS_CANCELLED,
        ];

        return $map[$action];
    }

    public function getActions (string $status): array
    {
        $map = [
            self::STATUS_NEW => [self::ACTION_CANCEL, self::ACTION_TAKE],
            self::STATUS_ACTIVE => [self::ACTION_ACCEPT, self::ACTION_REJECT]
        ];
        return $map[$status];
    }

}