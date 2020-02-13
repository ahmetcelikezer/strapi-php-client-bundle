<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('ahc_strapi_client');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('api_url')->isRequired()
            ->end()
        ;

        return $treeBuilder;
    }
}
