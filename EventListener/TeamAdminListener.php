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
use Quef\TeamBundle\Metadata\RegistryInterface;
use Quef\TeamBundle\Model\TeamInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TeamAdminListener implements EventSubscriberInterface
{
    /** @var ObjectManager */
    private $om;

    /** @var RegistryInterface */
    private $registry;

    public function __construct(RegistryInterface $registry, ObjectManager $objectManager)
    {
        $this->registry = $registry;
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

            $adminRole = $this->registry->getByObject($team)->getAdminRole();
            $event->getMember()->setTeamRole($adminRole);
            $this->om->persist($event->getMember());
            $this->om->persist($team);
            $this->om->flush();
        }
    }

}