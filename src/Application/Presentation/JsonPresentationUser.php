<?php

namespace Restest\Application\Presentation;

use Restest\Domain\Presentation\IPresentation;
use Restest\Domain\Presentation\Presentations;
use Restest\Domain\User;

class JsonPresentationUser extends SimpleJsonPresentation implements IPresentation
{
    public static $name = 'name';
    public static $email = 'email';
    public static $role = 'role_id';

    public function __construct()
    {
        parent::__construct();

        $this->mappings[JsonPresentationUser::$name] = function (User $object) {
            return $object->getName();
        };
        $this->mappings[JsonPresentationUser::$email] = function (User $object) {
            return $object->getEmail();
        };
        $this->mappings[JsonPresentationUser::$role] = function (User $object) {
            return is_null($object->getRole()) ? "" : Presentations::instance()->forRole()->inJson($object->getRole());
        };
    }

    public function allDefaultProperties()
    {
        return [
            SimpleJsonPresentation::$id,
            JsonPresentationUser::$name,
            JsonPresentationUser::$email,
            JsonPresentationUser::$role,
        ];
    }
}