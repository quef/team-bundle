<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 24/10/16
 * Time: 20:22
 */

namespace Quef\TeamBundle\Factory;


use Quef\TeamBundle\Model\InviteInterface;

interface InviteFactoryInterface
{

    /** @return InviteInterface */
    public function createNew();

    /** @return InviteInterface */
    public function createNewForCurrentTeam();

}