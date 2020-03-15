<?php

namespace Restest\Application\Presentation;

class JsonPresentationContractTest extends \PHPUnit\Framework\TestCase
{
    public function testAllDefaultProperties()
    {
        $presentationContract = new JsonPresentationContract();
        $this->assertSame(
            ["id", "name", "risk_id"],
            $presentationContract->allDefaultProperties()
        );
    }
}