<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 06/10/16
 * Time: 16:54
 */

namespace Quef\TeamBundle\Model;


interface TeamResourceInterface
{
    public function getId();

    /** @return TeamInterface */
    public function getTeam();
}