<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 06/10/16
 * Time: 16:53
 */

namespace Quef\TeamBundle\Model;


interface TeamInterface
{
    /** @return mixed */
    public function getId();

    /** @return TeamMemberInterface */
    public function getTeamAdmin();
}