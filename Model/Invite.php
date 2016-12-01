<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 17/10/16
 * Time: 20:11
 */

namespace Quef\TeamBundle\Model;


abstract class Invite implements InviteInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var mixed
     */
    protected $role;

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
    protected $sent;

    /** @var bool */
    protected $used;

    public function __construct()
    {
        $this->sent = false;
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
    public function isSent()
    {
        return $this->sent;
    }

    /**
     * @param boolean $sent
     */
    public function setSent($sent)
    {
        $this->sent = $sent;
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

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

}