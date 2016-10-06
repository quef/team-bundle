<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 06/10/16
 * Time: 16:55
 */

namespace Quef\TeamBundle\Model;


interface TeamMemberInterface
{
    /** @return array */
    public function getRoles();

    /** @return TeamInterface */
    public function getTeam();

}