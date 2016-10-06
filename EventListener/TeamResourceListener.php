<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 06/10/16
 * Time: 17:30
 */

namespace Quef\TeamBundle\EventListener;


use Quef\TeamBundle\Event\TeamResourceEvent;
use Quef\TeamBundle\Event\TeamEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TeamResourceListener implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return array(
            TeamEvents::CREATED_RESOURCE => 'onCreatedResource',
        );
    }


    public function onCreatedResource(TeamResourceEvent $event)
    {

    }
}