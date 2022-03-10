<?php

namespace TaskForce;

class CancelAction extends Action
{

        public static function getName():string
    {
        return 'Отменить';
    }

    public static function getCode():string
    {
        return 'cancel';
    }

    public static function checkRights(int $userId, int $customerId, int $workerId):bool
    {
        return $customerId === $userId;
    }

}