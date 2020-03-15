<?php

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

$builder = new ClassMetadataBuilder($metadata);
$builder->setTable("review_state");
$builder->addField("name", "string", ["length" => 255, "nullable" => false]);
$builder->addField("description", "string", ["length" => 255, "nullable" => false]);