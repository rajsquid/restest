<?php

namespace Restest\Application\Presentation;

use Restest\Domain\Presentation\Presentations;

class JsonPresentations extends Presentations
{
    /**
     * @return JsonPresentationUser
     */
    public function forUser()
    {
        return new JsonPresentationUser();
    }

    /**
     * @return JsonPresentationContract
     */
    public function forContract()
    {
        return new JsonPresentationContract();
    }

    /**
     * @return JsonPresentationRole
     */
    public function forRole()
    {
        return new JsonPresentationRole();
    }

    /**
     * @return JsonPresentationRisk
     */
    public function forRisk()
    {
        return new JsonPresentationRisk();
    }

    /**
     * @return JsonPresentationProcess
     */
    public function forProcess()
    {
        return new JsonPresentationProcess();
    }

    /**
     * @return JsonPresentationReview
     */
    public function forReview()
    {
        return new JsonPresentationReview();
    }
}