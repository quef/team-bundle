<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 06/10/16
 * Time: 17:30
 */

namespace Quef\TeamBundle\Event;


use Quef\TeamBundle\Model\TeamResourceInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class TeamResourceEvent extends GenericEvent
{

    public function __construct($subject, array $arguments = array())
    {
        parent::__construct($subject, $arguments);
        if(!$subject instanceof TeamResourceInterface) {
            throw new \InvalidArgumentException('This is not a valid TeamResourceInterface');
        }
    }

    /** @return TeamResourceInterface */
    public function getResource()
    {
        return $this->getSubject();
    }

}