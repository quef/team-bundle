<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 17/10/16
 * Time: 20:11
 */

namespace Quef\TeamBundle\Model;


use Sylius\Component\Resource\Model\ResourceInterface;

abstract class Invite implements InviteInterface, ResourceInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var array
     */
    protected $roles;

    /**
     * @var string
     */
    protected $code;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var \DateTime
     */
    protected $invitedAt;

    /** @var bool */
    protected $used;

    public function __construct()
    {
        $this->used = false;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return \DateTime
     */
    public function getInvitedAt()
    {
        return $this->invitedAt;
    }

    /**
     * @param \DateTime $invitedAt
     */
    public function setInvitedAt($invitedAt)
    {
        $this->invitedAt = $invitedAt;
    }

    /**
     * @return boolean
     */
    public function isUsed()
    {
        return $this->used;
    }

    /**
     * @param boolean $used
     */
    public function setUsed($used)
    {
        $this->used = $used;
    }

    public function setRole($role)
    {
        $this->setRoles(array($role));
    }

    public function getRole()
    {
        return isset($this->roles[0])? $this->roles[0]: null;
    }
}