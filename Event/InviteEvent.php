<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 06/10/16
 * Time: 17:30
 */

namespace Quef\TeamBundle\Event;


use Quef\TeamBundle\Model\InviteInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class InviteEvent extends GenericEvent
{

    public function __construct($subject, array $arguments = array())
    {
        parent::__construct($subject, $arguments);
        if(!$subject instanceof InviteInterface) {
            throw new \InvalidArgumentException('This is not a valid InviteInterface');
        }
    }

    /** @return InviteInterface */
    public function getInvite()
    {
        return $this->getSubject();
    }

}