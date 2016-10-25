<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 25/10/16
 * Time: 19:05
 */

namespace Quef\TeamBundle\Model;


interface InvitedTeamMemberInterface extends TeamMemberInterface
{
    /** @return InviteInterface */
    public function getInvite();

    /** @param InviteInterface $invite */
    public function setInvite(InviteInterface $invite);

}