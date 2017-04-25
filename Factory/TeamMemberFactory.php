<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 21/10/16
 * Time: 18:11
 */

namespace Quef\TeamBundle\Factory;


use Quef\TeamBundle\Model\InvitedTeamMemberInterface;
use Quef\TeamBundle\Model\InviteInterface;
use Quef\TeamBundle\Model\TeamInterface;
use Quef\TeamBundle\Model\TeamMemberInterface;
use Quef\TeamBundle\Security\Role\RoleProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TeamMemberFactory implements TeamMemberFactoryInterface
{
    private $className;
    /** @var RoleProviderInterface */
    private $roleProvider;

    public function setClassName($className)
    {
        $this->className = $className;
    }

    public function setRoleProvider(RoleProviderInterface $roleProvider)
    {
        $this->roleProvider = $roleProvider;
    }

    /**
     * @param InviteInterface $invite
     * @return TeamMemberInterface
     */
    public function createFromInvite(InviteInterface $invite, UserInterface $createdUser)
    {
        $invite->setUsed(true);
        /** @var TeamMemberInterface $member */
        $member = new $this->className;
        $member->setTeam($invite->getTeam());
        $member->setTeamRole($invite->getRole());
        $member->setUser($createdUser);
        if(method_exists($member, 'setEmail')) {
            $member->setEmail($invite->getEmail());
        }

        if($member instanceof InvitedTeamMemberInterface) {
            $member->setInvite($invite);
        }
        return $member;
    }

    public function createOwner(TeamInterface $team, UserInterface $createdUser)
    {
        /** @var TeamMemberInterface $member */
        $member = new $this->className;
        $member->setUser($createdUser);
        $member->setTeam($team);
        $member->setTeamRole($this->roleProvider->getOwnerRole());
        return $member;
    }
}