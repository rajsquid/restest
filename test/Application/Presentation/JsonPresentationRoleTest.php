<?php

namespace Restest\Application\Presentation;


class JsonPresentationRoleTest extends \PHPUnit\Framework\TestCase
{

    public function testAllDefaultProperties()
    {
        $presentationRole = new JsonPresentationRole();
        $this->assertSame(
            ["id", "name"],
            $presentationRole->allDefaultProperties()
        );

    }

}
