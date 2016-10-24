<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 06/10/16
 * Time: 17:30
 */

namespace Quef\TeamBundle\Event;


use Quef\TeamBundle\Model\TeamMemberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class TeamMemberEvent extends GenericEvent
{
    /** @var TeamMemberInterface */
    private $member;

    public function __construct($subject, array $arguments = array())
    {
        parent::__construct($subject, $arguments);
        if(!$subject instanceof TeamMemberInterface) {
            throw new \InvalidArgumentException('This is not a valid TeamMemberInterface');
        }
        $this->member = $subject;
    }

    /** @return TeamMemberInterface */
    public function getMember()
    {
        return $this->member;
    }

}