<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Factory;

use Ahc\StrapiClientBundle\Entity\ResourceComponent;
use Ahc\StrapiClientBundle\Resource\Mapper;

class ResourceComponentFactory implements StaticFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public static function create(array $fields): ResourceComponent
    {
        $fields = Mapper::mapResourceComponent($fields);

        return new ResourceComponent(
            $fields['__component'],
            $fields['id'],
            $fields['fields']
        );
    }
}
