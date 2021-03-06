<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 07/10/16
 * Time: 17:24
 */

namespace Quef\TeamBundle\Model;


use Symfony\Component\Security\Core\User\UserInterface;

interface TeamMemberRepositoryInterface extends TeamResourceRepositoryInterface
{
    public function findOneByTeamAndUser(TeamInterface $team, UserInterface $user);
}