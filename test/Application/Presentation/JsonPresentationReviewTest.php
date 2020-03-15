<?php

namespace Restest\Application\Presentation;

class JsonPresentationReviewTest extends \PHPUnit\Framework\TestCase
{
    public function testAllDefaultProperties()
    {
        $presentationReview = new JsonPresentationReview();
        $this->assertSame(
            ["id", "name", "description"],
            $presentationReview->allDefaultProperties()
        );
    }
}