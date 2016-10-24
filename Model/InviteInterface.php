<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 11/10/16
 * Time: 22:27
 */

namespace Quef\TeamBundle\Model;


interface InviteInterface extends TeamResourceInterface
{
    /** @return string */
    public function getCode();
    /** @param string */
    public function setCode($code);

    /** @return string */
    public function getEmail();

    /** @param string */
    public function setEmail($email);

    /** @return \DateTime */
    public function getInvitedAt();

    /** @param \DateTime */
    public function setInvitedAt($invitedAt);

    /** @return TeamMemberInterface */
    public function getInvitedBy();

    /** @param TeamMemberInterface */
    public function setInvitedBy(TeamMemberInterface $invitedBy);

    /** @return mixed */
    public function getRoles();

    /** @param mixed $roles */
    public function setRoles($roles);

    /** @param TeamInterface */
    public function setTeam(TeamInterface $team);

    /** @param bool $used */
    public function setUsed($used);

    /** @return bool */
    public function isUsed();

}