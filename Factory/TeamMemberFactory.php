<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 21/10/16
 * Time: 18:11
 */

namespace Quef\TeamBundle\Factory;


use Quef\TeamBundle\Model\InviteInterface;
use Quef\TeamBundle\Model\TeamMemberInterface;

class TeamMemberFactory implements TeamMemberFactoryInterface
{
    private $className;

    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * @param InviteInterface $invite
     * @return TeamMemberInterface
     */
    public function createFromInvite(InviteInterface $invite)
    {
        /** @var TeamMemberInterface $member */
        $member = new $this->className;
        $member->setTeam($invite->getTeam());
        $member->setTeamRoles($invite->getRoles());
        return $member;
    }
}