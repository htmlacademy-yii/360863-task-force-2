<?php

namespace TaskForce;

class AcceptAction extends Action
{
    public static function getName():string
    {
        return 'Выполнено';
    }

    public static function getCode():string
    {
        return 'accept';
    }

    public static function checkRights(int $userId, int $customerId, int $workerId):bool
    {
        return $customerId === $userId;
    }
}
