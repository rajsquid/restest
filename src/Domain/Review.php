<?php

namespace Restest\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Restest\Domain\Helper\HelperParameter;

/**
 * Class ApplicationReview
 *
 * @package App\Domain
 */
class Review extends Entity
{
    /**
     * @var $name string
     */
    private $name;

    /**
     * @var $description string
     */
    private $description;

    /**
     * ApplicationReview constructor.
     *
     * @param  $name string
     * @param $description string
     * @throws Error\ErrorParameter
     */
    public function __construct($name, $description)
    {
        $this->setName($name);
        $this->setDesc($description);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param  $name
     * @throws Error\ErrorParameter
     */
    public function setName(string $name)
    {
        HelperParameter::checkNotEmpty($name, "The review name is mandatory.");
        if ($this->name != $name) {
            $this->name = $name;
        }
    }

    /**
     * @return string
     */
    public function getDesc(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @throws Error\ErrorParameter
     */
    public function setDesc(string $description)
    {
        if ($this->description != $description) {
            $this->description = $description;
        }
    }
}