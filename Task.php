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
    public $userId;
    public $status;

    public function __construct ($customerId, $workerId = null )
    {
        $this->workerId = $workerId;
        $this->customerId = $customerId;
        $this->status = self::STATUS_NEW;
    }

    public function getMap()
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

    public function getNextStatus ($action)
    {
        if ($action === self::ACTION_CANCEL) {
            return self::STATUS_CANCELLED;
        } elseif ($action === self::ACTION_TAKE) {
            return self::STATUS_ACTIVE;
        } elseif ($action === self::ACTION_ACCEPT) {
            return self::STATUS_DONE;
        } elseif ($action === self::ACTION_REJECT) {
            return self::STATUS_CANCELLED;
        }
        return [];
    }

    public function getActions ($status)
    {
        if ($status === self::STATUS_NEW && $this->userId === $this->workerId) {
            return self::ACTION_CANCEL;
        } elseif ($status === self::STATUS_NEW && $this->userId === $this->customerId) {
            return self::ACTION_TAKE;
        } elseif ($status === self::STATUS_ACTIVE && $this->userId === $this->customerId) {
            return self::ACTION_ACCEPT;
        } elseif ($status === self::STATUS_ACTIVE && $this->userId === $this->workerId) {
            return self::ACTION_REJECT;
        }
        return [];
    }

}