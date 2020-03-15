<?php


namespace Restest\Application;

use Restest\Domain\Helper\HelperParameter;
use Restest\Domain\Presentation\Presentations;
use Restest\Domain\Repository\Repositories;
use Restest\Domain\Role;


class ApplicationRole extends HttpResources
{

    /**
     * @return ApplicationRole
     */
    public static function instance()
    {
        return new ApplicationRole();
    }

    /**
     * @SWG\Delete(
     *        path="/role/{id}", summary="Delete a role by id", description="",
     * @SWG\Parameter(name="id",   in="path", required=true, type="integer", description="role id"),
     * @SWG\Response(response=204, description="")
     * )
     */
    public function delete($req, $res, $args)
    {
        Repositories::instance()->forRole()->delete($args["id"]);

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
        $role = Repositories::instance()->forRole()->get($args["id"]);

        return $this->response(
            $res, static::STATUS_OK,
            Presentations::instance()->forRole()->inJsonWith(
                $role,
                HelperParameter::getFields($req->getParam("fields"))
            )
        );
    }

    /**
     * @SWG\Get(
     *        path="/role", summary="Get all roles", description="",
     * @SWG\Response(response=200, description="")
     * )
     */
    public function getAll($req, $res, $args)
    {
        $roles = Repositories::instance()->forRole()->getAll();

        $presentation = Presentations::instance()->forRole()->allInJsonWith(
            $roles,
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
        $role = new Role($req->getParam("name"));
        Repositories::instance()->forRole()->add($role);

        return $this->response(
            $res, static::STATUS_CREATED,
            Presentations::instance()->forRole()->inJson($role)
        );
    }

    /**
     * @SWG\Put(
     *        path="/role/{id}", summary="Replace a Role by id", description="",
     * @SWG\Parameter(name="id",    in="path", required=true, type="integer", description="Role id"),
     * @SWG\Parameter(name="name",  in="formData", required=true, type="string", description="Name"),
     * @SWG\Response(response=201,  description="")
     * )
     */
    public function put($req, $res, $args)
    {
        $presentation = "";
        $status = static::STATUS_NOT_FOUND;

        $role = Repositories::instance()->forRole()->get($args["id"]);
        if (!is_null($role)) {
            $role->setName($req->getParam("name"));
            Repositories::instance()->forRole()->edit($role);
            $presentation = Presentations::instance()->forRole()->inJson($role);
            $status = static::STATUS_CREATED;
        }

        return $this->response($res, $status, $presentation);
    }
}