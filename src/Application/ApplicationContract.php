<?php

namespace Restest\Application;

use Restest\Domain\Helper\HelperParameter;
use Restest\Domain\Presentation\Presentations;
use Restest\Domain\Repository\Repositories;
use Restest\Domain\Contract;

class ApplicationContract extends HttpResources
{
    /**
     * @return ApplicationContract
     */
    public static function instance()
    {
        return new ApplicationContract();
    }

    /**
     * @SWG\Delete(
     *        path="/contract/{id}", summary="Delete a contract by id", description="",
     * @SWG\Parameter(name="id",   in="path", required=true, type="integer", description="Contract id"),
     * @SWG\Response(response=204, description="")
     * )
     */
    public function delete($req, $res, $args)
    {
        Repositories::instance()->forContract()->delete($args["id"]);

        return $this->response($res, static::STATUS_NO_CONTENT);
    }

    /**
     * @SWG\Get(
     *        path="/contract/{id}", summary="Get a contract by id", description="",
     * @SWG\Parameter(name="id",   in="path", required=true, type="integer", description="Contract id"),
     * @SWG\Response(response=200, description="")
     * )
     */
    public function get($req, $res, $args)
    {
        $contract = Repositories::instance()->forContract()->get($args["id"]);

        return $this->response(
            $res, static::STATUS_OK,
            Presentations::instance()->forContract()->inJsonWith(
                $contract,
                HelperParameter::getFields($req->getParam("fields"))
            )
        );
    }

    /**
     * @SWG\Get(
     *        path="/company", summary="Get all companys", description="",
     * @SWG\Response(response=200, description="")
     * )
     */
    public function getAll($req, $res, $args)
    {
        $contracts = Repositories::instance()->forContract()->getAll();

        $presentation = Presentations::instance()->forContract()->allInJsonWith(
            $contracts,
            HelperParameter::getFields($req->getParam("fields"))
        );

        return $this->response($res, static::STATUS_OK, $presentation);
    }

    /**
     * @SWG\Post(
     *        path="/contract", summary="Create a contract", description="",
     * @SWG\Parameter(name="name", in="formData", required=true, type="string", description="Name"),
     * @SWG\Response(response=201, description="")
     * )
     */
    public function post($req, $res, $args)
    {
        $contract = new Contract($req->getParam("name"));
        Repositories::instance()->forContract()->add($contract);

        return $this->response(
            $res, static::STATUS_CREATED,
            Presentations::instance()->forContract()->inJson($contract)
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

        $contract = Repositories::instance()->forContract()->get($args["id"]);
        if (!is_null($contract)) {
            $contract->setName($req->getParam("name"));
            Repositories::instance()->forContract()->edit($contract);
            $presentation = Presentations::instance()->forContract()->inJson($contract);
            $status = static::STATUS_CREATED;
        }

        return $this->response($res, $status, $presentation);
    }
}