<?php

namespace TaskForce;

class RejectAction extends Action
{
    public static function getName():string
    {
        return 'Отказаться';
    }

    public static function getCode():string
    {
        return 'reject';
    }

    public static function checkRights(int $userId, int $customerId, int $workerId):bool
    {
        return $workerId === $userId;
    }
}
