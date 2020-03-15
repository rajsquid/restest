<?php

namespace Restest\Application\Presentation;

use Restest\Domain\Presentation\IPresentation;
use Restest\Domain\Role;

class JsonPresentationRole extends SimpleJsonPresentation implements IPresentation
{
    public static $name = 'name';

    public function __construct()
    {
        parent::__construct();

        $this->mappings[JsonPresentationRole::$name] = function (Role $object) {
            return $object->getName();
        };
    }

    public function allDefaultProperties()
    {
        return [
            SimpleJsonPresentation::$id,
            JsonPresentationRole::$name,
        ];
    }
}