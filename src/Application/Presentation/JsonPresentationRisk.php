<?php


namespace Restest\Application\Presentation;

use Restest\Domain\Presentation\IPresentation;
use Restest\Domain\Risk;


class JsonPresentationRisk extends SimpleJsonPresentation implements IPresentation
{
    public static $name = 'name';

    public function __construct()
    {
        parent::__construct();

        $this->mappings[JsonPresentationRisk::$name] = function (Risk $object) {
            return $object->getName();
        };
    }

    public function allDefaultProperties()
    {
        return [
            SimpleJsonPresentation::$id,
            JsonPresentationRisk::$name,
        ];
    }
}