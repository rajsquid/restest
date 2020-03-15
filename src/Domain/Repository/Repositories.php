<?php

namespace Restest\Domain\Repository;

abstract class Repositories
{
    private static $_instance;

    public static function initialize($instance)
    {
        static::$_instance = $instance;
    }

    /**
     * @return mixed
     */
    public static function instance()
    {
        return static::$_instance;
    }

    abstract public function forUser();

    abstract public function forContract();

    abstract public function forRole();

    abstract public function forRisk();

    abstract public function forProcess();

    abstract public function forReview();

    abstract public function beginTransaction();

    abstract public function rollback();

    abstract public function commit();
}