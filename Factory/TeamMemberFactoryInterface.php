<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 11/10/16
 * Time: 22:36
 */

namespace Quef\TeamBundle\Factory;


use Quef\TeamBundle\Model\InviteInterface;
use Quef\TeamBundle\Model\TeamInterface;
use Quef\TeamBundle\Model\TeamMemberInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface TeamMemberFactoryInterface
{
    /**
     * @param InviteInterface $invite
     * @param UserInterface $createdUser
     * @return TeamMemberInterface
     */
    public function createFromInvite(InviteInterface $invite, UserInterface $createdUser);


    /**
     * @param TeamInterface $team
     * @param UserInterface $createdUser
     * @return TeamMemberInterface
     */
    public function createOwner(TeamInterface $team, UserInterface $createdUser);
}