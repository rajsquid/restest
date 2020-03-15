<?php

namespace Restest\Application\Presentation;


class JsonPresentationRiskTest extends \PHPUnit\Framework\TestCase
{

    public function testAllDefaultProperties()
    {
        $presentationRisk = new JsonPresentationRisk();
        $this->assertSame(
            ["id", "name"],
            $presentationRisk->allDefaultProperties()
        );
    }
}
