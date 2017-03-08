<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 06/10/16
 * Time: 16:55
 */

namespace Quef\TeamBundle\Model;


use Symfony\Component\Security\Core\User\UserInterface;

interface TeamMemberInterface extends TeamResourceInterface
{
    /** @return string */
    public function getTeamRole();

    /** @param string $role */
    public function setTeamRole($role);

    /** @param TeamInterface $team */
    public function setTeam(TeamInterface $team);

    /** @return UserInterface */
    public function getUser();

    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user);

}