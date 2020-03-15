<?php

namespace Restest\Domain\Presentation;

/**
 * Class Presentations
 * @package Restest\Domain\Presentation
 */
abstract class Presentations
{
    /**
     * @var
     */
    private static $_instance;

    /**
     * @param $instance
     */
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

    /**
     * @return mixed
     */
    //abstract public function forRisk();
}