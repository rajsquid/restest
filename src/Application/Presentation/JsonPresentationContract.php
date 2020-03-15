<?php

namespace Restest\Application\Presentation;

use Restest\Domain\Presentation\IPresentation;
use Restest\Domain\Presentation\Presentations;
use Restest\Domain\Contract;

class JsonPresentationContract extends SimpleJsonPresentation implements IPresentation
{
    public static $name = 'name';
    public static $risk = 'risk_id';

    public function __construct()
    {
        parent::__construct();

        $this->mappings[JsonPresentationContract::$name] = function (Contract $object) {
            return $object->getName();
        };
        $this->mappings[JsonPresentationContract::$risk] = function (Contract $object) {
            return is_null($object->getRisk()) ? "" : Presentations::instance()->forRisk()->inJson($object->getRisk());
        };
    }

    public function allDefaultProperties()
    {
        return [
            SimpleJsonPresentation::$id,
            JsonPresentationContract::$name,
            JsonPresentationContract::$risk,
        ];
    }
}