<?php

namespace Restest\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Restest\Domain\Helper\HelperParameter;

/**
 * Class ApplicationContract
 *
 * @package App\Domain
 */
class Contract extends Entity
{
    /**
     * @var $name string
     */
    private $name;

    /**
     * @var $role null|Risk
     */
    private $risk;

    /**
     * ApplicationContract constructor.
     *
     * @param  $name string
     * @throws Error\ErrorParameter
     */
    public function __construct($name)
    {
        $this->setName($name);
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
        HelperParameter::checkNotEmpty($name, "The contract name is mandatory.");
        if ($this->name != $name) {
            $this->name = $name;
        }
    }

    /**
     * @return Risk|null
     */
    public function getRisk(): ? Risk
    {
        return $this->risk;
    }

    /**
     * @param Risk|null $risk
     */
    public function setRisk(?Risk $risk)
    {
        if ($this->risk !== $risk) {
            $this->risk = $risk;
        }
    }
}