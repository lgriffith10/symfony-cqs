<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function process(ContainerBuilder $container): void
    {
        if ('test' === $this->environment) {
            foreach ($container->getDefinitions() as $definition) {
                $definition->setPublic(true);
            }
            foreach ($container->getAliases() as $alias) {
                $alias->setPublic(true);
            }
        }
    }
}
