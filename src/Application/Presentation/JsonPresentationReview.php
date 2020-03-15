<?php

namespace Restest\Application\Presentation;

use Restest\Domain\Presentation\IPresentation;
//use Restest\Domain\Presentation\Presentations;
use Restest\Domain\Review;

class JsonPresentationReview extends SimpleJsonPresentation implements IPresentation
{
    public static $name = 'name';
    public static $description = 'description';

    public function __construct()
    {
        parent::__construct();

        $this->mappings[JsonPresentationReview::$name] = function (Review $object) {
            return $object->getName();
        };
        $this->mappings[JsonPresentationReview::$description] = function (Review $object) {
            return $object->getDesc();
        };
    }

    public function allDefaultProperties()
    {
        return [
            SimpleJsonPresentation::$id,
            JsonPresentationReview::$name,
            JsonPresentationReview::$description,
        ];
    }
}