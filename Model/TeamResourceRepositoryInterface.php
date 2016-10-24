<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 07/10/16
 * Time: 17:24
 */

namespace Quef\TeamBundle\Model;


interface TeamResourceRepositoryInterface
{
    public function findByTeam(TeamInterface $team);
}