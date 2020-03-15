<?php

use Restest\Application\ApplicationContract;
use Restest\Application\ApplicationRole;
use Restest\Application\ApplicationRisk;
use Restest\Application\ApplicationUser;
use Restest\Application\ApplicationProcess;
use Restest\Application\ApplicationReview;
use Slim\Views\PhpRenderer;

$id = "{id:\d+}";

$container = $app->getContainer();
$container['renderer'] = new PhpRenderer("../templates");

$app->get("/", function ($req, $res, $args) {
    //$this->logger->addInfo("home route reached");
    //print "API Home";
    return $this->renderer->render($res, "/index.phtml", $args);
});
//Risk routes
$app->get("/risks", function ($req, $res, $args) {return ApplicationRisk::instance()->getAll($req, $res, $args);});
$app->post("/risk", function ($req, $res, $args) {return ApplicationRisk::instance()->post($req, $res, $args);});
$app->get("/risk/$id", function ($req, $res, $args) {return ApplicationRisk::instance()->get($req, $res, $args);});
$app->put("/risk/$id", function ($req, $res, $args) {return ApplicationRisk::instance()->put($req, $res, $args);});
$app->delete("/risk/$id", function ($req, $res, $args) {return ApplicationRisk::instance()->delete($req, $res, $args);});

//Role routes
$app->get("/roles", function ($req, $res, $args) {return ApplicationRole::instance()->getAll($req, $res, $args);});
$app->post("/role", function ($req, $res, $args) {return ApplicationRole::instance()->post($req, $res, $args);});
$app->get("/role/$id", function ($req, $res, $args) {return ApplicationRole::instance()->get($req, $res, $args);});
$app->put("/role/$id", function ($req, $res, $args) {return ApplicationRole::instance()->put($req, $res, $args);});
$app->delete("/role/$id", function ($req, $res, $args) {return ApplicationRole::instance()->delete($req, $res, $args);});

//Contract routes
$app->get("/contracts", function ($req, $res, $args) {return ApplicationContract::instance()->getAll($req, $res, $args);});
$app->post("/contract", function ($req, $res, $args) {return ApplicationContract::instance()->post($req, $res, $args);});
$app->get("/contract/$id", function ($req, $res, $args) {return ApplicationContract::instance()->get($req, $res, $args);});
$app->put("/contract/$id", function ($req, $res, $args) {return ApplicationContract::instance()->put($req, $res, $args);});
$app->delete("/contract/$id", function ($req, $res, $args) {return ApplicationContract::instance()->delete($req, $res, $args);});

//User Routes
$app->get("/users", function ($req, $res, $args) {return ApplicationUser::instance()->getAll($req, $res, $args);});
$app->post("/user", function ($req, $res, $args) {return ApplicationUser::instance()->post($req, $res, $args);});
$app->get("/user/$id", function ($req, $res, $args) {return ApplicationUser::instance()->get($req, $res, $args);});
$app->put("/user/$id", function ($req, $res, $args) {return ApplicationUser::instance()->put($req, $res, $args);});
//$app->delete("/user/$id", function ($req, $res, $args) {return ApplicationUser::instance()->delete($req, $res, $args);});

//ProcessAssign Routes
$app->get("/processes", function ($req, $res, $args) {return ApplicationProcess::instance()->getAll($req, $res, $args);});
$app->get("/process/$id", function ($req, $res, $args) {return ApplicationProcess::instance()->get($req, $res, $args);});
$app->post("/process", function ($req, $res, $args) {return ApplicationProcess::instance()->post($req, $res, $args);});
//$app->delete("/process/$id", function ($req, $res, $args) {return ApplicationProcess::instance()->delete($req, $res, $args);});

//Review state routes
$app->get("/reviews", function ($req, $res, $args) {return ApplicationReview::instance()->getAll($req, $res, $args);});
$app->post("/review", function ($req, $res, $args) {return ApplicationReview::instance()->post($req, $res, $args);});
$app->get("/review/$id", function ($req, $res, $args) {return ApplicationReview::instance()->get($req, $res, $args);});
$app->put("/review/$id", function ($req, $res, $args) {return ApplicationReview::instance()->put($req, $res, $args);});
$app->delete("/review/$id", function ($req, $res, $args) {return ApplicationReview::instance()->delete($req, $res, $args);});

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
    return $handler($req, $res);
});
