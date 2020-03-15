<?php

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

$builder = new ClassMetadataBuilder($metadata);
$builder->setTable("user_process_assignment");
//$builder->addField("use", "string", ["length" => 255, "nullable" => false]);
//$builder->addField("email", "string", ["length" => 255, "nullable" => false]);

$builder->createManyToOne('user', 'User')->addJoinColumn('user_id', 'id', true, false, 'no action')->cascadePersist()->build();
$builder->createManyToOne('contract', 'Contract')->addJoinColumn('contract_id', 'id', true, false, 'no action')->cascadePersist()->build();