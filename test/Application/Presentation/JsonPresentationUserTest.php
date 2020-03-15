<?php

namespace Restest\Application\Presentation;

class JsonPresentationUserTest extends \PHPUnit\Framework\TestCase
{
    public function testAllDefaultProperties()
    {
        $presentationUser = new JsonPresentationUser();
        $this->assertSame(
            ["id", "name", "email", "role_id"],
            $presentationUser->allDefaultProperties()
        );
    }
}