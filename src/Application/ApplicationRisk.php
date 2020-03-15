<?php


namespace Restest\Application;

use Restest\Domain\Helper\HelperParameter;
use Restest\Domain\Presentation\Presentations;
use Restest\Domain\Repository\Repositories;
use Restest\Domain\Risk;


class ApplicationRisk extends HttpResources
{

    /**
     * @return ApplicationRisk
     */
    public static function instance()
    {
        return new ApplicationRisk();
    }

    /**
     * @SWG\Delete(
     *        path="/risk/{id}", summary="Delete a risk by id", description="",
     * @SWG\Parameter(risk="id",   in="path", required=true, type="integer", description="risk id"),
     * @SWG\Response(response=204, description="")
     * )
     */
    public function delete($req, $res, $args)
    {
        Repositories::instance()->forRisk()->delete($args["id"]);

        return $this->response($res, static::STATUS_NO_CONTENT);
    }

    /**
     * @SWG\Get(
     *        path="/role/{id}", summary="Get a role by id", description="",
     * @SWG\Parameter(name="id",   in="path", required=true, type="integer", description="Role id"),
     * @SWG\Response(response=200, description="")
     * )
     */
    public function get($req, $res, $args)
    {
        $risk = Repositories::instance()->forRisk()->get($args["id"]);

        return $this->response(
            $res, static::STATUS_OK,
            Presentations::instance()->forRisk()->inJsonWith(
                $risk,
                HelperParameter::getFields($req->getParam("fields"))
            )
        );
    }

    /**
     * @SWG\Get(
     *        path="/risk", summary="Get all risks", description="",
     * @SWG\Response(response=200, description="")
     * )
     */
    public function getAll($req, $res, $args)
    {
        $risks = Repositories::instance()->forRisk()->getAll();

        $presentation = Presentations::instance()->forRisk()->allInJsonWith(
            $risks,
            HelperParameter::getFields($req->getParam("fields"))
        );

        if(!$presentation) { $presentation = 'No records found'; }

        return $this->response($res, static::STATUS_OK, $presentation);
    }

    /**
     * @SWG\Post(
     *        path="/role", summary="Create a role", description="",
     * @SWG\Parameter(name="name", in="formData", required=true, type="string", description="Name"),
     * @SWG\Response(response=201, description="")
     * )
     */
    public function post($req, $res, $args)
    {
        $risk = new Risk($req->getParam("name"));
        Repositories::instance()->forRisk()->add($risk);

        return $this->response(
            $res, static::STATUS_CREATED,
            Presentations::instance()->forRisk()->inJson($risk)
        );
    }

    /**
     * @SWG\Put(
     *        path="/company/{id}", summary="Replace a company by id", description="",
     * @SWG\Parameter(name="id",    in="path", required=true, type="integer", description="Contract id"),
     * @SWG\Parameter(name="name",  in="formData", required=true, type="string", description="Name"),
     * @SWG\Response(response=201,  description="")
     * )
     */
    public function put($req, $res, $args)
    {
        $presentation = "";
        $status = static::STATUS_NOT_FOUND;

        $risk = Repositories::instance()->forRisk()->get($args["id"]);
        if (!is_null($risk)) {
            $risk->setName($req->getParam("name"));
            Repositories::instance()->forRisk()->edit($risk);
            $presentation = Presentations::instance()->forRisk()->inJson($risk);
            $status = static::STATUS_CREATED;
        }

        return $this->response($res, $status, $presentation);
    }
}