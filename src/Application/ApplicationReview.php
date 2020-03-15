<?php


namespace Restest\Application;

use Restest\Domain\Helper\HelperParameter;
use Restest\Domain\Presentation\Presentations;
use Restest\Domain\Repository\Repositories;
use Restest\Domain\Review;


class ApplicationReview extends HttpResources
{

    /**
     * @return ApplicationReview
     */
    public static function instance()
    {
        return new ApplicationReview();
    }

    /**
     * @SWG\Delete(
     *        path="/review/{id}", summary="Delete a review by id", description="",
     * @SWG\Parameter(name="id",   in="path", required=true, type="integer", description="review id"),
     * @SWG\Response(response=204, description="")
     * )
     */
    public function delete($req, $res, $args)
    {
        Repositories::instance()->forReview()->delete($args["id"]);

        return $this->response($res, static::STATUS_NO_CONTENT);
    }

    /**
     * @SWG\Get(
     *        path="/review/{id}", summary="Get a review by id", description="",
     * @SWG\Parameter(name="id",   in="path", required=true, type="integer", description="Review id"),
     * @SWG\Response(response=200, description="")
     * )
     */
    public function get($req, $res, $args)
    {
        $review = Repositories::instance()->forReview()->get($args["id"]);

        return $this->response(
            $res, static::STATUS_OK,
            Presentations::instance()->forReview()->inJsonWith(
                $review,
                HelperParameter::getFields($req->getParam("fields"))
            )
        );
    }

    /**
     * @SWG\Get(
     *        path="/reviews", summary="Get all reviews", description="",
     * @SWG\Response(response=200, description="")
     * )
     */
    public function getAll($req, $res, $args)
    {
        $reviews = Repositories::instance()->forReview()->getAll();

        $presentation = Presentations::instance()->forReview()->allInJsonWith(
            $reviews,
            HelperParameter::getFields($req->getParam("fields"))
        );

        if(!$presentation) { $presentation = 'No records found'; }

        return $this->response($res, static::STATUS_OK, $presentation);
    }

    /**
     * @SWG\Post(
     *        path="/review", summary="Create a review", description="",
     * @SWG\Parameter(name="name", in="formData", required=true, type="string", description="Name"),
     * @SWG\Parameter(name="description", in="formData", required=false, type="string", description="Description"),
     * @SWG\Response(response=201, description="")
     * )
     */
    public function post($req, $res, $args)
    {
        $review = new Review($req->getParam("name"),$req->getParam("description"));
        Repositories::instance()->forReview()->add($review);

        return $this->response(
            $res, static::STATUS_CREATED,
            Presentations::instance()->forReview()->inJson($review)
        );
    }

    /**
     * @SWG\Put(
     *        path="/review/{id}", summary="Replace a review by id", description="",
     * @SWG\Parameter(name="id",    in="path", required=true, type="integer", description="Review id"),
     * @SWG\Parameter(name="name",  in="formData", required=true, type="string", description="Name"),
     * @SWG\Parameter(name="description",  in="formData", required=false, type="string", description="description"),
     * @SWG\Response(response=201,  description="")
     * )
     */
    public function put($req, $res, $args)
    {
        $presentation = "";
        $status = static::STATUS_NOT_FOUND;

        $review = Repositories::instance()->forReview()->get($args["id"]);
        if (!is_null($review)) {
            $review->setName($req->getParam("name"));
            $review->setDesc($req->getParam("description"));
            Repositories::instance()->forReview()->edit($review);
            $presentation = Presentations::instance()->forReview()->inJson($review);
            $status = static::STATUS_CREATED;
        }

        return $this->response($res, $status, $presentation);
    }
}