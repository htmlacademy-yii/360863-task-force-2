<?php

namespace TaskForce;

abstract class Action
{
    abstract public static function getName():string;
    abstract public static function getCode():string;
    abstract public static function checkRights(int $userId, int $customerId, int $workerId):bool;
}
