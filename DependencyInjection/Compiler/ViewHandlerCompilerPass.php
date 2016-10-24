<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 30/04/16
 * Time: 01:27
 */

namespace Quef\GroupBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ViewHandlerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('sylius.resource_controller.view_handler');
        $definition->setClass('Quef\GroupBundle\View\ViewHandler');
        $definition->addMethodCall('setContainer', array(new Reference('service_container')));
    }
}