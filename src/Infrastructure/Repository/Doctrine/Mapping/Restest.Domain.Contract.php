<?php

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

$builder = new ClassMetadataBuilder($metadata);
$builder->setTable("contract");
$builder->addField("name", "string", ["length" => 255, "nullable" => false]);

$builder->createManyToOne('risk', 'Risk')->addJoinColumn('risk_id', 'id', true, false, 'no action')->cascadePersist()->build();
