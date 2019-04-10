<?php

declare(strict_types=1);

namespace NLubisch\GrumPHP;

use GrumPHP\Extension\ExtensionInterface;
use NLubisch\GrumPHP\Task\Ecs;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class Extension implements ExtensionInterface
{
    public function load(ContainerBuilder $container): void
    {
        $container->register('task.ecs', Ecs::class)
            ->addArgument(new Reference('config'))
            ->addArgument(new Reference('process_builder'))
            ->addArgument(new Reference('formatter.raw_process'))
            ->addTag('grumphp.task', ['config' => 'ecs']);
    }
}
