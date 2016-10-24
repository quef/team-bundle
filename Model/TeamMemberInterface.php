<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 06/10/16
 * Time: 16:55
 */

namespace Quef\TeamBundle\Model;


interface TeamMemberInterface extends TeamResourceInterface
{
    /** @return array */
    public function getTeamRoles();

    /** @param array $roles */
    public function setTeamRoles($roles);

    /** @param TeamInterface $team */
    public function setTeam(TeamInterface $team);

}