<?php

namespace TaskForce;

class TakeAction extends Action
{
    public static function getName():string
    {
        return 'Откликнуться';
    }

    public static function getCode():string
    {
        return 'take';
    }

    public static function checkRights(int $userId, int $customerId, int $workerId):bool
    {
        return $workerId === $userId;
    }
}
