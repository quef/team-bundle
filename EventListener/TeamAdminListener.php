<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 07/10/16
 * Time: 17:39
 */

namespace Quef\TeamBundle\EventListener;


use Doctrine\Common\Persistence\ObjectManager;
use Quef\TeamBundle\Event\TeamEvents;
use Quef\TeamBundle\Event\TeamMemberEvent;
use Quef\TeamBundle\Model\TeamInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TeamAdminListener implements EventSubscriberInterface
{
    /** @var ObjectManager */
    private $om;

    public function __construct(ObjectManager $objectManager)
    {
        $this->om = $objectManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            TeamEvents::TEAM_MEMBER_CREATED => 'onCreatedMember',
        );
    }

    public function onCreatedMember(TeamMemberEvent $event)
    {
        /** @var TeamInterface $team */
        $team = $event->getMember()->getTeam();
        if(null === $team) {
            throw new \InvalidArgumentException("A Member must have a Team.");
        }

        // Set first member as admin
        if(null === $team->getTeamAdmin()) {
            $team->setTeamAdmin($event->getMember());
            $this->om->persist($team);
            $this->om->flush();
        }
    }

}