<?php


namespace Restest\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Restest\Domain\Helper\HelperParameter;


/**
 * Class ApplicationProcess
 *
 * @package App\Domain
 */
class Process extends Entity
{
    /**
     * @var $user null|User
     */
    private $user;

    /**
     * @var $contract null|Contract
     */
    private $contract;

    /**
     * ApplicationProcess constructor.
     *
     * @param  $user_id integer
     * @param  $contract_id integer
     * @throws Error\ErrorParameter
     */
    public function __construct()
    {
    }

    /**
     * @return User|null
     */
    public function getUser(): ? User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user)
    {
        if ($this->user !== $user) {
            $this->user = $user;
        }
    }

    /**
     * @return Contract|null
     */
    public function getContract(): ? Contract
    {
        return $this->contract;
    }

    /**
     * @param Contract|null $contract
     */
    public function setContract(?Contract $contract)
    {
        if ($this->contract !== $contract) {
            $this->contract = $contract;
        }
    }
}