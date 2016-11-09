<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 09/11/16
 * Time: 17:29
 */

namespace Quef\TeamBundle\Security\Role;


use Quef\TeamBundle\Model\TeamMemberInterface;

interface RoleCheckerInterface
{
    public function hasRole($role, TeamMemberInterface $member);
}