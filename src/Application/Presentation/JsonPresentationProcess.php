<?php


namespace Restest\Application\Presentation;

use Restest\Domain\Presentation\IPresentation;
use Restest\Domain\Presentation\Presentations;
use Restest\Domain\Process;

class JsonPresentationProcess extends SimpleJsonPresentation implements IPresentation
{
    public static $user = 'user_id';
    public static $contract = 'contract_id';

    public function __construct()
    {
        parent::__construct();

        $this->mappings[JsonPresentationProcess::$user] = function (Process $object) {
            return is_null($object->getUser()) ? "" : Presentations::instance()->forUser()->inJson($object->getUser());
        };
        $this->mappings[JsonPresentationProcess::$contract] = function (Process $object) {
            return is_null($object->getContract()) ? "" : Presentations::instance()->forContract()->inJson($object->getContract());
        };
    }

    public function allDefaultProperties()
    {
        return [
            SimpleJsonPresentation::$id,
            JsonPresentationProcess::$user,
        ];
    }
}