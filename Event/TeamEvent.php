<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 06/10/16
 * Time: 17:30
 */

namespace Quef\TeamBundle\Event;


use Quef\TeamBundle\Model\TeamInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class TeamEvent extends GenericEvent
{

    public function __construct($subject, array $arguments = array())
    {
        parent::__construct($subject, $arguments);
        if(!$subject instanceof TeamInterface) {
            throw new \InvalidArgumentException('This is not a valid TeamInterface');
        }
    }

    /** @return TeamInterface */
    public function getTeam()
    {
        return $this->getSubject();
    }

}