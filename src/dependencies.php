<?php

use Restest\Application\Presentation\JsonPresentations;
use Restest\Domain\Presentation\Presentations;
use Restest\Domain\Repository\Repositories;
use Restest\Infrastructure\Configuration;
use Restest\Infrastructure\Repository\Doctrine\DoctrineRepositories;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;

$container = $app->getContainer();

$container['logger'] = function ($c) use ($configuration) {
    $logger = new Monolog\Logger("webservice");
    $streamHandler = new StreamHandler($configuration['general']['log.file'], $configuration['general']['log.level']);
    $streamHandler->setFormatter(new LineFormatter("[%datetime%] %level_name% %message%\n", 'Y-m-d H:i:s.u'));
    $logger->pushHandler($streamHandler);
    return $logger;
};

Configuration::init($configuration);
Repositories::initialize(new DoctrineRepositories($configuration['database']));
Presentations::initialize(new JsonPresentations());