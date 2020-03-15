<?php

namespace Restest\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Restest\Domain\Helper\HelperParameter;

/**
 * Class ApplicationUser
 *
 * @package App\Domain
 */
class User extends Entity
{
    /**
     * @var $name string
     */
    private $name;

    /**
     * @var $email string
     */
    private $email;

    /**
     * @var $role null|Role
     */
    private $role;

    /**
     * ApplicationUser constructor.
     *
     * @param  $name string
     * @param $email string
     * @throws Error\ErrorParameter
     */
    public function __construct($name, $email)
    {
        $this->setName($name);
        $this->setEmail($email);
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
        HelperParameter::checkNotEmpty($name, "The user name is mandatory.");
        if ($this->name != $name) {
            $this->name = $name;
        }
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @throws Error\ErrorParameter
     */
    public function setEmail(string $email)
    {
        HelperParameter::checkNotEmpty($email, "The user email is mandatory.");
        HelperParameter::checkEmail($email, "The user email is not well formatted: '$1'.");
        if ($this->email != $email) {
            $this->email = $email;
        }
    }

    /**
     * @return Role|null
     */
    public function getRole(): ? Role
    {
        return $this->role;
    }

    /**
     * @param Role|null $role
     */
    public function setRole(?Role $role)
    {
        if ($this->role !== $role) {
            $this->role = $role;
        }
    }
}