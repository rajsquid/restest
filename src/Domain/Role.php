<?php

namespace Restest\Domain;

use Restest\Domain\Helper\HelperParameter;

/**
 * Class ApplicationRole
 *
 * @package App\Domain
 */
class Role extends Entity
{
    /**
     * @var $name string
     */
    private $name;

    /**
     * ApplicationRole constructor.
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
        HelperParameter::checkNotEmpty($name, "The role name is mandatory.");
        if ($this->name != $name) {
            $this->name = $name;
        }
    }
}