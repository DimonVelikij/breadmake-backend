<?php

namespace Bread\ContentBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bread_content');

        $rootNode
            ->children()
                ->scalarNode('save_dir')
                    ->defaultValue('%kernel.root_dir%')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('asset_dir')
                    ->defaultValue('media/images')
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('entities')
                    ->isRequired()
                    ->prototype('array')
                        ->children()
                            ->integerNode('min_width')
                                ->isRequired()
                            ->end()
                            ->integerNode('min_height')
                                ->isRequired()
                            ->end()
                            ->integerNode('max_width')->end()
                            ->integerNode('max_height')->end()
                            ->arrayNode('crop_size')
                                ->children()
                                    ->scalarNode('width')->end()
                                    ->scalarNode('height')->end()
                                ->end()
                            ->end()
                            ->arrayNode('mime_types')
                                ->prototype('scalar')
                                    ->defaultValue(['jpg', 'png'])
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                            ->integerNode('min_count')
                                ->defaultValue(1)
                            ->end()
                            ->integerNode('max_count')
                                ->defaultValue(1)
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}