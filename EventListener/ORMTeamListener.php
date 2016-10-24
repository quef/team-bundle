<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 06/10/16
 * Time: 17:30
 */

namespace Quef\TeamBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Quef\TeamBundle\Event\TeamEvent;
use Quef\TeamBundle\Event\TeamEvents;
use Quef\TeamBundle\Event\TeamMemberEvent;
use Quef\TeamBundle\Event\TeamResourceEvent;
use Quef\TeamBundle\Model\TeamInterface;
use Quef\TeamBundle\Model\TeamMemberInterface;
use Quef\TeamBundle\Model\TeamResourceInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ORMTeamListener
{
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->eventDispatcher = $dispatcher;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if($entity instanceof TeamMemberInterface) {
            $this->eventDispatcher->dispatch(TeamEvents::TEAM_MEMBER_CREATED, new TeamMemberEvent($entity));
        }
        if($entity instanceof TeamResourceInterface) {
            $this->eventDispatcher->dispatch(TeamEvents::TEAM_RESOURCE_CREATED, new TeamResourceEvent($entity));
        }
        if($entity instanceof TeamInterface) {
            $this->eventDispatcher->dispatch(TeamEvents::TEAM_CREATED, new TeamEvent($entity));
        }
    }
}