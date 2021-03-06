<?php

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

$builder = new ClassMetadataBuilder($metadata);
$builder->setTable("user");
$builder->addField("name", "string", ["length" => 255, "nullable" => false]);
$builder->addField("email", "string", ["length" => 255, "nullable" => false]);

$builder->createManyToOne('role', 'Role')->addJoinColumn('role_id', 'id', true, false, 'no action')->cascadePersist()->build();