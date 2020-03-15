<?php

use Restest\Application\HttpResources;
use Restest\Domain\Error\ErrorEntityAlreadyExist;
use Restest\Domain\Error\ErrorEntityNotEditable;
use Restest\Domain\Error\ErrorEntityNotFound;
use Restest\Domain\Error\ErrorParameter;
use Restest\Domain\Repository\Repositories;

//use Restest\Infrastructure\MessageLog;

$app->add(
    function ($request, $response, $next) use ($app) {
        try {
            Repositories::instance()->beginTransaction();

            $response = $next($request, $response);

            //$app->getContainer()->get("logger")->info(MessageLog::succes($app->getContainer()));
            if (in_array($request->getMethod(), ["POST", "PUT", "DELETE", "PATCH"])) {
                Repositories::instance()->commit();
            }
        } catch (\Exception $e) {
            $map = [
                ErrorEntityNotFound::class => HttpResources::STATUS_NOT_FOUND,
                ErrorParameter::class => HttpResources::STATUS_BAD_REQUEST,
                ErrorEntityNotEditable::class => HttpResources::STATUS_FORBIDDEN,
                ErrorEntityAlreadyExist::class => HttpResources::STATUS_BAD_REQUEST,
            ];

            $libelle = new \ReflectionClass($e);
            $statut = array_key_exists($libelle->getName(), $map) ? $map[$libelle->getName()] : 500;

            //$app->getContainer()->get("logger")->error(MessageLog::erreur($app->getContainer(), $statut, $e->getMessage()));
            Repositories::instance()->rollback();

            $response = $response
                ->withStatus($statut)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode(["error" => $e->getMessage()]));
        }
        return $response;
    }
);

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});